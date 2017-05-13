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

	<div id="showMovie" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">

		<p class="w3-xlarge"><b>Movie Information Page</b></p><br>

		<?php

			$id = $_GET['id'];

			if(!is_null($id)) {

				$servername = "localhost";
				$username = "cs143";
				$password = "";
				$dbname = "CS143";

				// Create connection
				$conn = mysqli_connect($servername, $username, $password, $dbname);
				// Check connection
				if (mysqli_connect_errno()) {
				    die("Connection failed: " . mysqli_connect_error());
				}

				// Movie Information
				echo "<p class=\"w3-large\"><b>Movie Information:</b></p>";
				$title = $rating = $producer = $director = $genre = $movie_year = "";
				$movie_query = "SELECT title, year, rating, company FROM Movie WHERE id = $id;";
				$director_query = "SELECT first, last FROM Director WHERE id = ( SELECT did FROM MovieDirector WHERE mid = $id);";
				$genre_query = "SELECT genre FROM MovieGenre WHERE mid = $id;";

				if(($movie_result = mysqli_query($conn, $movie_query)) && 
					 ($director_result = mysqli_query($conn, $director_query)) &&
					 ($genre_result = mysqli_query($conn, $genre_query))) {

					$movieRow = mysqli_fetch_row($movie_result);
					$title = $movieRow[0];
					$movie_year = $movieRow[1];
					$rating = $movieRow[2];
					$producer = $movieRow[3];

					$directorRow = mysqli_fetch_row($director_result);
					$director = $directorRow[0]." ".$directorRow[1];

					$genreRow = mysqli_fetch_row($genre_result);
					$genre = $genreRow[0];

					echo "<p><b>Title: </b>".$title." (".$movie_year.")"."</p>";
					echo "<p><b>Producer: </b>".$producer."</p>";
					echo "<p><b>MPAA Rating: </b>".$rating."</p>";
					echo "<p><b>Director: </b>".$director."</p>";
					echo "<p><b>Genre: </b>".$genre."</p>";
					echo "<br>";

					// Free result set
					mysqli_free_result($movie_result);
					mysqli_free_result($director_result);
					mysqli_free_result($genre_result);
				} else {
					echo "<p class=\"w3-text-grey\">Movie not found.</p>";
				}

				// Show links to the actors/actresses that were in this movie.
				$role_query = "SELECT aid, role FROM MovieActor WHERE mid = $id;";

				if($role_result = mysqli_query($conn, $role_query)) {

					// Actors and Roles Table
					echo "<p class=\"w3-large\"><b>Actors in This Movie:</b></p>";
					echo "<table class=\"w3-table-all w3-hoverable\">";
					echo "<tr><th>Name</th> <th>Role</th></tr>";
					while($role_row = mysqli_fetch_row($role_result)) {
						$actor_result = mysqli_query($conn, "SELECT first, last FROM Actor WHERE id = $role_row[0];");
						$actor_row = mysqli_fetch_row($actor_result);
						echo "<tr>";
						echo "<td><a href=\"showActor.php?id=$role_row[0]\" class=\"w3-text-blue\">".$actor_row[0]." ".$actor_row[1]."</td>";
						echo "<td>".$role_row[1]."</td>";
						echo "</tr>";
						mysqli_free_result($actor_result);
					}
					echo "</table>";

					// Free result set
					mysqli_free_result($role_result);
				} else {
					// Empty query
					echo "<p class=\"w3-text-grey\">Actors not found.</p>";
				}

				// Average score + users reviews
				$review_query = "SELECT rating, name, time, comment FROM Review WHERE mid = $id;";
				$totalScore = 0;

				if($review_result = mysqli_query($conn, $review_query)) {
					
					// Show all user comments.
					echo "<br><br>";
					

					$reviewNum = mysqli_num_rows($review_result);

					if($reviewNum == 0) {
						echo "<p class=\"w3-large w3-text-grey\"><b>No Comments Yet!</b></p>";
					} else {
						echo "<p class=\"w3-large\"><b>Comments:</b></p><br>";
						while($row = mysqli_fetch_row($review_result)) {
							$totalScore = $totalScore + $row[0];
							echo "<p class=\"w3-small\"><b>Author: </b>".$row[1]." (".$row[2].") <b>Rating: </b>".$row[0]."/5</p>";
							echo "<p class=\"w3-small\"><b>Comment: </b></p>";
							echo "<p class=\"w3-small\">".$row[3]."</p>";
							echo "<br>";
						}
						echo "<br>";
						// Average Score
						$avgScore = round(($totalScore / $reviewNum), 2);
						echo "<p class=\"w3-large\"><b>Average Score: </b>".$avgScore."/5 (".$reviewNum." reviews)</p><br>";
					}
					// Free result set
					mysqli_free_result($review_result);
				} else {
					// No reviews yet
					echo "<br><br>";
					echo "<p class=\"w3-large w3-text-grey\"><b>No Comment Yet!</b></p>";
				}
				
				// Contain "Add Comment" button which links to Page I3 where users can add comments.
				echo "<p class=\"w3-text-grey\">Leave your comment!</p>";
				echo "<a class=\"w3-button w3-theme w3-hover-white\" href=\"addComment.php?mid=$id\">Add Comment</a><p></p>";

				mysqli_close($conn);

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


<!-- END MAIN -->
</div>

<script src="lib/functions.js"></script>
<script src="lib/w3codecolor.js"></script>
<script>
	w3CodeColor();
</script>

</body>
</html>


