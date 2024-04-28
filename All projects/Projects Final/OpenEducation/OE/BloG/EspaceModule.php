
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

$db = Database::connect();
                $statement = $db->query("SELECT * FROM modules  ORDER BY NomModule ASC");
                $articles = $statement->fetchAll();


?>





<!DOCTYPE html>
<html>
    <head>
        <title>Espace Modules</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style.css">
    </head>
    
    
    <body data-spy="scroll" data-target=".navbar" data-offset="60">
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
                        <li><a href="newpost.php">Poser une Question</a></li>
                        <li><a href="../index.php">Main Menu</a></li>    
                        
                    </ul>
                </div>
            
            </div>
        
        </nav>
        
        
        
        </section>
        
       
        <section id="about">    
           
<div class="container">
    <h1 style="text-align: center; color: darkcyan;"> Espace des Modules </h1>
    <br>
     <br>
      <br>
                    <h1><strong>- Choisir un Module :</strong></h1>
                    <br>
      <br>

    <?php foreach ($articles as $article) { ?>
        <article class="article">
            <a href="singleM.php?id=<?php echo $article['IdModule'];?>" class="singlearticle" title="Lire la suite">
                             
            <?php  echo '<div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                
                                <div class="caption">
                                    <h4>' . $article['NomModule'] . '</h4>
                            
                                 ';
                                 echo '<image src="../images/f.gif">'
                                      
                        ?>
            </a>
         
        </article>
    <?php } ?>

    </div>
            
        
        </section>






       

        



     
    
        
        
      
     
     
        
        
        
    </body>

</html>