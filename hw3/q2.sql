select dept, max(credits) 'maximum_course_credit'
from Department natural join Class
group by dept;