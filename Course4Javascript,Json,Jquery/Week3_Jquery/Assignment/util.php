<!-- $_POST is super global so it passes seemlessly between utility code and main code -->
<?php
function flashMessages() {
    // < --------flash message box-------- 
    if (isset($_SESSION['error'])) {
        echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['fail'])) {
        echo ('<p style="color: red;">' . htmlentities($_SESSION['fail']) . "</p>\n");
        unset($_SESSION['fail']);
    }
    if (isset($_SESSION['success'])) {
        echo ('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }
}

//use in add and edit
function validateProfile(){
    
    if(isset($_POST['first_name'])){
        if (strlen($_POST['first_name']) == 0 || strlen($_POST['last_name']) == 0 || strlen($_POST['email']) == 0 ||
        strlen($_POST['headline']) == 0 || strlen($_POST['summary']) == 0) {
        return "All fields are required";
    }
    }
    else{
    //in login.php
    if(strpos($_POST['email'],'@')===false){
        return "Email address must contain @";
    }
    }
    return true;

}

//use in add and edit
function validatePos() {
    for($i=1; $i<=9; $i++) {
      //skip the data which is not present
      if ( ! isset($_POST['year'.$i]) ) continue;
      if ( ! isset($_POST['desc'.$i]) ) continue;
  
      $year = $_POST['year'.$i];
      $desc = $_POST['desc'.$i];
  
      if ( strlen($year) == 0 || strlen($desc) == 0 ) {
        return "All fields are required";
      }
  
      if ( ! is_numeric($year) ) {
        return "Position year must be numeric";
      }
    }
    return true;
  }

//used in edit.php
function loadPos($pdo,$profile_id){
    // echo $profile_id;
    $stmt = $pdo->prepare('SELECT * FROM Position where profile_id = :prof ORDER BY rank');
    $stmt->execute(array(":prof" => $profile_id));
    $positions=array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $positions[] = $row; 
    }
    return $positions;
}  

function insertInPosition($pdo,$profile_id){
    $rank = 1;
    for ($i = 1; $i <= 9; $i++) {
        if (!isset($_POST['year' . $i])) continue;
        if (!isset($_POST['desc' . $i])) continue;

        $year = $_POST['year' . $i];
        $desc = $_POST['desc' . $i];
        $stmt = $pdo->prepare('INSERT INTO Position
            (profile_id, rank, year, description)
            VALUES ( :pid, :rank, :year, :desc)');

        $stmt->execute(array(
            ':pid' => $profile_id,
            ':rank' => $rank,
            ':year' => $year,
            ':desc' => $desc)
        );

        $rank++;
    }
}