<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?> 
    
<?php include 'header.php'; ?>
    
Here you can add or edit your grocery list.
<br>
Eventually I would like to have it so you can directly add
items to your grocery list from each recipe.
<br>
    <br>
                <textarea name="comments" rows="15" cols="40"></textarea>
                <br>
                    <br>
                        <input type="text" id="email" name="email" />
                        <input type="submit" value="Email Me the List!" id="submit">
    
<?php include 'footer.php'; ?>
    
</body>