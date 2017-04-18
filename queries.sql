
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



# Give me the title of movies that sell more than 1,000,000 tickets.


# You name it 1


# You name it 2