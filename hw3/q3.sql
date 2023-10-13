select dept 
from Department natural join Class
group by dept
having count(*) >= 3;