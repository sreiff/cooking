<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?> 
    
<?php include 'header.php'; ?>
    
    
   Below are all of your saved recipes. <br><br>
   To save a recipe, find one you like under all recipes and select the title to display it alone. 
   Then select the "Save to My Recipes" button and it will be added.
   <br>
    <br>

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
    $user_id = $_SESSION["logged"];
    $rec = $_REQUEST["recipe"];
    
    
    //Check if category if all, otherwise use input value
    if($cat == 'all' or $cat == ''){
             $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE users like '%$user_id%'";
          } else{
            $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE category = '$cat' and users like '%$user_id%'";
          }
    //check if specific recipe is selected      
    if(!$rec == ''){
        $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE image_url = '$rec' and users like '%$user_id%'";
    }

    $r2 = @mysqli_query ($dbc, $q2);
    $n = mysqli_num_rows($r2);
    //echo 'here';
     if ($n>1) { // If it ran OK, display the records.
        //echo 'here2';
     while ($row = mysqli_fetch_row($r2)) {
        
        $name = "{$row[0]}";
        $image = "{$row[1]}";
        echo "<h2><a href='myrecipes.php?recipe=$image'>$name</a></h2>";
        
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
        if($link != 'none'){
            echo "<a href='$link'>Source</a>";
        }
        }
     }
     //if only one recipe selected, give option to add to grocery list
    if ($n == 1){
        $row = mysqli_fetch_row($r2);
        $name = "{$row[0]}";
        echo "<h2>$name\n</h2>";
        $image = "{$row[1]}";
        echo "<img src='images/$image' alt='$name' width='25%'>\n";
        ?>
        <br> <br> 
            <?
        $ingredients = "{$row[2]}\n";
        echo "{$row[2]}\n";
        ?>
        <br> <br> <br>
            <?
        echo "{$row[3]}\n";
          ?>
        <br> <br> 
            <?
        $link = "{$row[4]}";
        if($link != 'none'){
            echo "<a href='$link'>Source</a>";
        }
        
        $x = $_SESSION["logged"];
        if (!($x == '0' or $x == '')) {
        ?>
         <form method="post" action=""> 
        <input type="submit" name="submit" value="Add Ingredients to Grocery List"> 
        </form>
        <?
        }
        
        $user_id = $_SESSION["logged"];
        //transfer text to grocery list
        if($_POST['submit']){
            
            $q3 = "SELECT list_text FROM list WHERE user_id = '$user_id'";
            
            $r3 = @mysqli_query ($dbc, $q3);
            $n1 = mysqli_num_rows($r3);
            if($n1 == 1){
                
                $q4 = "UPDATE list SET list_text = concat(list_text, '$ingredients'), last_saved = NOW() WHERE user_id = '$user_id'";
                $r4 = @mysqli_query ($dbc, $q4);
                
            }else{
                $q3 = "INSERT INTO list (user_id, list_text, last_saved) values ('$user_id', '$ingredients', NOW())";
                $r3 = @mysqli_query ($dbc, $q3);
            }
        }
        
    }

        // Free up the resources.
        mysqli_free_result ($r2);
  
    ?>
    
<?php include 'footer.php'; ?>
    
</body>