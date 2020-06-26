<!-- same logic as edit.php instead of update->insert -->
<!-- --------backend stuff-------- -->
<?php
session_start();
//***testcases***
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}


//--------addition in table with validation--------

require_once "pdo.php";
//double check of post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['first_name'])
        && isset($_POST['last_name'])
        && isset($_POST['email'])
        && isset($_POST['headline'])
        && isset($_POST['summary'])
    ) {
        //validation
        if (
            strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 ||
            strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1
        ) {
            $_SESSION['fail'] = 'All values are required';
            header("Location: add.php");
            return;
        } 
        //after validation insert
        else {
            $stmt = $pdo->prepare('INSERT INTO Profile (user_id,first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline,:summary)');
            $stmt->execute(
                array(
                    ':user_id' => $_SESSION['user_id'],
                    ':first_name' => $_POST['first_name'],
                    ':last_name' => $_POST['last_name'],
                    ':email' => $_POST['email'],
                    ':headline' => $_POST['headline'],
                    ':summary' => $_POST['summary']
                )
            );
            $_SESSION['success'] = "Record added.";
            header("Location: index.php");
            return;
        }
    }
} 
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Add Profile</title>
</head>

<body>
    <div class="container">
        <h1>Adding Profile for ITNU,Nirma</h1>
        
        <!-- --------flash message box-------- -->
        <?php
        if (isset($_SESSION['fail'])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION['fail']) . "</p>\n");
            unset($_SESSION['fail']);
        }
        ?>

        <!-- --------simple form--------  -->
        <div class="form-group">
            <form method="post">
                <input type="text" class="form-control col-sm-4" placeholder="First Name" name="first_name"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Last Name" name="last_name"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Email" name="email"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Headline" name="headline"><br>
                <textarea class="form-control col-sm-8" placeholder="Summary" id="exampleTextarea" rows="5" name="summary"></textarea><br>
                <button type="submit" class="btn btn-primary">Add</button>
                <!-- <p><a href="add.php">Add New Entry</a></p> -->
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>
    </div>
</body>

</html>