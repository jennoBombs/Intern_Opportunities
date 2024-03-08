<!DOCTYPE html>
<html>
    <head>
        <title>Request Opportunity</title>
    </head>
    <body>
    <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 9-1</h3><hr />
        <h1>College Internships</h1>
        <h2>Opportunity Requesteed</h2>

        <?php

        session_start();

$Body = "";
$errors = 0;
$InternID = 0;

if (!isset($_SESSION['internID'])){
    $Body .= "<p>You have not logged in or registered. " .
        "Please return to the " .
        " <a href='InternLogin.php'>Registration / Log In page</a>.</p>";
        ++$errors;
}


if ($errors == 0) {
    if (isset($_GET['opportunityID']))
        $OpportunityID = $_GET['opportunityID'];
    else {
        $Body .= "<p>You have not selected an opportunity. " .
            " Please return to the <a href='AvailableOpportunities.php?" .
            SID . "'>Available Opportunities page</a>.</p>";
        ++$errors;
    }

    if ($errors == 0) {
        $DBConnect = new mysqli("localhost", "root", "");
        if ($DBConnect === FALSE) {
            $Body .= "<p>Unable to connect to the database server. " .
                "Error code " . $DBConnect->connect_errno . ": " .
                $DBConnect->error . "</p>\n";
            ++$errors;
        } else {
            $DBName = "internships";
            $result = $DBConnect->select_db($DBName);
            if ($result === FALSE) {
                echo "<p>Unable to select the database. " .
                    "Error code " . $DBConnect->connect_errno . ": " .
                    $DBConnect->error . "</p>\n";
                ++$errors;
            }
        }
    }

    $DisplayDate = date("l, F j, Y, g:i A");
    $DatabaseDate = date("Y-m-d H:i:s");
    if ($errors == 0) {
        $TableName = "assigned_opportunities";
        $SQLstring = "INSERT INTO $TableName " .
            " (opportunityID, internID, date_selected) " .
            " VALUES ('$OpportunityID', " . $_SESSION['internID'] . ", '$DatabaseDate')";
        $QueryResult = $DBConnect->query($SQLstring);
        if ($QueryResult === FALSE) {
            echo "<p>Unable to execute the query. " .
                "Error code " . $DBConnect->connect_errno . ": " .
                $DBConnect->error . "</p>\n";
            ++$errors;
        } else {
            $Body .= "<p>Your request for opportunity # " .
                " $OpportunityID has been entered " .
                " on $DisplayDate.</p>\n";
        }

        $DBConnect->close();
    }

    if ($errors == 0 && $_SESSION['internID'] > 0)
        $Body .= "<p>Return to the <a href='" .
            "AvailableOpportunities.php?" . SID . "'>" .
            "Available Opportunities</a> page.</p>\n";
    }

    if ($errors == 0 && $InternID <= 0) {
        $Body .= "<p>Please <a href='InternLogin.php'>Register " .
            " or Log In</a> to use this page.</p>\n";
    }

    if ($errors == 0)
        setcookie("LastRequestDate",urlencode($DisplayDate),
        time()+60*60*24*7);

    echo $Body;

?>

</body>
</html>