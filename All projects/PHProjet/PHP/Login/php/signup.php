<?php
    session_start();
    include_once "config.php";
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = $bdd->query( "SELECT * FROM users WHERE Email = '{$email}'");
            $row= $sql->fetchArray();
            if($row > 0){
                echo "$email - This email already exist!";
            }else{
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                $insert_query = $bdd->exec( "INSERT INTO users (Id,Password,FirstName, LastName, Email)
                                VALUES ({$ran_id}, '{$encrypt_pass}', '{$fname}','{$lname}', '{$email}')");
                                if($insert_query){
                                    $select_query = $bdd->query( "SELECT * FROM users WHERE Email='{$email}'");
                                    $result=$sql->fetchArray();
            
                                        $_SESSION['id'] = $result['Id'];
                                        $_SESSION['Nom'] = $result['FirstName'];
                                        $_SESSION['prénom'] = $result['LastName'];
                                        $_SESSION['loggedin'] = true;
                                        echo "success";
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            
                        
                    
                }
            
        }else{
            echo "$email is not a valid email!";
        }
    }
    else{
        echo "All input fields are required!";
    }
?>