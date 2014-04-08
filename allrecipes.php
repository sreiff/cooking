<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?>
<script>
$( "#button" ).button();
</script>


<?php include 'header.php'; ?>
    
    
    All recipes uploaded by users.
   <br><br>

    <?
    session_start();
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
    $rec = $_REQUEST["recipe"];
   
    
    //Check if category if all, otherwise use input value
    if($cat == 'all' or $cat == ''){
             $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes";
          } else{
            $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE category = '$cat'";
          }
    //check if a specific recipe is selected      
    if(!$rec == ''){
        $q2 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE image_url = '$rec'";
    }
    
    $r2 = @mysqli_query ($dbc, $q2);
    $n = mysqli_num_rows($r2);
 
     if ($n>1) { // If it ran OK, display the records.
       
     while ($row = mysqli_fetch_row($r2)) {
        
        $name = "{$row[0]}";
        $image = "{$row[1]}";
        echo "<h2><a href='allrecipes.php?recipe=$image'>$name</a></h2>";
        
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
     }
     //if there is only one recipe, add a button to save to recipes
    if ($n == 1){
        $row = mysqli_fetch_row($r2);
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
        
        $x = $_SESSION["logged"];
        if (!($x == '0' or $x == '')) {
        ?>
         <form method="post" action=""> 
        <input type="submit" name="submit" value="Save to My Recipes"> 
        </form>
        <?
        }
        
        $user_id = $_SESSION["logged"];
        //if added to recipes, add to database
        if($_POST['submit']){
            
            $q3 = "SELECT name, image_url, ingredients, directions, source FROM recipes WHERE users like '%$user_id%' and image_url = '$image'";
            
            $r3 = @mysqli_query ($dbc, $q3);
            $n1 = mysqli_num_rows($r3);
            if($n1 < 1){
                
                $q4 = "UPDATE recipes SET users = concat(users, ', $user_id') WHERE image_url = '$image'";
                $r4 = @mysqli_query ($dbc, $q4);
                
            }
        }
        
    }

        // Free up the resources.
        mysqli_free_result ($r2);    
    ?>
    
<?php include 'footer.php'; ?>
    
</body>