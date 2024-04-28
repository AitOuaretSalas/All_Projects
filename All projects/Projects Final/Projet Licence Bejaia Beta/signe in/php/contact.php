<?php

    $array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "isSuccess" => false);


    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    { 
        $array["firstname"] = test_input($_POST["firstname"]);
        $array["name"] = test_input($_POST["name"]);
        $array["email"] = test_input($_POST["email"]);
        $array["phone"] = test_input($_POST["phone"]);
        $array["isSuccess"] = true; 
       
    
        
        if (empty($array["firstname"]))
        {
            $array["firstnameError"] = "Je veux connaitre ton prénom !";
            $array["isSuccess"] = false; 
        } 
       

        if (empty($array["name"]))
        {
            $array["nameError"] = "Et oui je veux tout savoir. Même ton nom !";
            $array["isSuccess"] = false; 
        } 
       

        if(!isEmail($array["email"])) 
        {
            $array["emailError"] = "T'essaies de me rouler ? C'est pas un email ça  !";
            $array["isSuccess"] = false; 
        } 
       

        if (!isPhone($array["phone"]))
        {
            $array["phoneError"] = "Que des chiffres et des espaces, stp...";
            $array["isSuccess"] = false; 
        }
      

        
        if($array["isSuccess"]) 
        {
                require 'DB.php';
            
            
                $db = Database::connect();
                $statement = $db->prepare("INSERT INTO utilisateurs (Nom,Prenom,Email,Tel) values(?, ?, ?, ?)");
                $statement->execute(array($array["name"],$array['firstname'],$array['email'],$array["phone"]));
                Database::disconnect();
                
           
        }
        
        echo json_encode($array);
        
    }

    function isEmail($email) 
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    function isPhone($phone) 
    {
        return preg_match("/^[0-9 ]*$/",$phone);
    }
    function test_input($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
 
?>


