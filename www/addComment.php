<p class="w3-xlarge"><b>Add New Comment</b></p>


<!-- retrieve movie from database -->
<?php
	$mid = $name = $time = $rating = $comment ="";
	$MovieID ="";
	$nameerr = $commerror = "";
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
	$MovieID = $_GET['mid'];
	if(empty($MovieID)){
		$mresult = mysql_query("SELECT id, title, year FROM Movie", $db_connection); // get movie info
	}
	else{
		$mresult = mysql_query("SELECT id, title, year FROM Movie WHERE id = $MovieID");
	}

?>

<?php 

// $query ="SELECT CURRENT_TIMESTAMP()";
// $result = mysql_query($query, $db_connection);
// $row = mysql_fetch_row($result);
// echo $row[0];
// $time = $row[0];
$msg ="";

echo $comment;
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
		$nameerr = "Reviewer name is required";
	}
	if(!empty($comment) && !empty($name)){
		$query = "INSERT INTO Review(name, time, mid, rating, comment) VALUES ('$name', '$time', $mid, $rating, '$comment')";

		//if insertion failed, output error message
		if(mysql_query($query, $db_connection)==TRUE){
			$msg = "New Record Inserted Successfully<br>";
		}
		else{
		    $msg = "New Record Is Not Inserted<br>";
		    $errmsg = mysql_error($db_connection);
		    $msg = $msg.$errmsg;//generate error msg
		}

	}
   
}

?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

<!-- get reviewer name-->
Your name<br>
<INPUT TYPE = "text" NAME = "name" VALUE="" SIZE =50 MAXLENGTH = 50>
<span class = "error"> <?php echo $nameerr; ?></span><br><br>

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

<!--get movie rating -->
Rating<br>
<SELECT NAME="rating">
<OPTION VALUE = 1>1</OPTION>
<OPTION VALUE = 2>2</OPTION>
<OPTION VALUE = 3>3</OPTION>
<OPTION VALUE = 4>4</OPTION>
<OPTION VALUE = 5>5</OPTION>
</SELECT><br><br>
  
Comment<br><TEXTAREA NAME ="comment" ROWS =10 COLS =50></TEXTAREA>
<span class = "error"> <?php echo $roleerror; ?></span>
<br><br>

<input type="submit" name = "submit" value ="Add">

</form>




<?php
//output success/error message to the reviewer
echo $msg;
$query = "SELECT * FROM Review WHERE name = '$name' AND time = '$time' AND mid = $mid AND rating = $rating AND comment = '$comment'";
//$query = "SELECT * FROM Review";
$result = mysql_query($query, $db_connection);
if(!empty($result)){
	$row = mysql_fetch_row($result);
	echo "Reviewer: ".$row[0].", ".$row[1].", MovieID: ".$row[2].", Rating: ".$row[3].", Comment: ".$row[4]."<br>";
}

//free result
mysql_free_result($mresult);
mysql_free_result($result);


//close connections
mysql_close($db_connection);

?>
