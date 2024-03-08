<?php
            session_start();
            
            $Body = "";
            $errors = 0;
            $email = "";

            //validate the email address entered
            if(empty($_POST['email'])){
                ++$errors;
                $Body .= "<p>You need to enter an e-mail address.</p>\n";
            }
            else{
                $email = stripslashes($_POST['email']);
                if (preg_match("/^[\w-]+(\.[\w-]+)*@" .
                    "[\w-]+(\.[\w-]+)*(\.[a-zA-Z]{2,})$/i",
                    $email) == 0) {
                        ++$errors;
                        $Body .= "<p>You need to enter a valid e-mail address.</p>\n";
                        $email = "";
                    }
            }

            //validate the password
            if (empty($_POST['password'])){
                ++$errors;
                $Body .= "<p>You need to enter a password.</p>\n";
                $password = "";
            }
            else{
                $password = stripslashes($_POST['password']);
                if (empty($_POST['password2'])){
                    ++$errors;
                    $Body .= "<p>You need to enter a confirmation password.</p>\n";
                    $password2 = "";
                }
                else
                    $password2 = stripslashes($_POST['password2']);
                    if ((!(empty($password))) && (!(empty($password2)))){
                        if (strlen($password) < 6){
                            ++$errors;
                            $Body .= "<p>The password is too short.</p>\n";
                            $password = "";
                            $password2 = "";
                        }
                        if ($password <> $password2){
                            ++$errors;
                            $Body .= "<p>The passwords do not match.</p>\n";
                            $password ="";
                            $password2 = "";
                        }
                    }
            }

            //connect to the database
            $DBConnect = FALSE;
            if($errors ==0){
                $DBConnect = new mysqli("localhost","root","");
                if($DBConnect === FALSE){
                    $Body .= "<p>Unable to connect to the database server. " . 
                    "Error code " . $DBConnect -> connect_errno . ": " . 
                    $DBConnect -> error . "</p>\n";
                    ++$errors;
                }
                else{
                    $DBName = "internships";
                    $result = $DBConnect -> select_db($DBName);
                    if ($result === FALSE){
                        $Body .= "<p>Unable to select the database. " . 
                        "Error code " . $DBConnect -> connect_errno . ": " . 
                        $DBConnect -> error . "</p>\n";
                        ++$errors;
                    }
                }
            }

            //verify email address entered isn't already in the interns table
            $TableName = "interns";
            if ($errors == 0){
                $SQLstring = "SELECT COUNT(*) FROM $TableName " . 
                    "WJERE email = '$email'";
                $QueryResult = $DBConnect -> query($SQLstring);
                if ($QueryResult !== FALSE){
                    $Row = $QueryResult -> fetch_row();
                    if ($Row[0]>0){
                        $Body .= "<p>The email address entered (" . 
                            htmlentities($email) . 
                            ") is already registered.</p>\n";
                            ++$errors;
                    }
                }
            }

            //show the appropriate error messages
            if ($errors > 0){
                $Body .= "<p>Please use your browser's BACK button to return" . 
                    " to the form and fix the errors indicated.</p>\n";
            }

            //add the new user to the interns table
            if ($errors == 0){
                $first = stripslashes($_POST['first_name']);
                $last = stripslashes($_POST['last_name']);
                $SQLstring = "INSERT INTO $TableName " . 
                    " (first_name, last_name, email, password_md5) " . 
                    " VALUES('$first', '$last', '$email', " . 
                    " '" . md5($password) . "')";
                $QueryResult = $DBConnect -> query($SQLstring);
                if ($QueryResult === FALSE) {
                    $Body .= "<p>Unable to save your registration " . 
                    " information. Error code " . $DBConnect -> connect_errno . 
                    ": " . $DBConnect -> error . "</p>\n";
                    ++$errors;

                }
                else {
                    $_SESSION['internID']= mysqli_insert_id($DBConnect);
                }
                setcookie("internID", $InternID);
                $DBConnect -> close();
            }

            if ($errors == 0){
                $InternName = $first . " " . $last;
                $Body .= "<p>Thank you, $InternName. ";
                $Body .= "Your new Intern ID is <strong>" . 
                    $_SESSION['internID'] . "</strong>.</p>\n";
            }

            //include form with hidden field from verifylogin if no errors
            if ($errors == 0){
                $Body .= "<p><a href='AvailableOpportunities.php?" .
                    SID . "'>View Available Opportunities</a></p>\n";
            }
        
        ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Intern Registration</title>
    </head>
    <body>
    <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 9-1</h3><hr />
        <h1>College Internships</h1>
        <h2>Intern Registration</h2>

        <?php
            echo $Body;
        ?>

    </body>
</html>