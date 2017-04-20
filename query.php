<html>
<head><title>CS143 Project 1A: Web Query Interface</title></head> 
<body>
<p>Please type an SQL query in the following box.</p>

<p>Example: SELECT * FROM Actor WHERE id=10;</p>
<form action="query.php" method="GET">

	<!--use textarea for inputing query-->
	<TEXTAREA NAME="query" ROWS=8 COLS=60></TEXTAREA>
	<br />

	<!--submit button -->
	<input type="submit" value ="Submit">

</form>
<?php

//Use GET function to get input from user
$query = $_GET["query"]; 
if($query){

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

	echo "Executed query: <code>{$query}</code><br>";
    
	//sanitize user input, remove "special" characters
	//$sanitized_query = mysql_real_escape_string($query, $db_connection); 

	//retrieve resutls
	//$result = mysql_query($sanitized_query, $db_connection); 
	$result = mysql_query($query, $db_connection); // result is an object
	$numFields = mysql_num_fields($result); //get the number of fields in  the reuslt
	if(!$numFields)
		echo "invalid query"; // if no result got, output error msg
	else{
		$num=mysql_num_rows($result);
  		echo "The total number of result is: ".$num."<br>";
		echo "<table border ='1'>"; //table with border = 1
		echo "<tr>";
		for ($i = 0; $i < $numFields; $i++) {
			echo '<td align = "center"><b>',mysql_field_name($result, $i),'</b></td>';//output the title 
		}
		echo "</tr>";
		
		//output the result
		while($row = mysql_fetch_assoc($result)){
			echo "<tr>";
			foreach($row as $instance){
				if(is_null(($instance))){
					echo "<td>"."N/A"."</td>";//if null output N/A
				}
				else{
					echo "<td>".$instance."</td>";//output the table content
				}
			}
			echo "</tr>";
		}
		echo "</table>";	
	}
		
	//free result
	mysql_free_result($result);


	//close connections
	mysql_close($db_connection); 
	

}

?>

</body>
</html>
