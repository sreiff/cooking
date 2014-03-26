 <?
 session_start();
 ?>
 <html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dinner Time</title>
     <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.5.1.min.js"></script>
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/jquery-ui.min.js"></script>
    <link href="http://ajax.aspnetcdn.com/ajax/jquery.ui/1.8.10/themes/ui-lightness/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
     <script>
        function newDoc(x)
        {
            window.location.href = x;
        }
    </script>
    
</head>
<body>
<div id="container">
<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$y = $_SESSION["logged"];
//echo $y;

$page_title = 'Register';
include("passwords.php");

// Connect to MySQL.    
    require ('../../mysqli_connect.php');
    
// Select the database:
    $q = "USE jetpack";    
    $r = @mysqli_query ($dbc, $q); 


// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
    $errors = array(); // Initialize an error array.
    
    // Check for a first name:
    if (empty($_POST['first_name'])) {
        $errors[] = 'You forgot to enter your first name.';
    } else {
        // $fn = trim($_POST['first_name']);
        $na = strip_tags($_POST['first_name']);
        $fn = mysqli_real_escape_string($dbc, trim($na));
    }
    
    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
        // Check that the email address is not already used:
        $q = "SELECT user_id FROM users WHERE email = '$e'";
        $r = @mysqli_query ($dbc, $q); // Run the query.
        $n = mysqli_num_rows($r);
        if ($n > 0) {
            //echo "<p>The email address $e is already in use.</p>";
            $errors[] = "The email address $e is already in use.";
        }
    }
    
    // Check for a password and match against the confirmed password:
    if (!empty($_POST['pass1'])) {
            $p = mysqli_real_escape_string($dbc, trim($_POST['pass1']));
        }
     else {
        $errors[] = 'You forgot to enter your password.';
    }
    
    
    if (empty($errors)) { // If everything's OK.
    
        // Register the user in the database...
        // Run the query.
        $q = "INSERT INTO users (name, email, pass, registration_date) VALUES ('$fn', '$e', SHA1('$p'), NOW() )";        
        $r = @mysqli_query ($dbc, $q);
        $q3 = "UPDATE session SET user = '$e' WHERE user_id = 1";        
        $r3 = @mysqli_query ($dbc, $q3);
        
        if ($r && $r3) { // If it ran OK.
            $_SESSION["logged"]=$_POST['email'];
            ?>
            <script type="text/javascript">
                newDoc("home.php");
            </script>
            <?
        } else { // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
            
            // Debugging message:
            //echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                        
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

} // End of the main Submit conditional.
?>
<h1>Register</h1>
<form action="register.php" method="post">
    <p>Name: <input type="text" name="first_name" size="15" maxlength="20" value="<?php if (isset($_POST['first_name'])) echo $_POST['first_name']; ?>" /></p>
    <p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
    <p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
    <p><input type="submit" name="submit" value="Register" /></p>
</form>

    
</body> 
 
