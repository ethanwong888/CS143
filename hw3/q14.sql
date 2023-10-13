select Student.name 'student_name', Instructor.name 'advisor.name'
from Student
left outer join Advisor on Student.id = Advisor.stud_id
left outer join Instructor on Instructor.id = Advisor.inst_id;