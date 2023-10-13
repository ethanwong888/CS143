-- load 'movie.del' into 'Movie' table
LOAD DATA LOCAL INFILE './movie.del' INTO TABLE Movie
-- use commas to separate columns, not tabs
FIELDS TERMINATED BY ","
-- in case fields are enclosed within "double quotes"
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n';


-- load 'actor1.del', 'actor2.del', 'actor3.del' into Actor table
LOAD DATA LOCAL INFILE './actor1.del' INTO TABLE Actor
FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE './actor2.del' INTO TABLE Actor
FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE './actor3.del' INTO TABLE Actor
FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n';


-- load 'moviegenre.del' into MovieGenre table
LOAD DATA LOCAL INFILE './moviegenre.del' INTO TABLE MovieGenre
FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n';


-- load 'movieactor1.del', 'movieactor2.del' into MovieActor table
LOAD DATA LOCAL INFILE './movieactor1.del' INTO TABLE MovieActor
FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n';

LOAD DATA LOCAL INFILE './movieactor2.del' INTO TABLE MovieActor
FIELDS TERMINATED BY "," OPTIONALLY ENCLOSED BY '"' LINES TERMINATED BY '\n';
