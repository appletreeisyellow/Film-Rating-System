
# ---------- Violate primary key constrains ----------

# Movie id cannot be duplicated, id = 272 already exist
INSERT INTO Movie(id, title, year, rating, company)
VALUES (272, 'The Lego Movie', 2014, 'G', 'WB');

# Movie id cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (NULL, 'The Lego Movie', 2014, 'G', 'WB');

# Movie title cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, NULL, 2014, 'G', 'WB');

# Movie year cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', NULL, 'G', 'WB');

# Movie rating cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, NULL, 'WB');

# Movie company cannot be null
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, 'G', NULL);

# Actor id cannot be duplicated, id = 10 already exist
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (10, 'Kitty', 'Hello', 'Female', 19750525, 20000525);

# Actor id cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (NULL, 'Kitty', 'Hello', 'Female', 19750525, 20000525);

# Actor last name cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, NULL, 'Hello', 'Female', 19750525, 20000525);

# Actor first name cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', NULL, 'Female', 19750525, 20000525);

# Actor sex cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', 'Hello', NULL, 19750525, 20000525);

# Actor dob cannot be null
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', 'Hello', 'Female', NULL, 20000525);

# Director id cannot be duplicated, id = 37146 already exist
INSERT INTO Director(id, last, first, dob, dod)
VALUES (37146, 'Kitty', 'Hello', 19750525, 20000525);

# Director id cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (NULL, 'Kitty', 'Hello', 19750525, 20000525);

# Director last name cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, NULL, 'Hello', 19750525, 20000525);

# Director first name cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, 'Kitty', NULL, 19750525, 20000525);

# Director dob cannot be null
INSERT INTO Director(id, last, first, dob, dod)
VALUES (1, 'Kitty', 'Hello', NULL, 20000525);




# ---------- Violate referential integrity constraints ----------

# mid = 1 in Sales must be also in Movie id
INSERT INTO Sales(mid, ticketsSold, totalIncome)
VALUES (1, 974262, 14613930);

# Should not be able to delete mid = 272 in Sales
DELETE FROM Sales WHERE mid = 272;

# mid = 1 in MovieGenre must be also in Movie id
INSERT INTO MovieGenre(mid, genre)
VALUES (1, 'Drama');

# Should not be able to delete mid = 4706 in MovieGenre
DELETE FROM MovieGenre WHERE mid = 4706;

# mid = 1 in MovieDirector must be also in Movie id
INSERT INTO MovieDirector(mid, did)
VALUES (1, 37146);

# Should not be able to delete mid = 4345 in MovieDirector
DELETE FROM MovieDirector WHERE mid = 4345;

# did = 1 in MovieDirector must be also in Director id
INSERT INTO MovieDirector(mid, did)
VALUES (272, 1);

# Should not be able to delete did = 557 in MovieDirector
DELETE FROM MovieDirector WHERE did = 557;

# mid = 1 in MovieActor must be also in Director id
INSERT INTO MovieActor(mid, aid, role)
VALUES (1, 10, 'The wife');

# Should not be able to delete mid = 4345 in MovieActor
DELETE FROM MovieActor WHERE mid = 4345;

# aid = 2 in MovieActor must be also in Actor id
INSERT INTO MovieActor(mid, aid, role)
VALUES (4345, 2, 'The wife');

# Should not be able to delete aid = 10208 in MovieActor
DELETE FROM MovieActor WHERE aid = 10208;

# mid = 1 in MovieRating must be also in Movie id
INSERT INTO MovieRating(mid, imdb, rot)
VALUES (1, 90, 89);

# Should not be able to delete mid = 272 in MovieRating
DELETE FROM MovieRating WHERE mid = 272

# mid = 1 in Review must be also in Movie id
INSERT INTO Review(name, time, mid, rating, comment)
VALUES ('Alice', 2016-10-04, 1, 4, 'I like this movie!');



# ---------- Violate CHECK constrains ----------


# Movie title length must greater than 0
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, '', 2014, 'G', 'WB');

# Movie company name length must greater than 0
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, 'G', '');

# Movie rating cannot be non-MPAA
INSERT INTO Movie(id, title, year, rating, company)
VALUES (1, 'The Lego Movie', 2014, 'GGGG', 'WB');

# Actor last name length must greater than 0
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, '', 'Hello', 'Female', 19750525, 20000525);

# Actor first name length must greater than 0
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', '', 'Female', 19750525, 20000525);

# Actor sex cannot be anything other than 'Male' or 'Female'
INSERT INTO Actor(id, last, first, sex, dob, dod)
VALUES (2, 'Kitty', 'Hello', 'Femaleee', 19750525, 20000525);

# MovieGenre genre length must be greater than 0
INSERT INTO MovieGenre(mid, genre)
VALUES (272, '');

# MovieActor role must be greater than 0
INSERT INTO MovieActor(mid, aid, role)
VALUES (272, 1, '');

# MovieRating imdb cannot be < 1 or > 100, rot < 1 or > 100
INSERT INTO MovieRating(mid, imdb, rot)
VALUES (272, 110, 90);

INSERT INTO MovieRating(mid, imdb, rot)
VALUES (272, 90, 110);

# Review rating cannot be < 0 or > 5
INSERT INTO Review(name, time, mid, rating, comment)
VALUES ('Alice', 2017-03-03, 272, 10, 'I like it!');

# Review comment length must be greater than 0
INSERT INTO Review(name, time, mid, rating, comment)
VALUES ('Alice', 2017-03-03, 272, 10, '');






