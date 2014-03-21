<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?> 
    
<?php include 'header.php'; ?>
    
    
   Here you will have the ability to look at all recipes.
   <br>
    <br>
    You can even sort your recipes by type: Breakfast, Lunch, Snacks, Dinner, Desserts, Drinks, Other.
    
    
    <?
    // Connect to MySQL.    
    require ('../../mysqli_connect.php');
    
    // Select the database:
    $q = "USE jetpack";    
    $r = @mysqli_query ($dbc, $q);
    
    // Clean up the input values
    foreach($_REQUEST as $key => $value) {
        if(ini_get('magic_quotes_gpc'))
            $_REQUEST[$key] = stripslashes($_REQUEST[$key]);
 
            $_REQUEST[$key] = htmlspecialchars(strip_tags($_REQUEST[$key]));
    }
 
    // Assign the input value to a variable for easy reference
    $cat = $_REQUEST["category"];
    //echo $cat;
    //Check if category if all, otherwise use input value
    if($cat == 'all' or $cat == ''){
             $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes";
          } else{
            $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE category = '$cat'";
          }
    $r2 = @mysqli_query ($dbc, $q2);

     if ($r2) { // If it ran OK, display the records.

     while ($row = mysqli_fetch_row($r2)) {
        
        $name = "{$row[0]}";
        echo "<h2>$name\n</h2>";
        $image = "{$row[1]}";
        echo "<img src='images/$image' alt='$name' width='25%'>\n";
        ?>
        <br> <br> 
            <?
        echo "{$row[2]}\n";
        ?>
        <br> <br> <br>
            <?
        echo "{$row[3]}\n";
          ?>
        <br> <br> 
            <?
        $link = "{$row[4]}";
        echo "<a href='$link'>Source</a>";
        }

        // Free up the resources.
        mysqli_free_result ($r2);
} 
    
    ?>
    
<?php include 'footer.php'; ?>
    
</body>