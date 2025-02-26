/*Évfolyamok megjelenítése*/
SELECT year
FROM classes
GROUP BY year
ORDER BY 1;

/*Osztályok egy adott évfolyamban (pl.2021-ben)*/
SELECT code
FROM classes
WHERE year='2021';

/*Tanulók egy adott osztályban egy adott évfolyamban (pl. 2021-ben a 11a-ban)*/
SELECT s.name
FROM students s
JOIN classes c ON s.class_id=c.id
WHERE c.code='11a' AND c.year='2021';


/*Egy osztály átlaga*/
-- egy ember egy tantárgyának áltaga --
SELECT c.code, st.id, st.name, su.name, AVG(g.grade)
FROM grades g
JOIN students st ON st.id=g.student_id
JOIN subjects su ON su.id=g.subject_id
JOIN classes c ON c.id=st.class_id
WHERE c.year='2021'
GROUP BY st.name, su.name;

-- egy ember teljes átlaga --
SELECT t.osztaly, t.nev, AVG(t.atlag)
FROM (SELECT c.code as osztaly, st.id as id, st.name as nev, su.name, AVG(g.grade) as atlag
        FROM grades g
        JOIN students st ON st.id=g.student_id
        JOIN subjects su ON su.id=g.subject_id
    JOIN classes c ON c.id=st.class_id
    WHERE c.year='2022'
    GROUP BY st.name, su.name) t
GROUP BY t.id;

-- ez a végleges --
SELECT h.osztaly as osztaly, ROUND(AVG(h.atlag), 2) as atlag
FROM (SELECT t.osztaly as osztaly, t.nev, AVG(t.atlag) as atlag
        FROM (SELECT c.code as osztaly, st.id as id, st.name as nev, su.name, AVG(g.grade) as atlag
                FROM grades g
                JOIN students st ON st.id=g.student_id
                JOIN subjects su ON su.id=g.subject_id
                JOIN classes c ON c.id=st.class_id
                WHERE c.code='11a'
                GROUP BY st.name, su.name) t
        GROUP BY t.id) h
GROUP BY h.osztaly;

-- osztály átlaga tantárgyanként --
SELECT c.code, su.name as targy, ROUND(AVG(g.grade), 2) as atlag
FROM grades g
JOIN students st ON st.id=g.student_id
JOIN subjects su ON su.id=g.subject_id
JOIN classes c ON c.id=st.class_id
WHERE c.code='11a'
GROUP BY c.code, su.name;