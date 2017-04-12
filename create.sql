/*

TODO:
  - Create tables
  - 12 constrains
    - 3 PRIMARY KEY
    - 6 FORIEN KEY
    - 3 CHECK
  - "ENGINE = INNODB"
  - For each constraint, write English description as a comment.

*/


/*
	Constraints:
	Every movie has a unique identification number.
	Every movie must have a title.
	Every movie must have a release year
	Every movie must have a rating
	Check that rating must be MPAA ratings
		G, PG, PG-13, R, NC-17
	Every movie must have a production company

*/
CREATE TABLE Movie(
	id 			int NOT NULL, 
	title 		varchar(100) NOT NULL, 
	year 		int NOT NULL, 
	rating 		varchar(10) NOT NULL, 
	company 	varchar(50) NOT NULL,
	PRIMARY KEY(id),
	CHECK (rating = "G" OR rating = "PG" OR rating = "PG-13" OR rating = "R" OR rating = "NC-17"),
	ENGINE = INNODB
);


/*
	Constraints:
	Every actor has a unique id number
	Every actor must have last name and first name
	Every actor must have sex
	Every actor must have a date of birth.
*/
CREATE TABLE Actor(
	id 			int NOT NULL, 
	last 		varchar(20) NOT NULL, 
	first 		varchar(20) NOT NULL, 
	sex 		varchar(6) NOT NULL, 
	dob 		date NOT NULL, 
	dod 		date,
	PRIMARY KEY(id),
	ENGINE = INNODB
);


/*
	Constraints:
	mid is unique and is foreign key reference from Movie(id)
	
*/
CREATE TABLE Sales(
	mid int, 
	ticketsSold int, 
	totalIncome int,
	ENGINE = INNODB
);


/*
	Constraints:
	Every director has a unique id number
	
*/
CREATE TABLE Director(
	id int, 
	last varchar(20), 
	first varchar(20), 
	dob date, 
	dod date,
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE MovieGenre(
	mid int, 
	genre varchar(20),
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE MovieDirector(
	id int, 
	did int,
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE MovieActor(
	mid int, 
	aid int, 
	role varchar(50)
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE MovieRating(
	mid int, 
	imdb int, 
	rot int,
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE Review(
	name varchar(20), 
	time timestamp, 
	mid int, 
	rating int, 
	comment varchar(500),
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE MaxPersonID(
	id int,
	ENGINE = INNODB
);


/*
	Constraints:
	
	
*/
CREATE TABLE MaxMovieID(
	id int,
	ENGINE = INNODB
);


