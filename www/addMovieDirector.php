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
	$dresult = mysql_query("SELECT id, last, first, dob FROM Director", $db_connection); //get director info

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
    echo "New Record Inserted Successfully<br>";
  }
  else{
    echo "New Record Is Not Inserted<br>";
    $errmsg = mysql_error($db_connection);
    echo $errmsg;
  }
 
}
//free result
mysql_free_result($mresult);
mysql_free_result($dresult);

//close connections
mysql_close($db_connection);

?>
