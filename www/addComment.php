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
	<div id="addComment" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
		
		<p class="w3-xlarge"><b>Add New Comment</b></p>

		<p><span class="error">* required field.</span></p>

		<!-- retrieve movie from database -->
		<?php
			$mid = $name = $time = $rating = $comment ="";
			$MovieID ="";
			$nameerr = $commerror = "";

			$servername = "localhost";
			$username = "id2605576_milkchild";
			$password = "password";
			$dbname = "id2605576_minifilmrating";

			// Create connection
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			// Check connection
			if (mysqli_connect_errno()) {
			    die("Connection failed: " . mysqli_connect_error());
			}

			$MovieID = $_GET['mid'];

			if(empty($MovieID)){
				$mresult = mysqli_query($conn, "SELECT id, title, year FROM Movie"); // get movie info
			}
			else{
				$mresult = mysqli_query($conn, "SELECT id, title, year FROM Movie WHERE id = $MovieID");
			}

			$msg ="";

			//add movie comment into table Review
			if($_SERVER["REQUEST_METHOD"] == "POST"){
				$name = $_POST["name"];
				$mid = $_POST["movie"];
				$rating = $_POST["rating"];
				$comment = $_POST["comment"];

				//get current timestamp
				$time = date("Y-m-d H:i:s");
				// echo $time."test<br>";


				if(empty($comment)){
					$commerror = "Comment is required";
				}
				if(empty($name)){
					//$nameerr = "Reviewer name is required";
					$name = "Anonymous";
				}
				if(!empty($comment) && !empty($name)){
					$query = "INSERT INTO Review(name, time, mid, rating, comment) VALUES ('$name', '$time', $mid, $rating, '$comment')";

					//if insertion failed, output error message
					if(mysqli_query($conn, $query)==TRUE){
						$msg = "New Record Inserted Successfully<br>";
					}
					else{
					    $msg = "New Record Is Not Inserted<br>";
					    $errmsg = mysqli_error($$conn);
					    $msg = $msg.$errmsg;//generate error msg
					}

				}
			   
			}

			// form start ================
			echo "<form method=\"post\" action=\"addComment.php?mid=$MovieID\">";

				
				echo "Your name <span class=\"w3-text-grey\">(leave blank if you want to comment as an Anonymous) </span><br>";
				echo "<INPUT TYPE = \"text\" NAME = \"name\" VALUE=\"\" SIZE =50 MAXLENGTH = 50>";
				echo "<span class = \"error\"> <?php echo $nameerr; ?></span><br><br>";

				echo "Movie<br>";
				echo "<SELECT NAME=\"movie\">";  
				
				//generate selection box for movie
				while($row = mysqli_fetch_row($mresult)){
					$movieid = $row[0];
					$movietitle = $row[1];
					$movieyear = $row[2];
					echo "<OPTION VALUE = ".$movieid."> ".$movietitle." (".$movieyear.")</OPTION>";
				} 
				
				echo "</SELECT><br><br>";

				// get movie rating 
				echo "Rating <span class = \"error\">*</span><br>";
				echo "<SELECT NAME=\"rating\">";
				echo "<OPTION VALUE = 1>1</OPTION>";
				echo "<OPTION VALUE = 2>2</OPTION>";
				echo "<OPTION VALUE = 3>3</OPTION>";
				echo "<OPTION VALUE = 4>4</OPTION>";
				echo "<OPTION VALUE = 5>5</OPTION>";
				echo "</SELECT><br><br>";
				  
				echo "Comment <span class = \"error\">* <?php echo $commerror; ?></span>";
				if(empty($comment))
					echo "<span class=\"error\">".$commerror."</span>";
				echo "<br><TEXTAREA NAME =\"comment\" ROWS =10 COLS =50></TEXTAREA> <br><br>";
				

				echo "<input class=\"w3-button w3-theme w3-hover-white\" type=\"submit\" name = \"submit\" value =\"Add\">";

				echo "</form>";

			// form end ==================



			//output success/error message to the reviewer
			echo "<p class=\"w3-text-grey\">";
			echo $msg;
			echo "</p>";
			
			if($msg == "New Record Inserted Successfully<br>") { // add successfully
				echo "<a href=\"showMovie.php?id=$MovieID\" class=\"w3-text-blue\">Go back to see this movie information</a><br><br>";
			}
			


			//free result
			mysqli_free_result($mresult);
			mysqli_free_result($result);


			//close connections
			mysqli_close($conn);

		?>



		


		




	</div>

	<!-- ========================= Main content end ======================================== -->
<!-- END MAIN -->
</div>

<footer class="w3-container w3-padding-16">
  <div class="w3-center">Copyright &copy 2017 Chunchun Ye. All Rights Reserved</div>
</footer>

<script src="lib/functions.js"></script>
<script src="lib/w3codecolor.js"></script>
<script>
	w3CodeColor();
</script>



</body>
</html>











