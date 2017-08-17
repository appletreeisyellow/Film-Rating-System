<!DOCTYPE html>
<html>
  <title>Mini Film Rating</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="lib/stylesheet.css">
  <style>
  .w3-theme {color:#fff !important;background-color:#5f4caf !important}
  .w3-btn {background-color:#5f4caf;margin-bottom:4px}
  .w3-code{border-left:4px solid #5f4caf}
  .myMenu {margin-bottom:150px}
  .error {color: #FF0000;}
  </style>

<body>

<!-- Top -->
<div class="w3-top">
  <div class="w3-row w3-white w3-padding">
    <a class="w3-wide w3-hover-white w3-left w3-button" href="index.php">Mini Film Rating</a>
  </div>

  <div class="w3-bar w3-theme w3-large" style="z-index:4;">
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme w3-padding-16" href="javascript:void(0)" onclick="w3_open()">&#9776</a> <!-- ☰ -->
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu1')">Add New Content</a>
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu2')">Browsering Content</a>
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu3')">Search Interface</a>
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="howToUse.php" title="How To Use">How To Use</a>
  </div>
</div>

<!-- Sidebar -->
<div class="w3-sidebar w3-bar-block w3-collapse" style="z-index:3;width:270px" id="mySidebar">
  <div class="w3-bar w3-hide-large w3-large">
    <a href="javascript:void(0)" onclick="w3_show_nav('menu1')" class="w3-bar-item w3-button w3-theme w3-hover-white w3-padding-16" style="width:50%">Add new content</a>
    <a href="javascript:void(0)" onclick="w3_show_nav('menu2')" class="w3-bar-item w3-button w3-theme w3-hover-white w3-padding-16" style="width:50%">Browsering Content</a>
    <a href="javascript:void(0)" onclick="w3_show_nav('menu3')" class="w3-bar-item w3-button w3-theme w3-hover-white w3-padding-16" style="width:50%">Search Interface</a>
  </div>
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-right w3-xlarge w3-hide-large" title="Close Menu">&#9747</a> <!-- x -->

  <div id="menu1" class="myMenu" style="display:none">
	  <div class="w3-container">
	    <h3>Add new content</h3>
	  </div>
	  <a href="addActorDirector.php" class="w3-bar-item w3-button">Add Actor/Director</a>
	  <a href="addMovieInfo.php" class="w3-bar-item w3-button">Add Movie Information</a>
	  <a href="addMovieActor.php" class="w3-bar-item w3-button">Add Movie/Actor Relation</a>
	  <a href="addMovieDirector.php" class="w3-bar-item w3-button">Add Movie/Director Relation</a>
  </div>

  <div id="menu2" class="myMenu">
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
	<div id="showActor" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
		
		<p class="w3-xlarge"><b>Actor Information Page</b></p>

		<?php
			$aid = $_GET['id'];
			//echo ".".$aid.".";
			if(!empty($aid)){
				$db_connection = mysql_connect("localhost", "cs143", ""); 
				//select database
				mysql_select_db("CS143", $db_connection); 
				//if the connection fails, output error msg and exit
				if(!$db_connection){ 
				    $errmsg = mysql_error($db_connection);
				    print "Connection failed: $errmsg <br />";
				    exit(1);
				}

				// Actor Information Table
				$result = mysql_query("SELECT * FROM Actor WHERE id =$aid", $db_connection); // result is an object
				echo "<p class='w3-large'><b>Actor Information</b></p>";
				echo "<table class=\"w3-table-all w3-hoverable\">";
				echo "<tr><th>Name</th> <th>Sex</th> <th>Date of Birth</th> <th>Date of Death</th></tr>";

				while($row = mysql_fetch_row($result)){
					echo "<tr>";
					echo "<td>".$row[2]." ".$row[1]."</td>"; //name
					echo "<td>".$row[3]."</td>";	//gender
					echo "<td>".$row[4]."</td>";	//dob
					if(is_null($row[5]) || $row[5]=="0000-00-00"){
						echo "<td>Still Alive</td>";
					}
					else{
						echo "<td>".$row[5]."</td>";
					}
					echo "<tr>";
				}
				echo "</table>";
				
				// Movie Role Table
				$result = mysql_query("SELECT mid, role FROM MovieActor WHERE aid =$aid", $db_connection);
				echo "<br><p class='w3-large'><b>Movie and Role Information</b></p>";
				echo "<table class=\"w3-table-all w3-hoverable\">";
				echo "<tr><th>Movie Title</th> <th>Role</th></tr>";
				while($row = mysql_fetch_row($result)){
					echo "<tr>";
					//$row[0] is movie id 
					$mresult = mysql_query("SELECT title FROM Movie WHERE id = $row[0]", $db_connection);
					$mrow = mysql_fetch_row($mresult);
					echo "<td><a href=\"showMovie.php?id=$row[0]\" class=\"w3-text-blue\">".$mrow[0]."</td>"; 	//$mrow[0] is MovieTitle
					echo "<td>".$row[1]."</td>";	//Role
					echo "<tr>";
				}
				echo "</table><br><br>";

				//free result
				mysql_free_result($result);
				//close connections
				mysql_close($db_connection);
			}
		?>

		<!-- Search Bar & Botton -->
		<div style="padding: 10px 0px;">
			<form method="get" action="search.php?searchKey=$searchKey">
				<input class="searchBar" type="text" name="searchKey" placeholder="Search.."><br><br>
				<input class="w3-button w3-theme w3-hover-white" type="submit" value="New Search"><br>
			</form>
			<br>
		</div> <!-- End of Search Bar & Botton -->
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













