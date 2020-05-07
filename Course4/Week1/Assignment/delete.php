<!-- note:profile id recieved in $_GET['profile_id'] -->
<!-- same logic as edit.php instead of update->delete, form->bootstrap card -->
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


require_once "pdo.php";



//--------deletion in table where profile id matches after submit--------
if ( isset($_POST['Delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM Profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);

    //you can take here GET also
    $stmt->execute(array(':zip' => $_POST['profile_id'])); //POST due to hidden field set
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}



// ***testcases*** Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}



//---------select a row with where profile id matches for displaying--------
$stmt = $pdo->prepare("SELECT first_name, last_name 
                       FROM Profile WHERE 
                       profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile id';
    header('Location: index.php');
    return;
}
?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>
<head>
    <title>Delete Profile</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">

<!-- --------details bootstrap card-------- -->
<div class="card border-danger mb-3" style="max-width: 20rem;">
  <div class="card-header">Details of Student</div>
  <div class="card-body">
    <p class="card-text">First Name: <?php echo($row['first_name']); ?></p>
    <p class="card-text">Last Name: <?php echo($row['last_name']); ?></p>
    
  </div>
</div>

<!-- --------buttons--------  -->
    <div class="form-group">
    <form method="post">
        <!-- hidden -->
        <input type="hidden" name="profile_id" value="<?php echo $_GET['profile_id'] ?>">
        <button type="submit" class="btn btn-primary" name="Delete">Delete</button>
        <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
    </form>
    </div>
</div>
</body>