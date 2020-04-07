<?php 
if( isset($_POST['cancel'])){
	header("Location: myindex.php");
	return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123


$failure = false;

if(isset($_POST['who']) && isset($_POST['pass']) ){
	if(strlen($_POST['who']) < 1 && strlen($_POST['pass']) < 1){
		$failure = "User name and password are required";
	}

	else{
		$check = hash('md5',$salt.$_POST['pass']);
		
		if($check == $stored_hash ){
			header("Location: mygame.php?name=".urlencode($_POST['who']));
			return;
		}
		else{
			$failure = "Incorrect Password";
		}
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<?php require_once "mybootstrap.php"; ?>
	<title>Ishan Makadia Login Page</title>
</head>
<body>


	<div class="container">
		<h1>Please Login</h1>
		<?php
		if($failure !== false){
			echo('<p style="color:red;">'.htmlentities($failure)."</p>\n") ;
		}


		?>
		<form method="POST">
			<label>User Name <input type="text" name="who" id="nam"></label></br></label>	
			<label>User Name <input type="text" name="pass" id="id_333"></label></br>
			<input type="submit" value="Log In">
			<input type="submit" value="Cancel" name="cancel">
		</form>	
	</div>
</body>
</html>