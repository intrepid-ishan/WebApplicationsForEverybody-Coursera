<!-- note:profile id recieved in $_GET['profile_id'] -->
<!-- --------backend stuff-------- -->
<?php
session_start();

require_once "pdo.php";

//***testcases**** 
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['cancel'])) {
    header('Location: index.php');
    return;
}

//when press submit all fields will be set if no value entered then also set
//instead of this 6 lines code you can use if($_SERVER["REQUEST_METHOD"]=="POST")




//--------updation in table where profile id matches--------
if (
    isset($_POST['first_name'])
    && isset($_POST['first_name'])
    && isset($_POST['last_name'])
    && isset($_POST['email'])
    && isset($_POST['headline'])
    && isset($_POST['summary'])
) {


    if (strpos($_POST['email'], '@') === false) {
        $_SESSION['error'] = 'Bad Email';
    } else {
        $sql = "UPDATE Profile SET 
            first_name = :first_name, 
            last_name = :last_name,
            email=:email,
            headline=:headline,
            summary=:summary
            WHERE profile_id = :profile_id";


        $stmt = $pdo->prepare($sql);

        $stmt->execute(
            array(
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':headline' => $_POST['headline'],
                ':summary' => $_POST['summary'],
                ':profile_id' => $_GET['profile_id'] //--------update in row with similar profile id
            )
        );
        //success redirection
        $_SESSION['success'] = 'Record updated';
        header('Location: index.php');
        return;
    }
}



//***testcase***Make sure that user_id is present
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}




//---------select a row with where profile id matches for displaying--------
$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);




//***testcase*** if database changed by mistake 
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php?page=1');
    return;
}
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Edit Profile</title>
</head>

<body>
    <div class="container">
        <h1>Editing Profile for ITNU,Nirma</h1>
        <!-- --------flash message box-------- -->
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>

        <!-- --------simple form-------- with value field set -->
        <div class="form-group">
            <form method="post">
                <input type="text" class="form-control col-sm-4" placeholder="First Name" name="first_name" value="<?php echo $row['first_name'] ?>"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Last Name" name="last_name" value="<?php echo $row['last_name'] ?>"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Email" name="email" value="<?php echo $row['email'] ?>"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Headline" name="headline" value="<?php echo $row['headline'] ?>"><br>
                <textarea class="form-control col-sm-8" placeholder="Summary" id="exampleTextarea" rows="5" name="summary"><?php echo $row['summary'] ?></textarea><br>
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>
        <p>
    </div>
</body>

</html>