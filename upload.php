<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?php include 'header.php'; ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Upload an Image</title>
    <style type="text/css" title="text/css" media="all">
    .error {
        font-weight: bold;
        color: #C00;
    }
    </style>
</head>
<body>
<?php # Script 11.2 - upload_image.php
$y = $_SESSION["logged"];
include("passwords.php");

// Connect to MySQL.    
    require ('../../mysqli_connect.php');
    
// Select the database:
    $q = "USE jetpack";    
    $r = @mysqli_query ($dbc, $q);
    
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $category = $_POST['category'];
    
    $errors = array(); // Initialize an error array.

    // Check for an uploaded file:
    if (isset($_FILES['upload'])) {
        
        // Validate the type. Should be JPEG or PNG.
        $allowed = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png');
        if (in_array($_FILES['upload']['type'], $allowed)) {
        
            // Move the file over.
            if (move_uploaded_file ($_FILES['upload']['tmp_name'], "../../images/{$_FILES['upload']['name']}")) {
                echo '<p><em>The file has been uploaded!</em></p>';
            } // End of move... IF.
            
        } else { // Invalid type.
            echo '<p class="error">Please upload a JPEG or PNG image.</p>';
        }

    }// End of isset($_FILES['upload']) IF.
    
    // Check for an email address:
    if (empty($_POST['rname'])) {
        $errors[] = 'You forgot to enter a recipe name';
    } else {
        $q = "SELECT * FROM recipes WHERE name = $rname";        
        $r = @mysqli_query ($dbc, $q);
        $n = mysqli_num_rows($r);
        if ($n < 1){
            $rname = mysqli_real_escape_string($dbc, trim($_POST['rname']));
        }else{
            $errors[] = 'The recipe already exists, please upload a new one.';
        }
    }
    
    // Check for an email address:
    if (empty($_POST['ingredients'])) {
        $errors[] = 'You forgot to enter the ingredients';
    } else {
        $ingredients = mysqli_real_escape_string($dbc, trim($_POST['ingredients']));
    }
    
    // Check for an email address:
    if (empty($_POST['directions'])) {
        $errors[] = 'You forgot to enter the directions';
    } else {
        $directions = mysqli_real_escape_string($dbc, trim($_POST['directions']));
    }
    
     // Check for an email address:
    if (empty($_POST['source'])) {
        $errors[] = 'You forgot to enter the source, enter "none" for none.';
    } else {
        $source = mysqli_real_escape_string($dbc, trim($_POST['source']));
    }
    
    // Check for an error:
    if ($_FILES['upload']['error'] > 0) {
        echo '<p class="error">The file could not be uploaded because: <strong>';
    
        // Print a message based upon the error.
        switch ($_FILES['upload']['error']) {
            case 1:
                print 'The file exceeds the upload_max_filesize setting in php.ini.';
                break;
            case 2:
                print 'The file exceeds the MAX_FILE_SIZE setting in the HTML form.';
                break;
            case 3:
                print 'The file was only partially uploaded.';
                break;
            case 4:
                print 'No file was uploaded.';
                break;
            case 6:
                print 'No temporary folder was available.';
                break;
            case 7:
                print 'Unable to write to the disk.';
                break;
            case 8:
                print 'File upload stopped.';
                break;
            default:
                print 'A system error occurred.';
                break;
        } // End of switch.
        
        print '</strong></p>';
    
    } // End of error IF.
    
    // Delete the file if it still exists:
    if (file_exists ($_FILES['upload']['tmp_name']) && is_file($_FILES['upload']['tmp_name']) ) {
        unlink ($_FILES['upload']['tmp_name']);
    }
    
    if (empty($errors)) { // If everything's OK.
    
        $user = $_SESSION['logged'];
        $image_url = $_FILES['upload']['name'];
        // Register the user in the database...
        // Run the query.
        $q = "insert into recipes (name, image_url, ingredients, directions, category, source, users, registration_date) values ('$rname', '$image_url', '$ingredients', '$directions', '$category', '$source', '$user', NOW())";      
        $r = @mysqli_query ($dbc, $q);
               
        if ($r) { // If it ran OK.
            echo "success!";
        } else { // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
            
            // Debugging message:
           // echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                        
        } // End of if ($r) IF.
        
        mysqli_close($dbc); // Close the database connection.

        // Include the footer and quit the script:
        exit();
        
    } else { // Report the errors.
    
        echo '<h1>Error!</h1>
        <p class="error">The following error(s) occurred:<br />';
        foreach ($errors as $msg) { // Print each error.
            echo " - $msg<br />\n";
        }
        echo '</p><p>Please try again.</p><p><br /></p>';
        
    } // End of if (empty($errors)) IF.
    
    mysqli_close($dbc); // Close the database connection.
            
} // End of the submitted conditional.
?>
    
<form enctype="multipart/form-data" action="upload.php" method="post">
    
    <input type="hidden" name="MAX_FILE_SIZE" value="524288" />
    
    <fieldset><legend>Select a JPEG or PNG image of 512KB or smaller to be uploaded:</legend>
    <p>Please name your file recipe_name.jpg</p>
    <p><b>File:</b> <input type="file" name="upload" /></p>    
    <p>Recipe Name: <input type="text" name="rname" size="15" maxlength="20"/></p>
    <p>Ingredients: <textarea name="ingredients" rows="10" cols="40">  </textarea> </p>
    <p>Directions: <textarea name="directions" rows="12" cols="40"> </textarea> </p>
    <p>Category: <select name="category">
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="snacks">Snacks</option>
                <option value="dinner">Dinner</option>
                <option value="dessert">Dessert</option>
                <option value="drinks">Drinks</option>
                <option value="other">Other</option>
                </select></p>
    <p>Source: <input type="text" name="source" size="15" maxlength="30"/></p>
    
    <div align="center"><input type="submit" name="submit" value="Submit" /></div>
    
    </fieldset>
</form>


   

<?php include 'footer.php'; ?>
</html>