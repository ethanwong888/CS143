-- using a similar CTE as q12
    -- select the stud_IDs from the Credits table, order by descending, then choose the top 4

with Credits as (select stud_id, sum(credits) 'total_credits'
                    from Takes, Class 
                    where Takes.class_id = Class.id
                    group by stud_id)
select stud_id
from Credits
order by (total_credits) desc 
limit 4;



