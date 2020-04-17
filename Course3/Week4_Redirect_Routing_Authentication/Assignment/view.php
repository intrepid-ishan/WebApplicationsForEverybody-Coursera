<?php
session_start();
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
require_once "pdo.php";

$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<html>
<head>
<title>Ishan Makadia 021aade7</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>


<h1><b>Tracking Autos for <?php echo $_SESSION['name']; ?></b></h1>

<?php
if ( isset($_SESSION['success']) ) {
    echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
    unset($_SESSION['success']);
}
?>

                <h2>Automobiles</h2>
                <?php
                    echo ("<ul>");
                        foreach($rows as $row){ 
                                echo ("<li>");
                                echo $row['year']." ".$row['make']." / ".$row['mileage']; 
                                echo ("</li>");
                        }
                    echo ("</ul>");       
                ?>
<a href="add.php">Add New</a> <span> | </span>
<a href="logout.php">Logout</a>


</body>
</html>