CREATE TABLE Movie (
       -- Movie ID
       id INT NOT NULL,
       -- Movie title
       title VARCHAR(100) NOT NULL,
       -- Release year
       year INT,
       -- MPAA rating
       rating VARCHAR(10) NOT NULL,
       -- Production company
       company VARCHAR(50) NOT NULL,
       primary key(id)
) ENGINE = InnoDB;


CREATE TABLE Actor (
       -- Actor ID
       id INT NOT NULL,
       -- Last name
       last VARCHAR(20) NOT NULL,
       -- First name
       first VARCHAR(20) NOT NULL,
       -- Sex of the actor (male/female)
       sex VARCHAR(6) NOT NULL,
       -- Date of birth
       dob DATE NOT NULL,
       -- Date of death
       dod DATE NOT NULL,
       primary key(id)
) ENGINE = InnoDB;


CREATE TABLE MovieGenre (
       -- Movie ID
       mid INT NOT NULL,
       -- Movie genre
       genre VARCHAR(20) NOT NULL
) ENGINE = InnoDB;


CREATE TABLE MovieActor (
       -- Movie ID
       mid INT NOT NULL,
       -- Actor ID
       aid INT NOT NULL,
       -- Actor role in movie
       role VARCHAR(50) NOT NULL
) ENGINE = InnoDB;
       

CREATE TABLE Review (
       -- Reviewer name
       name VARCHAR(20),
       -- Review time
       time datetime,
       -- Movie ID
       mid INT,
       -- Review rating
       rating INT,
       -- Reviewer comment
       comment TEXT(500)
 ) ENGINE = InnoDB;
