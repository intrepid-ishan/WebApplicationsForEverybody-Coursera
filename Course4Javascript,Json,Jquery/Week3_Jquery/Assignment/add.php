<!-- same logic as edit.php instead of update->insert -->
<!-- --------backend stuff-------- -->
<?php
session_start();

require_once 'util.php';

//***testcases***
if (!isset($_SESSION['name'])) {
    die('Not logged in');
}
if (isset($_POST['cancel'])) {
    header("Location: index.php");
    return;
}


//--------addition in table with validation--------

require_once "pdo.php";
//double check of post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['first_name'])
        && isset($_POST['last_name'])
        && isset($_POST['email'])
        && isset($_POST['headline'])
        && isset($_POST['summary'])
    ) {


        //use utiility to validate profile
        $msg = validateProfile();
        if (is_string($msg)) {
            $_SESSION['error'] = $msg;
            header("Location:add.php");
            return;
        }

        //use utility to validate position
        $msg = validatePos();
        if (is_string($msg)) {
            $_SESSION['error'] = $msg;
            header("Location:add.php");
            return;
        }

        $stmt = $pdo->prepare('INSERT INTO Profile (user_id,first_name, last_name, email, headline, summary) VALUES (:user_id, :first_name, :last_name, :email, :headline,:summary)');
        $stmt->execute(
            array(
                ':user_id' => $_SESSION['user_id'],
                ':first_name' => $_POST['first_name'],
                ':last_name' => $_POST['last_name'],
                ':email' => $_POST['email'],
                ':headline' => $_POST['headline'],
                ':summary' => $_POST['summary']
            )
        );

        //profile_id is foreign key in Position so take id from previous insert
        $profile_id = $pdo->lastInsertId();


        //---------------Insert into Position table---------------
        insertInPosition($pdo,$profile_id);
        


        $_SESSION['success'] = "Record added.";
        header("Location: index.php");
        return;
    }
}

?>

<!-- --------Fall into View-------- -->

<!DOCTYPE html>
<html>

<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Add Profile cf6c7f1e</title>
</head>

<body>
    <div class="container">
        <h1>Adding Profile for ITNU,Nirma</h1>

        <!-- --------flash message box-------- -->
        <?php
        flashMessages();
        ?>

        <!-- --------simple form--------  -->
        <div class="form-group">
            <form method="post">
                <input type="text" class="form-control col-sm-4" placeholder="First Name" name="first_name"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Last Name" name="last_name"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Email" name="email"><br>
                <input type="text" class="form-control col-sm-4" placeholder="Headline" name="headline"><br>
                <textarea class="form-control col-sm-8" placeholder="Summary" id="exampleTextarea" rows="5" name="summary"></textarea><br>
                <p>
                    Position: <input type="submit" id="addPos" value="+">
                    <div id="position_fields"></div>
                </p>
                <button type="submit" class="btn btn-primary">Add</button>
                <!-- <p><a href="add.php">Add New Entry</a></p> -->
                <button type="submit" class="btn btn-danger" name="cancel">Cancel</button>
            </form>
        </div>
    </div>


    <script>
        countPos = 0;

        $(document).ready(function() {
        window.console && console.log('Document ready called');

        // adding event listener on id element ---->$().click
        $('#addPos').click(function(event) {

            //----very imp---- this line will prevent the default action of submit button which we have used
            //i.e it will not be submitted as post because form is POST
            //and it will work as we guide below
            event.preventDefault();

            if (countPos >= 9) {
                alert("Maximum of nine position entries exceeded");
                return;
            }
            countPos++;
            window.console && console.log("Adding position" + countPos);

            //------> $().append()
            $('#position_fields').append(
                '<div id="position' + countPos + '"> \
                <p>Year: <input type="text" name="year' + countPos + '" value="" /> \
                <input type="button" value="-"  \
                    onclick="$(\'#position' + countPos + '\').remove(); return false;"></p>  \
                <textarea name="desc' + countPos + '" rows="8" placeholder="Description of above year" cols="80"></textarea>\
                </div>');
        });

    });
    </script>
</body>

</html>