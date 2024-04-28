<?php 
    session_start();
    include_once "config.php";
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(!empty($email) && !empty($password))
    {
        $sql = $bdd->query("SELECT * FROM users WHERE Email = '{$email}'");
       $row= $sql->fetchArray();
        if($row !=null){
            $user_pass = md5($password);
            $enc_pass = $row['Password'];
            if($user_pass === $enc_pass){
              
                    $_SESSION['id'] = $row['Id'];
                    $_SESSION['Nom'] = $row['FirstName'];
                    $_SESSION['prénom'] = $row['LastName'];
                    $_SESSION['loggedin'] = true;

                    
                    echo "success";
                }else
                {
                echo "Email or Password is Incorrect!";
             }
        } else
        {
            echo "email has not rlied a compt ";
        }
    }
    else
    {
        echo "All input fields are required!";
    }
  
?>