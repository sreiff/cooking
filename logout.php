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
session_unset();
session_destroy();
?>
<script> 
    newDoc("login.php");
</script>
    

</div>
</body>
