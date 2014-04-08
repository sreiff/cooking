<?php include 'header.php'; ?>


<?php

require ('../../mysqli_connect.php');
    
    // Select the database:
    $q = "USE jetpack";    
    $r = @mysqli_query ($dbc, $q);
    
// Clean up the input values
foreach($_POST as $key => $value) {
  if(ini_get('magic_quotes_gpc'))
    $_POST[$key] = stripslashes($_POST[$key]);
 
    $_POST[$key] = htmlspecialchars(strip_tags($_POST[$key]));
}

$user_id = $_SESSION["logged"];
$comments = $_POST["comments"];

$type = 'save';
if(!($_POST['submit'] == 'Save')){
 $type = 'email';   
 
}

//email the recipe
if($type == 'email'){
// Assign the input values to variables for easy reference

$email = $_POST["email"];

 
// Test input values for errors
$errors = array();

if(!$email) {
  $errors[] = "You must enter an email.";
} else if(!validEmail($email)) {
  $errors[] = "You must enter a valid email.";
}


 
if($errors) {
  // Output errors and die with a failure message
  $errortext = "";
  foreach($errors as $error) {
    $errortext .= "<p>".$error."</p>";
  }
  die("<span class='failure'>The following errors occured. Please fix them and resubmit:<p>". $errortext ."</p></span>");
}
else{
    
        // Send the email
            $to = $email;
            $subject = "Grocery List";

            $headers = "From: reiff.s@husky.neu.edu";
            
            $message = "$comments";
 
            mail($to, $subject, $message, $headers);
 
        // Die with a success message
            die("<span class='success'>Success! Your grocery list has been sent.</span>");   
}
//save the list
} else {
    $q2 = "select * FROM list WHERE user_id = '$user_id'";
    $r2 = @mysqli_query ($dbc, $q2);
    $n = mysqli_num_rows($r2);
    //echo 'here';
    if($n == 1){
        $q3 = "UPDATE list set list_text = '$comments', last_saved = NOW() WHERE user_id = '$user_id'";
        $r3 = @mysqli_query ($dbc, $q3);
        if($r3){
            ?>
            <script>
                newDoc("grocerylist.php");
            </script>
            <?
        }else {
            echo "Sorry, you list could not be saved, please try again.";
        }
    } else{
        $q3 = "INSERT INTO list (user_id, list_text, last_saved) values ('$user_id', '$comments', NOW())";
        $r3 = @mysqli_query ($dbc, $q3);
        if($r3){
            ?>
            <script>
                newDoc("grocerylist.php");
            </script>
            <?
        }else {
            echo "Sorry, you list could not be saved, please try again.";
        }
    }
    
    
}


 
// A function that checks to see if
// an email is valid
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}



?>   
 </p>

   
    
</body>
</html>

