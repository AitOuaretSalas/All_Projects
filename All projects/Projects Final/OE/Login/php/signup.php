<?php
    session_start();
    include_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){
                echo "$email - This email already exist!";
            }else{
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$status}')");
                                if($insert_query){
                                    $select_query = mysqli_query($conn, "SELECT * FROM users WHERE email='{$email}'");
                                    $result = mysqli_fetch_assoc($select_query);
            
                                        $_SESSION['id'] = $result['user_id'];
                                        $_SESSION['Nom'] = $result['fname'];
                                        $_SESSION['prénom'] = $result['lname'];
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