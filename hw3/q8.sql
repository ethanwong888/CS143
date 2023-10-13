-- select the department, average salary over everyone, average salary over each department
select distinct dept, avg(salary) over() - avg(salary) over(partition by dept) as diff_avg_salary
from Instructor;