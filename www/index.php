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
  .error {color: #FF0000;}
  </style>

<body>

<!-- Top -->
<div class="w3-top">
  <div class="w3-row w3-white w3-padding">
    <a class="w3-wide w3-hover-white w3-left w3-button" href="index.php">CS143 DataBase Query System</a>
  </div>

  <div class="w3-bar w3-theme w3-large" style="z-index:4;">
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme w3-padding-16" href="javascript:void(0)" onclick="w3_open()">&#9776</a> <!-- ☰ -->
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu1')">Add New Content</a>
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
  <div id="addActorDirector" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">

    <p class="w3-xlarge">Add Actor/Director</p>

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
          //$msg = $msg."<br>$sid, $first, $last, $gender, $dob, $dod <br />";
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
      <span class = "error">* <?php echo $roleerr;?></span><br>

      
      <br>First Name <span class = "error">* <?php echo $firsterr;?></span><br>
      <INPUT TYPE = "text" NAME ="First" VALUE="">
      
      
      <p></p>Last Name <span class = "error">* <?php echo $lasterr;?></span><br>
      <INPUT TYPE = "text" NAME ="Last" VALUE ="">
      

      <p></p>
      <!--Specify gender -->
      Gender <span class = "error">* <?php echo $gendererr;?></span><br>
      Female <input type="radio" name="Gender" value="1">
         <!--<INPUT TYPE = "radio" NAME="Gender" VALUE = "1" > -->
      Male <input type="radio" name="Gender" value="2">
      


      <!--<INPUT TYPE = "radio" NAME="Gender" VALUE = "2"><br> -->
      
      <!--Input dob -->
      <br><br>
      Date of Birth <span class = "error">* <?php echo $doberr; ?></span><br>
      Year<INPUT TYPE = "text" NAME ="DOB" VALUE ="" SIZE= 4 MAXLENGTH = 4>
      Month<INPUT TYPE = "text" NAME = "dobmonth" VALUE="" SIZE =2 MAXLENGTH = 2>
      Day<INPUT TYPE = "text" NAME = "dobday" VALUE="" SIZE =2 MAXLENGTH = 2>
      <br>i.e: 1970-01-01</br>
      
      <!--Input dod -->
      <br>
      Date of Die <font size ="1" class="w3-text-gray">(leave blank if alive now)</font> <br>
      Year<INPUT TYPE = "text" NAME ="DOD" VALUE ="" SIZE= 4 MAXLENGTH = 4>
      Month<INPUT TYPE = "text" NAME = "dodmonth" VALUE="" SIZE =2 MAXLENGTH = 2>
      Day<INPUT TYPE = "text" NAME = "dodday" VALUE="" SIZE =2 MAXLENGTH = 2>
      <span class = "error"> <?php echo $doderr; ?></span>
      <br><br>

      <input class="w3-button w3-theme w3-hover-white" type="submit" name = "submit" value ="Add">
    </form>
    <?php 
      echo "<p class=\"w3-text-gray\">";
      echo $output;
      echo "</p><br>";
    ?>
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





