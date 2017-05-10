<p class="w3-xlarge">Add Movie Information</p>

<html>
<style>
.error {color: #FF0000;}
</style>
<!--this page allows users to add actor and/or director information-->
<!--Actor(id, last, first, sex, dob, dod) -->
<!--Director(id, last, first, dob, dod) -->
<body>

<?php
$title = $year = $company = $rating = "";
$titleerr = $yearerr = $comerr ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $title = $_POST["Title"];
  $year = $_POST["Year"];
  $company = $_POST["Company"];
  $rating = $_POST["Rating"];
  if(empty($title)){
    $titleerr = "Movie title is required";
  }
  if(empty($year)){
    $yearerr = "Movie year is required";
  }
  if($year>2017 || $year <0){
    $yearerr = "Movie year is not valid";
  }
  if(empty($company)){
    $comerr = "Movie company is required";
  }
  //echo "$title, $year, $company, $rating<br>";
  if(!empty($title) && !empty($year) && !empty($company) && $year<=2017 && $year>0){
    $msg = insert_movie($title, $year, $company, $rating);
  }
}

function insert_movie($title, $year, $company, $rating){
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

  $result = mysql_query("SELECT id FROM MaxMovieID", $db_connection); // result is an object
  $row = mysql_fetch_row($result);
  $ID = $row[0]+1;
  //echo $ID."<br>";
  $query = "INSERT INTO Movie(id, title, year, rating, company) VALUES ($ID, '$title', $year, '$rating', '$company')";

  $msg = "";

  if(mysql_query($query, $db_connection)==TRUE){
    $msg =  "New Record Inserted Successfully<br>";
    $query = "UPDATE MaxMovieID SET id=$ID";
    mysql_query($query, $db_connection);
    $query = "SELECT * FROM Movie WHERE id = $ID";
    $result = mysql_query($query, $db_connection);

    while($row = mysql_fetch_row($result)) {
      $id = $row[0];
      $tit = $row[1];
      $y = $row[2];
      $r = $row[3];
      $com = $row[4];
      $msg = $msg."<br>$id, $tit, $y, $r, $com <br />";
    }
  }
  else{
    $msg = "New Record Is Not Inserted<br>";
    $errmsg = mysql_error($db_connection);
    $msg = $msg."<br>".$errmsg;
  }
  return $msg;
  //free result
  mysql_free_result($result);


  //close connections
  mysql_close($db_connection); 

}
?>


<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

  <!--choose to add acotr and/or director information -->
  Title<br><INPUT TYPE = "text" NAME="Title" VALUE = "<?php echo $title; ?>" SIZE = 100 MAXLENGTH = 100>
  <span class = "error">* <?php echo $titleerr;?></span><br><br>

  Year<br><INPUT TYPE = "text" NAME ="Year" VALUE ="<?php echo $year; ?>" SIZE= 4 MAXLENGTH = 4>  
  <span class = "error">* <?php echo $yearerr;?></span><br><br>

  Company<br><INPUT TYPE = "text" NAME="Company" VALUE = "<?php echo $company; ?>" SIZE = 50 MAXLENGTH = 50>
  <span class = "error">* <?php echo $comerr;?></span><br><br>

  Rating<br>
  <SELECT NAME="Rating">
  <OPTION <?php if (isset($rating) && $rating=="G") echo "SELECTED";?> VALUE ="G">G
  <OPTION <?php if (isset($rating) && $rating=="PG") echo "SELECTED";?> VALUE ="PG">PG
  <OPTION <?php if (isset($rating) && $rating=="PG-13") echo "SELECTED";?> VALUE ="PG-13">PG-13
  <OPTION <?php if (isset($rating) && $rating=="R") echo "SELECTED";?> VALUE ="R">R
  <OPTION <?php if (isset($rating) && $rating=="NC-17") echo "SELECTED";?> VALUE ="NC-17">NC-17
  </SELECT><br><br>

  <input type="submit" name = "submit" value ="Add">

</form>
<?php 
 echo $msg;
?>

</body>
</html>
