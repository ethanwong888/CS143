select distinct dept, avg(credits) over(partition by dept) dept_avg_course_credit, avg(credits)over() overall_avg_course_credit
from Class;