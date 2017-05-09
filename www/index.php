<!DOCTYPE html>
<html>
	<title>CS143 Project 1B</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	
	<style>
	.w3-theme {color:#fff !important;background-color:#4CAF50 !important}
	.w3-btn {background-color:#4CAF50;margin-bottom:4px}
	.w3-code{border-left:4px solid #4CAF50}
	.myMenu {margin-bottom:150px}
	</style>

<body>

<!-- Top -->
<div class="w3-top">
  <div class="w3-row w3-white w3-padding">
    <a class="w3-wide w3-hover-white w3-left w3-button" onclick="show_main('welcomePage')">CS143 DataBase Query System (Demo)</a>
  </div>

  <div class="w3-bar w3-theme w3-large" style="z-index:4;">
    <a class="w3-bar-item w3-button w3-left w3-hide-large w3-hover-white w3-large w3-theme w3-padding-16" href="javascript:void(0)" onclick="w3_open()">&#9776</a> <!-- ☰ -->
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-small w3-hover-white w3-padding-16" href="javascript:void(0)" onclick="w3_show_nav('menu1')">Add new content</a>
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
	  <a onclick="show_main('addActorDirector')" class="w3-bar-item w3-button">Add Actor/Director</a>
	  <a onclick="show_main('addMovieInfo')" class="w3-bar-item w3-button">Add Movie Information</a>
	  <a onclick="show_main('addMovieActor')" class="w3-bar-item w3-button">Add Movie/Actor Relation</a>
	  <a onclick="show_main('addMovieDirector')" class="w3-bar-item w3-button">Add Movie/Director Relation</a>
  </div>

  <div id="menu2" class="myMenu" style="display:none">
	  <div class="w3-container">
	    <h3>Browsering Content</h3>
	  </div>
	  <a onclick="show_main('showActor')" class="w3-bar-item w3-button">Show Actor Information</a>
	  <a onclick="show_main('showMovie')" class="w3-bar-item w3-button">Show Movie Information</a>
  </div>

  <div id="menu3" class="myMenu" style="display:none">
	  <div class="w3-container">
	    <h3>Search Interface</h3>
	  </div>
	  <a onclick="show_main('search')" class="w3-bar-item w3-button">Search Actor/Movie</a>
  </div>

</div>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 270 pixels when the sidebar is visible -->
<div class="w3-main w3-container" style="margin-left:270px;margin-top:117px;">

	<div id="welcomePage" class="w3-panel w3-padding-large w3-card-4 w3-light-grey">
	  <p class="w3-xlarge">Welcome to CS143 Query System! (Demo)</p>
	  <p> </p>
	</div>

	<div id="addActorDirector" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "addActorDirector.php"; ?>
	</div>

	<div id="addMovieInfo" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "addMovieInfo.php"; ?>
	</div>

	<div id="addMovieActor" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "addMovieActor.php"; ?>
	</div>

	<div id="addMovieDirector" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "addMovieDirector.php"; ?>
	</div>

	<div id="showActor" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "showActor.php"; ?>
	</div>

	<div id="showMovie" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "showMovie.php"; ?>
	</div>

	<div id="search" class="w3-panel w3-padding-large w3-card-4 w3-light-grey" style="display:none;">
		<?php include "search.php"; ?>
	</div>

<!-- END MAIN -->
</div>

<script>
	// Script to open and close the sidebar
	function w3_open() {
	    document.getElementById("mySidebar").style.display = "block";
	    document.getElementById("myOverlay").style.display = "block";
	}
	 
	function w3_close() {
	    document.getElementById("mySidebar").style.display = "none";
	    document.getElementById("myOverlay").style.display = "none";
	}
	function w3_show_nav(name) {
	    document.getElementById("menu1").style.display = "none";
	    document.getElementById("menu2").style.display = "none";
	    document.getElementById("menu3").style.display = "none";
	    document.getElementById(name).style.display = "block";
	    w3_open();
	}
	function show_main(id) {
		document.getElementById("welcomePage").style.display = "none";
		document.getElementById("addActorDirector").style.display = "none";
		document.getElementById("addMovieInfo").style.display = "none";
		document.getElementById("addMovieActor").style.display = "none";
		document.getElementById("addMovieDirector").style.display = "none";
		document.getElementById("showActor").style.display = "none";
		document.getElementById("showMovie").style.display = "none";
		document.getElementById("search").style.display = "none";
		document.getElementById(id).style.display = "block";
	}
</script>

<script src="lib/w3codecolor.js"></script>
<script>
	w3CodeColor();
</script>



</body>
</html>
