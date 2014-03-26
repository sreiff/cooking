<script>
        function newDoc(x)
        {
            window.location.href = x;
        }
    </script>


<?php
session_start();
//include 'password.php';
$_SESSION["logged"] = '0';
//check_logged();
//session_unset();
//session_destroy();
?>
<script> 
    newDoc("login.php");
</script>

<?

//echo 'you are logged out';

//newDoc("login.php");

//$_SESSION["logged"]='out';
/*
require ('../../mysqli_connect.php');
    
// Select the database:
    $q = "USE jetpack";    
    $r = @mysqli_query ($dbc, $q); 
     
     $q1 = "UPDATE session SET user = 'out' WHERE user_id = 1";  
     $r2 = @mysqli_query ($dbc, $q1);
     //echo $r2;
     //echo "herexx";
     if($r2){
        ?>
          <script>
            newDoc("login.php");
        </script>
          <?
     }
*/
?>
    

</div>
</body>
