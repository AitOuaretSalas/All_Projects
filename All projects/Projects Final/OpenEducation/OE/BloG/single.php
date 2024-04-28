
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

?>


<?php include('include/functions.php');

?>
<?php
   require 'database.php';
   $succées="";

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
  $lien= "single.php?id". $id;
    // echo $id;
} else {
    // Fausse redirection
    die('404');
}


$db = Database::connect();
                $statement = $db->query("SELECT * FROM articles  ORDER BY created_at DESC");
                $articles = $statement->fetchAll();


                $statement = $db->query("SELECT * FROM comments WHERE id_article = $id  ORDER BY created_at DESC");
                $comments = $statement->fetchAll();
                Database::disconnect();
$error = array();


if (!empty($_POST['submit'])) {
   
    $comm = trim(strip_tags($_POST['comm']));
    

    $error = validation($error,$comm,'comm',2,350);
   
    // si aucune erreur
    if(count($error) == 0) {
        $success = true;
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO comments (id_article, content, auteur, created_at, statut) VALUES (?, ?, ?, ?, ?)");
        $statement->execute(array($id,$comm,$_SESSION["username"],date("y-m-d H:i:sa"),"actif"));
        Database::disconnect();
        header('Location: single.php?id='. $id);
        
    
    } 

}

?>


<head>
        <title>La question et ses Réponses</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="style.css">
</head>
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
                        <li><a href="EspaceModule.php">Espace Modules</a></li>
                        <li><a href="../index.php">Main Menu</a></li>    
                        
                    </ul>
                </div>
            
            </div>
        
        </nav>
        
       
        
 </section>

    <div class="red-divider"></div>
    <div class="container admin">
    <div  class="row">

        <?php foreach ($articles as $article) { ?>
            <?php if($id == $article['id']) { ?>
                <article >
                    <h1 style="color: darkblue; text-align: center;"> Le Titre : <?php echo $article['title']; ?></h1> 
                    <br>
                    <br>
                    <h1> - La Question :    </h1>     
                    <br>
                    <br>             
                    <h4 class=" some-class"  style="color: darkred;"> - &quot;<?php echo $article['content']; ?>&quot;</h4>
                </article>
            <?php } ?>
        <?php } ?>

         </div>

        </div>
         <br>
         <br>
         <br>
         <br>
         
         <div class="red-divider"></div>

         <div class="container admin">
            <div class="row">
                <p class="help-inline" style="text-align: center; font-size: 50px"> <?php echo $succées;?> </p>
                <h1 style="color: darkblue; text-align: center;"><strong>Répondre à  La Question</strong></h1>
                <br>
                <form class="form" action="" role="form" method="post">
                    
                   
                    <div class="form-group">
                        <label for="description">Votre Réponse:</label>
                        <input type="text" class="form-control" id="comm" name="comm" placeholder="Votre réponse"?>
                        <span class="help-inline"><?php if(!empty($error['comm'])) { echo $error['comm']; } ?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        
                       
                        <input class="btn btn-success" type="submit" class="submit" name="submit" value="Répondre">
                   </div>
                </form>
            </div>
        </div>   








        <br>
         <br>
         <br>
         <br>









     
<div class="container">
<div class="red-divider"></div>
<h1 style="text-align: center; color: darkcyan;">Les Réponses : </h1>
<br>
<br>

<?php foreach ($comments as $comment) { ?>
    <?php $date = date('d/m/Y', strtotime($comment['created_at'])); ?>
    <?php $heure = date('H:i', strtotime($comment['created_at'])); ?>
    <?php $contenu = $comment['content']; ?>
    <article class="article">
        
                         
        <?php  echo '<div class="col-sm-6 col-md-12">
                        <div class="thumbnail">

                            <div class="caption">
                                <h4>' . $comment['auteur'] . '</h4>
                                <div class=" some-class"  >' . $contenu . '</div>
                             ';
                                  
                    ?> 
                    <div ><?php echo $date; ?></div> 
                    <div ><?php echo $heure; ?></div> 
    
     
    </article>
<?php } ?>

</div>
        
    