
# ---------- Violate primary key constrains ----------

# Movie id cannot be duplicated, id = 272 already exist
INSERT INTO Movie(id, title, year, rating, company)
VALUES (272, 'The Lego Movie', 2014, 'G', 'WB');
# ERROR 1062 (23000) at line 5: Duplicate entry '272' for key 'PRIMARY'

# Movie id cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (NULL, 'The Lego Movie', 2014, 'G', 'WB');
# ERROR 1048 (23000): Column 'id' cannot be null

# Movie title cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, NULL, 2014, 'G', 'WB');
# ERROR 1048 (23000): Column 'title' cannot be null

# Movie year cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', NULL, 'G', 'WB');
# ERROR 1048 (23000): Column 'year' cannot be null

# Movie rating cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, NULL, 'WB');
# ERROR 1048 (23000): Column 'rating' cannot be null

# Movie company cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, 'G', NULL);
# ERROR 1048 (23000): Column 'company' cannot be null

# Actor id cannot be duplicated, id = 10 already exist
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (10, 'Kitty', 'Hello', 'Female', 19750525, 20000525);
# ERROR 1062 (23000): Duplicate entry '10' for key 'PRIMARY'

# Actor id cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (NULL, 'Kitty', 'Hello', 'Female', 19750525, 20000525);
# ERROR 1048 (23000): Column 'id' cannot be null

# Actor last name cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, NULL, 'Hello', 'Female', 19750525, 20000525);
# ERROR 1048 (23000): Column 'last' cannot be null

# Actor first name cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', NULL, 'Female', 19750525, 20000525);
# ERROR 1048 (23000): Column 'first' cannot be null

# Actor sex cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', 'Hello', NULL, 19750525, 20000525);
# ERROR 1048 (23000): Column 'sex' cannot be null

# Actor dob cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', 'Hello', 'Female', NULL, 20000525);
# ERROR 1048 (23000): Column 'dob' cannot be null

# Director id cannot be duplicated, id = 37146 already exist
INSERT INTO Director(id, last, first, dob, dod)
VALUES (37146, 'Kitty', 'Hello', 19750525, 20000525);
# ERROR 1062 (23000): Duplicate entry '37146' for key 'PRIMARY'

# Director id cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (NULL, 'Kitty', 'Hello', 19750525, 20000525);
# ERROR 1048 (23000): Column 'id' cannot be null

# Director last name cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, NULL, 'Hello', 19750525, 20000525);
# ERROR 1048 (23000): Column 'last' cannot be null

# Director first name cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, 'Kitty', NULL, 19750525, 20000525);
# ERROR 1048 (23000): Column 'first' cannot be null

# Director dob cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, 'Kitty', 'Hello', NULL, 20000525);
# ERROR 1048 (23000): Column 'dob' cannot be null




# ---------- Violate referential integrity constraints ----------

# mid = 1 in Sales must be also in Movie id
INSERT INTO Sales(mid, ticketsSold, totalIncome)
VALUES (1, 974262, 14613930);
/*	
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key 
	constraint fails (`CS143`.`Sales`, CONSTRAINT `Sales_ibfk_1` FOREIGN 
	KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE 
	CASCADE)
*/

# mid = 1 in MovieGenre must be also in Movie id
INSERT INTO MovieGenre(mid, genre)
VALUES (1, 'Drama');
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key 
	constraint fails (`CS143`.`MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` 
	FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE ON 
	UPDATE CASCADE)
*/

# mid = 1 in MovieDirector must be also in Movie id
INSERT INTO MovieDirector(mid, did)
VALUES (1, 37146);
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key 
	constraint fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` 
	FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE 
	CASCADE)
*/

# did = 1 in MovieDirector must be also in Director id
INSERT INTO MovieDirector(mid, did)
VALUES (272, 1);
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint 
	fails (`CS143`.`MovieDirector`, CONSTRAINT `MovieDirector_ibfk_2` FOREIGN KEY 
	(`did`) REFERENCES `Director` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)
*/

# mid = 1 in MovieActor must be also in Director id
INSERT INTO MovieActor(mid, aid, role)
VALUES (1, 10, 'The wife');
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint 
	fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) 
	REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)
*/

# aid = 2 in MovieActor must be also in Actor id
INSERT INTO MovieActor(mid, aid, role)
VALUES (4345, 2, 'The wife');
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint 
	fails (`CS143`.`MovieActor`, CONSTRAINT `MovieActor_ibfk_2` FOREIGN KEY (`aid`) 
	REFERENCES `Actor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)
*/

# mid = 1 in MovieRating must be also in Movie id
INSERT INTO MovieRating(mid, imdb, rot)
VALUES (1, 90, 89);
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint 
	fails (`CS143`.`MovieRating`, CONSTRAINT `MovieRating_ibfk_1` FOREIGN KEY (`mid`) 
	REFERENCES `Movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)
*/

# mid = 1 in Review must be also in Movie id
INSERT INTO Review(name, time, mid, rating, comment)
VALUES ('Alice', 2016-10-04, 1, 4, 'I like this movie!');
/*
	ERROR 1452 (23000): Cannot add or update a child row: a foreign key constraint 
	fails (`CS143`.`Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES 
	`Movie` (`id`) ON DELETE CASCADE ON UPDATE CASCADE)
*/


# ---------- Violate CHECK constrains ----------

# Movie rating cannot be non-MPAA
INSERT INTO Movie(id, title, year, rating, company)
VALUES (10000, 'The Lego Movie', 2014, 'GGGG', 'WB');

# Actor sex cannot be anything other than 'Male' or 'Female'
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', 'Hello', 'Femaleee', 19750525, 20000525);

# MovieRating imdb cannot be < 1 or > 100, rot < 1 or > 100
INSERT INTO MovieRating(mid, imdb, rot)
VALUES (272, 110, 90);

INSERT INTO MovieRating(mid, imdb, rot)
VALUES (272, 90, 110);

# Review rating cannot be < 0 or > 5
INSERT INTO Review(name, time, mid, rating, comment)
VALUES ('Alice', 2017-03-03, 272, 10, 'I like it!');

# Movie title length must greater than 0
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, '', 2014, 'G', 'WB');

# Movie company name length must greater than 0
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, 'G', '');

# Actor last name length must greater than 0
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, '', 'Hello', 'Female', 19750525, 20000525);

# Actor first name length must greater than 0
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', '', 'Female', 19750525, 20000525);

# MovieGenre genre length must be greater than 0
INSERT INTO MovieGenre(mid, genre)
VALUES (272, '');

# MovieActor role must be greater than 0
INSERT INTO MovieActor(mid, aid, role)
VALUES (272, 1, '');

# Review comment length must be greater than 0
INSERT INTO Review(name, time, mid, rating, comment)
VALUES ('Alice', 2017-03-03, 272, 10, '');






