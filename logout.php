<script>
        function newDoc(x)
        {
            window.location.href = x;
        }
    </script>

<div id="container">

<?php
session_start();
//$_SESSION["logged"]='out';

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

?>
    

</div>
</body>
