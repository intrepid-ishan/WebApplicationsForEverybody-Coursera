<!-- --------backend stuff-------- -->
<!-- note: we have already entered md5(salt+pass) in database -->
<?php
//start in each file where you need session variable
session_start();
require_once "pdo.php";
require_once 'util.php';
//if dont want to login in
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}
$salt = 'XyZzy12*_';

//executed when form submitted
if (isset($_POST['pass']) && isset($_POST['email'])) {


    // // -------- php validation --------
    // if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
    //     // $failure = "Email and password are required";
    //     $_SESSION['error'] = "Email must have an at-sign (@)";
    //     header("Location: login.php");
    //     return;
    // } else {
    //     $pass = htmlentities($_POST['pass']);
    //     $email = htmlentities($_POST['email']);

    //     if ((strpos($email, '@') === false)) {
    //         // $failure = "Email must have an at-sign (@)";
    //         $_SESSION['error'] = "Email must have an at-sign (@)";
    //         header("Location: login.php");
    //         return;
    //     } // --------end php validation-------- 

    //--------script for username and password matching-------- 

    $msg = validateProfile();
    if (is_string($msg)) {
        $_SESSION['error'] = $msg;
        header("Location:login.php");
        return;
    }
    else{
    $check = hash('md5', $salt . $_POST['pass']);
    //check for email and password entered in database table
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));

    //fetch as associative array, coloum name as key
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //if no such array found then will return ***false***

    //if found
    if ($row == true) {
        //for that user store its name and user_id
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];
        // Redirect the browser to index.php ###alternateoption### new php file to avoid if statement in index.php
        header("Location: index.php");
        return;
    } //if not
    else {
        $_SESSION['error'] = "Not Matched";
        //redirect to same page to break post submission again
        header("Location: login.php");
        return;
    }
}

}
?>
<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Login cf6c7f1e</title>
</head>
<body>
    <div class="container">
        <h1>Please Log In</h1>

        <!-- --------flash message box-------- -->
        <?php
        flashMessages();
        ?>



        <!-- --------login form-------- action="login.php" -->
        <div class="form-group">
            <form method="POST">
                <input type="text" class="form-control col-sm-4" placeholder="Email" name="email"><br>
                <input type="password" class="form-control col-sm-4" placeholder="Password" name="pass" id="id_1723"><br>
                <!-- <button type="submit" class="btn btn-success" onclick="return doValidate();">Log in</button> -->
                <input type="submit"  onclick="return doValidate()"; value="Log In">
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>



        <!-- --------javascript validation-------- -->
        <script>
            //redirected from line72
            function doValidate() {
                pw = document.getElementById('id_1723').value;
                if (!pw) {
                    alert("Both fields must be filled out");
                    return false;
                    //form will abort its normal flow and it will not be submitted
                } else {
                    return true;
                    //form will be submitted as POST and php script will be activated where post is there
                }
            }
        </script>




        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
            <!-- php123 -->
        </p>
    </div>
</body>

</html>