<html>
<head>
<title>Ishan Makadia 6e5abe0d</title>
</head>

<body>
<h1>Welcome to my guessing game</h1>

<?php
if(! isset($_GET['guess']) ){
	echo "Missing guess parameter";	
}
elseif ($_GET['guess']=='') {
	echo "Your guess is too short";
}
elseif (! is_numeric($_GET['guess']) ) {
	echo "Your guess is not a number";
}
elseif ($_GET['guess']<42) {
	    echo "Your guess is too low";
}
elseif ($_GET['guess']>42){
		echo "Your guess is too high";
}
else{
	echo "Congratulations - You are right";
}
?>

</body>
</html>	