<?php

require 'config.php';

$conn = initDatabase();

$usernameErr = $emailErr = $passErr = $cpassErr = "";
$username = $email = $password = $confirm_password = "";
$fname = $_POST['fname'];
$lname = $_POST['lname'];

if (isset($_POST['submit'])) { 
    if(empty(trim($_POST["username"]))){
        $usernameErr = "Please enter a username.";
    }
    else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";


        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $usernameErr = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate email

    if (empty(trim($_POST["email"]))) {
        $emailErr = "Email is required";
      } else {
            $sql = "SELECT id FROM users WHERE email=:email";
            if($stmt = $conn->prepare($sql))
            {
                $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
                $param_email = trim($_POST["email"]);

                if($stmt->execute()){
                    if($stmt->rowCount() == 1){
                        $emailErr = "This email is already taken.";
                    } else{
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $emailErr = "Invalid email format";
                                }
                                else{
                                    $email = trim($_POST["email"]);
                                }
                            }
                } 
    
                // Close statement
                unset($stmt);
               
            }
        }
      
// Validate password
if(empty(trim($_POST["password"]))){
    $passErr = "Please enter a password.";     
} elseif(strlen(trim($_POST["password"])) < 6){
    $passErr = "Password must have atleast 6 characters.";
} else{
    $password = trim($_POST["password"]);
}

// Validate confirm password
if(empty(trim($_POST["confirm_password"]))){
    $cpassErr = "Please confirm password.";     
} else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
        $cpassErr = "Password did not match.";
    }
}

// Check input errors before inserting in database
if(empty($usernameErr) && empty($emailErr) && empty($passErr) && empty($cpassErr)){
        
    // Prepare an insert statement
    $sql = "INSERT INTO users (username, fname, lname, email, password) VALUES (:username, :fname, :lname, :email, :password)";
     
    if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
        $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
        $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);
        
        // Set parameters
        $param_username = $username;
        $param_email = $email;
        $param_fname = $fname;
        $param_lname = $lname;
        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Redirect to login page
            header("location: sign-up.php");
        } else{
            echo "Something went wrong. Please try again later.";
        }

        // Close statement
        unset($stmt);
    }
}

// Close connection
unset($conn);
}

?>