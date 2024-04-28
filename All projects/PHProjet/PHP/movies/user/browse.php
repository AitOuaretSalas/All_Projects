<?php

session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../index.php');
}

?>


<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>chercher ton film favoris</title>

    <link rel="stylesheet" href="../css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Arimo' rel='stylesheet'>
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-secondary navbar-dark fixed-top ">

        <a class="navbar-brand" href="index.php">
            <img src="../image/icon.png" alt="logo"> MoviesLand
        </a>


        <ul class="navbar-nav mr-auto">

        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="#">On est Va </a>
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


    <div class="container-fluid body">
        <div class="container">
            <div class="sbox">

                <div>
                    <center>
                        <div class="content">
                            <h1 style="color: white">MoviesLand: Information about over 10k+ movies</h1>
                        </div>
                    </center>
                    <form id="searchForm">
                        <input type="text" class="searchBox" placeholder="Search Movies here" id="searchText">
                    </form>
                </div>
            </div>
        </div>

        <div class="container">
            <div id="movies" class="row"></div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; Copyright Developed by ZasDev.</p>
    </div>

 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="../js/main.js"></script>
    <script>
        popularMovies();
    </script>
</body>

</html>