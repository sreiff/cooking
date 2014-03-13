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
        $(document).ready(function () {
			$("#datepicker").datepicker();
		});
        
    </script>

    <script>
         $(document).ready(function() {
            $( "#menu" ).menu();
            });
    </script>
    
    <style>
  .ui-menu { width: 150px; }
  </style>

    
</head> 

    <body>
    <div id="logout"><a href="logout.php">Logout</a></div>
    <div class="navbar">
        <ul id="menu" class="navbar">
            <li>
                <a href="home.php">Home</a>
            </li>
            <li>
                <a href="myrecipes.php" >My Recipes</a>
                <ul id="submenu">
                    <li>
                        <a href="myrecipes.php" >Breakfast</a>
                    </li>
                    <li>
                        <a href="myrecipes.php" >Lunch</a>
                    </li>
                    <li>
                        <a href="myrecipes.php" >Snacks</a>
                    </li>
                    <li>
                        <a href="myrecipes.php" >Dinner</a>
                    </li>
                    <li>
                        <a href="myrecipes.php" >Dessert</a>
                    </li>
                    <li>
                        <a href="myrecipes.php" >Drinks</a>
                    </li>
                    <li>
                        <a href="myrecipes.php" >Other</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="calendar.php">My Calendar</a>
            </li>
            <li>
                <a href="grocerylist.php">Grocery List</a>
            </li>
            <li>
                <a href="tools.php">Tools</a>
            </li>
    </div>
    
    <div id="container">
        
        <body>
    