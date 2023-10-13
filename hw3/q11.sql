-- create table R1 that contains studentID, number of classes they take 
    -- table is created by joining Takes with Student where year is 2009
-- create table R2 that contains studentID, number of classes they take 
    -- table is created by joining Takes with Student where year is 2010

-- left outer join these tables together on R1.id = R2.id (so that they are joined based on the student's ID)

-- select R1.id where the numClasses > r2.numClasses
-- Remark: Note that some students took classes in 2009 but not in 2010. These students must be included in your answer.
    -- this is why we have to use the coalesce() function -- it returns the first non-null value in a list
    -- the 'coalesce(R2.numClasses, 0)' basically just means that if a value is NULL, treat it as 0 -- that way R1.numClasses is always greater than R2.numClasses


select R1.id
from (select S.id 'id', count(T.class_id) 'numClasses'
        from Student S
        left outer join Takes T on S.id = T.stud_id
        where T.year = 2009
        group by S.id) R1
left outer join (select S.id 'id', count(T.class_id) 'numClasses'
        from Student S
        left outer join Takes T on S.id = T.stud_id
        where T.year = 2010
        group by S.id) R2
on R1.id = R2.id
where R1.numClasses > coalesce(R2.numClasses, 0);