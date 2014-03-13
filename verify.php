<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.
// Connect to MySQL.    
    require ('../../mysqli_connect.php');
// Select the database:
    $q = "USE cooking";    
    $r = @mysqli_query ($dbc, $q); 
// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array(); // Initialize an error array.
    // Check for an email address:
    if (empty($_POST['email'])) {
        $errors[] = 'You forgot to enter your email address.';
    } else {
        $e = mysqli_real_escape_string($dbc, trim($_POST['email']));
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
        $q = "SELECT user_id FROM users WHERE (email='$e' AND pass=SHA1('$p') )";        
        $r = @mysqli_query ($dbc, $q);
        $n = mysqli_num_rows($r);
        if ($n==1) { // If it ran OK.
            header("Location: home.php"); 
        } else { // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>'; 
            
            // Debugging message:
            echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
                        
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