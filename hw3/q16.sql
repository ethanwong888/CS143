with recursive P(pre, course)
    as ((select * from Prereq)
union
    (select P.pre, Prereq.class_id
    from P, Prereq
    where P.course=Prereq.class_id))
select course from P where pre='BIO-399';