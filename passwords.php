     <script>
        function newDoc(x)
        {
            window.location.href = x;
        }
    </script>

<?php 
//session_start();

function check_logged(){
     // Connect to MySQL.    
    require ('../../mysqli_connect.php');
    
// Select the database:
    $q = "USE jetpack";    
    $r = @mysqli_query ($dbc, $q); 
     
     $q1 = "select user from session where user_id = 1";
     $r2 = @mysqli_query ($dbc, $q1);
     
     if($r2){
          $row = mysqli_fetch_row($r2);
          //echo $row[0];
          if(($row[0]) == "out"){
            ?>
            <script>
               newDoc("login.php");
            </script>
            <?
          }
          //header("Location: login.php");
     }
     
     //global $_SESSION;
     //$x = $_SESSION["logged"];
     //if ($x = 'out') {
          //header("Location: login.php"); 
     //}; 
}; 
?>
