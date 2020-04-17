<?php 

session_start();

if ( isset($_POST['logout'] ) ) {
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash= '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$failure = false;  

if ( isset($_POST['email']) && isset($_POST['pass']) ) 
{
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) 
    {
        // $failure = "Email and password are required";
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } 
    else 
    {
        $pass = htmlentities($_POST['pass']);
        $email = htmlentities($_POST['email']);

        if ((strpos($email, '@') === false)) 
        {
            // $failure = "Email must have an at-sign (@)";
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        else
        {
            $check = hash('md5', $salt.$pass);
            if ( $check == $stored_hash ) 
            {
                
                // error_log("Login success ".$email);
                // header("Location: autos.php?name=".urlencode($email)); //name=
                // return;
                // Redirect the browser to view.php
                $_SESSION['name'] = $_POST['email'];
                header("Location: view.php");
                return;

            } 
            else 
            {
                error_log("Login fail ".$email." $check");
                // $failure = "Incorrect password";
                $_SESSION['error'] = "Incorrect password";
                header("Location: login.php");
                return;
            }
        }
    }
}

// Fall through into the View
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ishan Makadia Login Page ff2215a0</title>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>Please Log In</h1>
                <?php
               
                    // if ( $failure !== false ) 
                    // {
                    //     echo(
                    //         '<p style="color: red;" class="col-sm-10 col-sm-offset-2">'.
                    //             htmlentities($failure).
                    //         "</p>\n"
                    //     );
                    // }
                    if ( isset($_SESSION['error']) ) {
                        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                        unset($_SESSION['error']);
                    }

                ?>
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="email" id="email">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pass">Password:</label>
                    <div class="col-sm-3">
                        <input class="form-control" type="text" name="pass" id="pass">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <input class="btn btn-primary" type="submit" value="Log In">
                        <input class="btn" type="submit" name="logout" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>