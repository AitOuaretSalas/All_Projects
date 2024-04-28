<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../Login/login.php");
    exit;
}
?>
<?php
     
    require 'database.php';
 
    $nameError = $descriptionError  = $moduleError = $PDFError =$TypeError = $name  = $module = $Type = $PDF = $succées ="";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $Personne        = htmlspecialchars($_SESSION["username"]);
        $module           = checkInput($_POST['module']); 
        $Type               = checkInput($_POST['Type']); 
        $PDF              = checkInput($_FILES["PDF"]["name"]);
        $PDFPath          = '../PDF/'. basename($PDF);
        $PDFExtension     = pathinfo($PDFPath,PATHINFO_EXTENSION);
        $isSuccess          = true;
        $isUploadSuccess    = false;
        
        if(empty($name)) 
        {
            $nameError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        
        if(empty($module)) 
        {
            $moduleError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($Type)) 
        {
            $TypeError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        if(empty($PDF)) 
        {
            $PDFError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
        else
        {
            $isUploadSuccess = true;
            if($PDFExtension != "pdf" && $PDFExtension != "png" && $PDFExtension != "docx" && $PDFExtension != "jpg" ) 
            {
                $imageError = "Les fichiers autorises sont: .jpg, .docx, .png, .pdf";
                $isUploadSuccess = false;
            }
            if(file_exists($PDFPath)) 
            {
                $PDFError = "Le fichier existe déja";
                $isUploadSuccess = false;
            }
            if($_FILES["PDF"]["size"] > 1500000) 
            {
                $PDFError = "Le fichier ne doit pas depasser les 500KB";
                $isUploadSuccess = false;
            }
            if($isUploadSuccess) 
            {
                if(!move_uploaded_file($_FILES["PDF"]["tmp_name"], $PDFPath)) 
                {
                    $PDFError = "Il y a eu une erreur lors de l'upload";
                    $isUploadSuccess = false;
                } 
            } 
        }
        
        if($isSuccess && $isUploadSuccess) 
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO contpédag (NomPDF,AjouterPar,NomFichePDF,Module,Type) values(?, ?, ?, ?, ?)");
            $statement->execute(array($name,$Personne,$PDF,$module,$Type));
            Database::disconnect();
            $succées="thank you :)";
            
        }
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Inserer un PDF</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
         

        <h1 class="text-logo"><span class="glyphicon glyphicon-cloud-upload"></span> Ajouter un Document <span class="glyphicon glyphicon-cloud-upload"></span></h1>
         <div class="container admin">
            <div class="row">
                <p class="help-inline" style="text-align: center; font-size: 50px"> <?php echo $succées;?> </p>
                <a class="btn btn-primary" href="../../index.php"><span class="glyphicon glyphicon-arrow-left"></span> Retour</a>
                <h1><strong>Ajouter un Document</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nom:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nom" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    
                    <div class="form-group">
                        <label for="module">module:</label>
                        <select class="form-control" id="module" name="module">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM modules') as $row) 
                           {
                                echo '<option value="'. $row['IdModule'] .'">'. $row['NomModule'] . '</option>';;
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $moduleError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="Type">Type:</label>
                        <select class="form-control" id="Type" name="Type">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM types') as $row) 
                           {
                                echo '<option value="'. $row['IdType'] .'">'. $row['NomType'] . '</option>';;
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $TypeError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Sélectionner un PDF:</label>
                        <input type="file" id="PDF" name="PDF"> 
                        <span class="help-inline"><?php echo $PDFError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Ajouter</button>
                       
                       
                   </div>
                </form>
            </div>
        </div>   
    </body>
</html>