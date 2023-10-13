-- use CTE to find actual number of credits for each student
-- do left outer join between Students and Credits to match up the studentID's
-- select id, use coalesce to choose which between 'S.tot_cred - Credits.credits' and 'S.tot_cred' is not Null (in case sum(credits) is Null)


with Credits as (select stud_id, sum(credits) 'credits'
                    from Takes T, Class C
                    where T.class_id = C.id
                    group by stud_id)
select id, coalesce(S.tot_cred - Credits.credits, S.tot_cred) 'credit_discrepency'
from Student S
left outer join Credits 
on S.id = Credits.stud_id;
