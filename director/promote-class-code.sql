-- Islamiyyah Only Students Promotion
UPDATE students s
JOIN classes c ON s.class_id = c.id
SET s.class_id = (
    CASE c.class
        WHEN 'Pre basic one' THEN (SELECT id FROM classes WHERE class = 'Pre basic two')
        WHEN 'Pre basic two' THEN (SELECT id FROM classes WHERE class = 'Basic one')
        WHEN 'Basic one' THEN (SELECT id FROM classes WHERE class = 'Basic two')
        WHEN 'Basic two' THEN (SELECT id FROM classes WHERE class = 'Basic three')
        WHEN 'Basic three' THEN (SELECT id FROM classes WHERE class = 'Basic four')
        WHEN 'Basic four' THEN (SELECT id FROM classes WHERE class = 'Basic five')
        WHEN 'Basic five' THEN (SELECT id FROM classes WHERE class = 'Basic six')
        WHEN 'Basic six' THEN (SELECT id FROM classes WHERE class = 'Basic seven')
        ELSE s.class_id
    END
)
WHERE c.class IN (
    'Pre basic one', 'Pre basic two', 'Basic one', 'Basic two',
    'Basic three', 'Basic four', 'Basic five', 'Basic six', 'Basic seven'
);


-- Islamiyyah Students Also In Conventional Promotion
UPDATE students s
JOIN classes c ON s.2ndClass_id = c.id
SET s.2ndClass_id = (
    CASE c.class
        WHEN 'Pre basic one' THEN (SELECT id FROM classes WHERE class = 'Pre basic two')
        WHEN 'Pre basic two' THEN (SELECT id FROM classes WHERE class = 'Basic one')
        WHEN 'Basic one' THEN (SELECT id FROM classes WHERE class = 'Basic two')
        WHEN 'Basic two' THEN (SELECT id FROM classes WHERE class = 'Basic three')
        WHEN 'Basic three' THEN (SELECT id FROM classes WHERE class = 'Basic four')
        WHEN 'Basic four' THEN (SELECT id FROM classes WHERE class = 'Basic five')
        WHEN 'Basic five' THEN (SELECT id FROM classes WHERE class = 'Basic six')
        WHEN 'Basic six' THEN (SELECT id FROM classes WHERE class = 'Basic seven')
        ELSE s.2ndClass_id
    END
)
WHERE c.class IN (
    'Pre basic one', 'Pre basic two', 'Basic one', 'Basic two',
    'Basic three', 'Basic four', 'Basic five', 'Basic six', 'Basic seven'
);


-- Promote for conentional sudents only
UPDATE students s
JOIN classes c ON s.class_id = c.id
SET s.class_id = (
    CASE c.class
        WHEN 'Pre basic one' THEN (SELECT id FROM classes WHERE class = 'Pre basic two')
        WHEN 'Pre basic two' THEN (SELECT id FROM classes WHERE class = 'Basic one')
        WHEN 'Basic one' THEN (SELECT id FROM classes WHERE class = 'Basic two')
        WHEN 'Basic two' THEN (SELECT id FROM classes WHERE class = 'Basic three')
        WHEN 'Basic three' THEN (SELECT id FROM classes WHERE class = 'Basic four')
        WHEN 'Basic four' THEN (SELECT id FROM classes WHERE class = 'Basic five')
        WHEN 'Basic five' THEN (SELECT id FROM classes WHERE class = 'Basic six')
        ELSE s.class_id
    END
)
WHERE c.class IN (
    'Pre basic one', 'Pre basic two', 'Basic one', 'Basic two',
    'Basic three', 'Basic four', 'Basic five', 'Basic six'
);
