<p class="w3-xlarge"><b>Actor Information Page</b></p>

<!-- Search Bar & Botton -->
<div style="padding: 10px 0px;">
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

    <input class="searchBar" type="text" name="search" placeholder="Search.."><br><br>
    <input type="submit" name = "submit" value ="Search">
  </form><p></p>

  <!--<a class="w3-button w3-theme w3-hover-white" onclick="show_main('search')">Search</a><p></p>-->
</div>


<?php
$aname = "";
$namerr ="";
if($_SERVER["REQUEST_METHOD"]== "POST"){
  $aname = $_POST["search"];
  if(empty($aname)){
    $namerr = "Empty Search";
  }
  else{
    $names = explode(" ", $aname);
    $db_connection = mysql_connect("localhost", "cs143", ""); 
    //select database
    mysql_select_db("CS143", $db_connection); 
    //if the connection fails, output error msg and exit
    if(!$db_connection){ 
        $errmsg = mysql_error($db_connection);
        print "Connection failed: $errmsg <br />";
        exit(1);
    }

    $result = mysql_query("SELECT * FROM Actor WHERE last ='$names[1]' AND first ='$names[0]'", $db_connection); // result is an object
    echo "<p class='w3-large'><b>Actor Information</b></p>";
    echo "<table border ='1'>";
    echo "<tr>";
      echo"<th>Name</th>";
      echo"<th>Sex</th>";
      echo"<th>Date of Birth</th>";
      //echo"<th>Date of Death</th>";
    echo "</tr>";
    while($row = mysql_fetch_row($result)){
      echo "<tr>";
      echo "<td><a href=\"showActor.php?id=$row[0]\" class=\"w3-text-blue\">".$row[2]." ".$row[1]."</td>"; //name
      echo "<td>".$row[3]."</td>";  //gender
      echo "<td>".$row[4]."</td>";  //dob
      // if(is_null($row[5])){
      //  $dod = "Still Alive";
      // }
      // else{
      //  $dod = $row[5];
      // }
      echo "<tr>";
      
    }
    echo "</table>";
  }
  //free result
  mysql_free_result($result);


  //close connections
  mysql_close($db_connection); 
  

}

?>

<?php
  $aid = $_GET['id'];
  echo ".".$aid.".";
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
      echo "<td>".$row[3]."</td>";  //gender
      echo "<td>".$row[4]."</td>";  //dob
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
      $mresult = mysql_query("SELECT title FROM Movie WHERE id = $row[0]", $db_connection);
      $mrow = mysql_fetch_row($mresult);
      echo "<td>".$mrow[0]."</td>";   //MovieTitle
      echo "<td>".$row[1]."</td>";  //Role
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

