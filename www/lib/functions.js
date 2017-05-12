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
	document.getElementById("addComment").style.display = "none";
	document.getElementById("showActor").style.display = "none";
	document.getElementById("showMovie").style.display = "none";
	document.getElementById("search").style.display = "none";
	document.getElementById(id).style.display = "block";
}