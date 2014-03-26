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
        <form id="grocerylist" action="groceryverification.php" method="post">
                <textarea name="comments" rows="15" cols="40">
                    <?
                     require ('../../mysqli_connect.php');
    
                        // Select the database:
                        $q = "USE jetpack";    
                        $r = @mysqli_query ($dbc, $q);
    
                        $user_id = $_SESSION["logged"];
    
                        $q1 = "select list_text from list where user_id = '$user_id'";
                        $r1 = @mysqli_query ($dbc, $q1);
                        $row = mysqli_fetch_row($r1);
                        echo "{$row[0]}\n";
                    ?>
                </textarea>
                <br>
                    <br>
                        <input type="text" id="email" name="email" />
                        <input type="submit" value="Email Me the List!" id="emailme" name="submit">
                        <br> <br>
                        <input type="submit" value="Save" id="save" name="submit">
        </form>
    
<?php include 'footer.php'; ?>
    
</body>