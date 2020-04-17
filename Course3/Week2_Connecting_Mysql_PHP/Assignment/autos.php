<?php

ini_set('display_startup_errors', true);
error_reporting(E_ALL);
ini_set('display_errors', true);



            if(! isset($_GET['name']) || strlen($_GET['name']) < 1 ){
                die('Name parameter missing');
            }

            if( isset($_POST['logout']) ){
                header('Location: index.php');
            }



require_once "pdo.php";
$failure=$failure1=$success=$success1=$make=$year=$mileage=" ";



if($_SERVER["REQUEST_METHOD"]=="POST"){  
  
    
 $make = htmlentities($_POST['make']);
 $year = htmlentities($_POST['year']);
 $mileage  = htmlentities($_POST['mileage']);

            if(isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['year'])){
                    if(strlen($_POST['make']) < 1){    
                        $failure=true;
                        $failure1 = "Make is required";
                    }

                    else if( is_numeric($_POST['year']) && is_numeric($_POST['mileage'])){
                        $stmt = $pdo->prepare('INSERT INTO autos
                                (make, year, mileage) VALUES ( :mk, :yr, :mi)');
                                            $stmt->execute(array(
                                            ':mk' => $make,
                                                ':yr' => $year,
                                                    ':mi' => $mileage)
                                                );

                            $success1 = "Record inserted" ;  
                            $success=true; 
                                        
                    }
                    else{
                            $failure=true;
                            $failure1 = "Mileage and year must be numeric";
                    }
            }    
}


$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>



<html>
<head>
<title>Ishan Makadia 021aade7</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>
<body>




<h1><b>Tracking Autos for <?php echo $_GET['name']; ?></b></h1>

<?php
		if($failure !== false){
			echo('<p style="color:red;">'.htmlentities($failure1)."</p>\n") ;
		}
        if($success !== false){
			echo('<p style="color:green;">'.htmlentities($success1)."</p>\n") ;
        }
       
?>

<pre>
<form method="post">
Make:   <input type="text" name="make" size="40">
Year:   <input type="text" name="year">
Mileage:<input type="text" name="mileage">
<input type="submit" value="Add"/><input type="submit" value="Logout" name="logout"/> 
</form>
</pre>  

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
</body>
</html>