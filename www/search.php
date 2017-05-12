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
    <a class="w3-wide w3-hover-white w3-left w3-button" href="index.php" ">CS143 DataBase Query System (Demo)</a>
  </div>

  <div class="w3-bar w3-theme w3-large" style="z-index:4;">
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme w3-padding-16" href="javascript:void(0)" onclick="w3_open()">&#9776</a> <!-- ☰ -->
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu1')">Add new content</a>
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

  <div id="menu1" class="myMenu" style="display:none">
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

  <div id="menu3" class="myMenu">
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

	<div id="search" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
		<p class="w3-xlarge"><b>Searching Page</b></p>

		<!-- Search Bar & Botton -->
		<div style="padding: 10px 0px;">
			<form method="get" action="">
				<input class="searchBar" type="text" name="searchKey" placeholder="Search.."><br><br>

				<input class="w3-button w3-theme w3-hover-white" type="submit" value="Search"><br>

				<!-- php script -->
				<?php
					$servername = "localhost";
					$username = "cs143";
					$password = "";
					$dbname = "CS143";

					// Create connection
					$conn = mysqli_connect($servername, $username, $password, $dbname);
					// Check connection
					if (!$conn) {
					    die("Connection failed: " . mysqli_connect_error());
					}

					$key = $_GET['searchKey'];

					// Collect value of search bar
					if($key == "") {
						echo "<p class=\"w3-text-grey\">Please enter an actor/actress/movie name.</p>";
					} else {
						echo "<p class=\"w3-text-grey\">Search: {$key}</p>";

						$keyArr = explode(" ", $key);
						$actor_query = "SELECT id, first, last, dob FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%$keyArr[0]%'";
						for($i = 1; $i < count($keyArr); ++$i) {
							$actor_query = $actor_query." AND CONCAT(first, ' ', last) LIKE '%$keyArr[$i]%'";
						}
						$actor_query = $actor_query.";";
						$actor_result = mysqli_query($conn, $actor_query);

						if(!$actor_result) {
							echo "Error description: " . mysqli_error($conn);
						} else {
							echo $actor_result;
							echo "successfully got result!";	
						}

						
						if(mysqli_num_rows($actor_result) == 0) {
							echo "<p class=\"w3-text-grey\">No result of {$key}</p>";
						} else {
							echo $actor_result;
						}
					}
					
				?>
			</form><br>
		</div>

		<!-- Actor/Movie Tables -->
		<div id="actorTable" style="padding-bottom: 10px;">
			<p class="w3-large"><b>Matching Actors are:</b></p>
			<table class="w3-table-all w3-hoverable">
				<tr>
					<th>Name</th>
					<th>Date of Birth</th>
				</tr>
				<tr>
					<td>Sample 1</td>
					<td>Sample 1</td>
				</tr>
				<tr>
					<td>Sample 2</td>
					<td>Sample 2</td>
				</tr>
			</table>
		</div>

		<div id="movieTable" style="padding-bottom: 10px;">
			<p class="w3-large"><b>Matching Movies are:</b></p>

			<table class="w3-table-all w3-hoverable">
				<tr>
					<th>Title</th>
					<th>Year</th>
				</tr>
				<tr>
					<td>Sample 1</td>
					<td>Sample 1</td>
				</tr>
				<tr>
					<td>Sample 2</td>
					<td>Sample 2</td>
				</tr>
			</table>
		</div>

	</div>

<!-- END MAIN -->
</div>


<script src="lib/functions.js"></script>
<script src="lib/w3codecolor.js"></script>
<script>
	w3CodeColor();
</script>

</body>
</html>












