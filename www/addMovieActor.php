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
	$aresult = mysql_query("SELECT id, last, first, dob FROM Actor", $db_connection); //get director info

?>

<?php 

$msg ="";
//add movie director into table MovieDirector
if($_SERVER["REQUEST_METHOD"] == "POST"){
	$mid = $_POST["movie"];
	$aid = $_POST["actor"];
	$role = $_POST["role"];

	if(empty($role)){
		$roleerror = "Role is required";
	}
	else{
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

Actor<br>
<SELECT NAME="actor">  
<?php 
//generate selection box for director

while($row = mysql_fetch_row($aresult)){
	$actorid = $row[0];
	$actorname = $row[1]." ".$row[2];
	$actordob = $row[3];
	echo "<OPTION VALUE = ".$actorid."> ".$actorname." (".$actordob.")</OPTION>";
} 
?>
</SELECT><br><br>

Role<br><INPUT TYPE = "text" NAME = "role" VALUE="<?php echo $role; ?>" SIZE =50 MAXLENGTH = 50>
<span class = "error"> <?php echo $roleerror; ?></span>
<br><br>

<input type="submit" name = "submit" value ="Add">

</form>




<?php

echo $msg;
//free result
mysql_free_result($mresult);
mysql_free_result($aresult);

//close connections
mysql_close($db_connection);

?>
