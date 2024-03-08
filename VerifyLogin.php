<?php
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Verify Intern Login</title>
    </head>
    <body>
    <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 9-1</h3><hr />
        <h1>College Internships</h1>
        <h2>Verify Intern</h2>

        <?php
            $errors = 0;
            $DBConnect = new mysqli("localhost","root","");
            if ($DBConnect === FALSE){
                echo "<p>Unable to connect to the database server. " . 
                "Error code " . $DBConnect -> connect_errno . ": " . 
                $DBConnect -> error . "</p>\n";
                ++$errors;
            }
            else{
                $DBName = "internships";
                $result = $DBConnect -> select_db($DBName);
                if ($result === FALSE){
                    echo "<p>Unable to select the database. " . 
                    "Error code " . $DBConnect -> connect_errno . ": " . 
                    $DBConnect -> error . "</p>\n";
                    ++$errors;
                }
            }

            //verify that the email and password are in the interns table
            $TableName = "interns";
            if ($errors == 0){
                $SQLstring = "SELECT internID, first_name, last_name FROM $TableName" . 
                " WHERE email = '" . stripslashes($_POST['email']) . 
                "' and password_md5 = '" . 
                md5(stripslashes($_POST['password'])) . "'";
            $QueryResult = $DBConnect -> query($SQLstring);
            
            if (mysqli_num_rows($QueryResult)==0){
                echo "<p>The e-mail address/password " . 
                " combination entered is invalid.</p>\n";
            ++$errors;
            }
            else{
                $Row = $QueryResult -> fetch_assoc();
                $_SESSION['internID'] = $Row['internID'];
                $InternName = $Row['first_name'] . " " . 
                $Row['last_name'];
                echo "<p>Welcome back, $InternName!</p>\n";
            }
            }

            //display appropriate message if no errors
            if ($errors == 0) {
                echo "<p><a href='AvailableOpportunities.php?" . 
                SID . "'>Available Opportunities</a></p>\n";
            }

        ?>
    </body>
</html>