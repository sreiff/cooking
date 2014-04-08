<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?>

<style>
  img {
    height: 200px;
  }
  </style>
    
<?php include 'header.php'; ?>
Here are some of the most recent flickr images for foodies. <br>
Get inspired to cook by looking through them! <br> <br>
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
    	$('#images').append('</p><p>' + item.title + '</p>');
        if ( i === 9 ) {
          return false;
        }
      });
    });
})();
</script>    
        
        
<?php include 'footer.php'; ?>
    
</body>