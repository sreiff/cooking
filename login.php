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
    <style>
  img {
    height: 200px;

  }
  </style>

</head>
<body>
     <div id="container">
<?php # Script 9.5 - register.php #2
// This script performs an INSERT query to add a record to the users table.

$page_title = 'Log in';

include("passwords.php");

// Connect to MySQL.    
    require ('../../mysqli_connect.php');
    
// Select the database:
    $q = "USE jetpack";    
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
            
             $_SESSION["logged"]=$_POST['email'];
             //$y = $_SESSION["logged"];
            //echo $y;
            ?>
            <script type="text/javascript">
                newDoc("home.php");
            </script>
            <?
            //header('Location: home.php');
        }
        else if ($n == 0){
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">The email-password combination did not work, please try again.</p>'; 
            
        }
        else { // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">You could not be logged in due to a system error. We apologize for any inconvenience.</p>'; 
            
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

} // End of the main Submit conditional.
?>
<p>
    This website is for finding new recipes, keeping track of them, <br>
    planning your meals and grocery trips, as well as getting <br> inspired to cook. <br><br>
    Join or log in to get started!
</p>


<h1>Log In</h1>
<form action="login.php" method="post">
    <p>Email Address: <input type="text" name="email" size="20" maxlength="60" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"  /> </p>
    <p>Password: <input type="password" name="pass1" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>"  /></p>
    <p><input type="submit" name="submit" value="Login" /></p>
</form>
<a href="register.php">New User</a>
<br>
    <br>

    

    <div id="images"></div>
<div id="titles"></div>
<div id="alts"></div>


<script>
(function() {
  var flickerAPI = "http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?";
  
  $.getJSON( flickerAPI, {
    tags: "foodie",
    tagmode: "any",
    format: "json"
  })
    .done(function( data ) {
      $.each( data.items, function( i, item ) {
      	$('#images').append('<p>');	
        $( "<img>" ).attr( "src", item.media.m ).appendTo( "#images" );
    	$('#images').append('</p>');
        if ( i === 0 ) {
          return false;
        }
      });
    });
})();
</script>  

    
</body> 
 
