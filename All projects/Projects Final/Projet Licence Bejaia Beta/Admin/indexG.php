<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../Login/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Liste des Documents</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-folder-open"></span> Liste des Document <span class="glyphicon glyphicon-folder-open"></span></h1>
        
        <div class="container admin">
        <a class="btn btn-primary" href="../../index.php"><span class="glyphicon glyphicon-chevron-left"></span>Reteur au Main</a>
            <div class="row">

                <h1><strong>Liste des Documents  </strong><a href="insertG.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Ajouter</a></h1>
                
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>AjouterPar</th>
                      <th>Catégorie</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        require 'database.php';
                        $db = Database::connect();
                        $statement = $db->query('SELECT guides.IdPDF, guides.NomPDF, guides.AjouterPar,guides.NomFichePDF, catégories.Nomcatégorie AS category FROM guides LEFT JOIN catégories ON guides.catégorie = catégories.IdCatégorie ORDER BY guides.AjouterPar DESC');
                        while($item = $statement->fetch()) 
                        {
                            echo '<tr>';
                            echo '<td>'. $item['NomPDF'] . '</td>';
                            echo '<td>'. $item['AjouterPar'] . '</td>';
                            echo '<td>'. $item['category'] . '</td>';
                            echo '<td width=300>';
                            
                            echo '<a class="btn btn-danger" href="../PDF/'.$item['NomFichePDF'].'"><span class="glyphicon glyphicon-log-in"></span>VOIR</a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect();
                      ?>
                  </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
