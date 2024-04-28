<?php
$bdd = new SQLite3('MVDB.db');

$query = "CREATE TABLE users (
    Id INTEGER PRIMARY KEY,
    Password varchar(22) NOT NULL,
    FirstName varchar(44) NOT NULL,
    LastName varchar(44) NOT NULL,
    Email varchar(44) NOT NULL,
    Status varchar(10) NOT NULL
  );";
$bdd->exec($query) ;

$query = "CREATE TABLE IF NOT EXISTS films (
    id INTEGER PRIMARY KEY,
    Nom_Film TEXT,
    date_sortie DATE,
    Adult INTEGER,
    gnere TEXT,
    statut TEXT,
    mediatype TEXT,
    synopsis TEXT
);";
$bdd->exec($query) ;

$query = "CREATE TABLE favories (
    id INTEGER PRIMARY KEY,
    movie_id int(11) NOT NULL,
    user_id int(11) NOT NULL, 
    FOREIGN KEY (movie_id) REFERENCES films (id),
    FOREIGN KEY (user_id) REFERENCES users (id)
  );";
$bdd->exec($query) ;

$query = "CREATE TABLE ratings (
    id  INTEGER PRIMARY KEY,
    movie_id int(11) NOT NULL, 
    rating varchar(10) NOT NULL,
    FOREIGN KEY (movie_id) REFERENCES films (id)
  );";
$bdd->exec($query) ;

?> 