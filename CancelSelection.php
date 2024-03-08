<!DOCTYPE html>
<html>
    <head>
        <title>Cancel Selection</title>
    </head>
    <body>
    <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 9-1</h3><hr />
        <h1>Cancel Selection</h1>
<?php
    session_start();
    
    //verify the correct information was passed to this page
    $Body ="";
    $errors = 0;
    if (!isset($_SESSION['internID'])){
        $Body .="<p>You have not logged in or registered. " . 
            " Please return to the " . " <a href= 'InternLogin.php'>Registration / " . 
            " Log In page</a>.</p>\n";
        ++$errors;
    }
    
    if ($errors == 0){
        if (isset($_GET['opportunityID']))
            $OpportunityID = $_GET['opportunityID'];
        else{
            $Body .= "<p>You have not selected an opportunity. " . 
                " Please return to the " . " <a href='AvailableOpportunities.php?" .
                 SID . "'Available " . " Opportunities page</a>.</p>\n";
            ++$errors;
        }
    }

    if ($errors == 0){
        $DBConnect = new mysqli("localhost", "root", "");
        if($DBConnect === FALSE){
            $Body .= "<p>UNable to connect to the database " . 
                " server. Error code " . $DBConnect -> connect_errno . ": " . 
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

    if ($errors == 0){
        $TableName = "assigned_opportunities";
        $SQLstring = "DELETE FROM $TableName" . 
            "WHERE opportunityID=$OpportunityID " . 
            " AND internID=" . $_SESSION['internID'] . 
            " AND date_approved IS NULL";
        $QueryResult = $DBConnect -> query($SQLstring);
        if ($QueryResult === FALSE) {
                $Body .="<p>Unable to execute the query. " .
                "Error code " . $DBConnect -> connect_errno . ": " . 
                $DBConnect -> error . "</p>\n";
            ++$errors;
        }
        else{
            $AffectedRows = $DBConnect -> affected_rows;
            if ($AffefctedRows == 0)
                $Body .= "<p>You had not previously " . 
                    " selected opportunity # " . 
                    $OpportunityID . ".</p>\n";
            else
                $Body .= "<p>Your request for opportunity # " . 
                    " $OpportunityID has been " . 
                    " removed.</p>\n";
        }
        $DBConnect -> close();
    }

    if ($_SESSION['internID'] > 0)
        $Body .= "<p>Return to the <a href='" . 
            "AvailableOpportunities.php?" . SID . "'>" . 
            "Available Opportunities</a> page.</p>\n";
    else
        $Body .= "<p>Please <a href='InternLogin.php'>Register " . 
            " or Log In</a> to use this page.</p>\n";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Cancel Selection</title>
    </head>
    <body>
        <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 9-1</h3><hr />
        <h1>College Internships</h1>
        <h2>Cancel Selection</h2>
        <?php
            echo $Body;
        ?>
    </body>
</html>