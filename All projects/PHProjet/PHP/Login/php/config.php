<?php
  $bdd = new SQLite3('MVDB.db');

  $query = "CREATE TABLE IF NOT EXISTS users (
      Id INTEGER PRIMARY KEY,
      Password varchar(22) NOT NULL,
      FirstName varchar(44) NOT NULL,
      LastName varchar(44) NOT NULL,
      Email varchar(44) NOT NULL
    );";
  $bdd->exec($query) ;
?>
