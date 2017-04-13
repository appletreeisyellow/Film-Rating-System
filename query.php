<!-- 
TODO 
	Build a web query interface using php
	Create php page that allows users to type a SQL SELECT statement
	Use a TEXTAREA input box(with ne name "query") as the mean of input from user
	Return the  query results as the results page in an HTML table
	//Output error message when the query does not work
 -->


<html>
<head><title>CS143 Project 1A: Web Query Interface</title></head> 
<body>
<p>Please type an SQL query in the following box.</p>

<form action="query.php" method="GET">

<!--<form action="~/www/query.php" method="GET"> -->

<!--use textarea for inputing query-->
<TEXTAREA NAME="query" ROWS=8 COLS=60> 
</TEXTAREA><br />

<!--submit button -->
<input type="submit" value ="Submit"/>

</form>
<?php

	# GET function to get input from user
	$query = $_GET["query"]; 
	if($query){

		# connect to mysql
		$db_connection = mysql_connect("localhost", "cs143", ""); 

		# if the connection fails, output error msg and exit
		if(!$db_connection) { 
	    $errmsg = mysql_error($db_connection);
	    print "Connection failed: $errmsg <br />";
	    exit(1);
		}

		# sanitize user input, remove "special" characters
		$sanitized_query = mysql_real_escape_string($query, $db_connection); 

		# select database
		mysql_select_db("TEST", $db_connection); 

		# retrieve resutls 
		$rs = mysql_query($sanitized_query, $db_connection); 

		# close connections -->
		mysql_close($db_connection); 

		# output query result -->
		echo "Results from MySQL"."<br />"; 
		echo $rs."<br />"; 
	}


?>
<!-- want to print the results in a talbe...still working
<h1>Results from MySQL:</h1>

<table border=1 cellspacing=1 cellpadding=2>
<tr align=center><td><b>id</b></td><td><b>last</b></td><td><b>first</b></td><td><b>sex</b></td><td><b>dob</b></td><td><b>dod</b></td></tr>
<tr align=center><td>10</td><td>Aaltonen</td><td>Minna</td><td>Female</td><td>1966-09-17</td><td>N/A</td></tr>
-->
</body>
</html>