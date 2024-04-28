<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../Login/login.php");
    exit;
}
?>
<?php
     // Initialize the session

if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
    $_SESSION["username"]=  htmlspecialchars($_SESSION["Nom"])." ".htmlspecialchars($_SESSION["prénom"]);
}

    require 'database.php';
 
    $nameError = $descriptionError  = $moduleError = $DescriptionError  = $Discription =$name  = $module = $succées ="";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $Personne        = $_SESSION["username"];
        $module           = checkInput($_POST['module']); 
        $description        = checkInput($_POST['description']);
        $isSuccess          = true;
        
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
        if(empty($description)) 
        {
            $descriptionError = 'Ce champ ne peut pas être vide';
            $isSuccess = false;
        }
      
       
      
        if($isSuccess ) 
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO articles (title, content, auteur, created_at, module) VALUES (?, ?, ?, ?, ?)");
            $statement->execute(array($name,$description,$Personne,date("y-m-d H:i:sa"),$module));
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
        <title>Poser une Question</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style.css">
</head>
    
    <body>
    <section> 
        
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="EspaceModule.php">Espace Modules</a></li>
                        <li><a href="../index.php">Main Menu</a></li>    
                        
                    </ul>
                </div>
            
            </div>
        
        </nav>
        
        
        
        </section>
         
         <div class="container admin">
            <div class="row">
                <p class="help-inline" style="text-align: center; font-size: 50px"> <?php echo $succées;?> </p>
                <h1><strong>Poser une Question</strong></h1>
                <br>
                <form class="form" action="newpost.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Titre de la question:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Titre de la Question" value="<?php echo $name;?>">
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
                        <label for="description">Votre question:</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Votre Question" value="<?php echo $Discription;?>">
                        <span class="help-inline"><?php echo $descriptionError;?></span>
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