select dept, 
case
    when  (dept = 'Comp. Sci.' or dept = 'Elec. Eng.') then 'Engineering'
    else 'L&S'
end as school
from Department;
