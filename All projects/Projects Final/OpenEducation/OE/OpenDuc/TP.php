<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../Login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>TPs</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/styles.css">
    </head>
    
    
    <body>
        <div class="container site">
            <h1 class="text-logo"><span class="glyphicon glyphicon-book"></span> TPs <span class="glyphicon glyphicon-book"></span></h1>
            <a class="btn btn-default" href="../index.php"><span class="glyphicon glyphicon-chek"></span>Reteur dans Main</a>
            <a class="btn btn-primary" href="admin/insert.php"><span class="glyphicon glyphicon-chek"></span>Ajouter Un Fechier</a>
            <?php
				require 'admin/database.php';
			 
                echo '<nav>
                        <ul class="nav nav-pills">';

                $db = Database::connect();
                $statement = $db->query('SELECT * FROM modules');
                $modules = $statement->fetchAll();
                foreach ($modules as $module) 
                {
                    if($module['IdModule'] == '1')
                        echo '<li role="presentation" class="active"><a href="#'. $module['IdModule'] . '" data-toggle="tab">' . $module['NomModule'] . '</a></li>';
                    else
                        echo '<li role="presentation"><a href="#'. $module['IdModule'] . '" data-toggle="tab">' . $module['NomModule'] . '</a></li>';
                }

                echo    '</ul>
                      </nav>';

                echo '<div class="tab-content">';

                foreach ($modules as $module) 
                {
                    if($module['IdModule'] == '1')
                        echo '<div class="tab-pane active" id="' . $module['IdModule'] .'">';
                    else
                        echo '<div class="tab-pane" id="' . $module['IdModule'] .'">';
                    
                    echo '<div class="row">';
                    $statement = $db->prepare('SELECT * FROM contpédag WHERE contpédag.Type = 2 AND contpédag.Module = ?');
                    $statement->execute(array($module['IdModule']));
                    while ($item = $statement->fetch()) 
                    {
                        echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
        
                                    <div class="caption">
                                        <h4>' . $item['NomPDF'] . '</h4>
                                         <h4> Ajouter Par </h4>
                                        <p>' . $item['AjouterPar'] . '</p>';
                                    
                        echo '<a class="btn btn-danger" href="PDF/'.$item['NomFichePDF'].'"><span class="glyphicon glyphicon-log-in"></span>--VOIR--</a> <image src="../images/PDF.jpg">';
                        echo '</div>

                                </div>
                            </div>';
                    }
                   
                   echo    '</div>
                        </div>';
                    
                   
                }
                Database::disconnect();
                echo  '</div>';
            ?>
        </div>
        
    </body>
</html>

