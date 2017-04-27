# CS143 Project 1 Spring 2017

## 1A

[Here](http://yellowstone.cs.ucla.edu/cs143/project/project1A.html) is the spec for Project 1A

#### Overview

1. Create a few tables to contain information about movies and actors
2. Load tables with (real) data that are provided by TA
3. Run a few queries to get familiar with MySQL
4. Create a php page that allows users to query your MySQL database using HTML forms
5. Identify a few constraints that the tables should satisfy and enforce them for the tables

#### Files

- [x] create.sql
- [x] load.sql
- [x] queries.sql
- [x] query.php
- [x] violate.sql

## 1B 

[Here](http://yellowstone.cs.ucla.edu/cs143/project/project1B.html) is the spec for Project 1B

#### Overview

###### Four input pages:

1. Page I1: A page that lets users to add actor and/or director information. Here are some name examples: Chu-Cheng Hsieh, J'son Lee, etc.
2. Page I2: A page that lets users to add movie information.
3. Page I3: A page that lets users to add comments to movies.
4. Page I4: A page that lets users to add "actor to movie" relation(s).
5. Page I5: A page that lets users to add "director to movie" relation(s).

###### Two browsing pages:

1. Page B1: A page that shows actor information.
  * Show links to the movies that the actor was in.
2. Page B2: A page that shows movie information.
  * Show Title, Producer, MPAA Rating, Director, Genre of this movie.
  * Show links to the actors/actresses that were in this movie.
  * Show the average score of the movie based on user feedbacks.
  * Show all user comments.
  * Contain "Add Comment" button which links to Page I3 where users can add comments.

###### One search page:

1. Page S1: A page that lets users search for an actor/actress/movie through a keyword search interface. (For actor/actress, you should examine first/last name, and for movie, you should examine title.)
  * Your search page should support multi-word search, such as "Tom Hanks". For multi-word search, interpret space as "AND" relation. That is, return all items that contain both words, "Tom" and "Hanks". Since the search page is for actor/actress/movie, so if there was a movie named "I love Tom Hanks!", it should be returned. As for the output, you should sort them in a way that users could find an item easily.

#### Files

- [x] create.sql
- [x] load.sql
- [ ] index.php
- [ ] search.php
- [ ] others.php
