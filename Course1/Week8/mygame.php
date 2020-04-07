<?php 

if(! isset($_GET['name']) || strlen($_GET['name']) < 1 ){
	die('Name parameter missing');
}


if(isset($_POST['logout'])){
	header('Location: myindex.php');
	return;
}


$names=array('Rock','Paper','Scissors');
$human=isset($_POST["human"]) ? $_POST['human']+0 : -1;

$computer=rand(0,2);

function check($computer,$human){


if ( $human == $computer ) {
    return "Tie";
}
else if ( $human == 0 && $computer ==  1) {
    return "You Lose";}
    else if ( $human == 0 && $computer == 2) {
        return "You Win";}
        else if ( $human == 1 && $computer == 0) {
            return "You Win";}
            else if ( $human == 1 && $computer == 2) {
                return "You Lose";}    
              else if ( $human == 2 && $computer == 0) {
                return "You Lose";}
                else if ( $human == 2 && $computer == 1) {
                    return "You Win";  }
                    else{               
                        return false;}


}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Ishan Makadia</title>
	<?php require_once "mybootstrap.php"; ?>
</head>
<body>
<div class="container">
	<h1 style="text-align: center;"><hr><b>Ishan's Rock Paper Scissors</b><hr></h1>


	<form method="post">
		<select name="human">
			<option value="-1">-Select-</option>
			<option value="0">Rock</option>
			<option value="1">Paper</option>
			<option value="2">Scissors</option>
			<option value="3">Test</option>
		</select>
		<input type="submit" value="Play">
		<input type="submit" value="Logout" name="logout">
	</form>

	<pre>
		<?php 

		if($human == -1){
			print "Please select a strategy and press play.\n";
		}
		else if($human == 3){
			for($c=0;$c<3;$c++){
				for($h=0;$h<3;$h++){
					$r= check($c,$h);
					print "\nHuman=$names[$h] Computer=$names[$c] Result=$r";
				}
			}
		}
		else{
			$result = check($computer,$human);
				print "Your Play=$names[$human] Computer Play=$names[$computer] Result=$result\n";
		}
		?>

	</pre>

</div>
</body>
</html>