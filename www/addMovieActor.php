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
	.error {color: #FF0000;}
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
	<div id="addMovieActor" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
		
		<p class="w3-xlarge">Add Movie/Actor Relation</p>

		<!-- retrieve movie and actor info from database -->
		<?php
			$role = $actor = $movie ="";
			$roleerror ="";

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
			$aresult = mysql_query("SELECT id, first, last, dob FROM Actor", $db_connection); //get actor info
		?>

		<?php 

		$msg ="";
		//add movie director into table MovieDirector
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			$mid = $_POST["movie"];
			$aid = $_POST["actor"];
			$role = $_POST["role"];

			if(empty($mid)) {
				$miderror = "Movie is required";
			} 

			if(empty($aid)) {
				$aiderror = "Actor/Actress is required";
			} 

			if(empty($role)){
				$roleerror = "Role is required";
			}

			if(!empty($mid) && !empty($aid) && !empty($role)) {
				$query = "INSERT INTO MovieActor(mid, aid, role) VALUES ($mid, $aid,'$role')";

				//if insertion failed, output error message
				if(mysql_query($query, $db_connection)==TRUE){
					$msg = "New Record Inserted Successfully<br>";
				}
				else{
				    $msg = "New Record Is Not Inserted<br>";
				    $errmsg = mysql_error($db_connection);
				    $msg = $msg.$errmsg;
				}
			}
		}
		?>

		<p><span class="error">* required field.</span></p>

		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

			Movie <span class = "error">*<?php echo $miderror; ?></span> <br>
			<SELECT NAME="movie">  
			<?php 

			//generate selection box for movie
			echo "<option value=\"\" disabled selected></option>"; // empty option
			while($row = mysql_fetch_row($mresult)){
				$movieid = $row[0];
				$movietitle = $row[1];
				$movieyear = $row[2];
				echo "<OPTION VALUE = ".$movieid."> ".$movietitle." (".$movieyear.")</OPTION>";
			} 
			?>
			</SELECT><br><br>

			Actor <span class = "error">*<?php echo $aiderror; ?></span> <br>
			<SELECT NAME="actor">  
			<?php 
			//generate selection box for actor
			echo "<option value=\"\" disabled selected></option>"; // empty option
			while($row = mysql_fetch_row($aresult)){
				$actorid = $row[0];
				$actorname = $row[1]." ".$row[2];
				$actordob = $row[3];
				echo "<OPTION VALUE = ".$actorid."> ".$actorname." (".$actordob.")</OPTION>";
			} 
			?>
			</SELECT><br><br>

			Role <span class = "error">*<?php echo $roleerror; ?></span><br>
			<INPUT TYPE = "text" NAME = "role" VALUE="" SIZE =50 MAXLENGTH = 50>
			
			<br><br>

			<input class="w3-button w3-theme w3-hover-white" type="submit" name = "submit" value ="Add">

		</form>


		<?php
			echo "<p class=\"w3-text-grey\">";
			echo $msg;
			echo "</p>";
			//free result
			mysql_free_result($mresult);
			mysql_free_result($aresult);

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














