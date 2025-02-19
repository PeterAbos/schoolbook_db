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