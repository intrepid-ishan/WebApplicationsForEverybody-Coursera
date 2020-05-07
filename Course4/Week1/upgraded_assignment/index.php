<!-- --------backend stuff-------- -->
<?php
//start
session_start();
//establish connection
require_once "pdo.php";

if (isset($_SESSION['searchtext'])) {
    //select
    //query for matching search
    $searchtext = $_SESSION['searchtext'];
    
    $stmt = $pdo->query("SELECT * FROM profile WHERE 
    first_name LIKE '%$searchtext%' 
    OR 
    last_name LIKE '%$searchtext%'
    ");
    //associative array form 
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


    unset($_SESSION['searchtext']);
} else {
    //------------limiting 5 entries in 1 page--------
    // $count=$pdo->query('SELECT COUNT(*) FROM profile');
    $limit =5;
    $page=isset($_GET['page'])?$_GET['page']:1;//by default 1
    $start=($page-1)*$limit;
    //every page hase limit here 5
    $stmt = $pdo->query("SELECT * FROM profile LIMIT $start,$limit"); 
   
    //associative array form 
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!-- --------Fall into View-------- -->


<!DOCTYPE html>
<html>

<head>
    <title>Ishan Makadia's Resume Registry e7a493b9</title>
    <?php require_once "bootstrap.php"; ?>
</head>

<body>
    <div class="container">
        <h2>Ishan Makadia's Resume Registry</h2>


        <!-- --------logout-------- -->
        <!-- name not set until login done -->
        <?php
        if (isset($_SESSION['name'])) {
            //in php script echo needed
            echo "<p><a href='logout.php' class='btn btn-danger'>Logout</a></p>";
            //if many things to write then double quotes
        }
        ?>

        <!-- --------flash message box-------- -->
        <!-- success not set until login done -->
        <?php
        if (isset($_SESSION['success'])) {
            echo ('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
            unset($_SESSION['success']);
        }
        ?>
        <?php
        if (isset($_SESSION['error'])) {
            echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
            unset($_SESSION['error']);
        }
        ?>


        <!-- --------login-------- -->
        <?php
        //name not set until login done
        if (!isset($_SESSION['name'])) {
            echo "<p><a href='login.php' class='btn btn-success'>Please log in</a></p>";
        }
        ?>

        <!-- ------------new search by name------------ -->
        <!-- if you want to build real time then use javascript oninput function and call function -->
        <div class="form-group col-xs-3 w-25 form-inline">
            <form method="POST">
                <input class="form-control" type="text" placeholder="search by full name" id="searchtext" name="searchtext">
                <button type="submit" class="btn btn-link" name="search">Search</button>
            </form>
        </div>
        <?php
        if (isset($_POST['search'])) {
            $_SESSION['searchtext'] = $_POST['searchtext'];
            header("Location: index.php");
            return;
        }
        ?>
        <!-- ------------end new search by name------------ -->
        <?php
        if (true) {
            //--------table---------
            echo "<table border='1' class='table table-hover' >";
            echo "<thead><tr class='table-active'>";                      //start row NAME,HEADLINE,ACTION 

            echo "<th>Name</th>";
            echo " <th>Headline</th>";

            //if name set then only have action coloumn 
            if (isset($_SESSION['name'])) {
                echo ("<th>Action</th>");
            }


            echo " </tr></thead>";                   //end row 

            //--------print table NAME HEADLINE ACTION-------- 

            // --------- at the time of table formation we will attach profile id with links as GET parameter --------
            foreach ($rows as $row) {
                echo "<tr><td>";                     //start row
                //NAME
                echo ("<a href='view.php?profile_id=" . $row['profile_id'] . "'>"
                    . $row['first_name']  . $row['last_name']  .
                    "</a>" .
                    "<span class='badge badge-primary'>View</span>"); //imp line
                echo ("</td><td>");
                //HEADLINE
                echo ($row['headline']);
                echo ("</td>");
                //ACTION
                if (isset($_SESSION['name'])) {
                    if ($_SESSION['user_id'] == $row['user_id']) { //------------new edit delete option to owner only------------
                        echo ("<td>");
                        echo ('<a href="edit.php?profile_id=' . $row['profile_id'] . '">
                    Edit
                    </a> 
                    /
                    <a href="delete.php?profile_id=' . $row['profile_id'] . '">
                    Delete
                    </a>');
                    } else {
                        echo ("<td>");
                        echo ('Not permitted');
                    }
                }

                echo ("</td></tr>\n");                 //end row  
            } //end for                
            echo "</table>";
        } else {
            echo 'No rows found';
        }
        ?>
        <div style="text-align: center" >
        <a href="index.php?page=1" style="margin:25px">1</a>
        <a href="index.php?page=2" style="margin:25px">2</a>
        <a href="index.php?page=3" style="margin:25px">3</a>
        </div>

        <!-- --------die if not login/other option-> show when session variable set-------- -->
        <p><a href="add.php"><button type="button" class="btn btn-primary">Add New Entry</button></a></p>
        <!-- <p><a href="add.php">Add New Entry</a></p> -->
    </div>
</body>

</html>