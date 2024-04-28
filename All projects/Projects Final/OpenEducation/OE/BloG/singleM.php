
<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../Login/login.php");
    exit;
}
?>

<?php
   require 'database.php';
   $succées="";

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $ids = $_GET['id'];
    $id = intval($ids);
    // echo $id;
} else {
    // Fausse redirection
    die('404');
}


$db = Database::connect();
                $statement = $db->query("SELECT * FROM articles  WHERE articles.module = $id ORDER BY created_at DESC ");
                $articles = $statement->fetchAll();
                $statement = $db->query("SELECT * FROM modules  WHERE modules.IdModule = $id ");
                $Module = $statement->fetch();


                Database::disconnect();
?>


<head>
        <title>Les Questions d'un Module</title>
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

    <div class="container admin">
    <div  class="row">
    <h1 style="text-align: center; color: darkcyan;"> Le Module : <?php echo $Module['NomModule'];?> </h1>
    <h3 style="color: darkred;"> -Notis!!!!! : cliqué sur une question pour voir les réponses ou méme répondre</h3>

    <br>
    <br>
    <h1>Les questions : </h1>
    <br>
    <br>

    <?php foreach ($articles as $article) { ?>
        <?php $date = date('d/m/Y', strtotime($article['created_at'])); ?>
        <?php $heure = date('H:i', strtotime($article['created_at'])); ?>
        <?php $contenu = substr($article['content'], 0, 40); ?>
        <article class="article">
            <a href="single.php?id=<?php echo $article['id'];?>" class="singlearticle" title="Lire la suite">
                             
            <?php  echo '<div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
    
                                <div class="caption">
                                    <h4>' . $article['auteur'] . '</h4>
                                    <h4 style="color: darkorange;"> Le Titre : </h4>
                                    <h4>' . $article['title'] . '</h4>
                                    <h4 style="color: darkorange;">Le contenu : </h4>
                                 ';

                                      
                        ?>
                        <div >&quot;<?php echo  $contenu;  ?> ... &quot;</div> 
                          <image src="../images/p.gif">
                        <div ><?php echo $date; ?></div> 
                        <div ><?php echo $heure; ?></div> 
            </a>
         
        </article>
    <?php } ?>

         </div>

        </div>
        
    