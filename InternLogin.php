<!DOCTYPE html>
<html>
    <head>
        <title>College Internships</title>
    </head>
    <body>
    <h3>Jennifer Reisinger CS316</h3>
        <h3>Assignment 9-1</h3><hr />
        <h1>College Internships</h1>
        <h2>Register / Log In</h2>
        <p>New interns, please complete the top form to register as a user. Returning users, please complete
            the second form to log in.</p><hr />

        <h3>New Intern Registration</h3>
        <form method = "post" action = "RegisterIntern.php">
            <p>Enter your name: First: <input type = "text" name= "first_name" />
                Last: <input type = "text" name = "last_name" /></p>
            <p>Enter your e-mail address: <input type = "text" name = "email" /></p>
            <p>Enter a password for your account: <input type = "password" name = "password" /></p>
            <p>Confirm your password: <input type = "password" name = "password2" /></p>
            <p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
                <input type = "reset" name = "reset" value = "Reset Registration Form" />
                <input type = "submit" name = "register" value = "Register" />
        </form>
        <hr />
        <h3>Returning Intern Login</h3>
        <form method = "post" action = "VerifyLogin.php">
            <p>Enter your e-mail address: <input type = "text" name = "email" /></p>
            <p>Enter your password: <input type = "password" name = "password" /></p>
            <p><em>(Passwords are case-sensitive and must be at least 6 characters long)</em></p>
                <input type = "reset" name = "reset" value = "Reset Login Form" />
                <input type = "submit" name = "login" value = "Log In" />
        </form>
        <hr />
    <?php
        session_start();
        $_SESSION = array();
        session_destroy();
    ?>
        
    </body>
</html>