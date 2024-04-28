<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../Login/login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bienvenue</title>
    <link rel="stylesheet" href="../css/index.css">
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet'>
    <link rel=" stylesheet " href="../css/bootstrap.min.css ">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>

<body>
    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark fixed-top ">
        <!-- Brand/logo -->
        <a class="navbar-brand " href="#">
            <img src="../image/icon.png " alt="logo ">MoviesLand 
        </a>
        <ul class="navbar-nav mr-auto ">
        </ul>
        <ul class="navbar-nav ">
            <li class="nav-item ">
                <a class="nav-link active " href="# ">Home</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="browse.php">on est va </a>
            </li>
        
            <li class="nav-item dropdown dropleft">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <img src="../image/default-user.png" style="width:30px; border-radius:50%;" alt="logo ">
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item disabled" style="color:silver; text-transform:lowercase;" href="#"><?php echo $_SESSION['username'] ?></a>
                </div>
            </li>
        </ul>
    </nav>


    <header>
        <div class="container body ">
            <center>
                <div class=" inner-body ">
                    <h1 class="title ">Welcome,
                        <span style="color: #6AC045; text-transform:lowercase;"><?php echo $_SESSION['username'] ?></span>
                    </h1>
                    <p style="color: white" class="content">
                        bienvenue a MoviesLand
                </div>
              
                <div class="container">
                    <a href="browse.php" class="btn-main btn-main-primary">
                        On est Va 
                    </a>
                </div>

            </center>

            <br>
			   <a href="../../index.php" class="btn btn-danger ml-3">Retour</a>
        </div>
    </header>

  
  

    <div class="footer">
        <p>&copy; Copyright Developed by ZasDev.</p>
    </div>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        getTopMovies();
    </script>
</body>

</html>