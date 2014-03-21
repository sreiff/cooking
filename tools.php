<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?> 
    
<?php include 'header.php'; ?>

    Eventually here I would like to include helpful tools for cooking and links.
    <br> <br>
        Something like a convertor that will convert cups to tablespoons and things like that.
<?php include 'footer.php'; ?>
    
</body>