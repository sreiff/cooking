// $url should be an absolute url
function redirect(){
    if (headers_sent()){
        die('<script type="text/javascript">window.location=\'.home.php.\';</script>');
    }else{
      header('Location: home.php');
      die();
    }    
}