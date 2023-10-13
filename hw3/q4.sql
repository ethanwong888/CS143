select dept 
from Department except(select dept
                        from Class
                        where credits != 3)