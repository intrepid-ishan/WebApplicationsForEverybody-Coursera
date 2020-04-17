<?php
session_start();
if ( ! isset($_SESSION['name']) ) {
    die('Not logged in');
}
require_once "pdo.php";

$stmt = $pdo->query("SELECT autos_id, make, model, year, mileage FROM automobile");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>



<html>
<head>
<title>Ishan Makadia 40d30097</title>
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
                <table border="2">
                <?php

                        if($rows==false){
                            echo "No rows found";
                        }

                        foreach($rows as $row){ 
                            echo "<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>";
                            echo "<tr><td>";
                            echo(htmlentities($row['make']));
                            echo("</td><td>");
                            echo(htmlentities($row['model']));
                            echo("</td><td>");
                            echo(htmlentities($row['year']));
                            echo("</td><td>");
                            echo(htmlentities($row['mileage']));
                            echo("</td><td>");
                            echo('<form method="post"><input type="hidden" ');
                            echo('name="user_id" value="'.$row['autos_id'].'">'."\n");
                            echo('<a href="edit.php?user_id='.$row['autos_id'].'">Edit</a> / ');
                            echo('<a href="delete.php?user_id='.$row['autos_id'].'">Delete</a>');
                            // echo('<input type="submit" value="Del" name="delete">');
                            echo("\n</form>\n");
                            echo("</td></tr>\n");
                        }
                                // echo ("<li>");
                                // echo $row['year']." ".$row['make']." / ".$row['mileage']; 
                                // echo ("</li>");
                        
                    // echo ("</ul>");       
                ?>
                </table>
<a href="add.php">Add New Entry</a> <br>
<a href="logout.php">Logout</a>


</body>
</html>