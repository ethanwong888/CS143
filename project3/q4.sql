SELECT COUNT(*) 
FROM (SELECT DISTINCT city 
        FROM Affiliation 
        WHERE name = 'University of California' 
        GROUP BY city) UC;