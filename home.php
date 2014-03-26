
<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?> 
    
<?php include 'header.php'; ?>
    
    Welcome to the recipe/dinner tracking site!
    <br>
    <br>
    <br>
    This will give you the ability to plan your meals,
    find new recipes, create a grocery list and more. 
    <br>
        <br>
            <a href="http://savannahreiff.com/cooking/Find_New_Recipes.xml">
            <img src="images/rss.gif" width="36" height="14">
            </a>
            <br>
                
                
<?php include 'footer.php'; ?>
    
</body>