<?php
  $hostname = "sql302.unaux.com";
  $username = "unaux_29314915";
  $password = "0z3rikfs7pqle";
  $dbname = "unaux_29314915_bddopeneducation";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
