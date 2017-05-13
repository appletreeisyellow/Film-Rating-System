<p class="w3-xlarge"><b>Actor Information Page</b></p>

<!-- Search Bar & Botton -->
<div style="padding: 10px 0px;">
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

		<input class="searchBar" type="text" name="searchKey" placeholder="Search.."><br><br>
		<input type="submit" name = "submit" value ="Search">
	</form><p></p>

	<!--<a class="w3-button w3-theme w3-hover-white" onclick="show_main('search')">Search</a><p></p>-->
</div>


<?php
$searchKey = "";
$namerr ="";
if($_SERVER["REQUEST_METHOD"]== "POST"){
	$searchKey = $_POST['searchKey'];
	if(empty($searchKey)){
		$namerr = "Empty Search";
	}
	else{
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

		echo "<p class=\"w3-text-grey\">Search: {$searchKey}</p>";

		$keyArr = explode(" ", $searchKey);

		// Actor query 
		$actor_query = "SELECT id, first, last, dob FROM Actor WHERE CONCAT(first, ' ', last) LIKE '%$keyArr[0]%'";
		for($i = 1; $i < count($keyArr); ++$i) {
			$actor_query = $actor_query." AND CONCAT(first, ' ', last) LIKE '%$keyArr[$i]%'";
		}
		
		$actor_query = $actor_query.";";

		if($actor_result=mysqli_query($conn, $actor_query)) {
			
			if( mysqli_num_rows($actor_result) == 0) {
				// Empty query
				echo "<p class=\"w3-text-grey\">No Actor found named in \"{$searchKey}\"</p>";
			} 
			else {
				// Actor Table
				echo "<p class=\"w3-large\"><b>Matching Actors are:</b></p>";
				echo "<table class=\"w3-table-all w3-hoverable\">";
				echo "<tr><th>Name</th> <th>Date of Birth</th></tr>";
				while($row = mysqli_fetch_row($actor_result)) {
					echo "<tr>";
					echo "<td><a href=\"showActor.php?id=$row[0]\" class=\"w3-text-blue\">".$row[1]." ".$row[2]."</td>";
					echo "<td>".$row[3]."</td>";
					echo "</tr>";
				}
				echo "</table>";
			}
			    
			// Free result set
			mysqli_free_result($actor_result);
		}
	}


	//close connections
	mysqli_close($conn);
	

}

?>

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

		//print actor information
		$result = mysql_query("SELECT * FROM Actor WHERE id =$aid", $db_connection); // result is an object
		echo "<p class='w3-large'><b>Actor Information</b></p>";
		echo "<table border ='1'>";
		echo "<tr align ='center'>";
			echo"<th>Name</th>";
			echo"<th>Sex</th>";
			echo"<th>Date of Birth</th>";
			echo"<th>Date of Death</th>";
		echo "</tr>";
		while($row = mysql_fetch_row($result)){
			echo "<tr align ='center'>";
			echo "<td>".$row[2]." ".$row[1]."</td>"; //name
			echo "<td>".$row[3]."</td>";	//gender
			echo "<td>".$row[4]."</td>";	//dob
			if(is_null($row[5])){
				echo "<td>Still Alive</td>";
			}
			else{
				echo "<td>".$row[5]."</td>";
			}
			echo "<tr>";
			
		}
		echo "</table>";
		//print movie role
		//$query = "SELECT mid, role FROM MovieActor WHERE aid = $aid";
		$result = mysql_query("SELECT mid, role FROM MovieActor WHERE aid =$aid", $db_connection);
		echo "<br><p class='w3-large'><b>Movie and Role Information</b></p>";
		echo "<table border ='1'>";
		echo "<tr>";
			echo"<th>MovieTitle</th>";
			echo"<th>Role</th>";
		echo "</tr>";
		while($row = mysql_fetch_row($result)){
			echo "<tr>";
			//$row[0] is movie id 
			$mresult = mysql_query("SELECT title FROM Movie WHERE id = $row[0]", $db_connection);
			$mrow = mysql_fetch_row($mresult);
			echo "<td><a href=\"showMovie.php?id=$row[0]\" class=\"w3-text-blue\">".$mrow[0]."</td>"; 	//$mrow[0] is MovieTitle
			echo "<td>".$row[1]."</td>";	//Role
			echo "<tr>";
			
		}

	}
?>

<?php
	//free result
	mysql_free_result($result);


	//close connections
	mysql_close($db_connection); 
?>

