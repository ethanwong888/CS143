-- first want to extract information from Takes, Class to build another table
    -- create 'Credits' table that has Takes.stud_id, Takes.year, Class.sum(credits) where Takes.class_id = Class.id (to make sure that we are looking at the same class)
    -- and group by the stud_id and the year in question

-- next create another table MC (maxCredits) from Credits that tells the year where a student achieved the max amount of credits
    -- select Credits.stud_id, Credits.year where the studentID matches and the credits match (just to double check)


with Credits as (select stud_id, year, sum(credits) 'credits'
                    from Takes, Class 
                    where Takes.class_id = Class.id
                    group by stud_id, year)
select Credits.stud_id, Credits.year
from Credits, (select stud_id, max(credits) 'credits' from Credits group by stud_id) MC
where Credits.stud_id = MC.stud_id and Credits.credits = MC.credits;

