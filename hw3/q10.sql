-- common table expression that uses the query from Q9
-- select the school (Engineering or L&S), then count the distinct Student ID and Instructor ID
-- check that the student's department = the department of their school, and the student's department = the instructor's department
-- group by school to make sure both 'Engineering' and 'L&S' schools appear in the result


with School as 
    (select dept, 
    case
        when  (dept = 'Comp. Sci.' or dept = 'Elec. Eng.') then 'Engineering'
        else 'L&S'
    end as school
    from Department)
select school, count(distinct Student.id) as 'num_studs', count(distinct Instructor.id) as 'num_insts'
from School, Student, Instructor
where Student.dept = School.dept and Student.dept = Instructor.dept
group by school;