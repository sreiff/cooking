
<?php
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<?php include 'header.php'; ?>
    
    Welcome to the recipe/dinner tracking site!
    <br>
    <br>
    <br>
    This website will give you the ability to plan your meals on a calendar,
    find new recipes, create a grocery list, <br>
    upload new recipes, save recipes and more all in one place!
    <br>
        <br>
            <a href="http://savannahreiff.com/cooking/Find_New_Recipes.xml">
            <img src="images/rss.gif" width="36" height="14">
            </a>
            <br>
            <br> <br>
            <h2><a href="upload.php">Upload a New Recipe!</a></h2>
            <br> <br>
    
          
<?php include 'footer.php'; ?>
    
</body>