
# Give me the names of all the actors in the movie 'Die Another Day'. 
# Please also make sure actor names are in this format:  <firstname> <lastname>   (seperated by a single space). 
# You may need to use MySQL CONCAT Function (very important).
CREATE VIEW ActorNames(last, first) AS
	SELECT last, first
	FROM Actor
	WHERE id IN (	# the id of actors who played in 'Die Another Day'
					SELECT DISTINCT aid
					FROM MovieActor
					WHERE mid IN (	# the movie id of 'Die Another Day'
									SELECT id
									FROM Movie 
									WHERE title = 'Die Another Day'
								)
				)
;

SELECT CONCAT(first, ' ', last)
FROM ActorNames;

								


# Give me the count of all the actors who acted in multiple movies.
CREATE VIEW ActorMovieCount(aid, movieCount) AS
	SELECT aid, COUNT(DISTINCT mid)
	FROM MovieActor
	GROUP BY aid;

SELECT COUNT(aid)
FROM ActorMovieCount
WHERE movieCount > 1;


# Give me the title of movies that sell more than 1,000,000 tickets.
SELECT title
FROM Movie
WHERE id IN ( # find mid that sold more than 1,000,000 tickets
				SELECT mid
				FROM Sales
				WHERE ticketsSold > 1000000
			);



# Find the count of all the directors who made more than one movie

CREATE VIEW DirectorMovieCount(did, movieCount) AS
	SELECT did, COUNT(DISTINCT mid)
	FROM MovieDirector
	GROUP BY did;

SELECT COUNT(did)
FROM DirectorMovieCount
WHERE movieCount > 1;



# Find the title of movies that have IMDb rating greater than 90
SELECT title
FROM Movie
WHERE id IN ( 	SELECT mid
				FROM MovieRating
				WHERE imdb > 90
			);





