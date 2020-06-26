<!-- note:profile id recieved in $_GET['profile_id'] -->
<!-- same logic as edit.php instead of update->Select -->
<?php 
session_start();
require_once "pdo.php";
require_once 'util.php';
//***testcases***
if (!isset($_GET['profile_id'])) {
    $_SESSION['error'] = "Missing profile_id";
    header('Location: index.php');
    return;
}


//---------select a row with where profile id matches for displaying--------
$stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$positions = loadPos($pdo, $_GET['profile_id']);


$stmt = $pdo->prepare("SELECT * FROM Education join Institution on Education.institution_id = Institution.institution_id where profile_id = :xyz ORDER BY rank");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$rowsofedu = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>View Profile 4d362d4b</title>
</head>
<body>
<div class="container">

<!-- --------Information bootstrap card-------- -->
<h3>Profile Information</h3>    
<div class="card border-primary mb-3" style="max-width: 20rem;">
  <div class="card-body">
    <p>First Name: <?php echo($row['first_name']); ?></p>
    <p>Last Name: <?php echo($row['last_name']); ?></p>
    <p>Email: <?php echo($row['email']); ?></p>
    <p>Headline:<br/> <?php echo($row['headline']); ?></p>
    <p>Summary: <br/><?php echo($row['summary']); ?></p>

    <p>Education: <br/><ul>
        <?php
        foreach ($rowsofedu as $row) {
            echo('<li>'.$row['year'].':'.$row['name'].'</li>');
        } ?>
    </ul></p>

    <p>Position: <br/>
    <ul>
        <?php
        foreach ($positions as $row) {
            echo('<li>'.$row['year'].':'.$row['description'].'</li>');
        } 
        ?>
    </ul>
  </p>
    

    <a href="index.php">Done</a>
  </div>
    
</div>
</body>
</html>
