<?php 
session_start(); /// initialize session 
include("passwords.php"); 
check_logged(); /// function checks if visitor is logged. 
//If user is not logged the user is redirected to login.php page  
?>

<?php include 'header.php'; ?> 
<script>
    
 $.datepicker.setDefaults($.datepicker.regional['nl']); 
$.datepicker.setDefaults({ dateFormat: 'yy-mm-dd' });
//Later..
$('.datepicker').datepicker();
  
  </script>


    
<? require ('../../mysqli_connect.php'); ?>

<p>Plan what meals you will make each night! Or track what you have made in the past.</p>
<form enctype="multipart/form-data" action="calendar.php" method="post">
     
    <p>Add one of your recipes to the calendar!</p>
    
    <p>Recipe: 
                <?
                    echo '<select name="recipe" id="recipe">';
                    
                    
                    // Select the database:
                    $q = "USE jetpack";    
                    $r = @mysqli_query ($dbc, $q);
    
                    $user_id = $_SESSION["logged"];
                    
                    $q2 = "select * from recipes where users like '%$user_id%'";
                    $r2 = @mysqli_query ($dbc, $q2);
                    
                    $n = mysqli_num_rows($r2);
                        //echo 'here';
                    if ($n>0) { // If it ran OK, display the records.
                        //echo 'here2';
                        while ($row = mysqli_fetch_row($r2)) {
                            $x = $row[0];
                            echo "<option value='$x'>$x</option>";
							
                        }
                    }
                echo  '</select>';
                ?>
                
    <p>Date: <input type="text" id="datepicker" name="datepicker"></p>
    <div align="center"><input type="submit" name="submit" value="Submit" /></div>
    
    </fieldset>
</form>

<?
    
// Select the database:
$q = "USE jetpack";    
$r = @mysqli_query ($dbc, $q);
    
$user_id = $_SESSION["logged"];


// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $date = $_POST['datepicker'];
    $recipe = $_POST['recipe'];
    
    $errors = array(); // Initialize an error array.


   if (empty($errors)) { // If everything's OK.
    
        // Run the query.
        $q = "insert into event (event_name, user_id, event_date) values ('$recipe', '$user_id', '$date' )";      
        $r = @mysqli_query ($dbc, $q);
               
        if ($r) { // If it ran OK.
            ?>
            <script type="text/javascript">
                newDoc("calendar.php");
            </script>
            <?
        } else { // If it did not run OK.
            
            // Public message:
            echo '<h1>System Error</h1>
            <p class="error">You could not add your recipe due to a system error. We apologize for any inconvenience.</p>'; 
            
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
        
    }
}   



//calendar code adapted from from http://davidwalsh.name/php-event-calendar

/* draws a calendar */
function draw_calendar($month,$year,$events = array(), $events2 = array()){

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

	/* table headings */
	$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):
		$calendar.= '<td class="calendar-day"><div style="position:relative;height:100px;">';
			/* add in the day number */
			$calendar.= '<div class="day-number">'.$list_day.'</div>';
			$event_day = $year.'-'.$month.'-'.$list_day;
                        //echo $event_day;
			if(isset($events[$event_day])) {
                                    //echo "here";
				foreach($events[$event_day] as $event) {
                                            //echo $event_day;
                                            //echo $event;
                                        foreach($events2[$event] as $ev) {
                                            //$ev = $events2[$event];
                                                //echo $ev;
                                            $calendar.= '<div class="event">'.$ev.'</div>';
				}
                                }
			}
			else {
				$calendar.= str_repeat('<p>&nbsp;</p>',2);
			}
		$calendar.= '</div></td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
	endfor;

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np">&nbsp;</td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';
	

	/* end the table */
	$calendar.= '</table>';

	/** DEBUG **/
	$calendar = str_replace('</td>','</td>'."\n",$calendar);
	$calendar = str_replace('</tr>','</tr>'."\n",$calendar);
	
	/* all done, return result */
	return $calendar;
}

function random_number() {
	srand(time());
	return (rand() % 7);
}

/* date settings */
$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
$month = str_pad($month,2,'0', STR_PAD_LEFT);
$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

/* select month control */
$select_month_control = '<select name="month" id="month">';
for($x = 1; $x <= 12; $x++) {
	$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
}
$select_month_control.= '</select>';

/* select year control */
$year_range = 7;
$select_year_control = '<select name="year" id="year">';
for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
	$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
}
$select_year_control.= '</select>';

/* "next month" control */
$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month &gt;&gt;</a>';

/* "previous month" control */
$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control">&lt;&lt; 	Previous Month</a>';


/* bringing the controls together */
$controls = '<form method="get">'.$select_month_control.$select_year_control.'&nbsp;<input type="submit" name="submit" value="Go" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$previous_month_link.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$next_month_link.' </form>';


/* get all events for the given month */

$events1 = array();
$events2 = array();
$query = "SELECT event_id, event_name, DATE_FORMAT(event_date,'%Y-%m-%e') AS event_date FROM event WHERE event_date LIKE '$year-$month%' and user_id like '%$user_id%'";
$result = @mysqli_query($dbc, $query)  or die('cannot get results!');
while($row = mysqli_fetch_row($result)) {
        $key = $row[2];
        $val = $row[1];
        $title = $row[0];
	$events1[$key][] = $title;
        $events2[$title][] = $val;
}

echo '<h2 style="float:left; padding-right:30px;">'.date('F',mktime(0,0,0,$month,1,$year)).' '.$year.'</h2>';
echo '<div style="float:left;">'.$controls.'</div>';
echo '<div style="clear:both;"></div>';
echo draw_calendar($month,$year,$events1, $events2);
echo '<br /><br />';
?>



    
<?php include 'footer.php'; ?>
    
</body>