select dept, avg(credits) 'dept_average_course_credit'
from Class
group by dept;