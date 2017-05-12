<p class="w3-xlarge">Add Actor/Director</p>

<html>
<style>
.error {color: #FF0000;}
</style>
<!--this page allows users to add actor and/or director information-->
<!--Actor(id, last, first, sex, dob, dod) -->
<!--Director(id, last, first, dob, dod) -->
<body>

<?php

$role = $first = $last = $gender = $DOB = $dobmonth = $dobday = $dodyear = $dodmonth = $dodday = "";
$doderr = $doberr = $firsterr = $lasterr = $roleerr = $gendererr = "";
//function validate_input
//Strip unnecessary characters (extra space, tab, newline) 
//get rid of  back slash 
function validate_input($data){
  $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function insert_person($role, $first, $last, $gender, $dob, $dod){
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

  $result = mysql_query("SELECT id FROM MaxPersonID", $db_connection); // result is an object
  $row = mysql_fetch_row($result);
  $ID = $row[0]+1;
  if($role ==1){//actor
    if($gender ==1){
      //female
      $query = "INSERT INTO Actor(id, last, first, sex, dob, dod) VALUES ($ID, '$last', '$first', 'Female', $dob, $dod);";
    }
    elseif($gender==2){
      //male
      $query = "INSERT INTO Actor(id, last, first, sex, dob, dod) VALUES ($ID, '$last', '$first', 'Male', $dob, $dod);";
    }

  }
  elseif($role ==2){//director
    
    $query = "INSERT INTO Director(id, last, first, dob, dod) VALUES ($ID, '$last', '$first', $dob, $dod);";

  }
  $msg = "";

  if(mysql_query($query, $db_connection)==TRUE){
    $msg =  "New Record Inserted Successfully<br>";
    $query = "UPDATE MaxPersonID SET id=$ID";
    mysql_query($query, $db_connection);
    $query = "SELECT * FROM Actor WHERE id = $ID";
    $result = mysql_query($query, $db_connection);

    while($row = mysql_fetch_row($result)) {
      $sid = $row[0];
      $first = $row[1];
      $last = $row[2];
      $gender = $row[3];
      $dob = $row[4];
      $dod = $row[5];
      $msg = $msg."<br>$sid, $first, $last, $gender, $dob, $dod <br />";
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

if($_SERVER["REQUEST_METHOD"]== "POST"){
  //Use GET function to get input from user
  $role = $_POST["Title"]; 
  $first = $_POST["First"]; 
  $last = $_POST["Last"]; 
  $gender = $_POST["Gender"];

  $dobyear = $_POST["DOB"];
  $dobmonth = $_POST["dobmonth"];
  $dobday = $_POST["dobday"];

  $dodyear = $_POST["DOD"];
  $dodmonth = $_POST["dodmonth"];
  $dodday = $_POST["dodday"];

  if(empty($role)){
  	$roleerr = "Plese select actor or director";
  }

  if(empty($first)){
    $firsterr = "First name is required";
  }
  else{
    $first = validate_input($first);

    if(!preg_match("/^[a-zA-Z ]*$/", $first)){
      $firsterr = "Only letters and white space allowed";
      //check if the name contains special character
      //if so, output error msg
    }

  }

  if(empty($last)){
    $lasterr = "Last name is required";
  }
  else{
    $last = validate_input($last);

    if(!preg_match("/^[a-zA-Z ]*$/", $last)){
      $lastterr = "Only letters and white space allowed";
      //check if the name contains special character
      //if so, output error msg
    }
  }

  if(empty($gender) && $role =="1"){
  	$gendererr = "Please select gender";
  }

  if(!checkdate($dobmonth, $dobday,$dobyear)){
      $doberr = "Invalid date of birth";
      //check if the date is valid or not 
      //if not, output error msg
    }
  if(!checkdate($dodmonth, $dodday, $dodyear) && !(empty($dodyear) && empty($dodmonth) && empty($dodday)) ){
      $doderr = "Invalid date of death";
      //if the dod is not empty, check if the date is valid or not 
      //if not, output error msg
    }

  //when all inputs(except dod) are not empty and valid
  if(!empty($first) && !empty($last) && preg_match("/^[a-zA-Z]*$/", $first) && preg_match("/^[a-zA-Z]*$/", $last) && checkdate($dobmonth, $dobday,$dobyear)){

    if((empty($dodyear) && empty($dodmonth) && empty($dodday)) || checkdate($dodmonth, $dodday, $dodyear)) {
      //the actor/director added is still alive
      if(strlen((string)$dodmonth)==1){
        $dodmonth = "0".$dodmonth;
      }
      if(strlen((string)$dodday)==1){
        $dodday = "0".$dodday;
      }
      if(strlen((string)$dobmonth)==1){
        $dobmonth = "0".$dobmonth;
      }
      if(strlen((string)$dobday)==1){
        $dobday = "0".$dobday;
      }
      $dod = $dodyear.$dodmonth.$dobday;
      $dob = $dobyear.$dobmonth.$dobday;
      $output = insert_person($role, $first,$last,$gender,$dob,$dod); 
    }
    
    else{
      $doderr = "Invalid date of death";
    }
  } 
} 


?>


<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

  <!--choose to add acotr and/or director information -->
  Actor <INPUT TYPE = "radio" NAME="Title" VALUE = "1" <?php echo "checked";?>>
  Director <INPUT TYPE = "radio" NAME="Title" VALUE = "2">
  <span class = "error">* <?php echo $roleerr;?></span>

  
  <br>First Name<br><INPUT TYPE = "text" NAME ="First" VALUE="">
  <span class = "error">* <?php echo $firsterr;?></span>
  
  <p></p>Last Name<br><INPUT TYPE = "text" NAME ="Last" VALUE ="">
  <span class = "error">* <?php echo $lasterr;?></span>

  <p></p>
  <!--Specify gender -->
  Female <input type="radio" name="Gender" value="1">
     <!--<INPUT TYPE = "radio" NAME="Gender" VALUE = "1" > -->
  Male <input type="radio" name="Gender" value="2">
  <span class = "error">* <?php echo $gendererr;?></span>


  <!--<INPUT TYPE = "radio" NAME="Gender" VALUE = "2"><br> -->
  
  <!--Input dob -->
  <br><br>
  Date of Birth<br>Year<INPUT TYPE = "text" NAME ="DOB" VALUE ="" SIZE= 4 MAXLENGTH = 4>
  Month<INPUT TYPE = "text" NAME = "dobmonth" VALUE="" SIZE =2 MAXLENGTH = 2>
  
  Day<INPUT TYPE = "text" NAME = "dobday" VALUE="" SIZE =2 MAXLENGTH = 2>
  <span class = "error">* <?php echo $doberr; ?></span>
  <br>i.e: 1970-01-01</br>
  
  <!--Input dod -->
  <br>
  Date of Die<br>Year<INPUT TYPE = "text" NAME ="DOD" VALUE ="" SIZE= 4 MAXLENGTH = 4>
  Month<INPUT TYPE = "text" NAME = "dodmonth" VALUE="" SIZE =2 MAXLENGTH = 2>
  
  Day<INPUT TYPE = "text" NAME = "dodday" VALUE="" SIZE =2 MAXLENGTH = 2>
  <span class = "error"> <?php echo $doderr; ?></span>
  <br><font size ="2">leave blank if alive now</font><br><br>

  <input type="submit" name = "submit" value ="Add">

</form>
<?php 
  echo $output
?>

</body>
</html>
