
/*
DROP TABLE Sales;
DROP TABLE MovieGenre;
DROP TABLE MovieDirector;
DROP TABLE MovieActor;
DROP TABLE MovieRating;
DROP TABLE Review;

DROP TABLE Movie;
DROP TABLE Actor;
DROP TABLE Director;

DROP TABLE MaxPersonID;
DROP TABLE MaxMovieID;
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
	CHECK(LENGTH(title) > 0),
	CHECK(LENGTH(company) > 0),
	CHECK (rating = "G" OR rating = "PG" OR rating = "PG-13" OR rating = "R" OR rating = "NC-17")
);


/*
	Constraints:
	Every actor has a unique id number
	Every actor must have last name and first name
	Every actor must have sex, either Male or Female
	Every actor must have a date of birth

	If a person is both an actor and a director, 
	the person will have the same ID both in the Actor 
	and the Director table

	TODO: id between Actor and Director?
*/
CREATE TABLE Actor(
	id 			int NOT NULL, 
	last 		varchar(20) NOT NULL, 
	first 		varchar(20) NOT NULL, 
	sex 		varchar(6) NOT NULL, 
	dob 		date NOT NULL, 
	dod 		date,
	PRIMARY KEY(id),
	CHECK(LENGTH(last) > 0),
	CHECK(LENGTH(first) > 0),
	CHECK(sex in ('Male','Female'))
);


/*
	Constraints:
	mid is unique and is a foreign key reference from Movie(id)
	Every sale must have total number of tickets sold
	Every sale must have total Income
*/
CREATE TABLE Sales(
	mid 		int NOT NULL, 
	ticketsSold int NOT NULL, 
	totalIncome int NOT NULL,
	UNIQUE(mid),
	FOREIGN KEY (mid) references Movie(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE = INNODB;


/*
	Constraints:
	Every director has a unique id number
	Every actor must have last name and first name
	Every actor must have a date of birth
	
	If a person is both an actor and a director, 
	the person will have the same ID both in the Actor 
	and the Director table
*/
CREATE TABLE Director(
	id 		int NOT NULL, 
	last 	varchar(20) NOT NULL, 
	first 	varchar(20) NOT NULL, 
	dob 	date NOT NULL, 
	dod 	date,
	PRIMARY KEY (id),
	CHECK(LENGTH(last) > 0),
	CHECK(LENGTH(first) > 0)
);


/*
	Constraints:
	Every MovieGenre has a unique movie id 
	Every mid is a foreign key reference from Movie(id)
	Every movie must have genre
	
*/
CREATE TABLE MovieGenre(
	mid 	int NOT NULL, 
	genre 	varchar(20) NOT NULL,
	UNIQUE(mid),
	CHECK(LENGTH(genre) > 0),
	FOREIGN KEY (mid) references Movie(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE = INNODB;


/*
	Constraints:
	Every entry must have mid and did
	mid 
	mid is the id of a movie, references from Movie(id)
	did is the id of the director of the movie, references from Director(id)
	
*/
CREATE TABLE MovieDirector(
	mid 	int NOT NULL, 
	did 	int NOT NULL,
	UNIQUE(mid),
	FOREIGN KEY (mid) references Movie(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (did) references Director(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE = INNODB;


/*
	Constraints:
	Every entry must have mid, aid, and role
	mid is the id of a movie, references from Movie(id)
	aid is the id of an actor, references from Actor(id)
	
*/
CREATE TABLE MovieActor(
	mid 	int NOT NULL, 
	aid 	int NOT NULL, 
	role 	varchar(50) NOT NULL,
	CHECK(LENGTH(role) > 0),
	FOREIGN KEY (mid) references Movie(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	FOREIGN KEY (aid) references Actor(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE = INNODB;


/*
	Constraints:
	Every entry must have mid, imdb, and rot
	mid is unique
	mid is the id of a movie, references from Movie(id)
	imdb and rot ratings are between 1 and 100
	
*/
CREATE TABLE MovieRating(
	mid 	int NOT NULL, 
	imdb 	int NOT NULL, 
	rot 	int NOT NULL,
	UNIQUE(mid),
	FOREIGN KEY (mid) references Movie(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	CHECK (imdb >= 1 AND imdb <= 100),
	CHECK (rot >= 1 AND rot <= 100)
) ENGINE = INNODB;


/*
	Constraints:
	Each tuple must have name of the reviewer, 
	  the timestamp of the review, the movie id
	  the rating that the reviewer gave the movie 
	  (x out of 5), and additional comments about 
	  the movie 
	mid is the id of a movie, references from Movie(id)
	rating should be between 0 and 5
	
*/
CREATE TABLE Review(
	name 	varchar(20) NOT NULL, 
	time 	timestamp NOT NULL, 
	mid 	int NOT NULL, 
	rating 	int NOT NULL, 
	comment varchar(500) NOT NULL,
	CHECK(LENGTH(name) > 0),
	CHECK(LENGTH(comment) > 0),
	FOREIGN KEY (mid) references Movie(id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
	CHECK (rating >= 0 AND rating <=5)
) ENGINE = INNODB;


/*
	Constraints:
	MaxPersonID must have an id
	This id is the id for a new added actor/director
	
*/
CREATE TABLE MaxPersonID(
	id 		int NOT NULL,
	UNIQUE(id)
);


/*
	Constraints:
	MaxMovieID must have an id
	This id is the id for a new added movie
	
*/
CREATE TABLE MaxMovieID(
	id 		int NOT NULL,
	UNIQUE(id)
);




