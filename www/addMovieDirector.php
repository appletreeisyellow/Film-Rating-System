<!DOCTYPE html>
<html>
	<title>CS143 Project 1B</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="lib/stylesheet.css">
	<style>
	.w3-theme {color:#fff !important;background-color:#4CAF50 !important}
	.w3-btn {background-color:#4CAF50;margin-bottom:4px}
	.w3-code{border-left:4px solid #4CAF50}
	.myMenu {margin-bottom:150px}
	</style>

<body>

<!-- Top -->
<div class="w3-top">
  <div class="w3-row w3-white w3-padding">
    <a class="w3-wide w3-hover-white w3-left w3-button" href="index.php">CS143 DataBase Query System</a>
  </div>

  <div class="w3-bar w3-theme w3-large" style="z-index:4;">
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme w3-padding-16" href="javascript:void(0)" onclick="w3_open()">&#9776</a> <!-- ☰ -->
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu1')">Add New Content</a>
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu2')">Browsering Content</a>
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu3')">Search Interface</a>
  </div>
</div>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-collapse w3-animate-left" style="z-index:3;width:270px" id="mySidebar">
  <div class="w3-bar w3-hide-large w3-large">
    <a href="javascript:void(0)" onclick="w3_show_nav('menu1')" class="w3-bar-item w3-button w3-theme w3-hover-white w3-padding-16" style="width:50%">Add new content</a>
    <a href="javascript:void(0)" onclick="w3_show_nav('menu2')" class="w3-bar-item w3-button w3-theme w3-hover-white w3-padding-16" style="width:50%">Browsering Content</a>
    <a href="javascript:void(0)" onclick="w3_show_nav('menu3')" class="w3-bar-item w3-button w3-theme w3-hover-white w3-padding-16" style="width:50%">Search Interface</a>
  </div>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-right w3-xlarge w3-hide-large" title="Close Menu">&#9747</a> <!-- x -->

  <div id="menu1" class="myMenu">
	  <div class="w3-container">
	    <h3>Add new content</h3>
	  </div>
	  <a href="addActorDirector.php" class="w3-bar-item w3-button">Add Actor/Director</a>
	  <a href="addMovieInfo.php" class="w3-bar-item w3-button">Add Movie Information</a>
	  <a href="addMovieActor.php" class="w3-bar-item w3-button">Add Movie/Actor Relation</a>
	  <a href="addMovieDirector.php" class="w3-bar-item w3-button">Add Movie/Director Relation</a>
  </div>

  <div id="menu2" class="myMenu" style="display:none">
	  <div class="w3-container">
	    <h3>Browsering Content</h3>
	  </div>
	  <a href="showActor.php" class="w3-bar-item w3-button">Show Actor Information</a>
	  <a href="showMovie.php" class="w3-bar-item w3-button">Show Movie Information</a>
  </div>

  <div id="menu3" class="myMenu" style="display:none">
	  <div class="w3-container">
	    <h3>Search Interface</h3>
	  </div>
	  <a href="search.php" class="w3-bar-item w3-button">Search Actor/Movie</a>
  </div>

</div>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 270 pixels when the sidebar is visible -->
<div class="w3-main w3-container" style="margin-left:270px;margin-top:117px;">

	<!-- ========================= Main content start ======================================== -->
	<div id="addMovieDirector" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
		
		<p class="w3-xlarge">Add Movie/Director Relation</p>

		<!-- retrieve movie and director info from database -->
		<?php 
			
			$director = $movie ="";

			//connect to mysql
			$db_connection = mysql_connect("localhost", "cs143", ""); 
			//select database
			mysql_select_db("CS143", $db_connection); 
			//if the connection fails, output error msg and exit
			if(!$db_connection){ 
			  $errmsg = mysql_error($db_connection);
			  print "Connection failed: $errmsg <br />";
			  exit(1);
			}

			$mresult = mysql_query("SELECT id, title, year FROM Movie", $db_connection); // get movie info
			$dresult = mysql_query("SELECT id, first, last, dob FROM Director", $db_connection); //get director info

		?>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		Movie<br>
		<SELECT NAME="movie">  
		<?php 
		//generate selection box for movie
		while($row = mysql_fetch_row($mresult)){
			$movieid = $row[0];
			$movietitle = $row[1];
			$movieyear = $row[2];
			echo "<OPTION VALUE = ".$movieid."> ".$movietitle." (".$movieyear.")</OPTION>";
		} 
		?>
		</SELECT><br><br>

		Director<br>
		<SELECT NAME="director">  
		<?php 
		//generate selection box for director

		while($row = mysql_fetch_row($dresult)){
			$directorid = $row[0];
			$directorname = $row[1]." ".$row[2];
			$directordob = $row[3];
			echo "<OPTION VALUE = ".$directorid."> ".$directorname." (".$directordob.")</OPTION>";
		} 
		?>
		</SELECT><br><br>
		<input type="submit" name = "submit" value ="Add">

		</form>


		<?php 
		//add movie director into table MovieDirector
		if($_SERVER["REQUEST_METHOD"] == "POST"){
		  $mid = $_POST["movie"];
		  $did = $_POST["director"];
		  $query = "INSERT INTO MovieDirector(mid, did) VALUES ($mid, $did)";

		  //if insertion failed, output error message
		  if(mysql_query($query, $db_connection)==TRUE){
		    echo "<p class=\"w3-text-grey\">New Record Inserted Successfully</p><br>";
		  }
		  else{
		    echo "<p class=\"w3-text-grey\">New Record Is Not Inserted</p>";
		    $errmsg = mysql_error($db_connection);
		    echo "<p class=\"w3-text-grey\">";
		    echo $errmsg;
		    echo "</p><br>";
		  }
		 
		}
		//free result
		mysql_free_result($mresult);
		mysql_free_result($dresult);

		//close connections
		mysql_close($db_connection);

		?>

	</div>

	<!-- ========================= Main content end ======================================== -->
<!-- END MAIN -->
</div>

<script src="lib/functions.js"></script>
<script src="lib/w3codecolor.js"></script>
<script>
	w3CodeColor();
</script>



</body>
</html>










