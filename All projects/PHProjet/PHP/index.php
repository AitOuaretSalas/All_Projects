<?php
// Initialize the session
session_start();
if(isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] == true){
    $_SESSION["username"]=  htmlspecialchars($_SESSION["Nom"])." ".htmlspecialchars($_SESSION["prénom"]);
}
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: Login/login.php");
    exit;
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Main Menu</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/style.css">
        <script src="js/script.js"></script>
    </head>
    
    
    <body data-spy="scroll" data-target=".navbar" data-offset="60">
        
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
                        <li><a href="#portfolio">Espace Films</a></li>   
                        <li><a href="#PF">Rejoignez Nous dans notre communauté</a></li>    
                        <li><a href="#recommandations">citations</a></li>
                    </ul>
                </div>
            
            </div>
        
        </nav>
       
        <section id="about">
           
           
         <div class="heading">
                  <h1 class="my-5">Hi, <b><?php echo htmlspecialchars($_SESSION["Nom"])." ".htmlspecialchars($_SESSION["prénom"]); ?></b>. Welcome to our site.</h1>
                  <h1>MoviesLand</h1>
    <p>
        <a href="Login/logout.php" class="btn btn-danger ml-3">Sign Out of Your Account</a>
    </p>
            </div>
        
        </section>




        <section id="portfolio">
            <div class="container">
                <div class="white-divider"></div>
                <div class="heading">
                    <h2>Espace Films</h2>
                </div>
                <div class="row">


                <div class="col-sm-6">
                        <h1>meilleurs films notés <br> </h1>
                        <a class="thumbnail" href="Top_Mov/index.php" >
                            <img src=images/R1.png alt="TD">
                        </a>
                    </div>    
                   

                    <div class="col-sm-6">
                        <h1> MoviesLand<br> </h1>
                        <a class="thumbnail" href=movies/index.php>
                            <img src=images/S.jpg alt="TD">
                        </a>
                    </div>
             </div>

            <div class="row">

            <div class="col-sm-6">
                        <h1>
                        Rechercher par critére<br> </h1>
                        <a class="thumbnail" href=R-Mov/index.php>
                            <img src=images/R1.jpg alt="TD">
                        </a>
                    </div>

                <div class="col-sm-6">
                         <h1>
                         <br>
                        Contactez Nous 
                            </h1>
                        <a class="thumbnail" href="contact/index.php" target="blank" >
                            <img src="images/l1.jpg" alt="forum de descussion">
                        </a>
                </div>
                   
                  
                  

               
                  
            </div>
                
            </div>
        </div>
            
        </section>


        



        
       
        
        <section id="PF">
            <div class="container">
                <div class="white-divider"></div>
                <div class="heading">
                    <h2>Rejoignez Nous sur : </h2>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <a class="thumbnail" href="http://www.facebook.com" target="_blank">
                            <img src="images/facebook_share.png" alt="facebook">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="thumbnail" href="http://www.google.com" target="_blank">
                            <img src="images/youtube.png" alt="youtube">
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a class="thumbnail" href="http://www.instagram.com" target="_blank">
                            <img src="images/ins.png" alt="Instagram">
                        </a>
                    </div>
                </div>
            
            </div>
            
        </section>
                
        
        
      
     
        <section id="recommandations">
            <div class="container">
                <div class="red-divider"></div>
                <div class="heading">
                    <h2>Citataions</h2>
                </div>
                <div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
                    <ol class="carousel-indicators">
                         <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                         <li data-target="#myCarousel" data-slide-to="1"></li>
                         <li data-target="#myCarousel" data-slide-to="2"></li>  
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <h3>" Innover, c'est savoir abandonner des milliers de bonnes idées. "</h3>
                                  
                        </div>
                          <div class="item">
                            <h3>"La vie, c'est comme une bicyclette, il faut avancer pour ne pas perdre l'équilibre."</h3>
                                  
                        </div>
                          <div class="item">
                            <h3>"La difficulté se trouve dans l'absence de quelque chose de tout simple"</h3>
                                  
                        </div>
                    </div>
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev" role="button">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next" role="button">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                
                </div>
            
            </div>
        
        
        </section>
        
        <footer class="text-center">
            <a href="#about">
                <span class="glyphicon glyphicon-chevron-up"></span>
            </a>
            <h5>©ZasDev.<br><br>copyrights 2023</h5>
        </footer>
                
        
        
    </body>

</html>