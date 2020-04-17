<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}



if (
    isset($_POST['make']) && isset($_POST['model'])
    && isset($_POST['year']) && isset($_POST['mileage'])
) {

    // Data validation
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?user_id=" . $_POST['user_id']);
        return;
    } else if (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {

        $sql = "UPDATE automobile SET make = :make,model = :model, year = :year, mileage = :mileage
    WHERE autos_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':user_id' => $_POST['user_id']));
        
        $_SESSION['success'] = 'Record edited';
        header('Location: index.php');
        return;
    }
    else {
        $_SESSION['error'] = " Year must be an integer";
        header("Location: edit.php?user_id=" . $_POST['user_id']);
        return;
    }
} //end of validation

// Guardian: Make sure that user_id is present
if (!isset($_GET['user_id'])) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM automobile where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}

// Flash pattern
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}

$ma = htmlentities($row['make']);
$mo = htmlentities($row['model']);
$y = htmlentities($row['year']);
$m = htmlentities($row['mileage']);
$user_id = $row['autos_id'];
?>


<p>Edit User</p>
<form method="post">
    <p>Make:
        <input type="text" name="make" value="<?= $ma ?>"></p>
    <p>Model:
        <input type="text" name="model" value="<?= $mo ?>"></p>
    <p>Year:
        <input type="text" name="year" value="<?= $y ?>"></p>
    <p>Mileage:
        <input type="text" name="mileage" value="<?= $m ?>"></p>
    <input type="hidden" name="user_id" value="<?= $user_id ?>">
    <p><input type="submit" value="Save" />
        <a href="index.php">Cancel</a></p>
</form>