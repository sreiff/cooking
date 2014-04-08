     <script>
        function newDoc(x)
        {
            window.location.href = x;
        }
    </script>

<?php 

/*
 *Login/logout code adapted from http://www.phpjabbers.com/create-user-login-in-php-php23.html
 */
function check_logged(){
     session_start();
     //global $_SESSION;
     $x = $_SESSION["logged"];
     if ($x == '0' or $x == '') {
           ?>
            <script>
               newDoc("login.php");
            </script>
            <?
     }; 
}; 
?>
