SELECT COUNT(*) 
FROM (SELECT awardYear 
        FROM NobelPrize 
        WHERE lid IN (SELECT lid
                        FROM Laureate 
                        WHERE familyName IS NULL AND gender IS NULL) GROUP BY awardYear) orgs;
