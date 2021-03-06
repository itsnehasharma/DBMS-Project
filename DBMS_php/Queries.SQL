//D1
SELECT AVG(A.AGE), YEAR
FROM (SELECT p.age, p.position, p.medical_treatment, c.weather_id, c.roadsurface_id, c.year
FROM DOSPINA.PERSON P, DOSPINA.COLLISION C
WHERE P.CID = C.COLLISION_ID AND AGE <> -1 AND p.position = 11
AND p.medical_treatment BETWEEN 2 AND 3
AND c.weather_id = 3
AND c.roadsurface_id = 2) A
WHERE YEAR BETWEEN 1999 AND 2003
GROUP BY A.YEAR
ORDER BY YEAR DESC;

//AS12
SELECT A.BABIES, b.toddlers, c.kids, d.teenagers, e.young_adults as "YOUNG ADULTS", f.adults, g.senior_citizens AS "SENIOR CITIZENS", year
FROM (SELECT COUNT(ROWNUM) AS BABIES, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 0 AND 1 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) A NATURAL JOIN
(SELECT COUNT(ROWNUM) AS TODDLERS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 2 AND 3 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) B NATURAL JOIN
(SELECT COUNT(ROWNUM) AS KIDS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 4 AND 12 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) C NATURAL JOIN
(SELECT COUNT(ROWNUM) AS TEENAGERS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 13 AND 19 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) D NATURAL JOIN
(SELECT COUNT(ROWNUM) AS "YOUNG_ADULTS", c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 20 AND 30 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) E NATURAL JOIN
(SELECT COUNT(ROWNUM) AS ADULTS, c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age BETWEEN 31 AND 60 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) F NATURAL JOIN
(SELECT COUNT(ROWNUM) AS "SENIOR_CITIZENS", c.year
FROM DOSPINA.PERSON P, DOSPINA.collision C
WHERE P.CID = c.collision_id AND p.age >=61 AND p.medical_treatment BETWEEN 2 AND 3
GROUP BY c.year ORDER BY YEAR) G;

//AS6
SELECT *
FROM (SELECT COUNT(ROWNUM) AS MALE, C.YEAR
FROM DOSPINA.person P, DOSPINA.collision C
WHERE P.CID = C.COLLISION_ID AND P.SEX <> '-1' AND p.position = 11 AND p.sex = 'M'
GROUP BY c.year
ORDER BY c.year) A NATURAL JOIN
(SELECT COUNT(ROWNUM) AS FEMALE, C.YEAR
FROM DOSPINA.person P, DOSPINA.collision C
WHERE P.CID = C.COLLISION_ID AND P.SEX <> '-1' AND p.position = 11 AND p.sex = 'F'
GROUP BY c.year
ORDER BY c.year) B;

//D3
SELECT *
FROM (SELECT COUNT(ROWNUM) AS AGE7 , YEAR
FROM (SELECT c.year - v.vehicle_year AS AGE, v.vehicle_id, c.year
FROM DOSPINA.vehicle V NATURAL JOIN DOSPINA.collision C
WHERE v.vehicle_type = 1 AND C.ROADSURFACE_ID = 1 AND c.roadalign_id = 1 AND c.roadconfig_id = 2) A
WHERE A.AGE = 7
GROUP BY YEAR
ORDER BY YEAR DESC) B NATURAL JOIN
(SELECT COUNT(ROWNUM) AS AGE2, YEAR
FROM (SELECT c.year - v.vehicle_year AS AGE, v.vehicle_id, c.year
FROM DOSPINA.vehicle V NATURAL JOIN DOSPINA.collision C
WHERE v.vehicle_type = 1 AND C.ROADSURFACE_ID = 1 AND c.roadalign_id = 1 AND c.roadconfig_id = 2) A
WHERE A.AGE = 2
GROUP BY YEAR
ORDER BY YEAR DESC) c;
//sql SERVER AKHAND CHUTIYA CHEESE HAI

//AS9
SELECT COUNT(A.VEHICLE_ID) AS "Number Of Vehicles", a.year
FROM (SELECT v.vehicle_id, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_year = c.year) A
GROUP BY YEAR
ORDER BY YEAR;

//AS8
SELECT YEAR, ROUND(TYPE_1/TOTAL*100,2) AS "Percentage of Type1 Vehicles", ROUND(TYPE_5/TOTAL*100,2) AS "Percentage of Type5 Vehicles", ROUND(TYPE_6/TOTAL*100,2) AS "Percentage of Type6 Vehicles", 
ROUND(TYPE_7/TOTAL*100,2) AS "Percentage of Type7 Vehicles", ROUND(TYPE_8/TOTAL*100,2) AS "Percentage of Type8 Vehicles", ROUND(TYPE_9/TOTAL*100,2) AS "Percentage of Type9 Vehicles", 
ROUND(TYPE_10/TOTAL*100,2) AS "Percentage of Type10 Vehicles", ROUND(TYPE_11/TOTAL*100,2) AS "Percentage of Type11 Vehicles", ROUND(TYPE_14/TOTAL*100,2) AS "Percentage of Type14 Vehicles", 
ROUND(TYPE_16/TOTAL*100,2) AS "Percentage of Type16 Vehicles", ROUND(TYPE_17/TOTAL*100,2) AS "Percentage of Type17 Vehicles", ROUND(TYPE_18/TOTAL*100,2) AS "Percentage of Type18 Vehicles", 
ROUND(TYPE_19/TOTAL*100,2) AS "Percentage of Type19 Vehicles", ROUND(TYPE_20/TOTAL*100,2) AS "Percentage of Type20 Vehicles", ROUND(TYPE_21/TOTAL*100,2) AS "Percentage of Type21 Vehicles", 
ROUND(TYPE_22/TOTAL*100,2) AS "Percentage of Type22 Vehicles", ROUND(TYPE_23/TOTAL*100,2) AS "Percentage of Type23 Vehicles"
FROM (SELECT TYPE_1, TYPE_5, TYPE_6, TYPE_7, TYPE_8, TYPE_9, TYPE_10, TYPE_11, TYPE_14, TYPE_16, TYPE_17, TYPE_18, TYPE_19, TYPE_20, TYPE_21, TYPE_22, TYPE_23, 
TYPE_1 + TYPE_5 + TYPE_6 + TYPE_7 + TYPE_8 + TYPE_9 + TYPE_10 + TYPE_11 + TYPE_14 + TYPE_16 + TYPE_17 + TYPE_18 + TYPE_19 + TYPE_20 + TYPE_21 + TYPE_22 + TYPE_23 AS TOTAL, YEAR
FROM (SELECT COUNT(A.VEHICLE_ID) AS TYPE_1, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 1
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_5, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 5
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_6, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 6
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_7, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 7
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_8, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 8
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_9, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 9
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_10, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 10
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_11, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 11
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_14, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 14
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_16, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 16
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_17, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 17
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_18, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 18
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_19, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 19
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_20, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 20
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_21, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 21
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_22, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 22
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)

NATURAL JOIN
(SELECT COUNT(A.VEHICLE_ID) AS TYPE_23, A.YEAR
FROM (SELECT v.vehicle_id, v.vehicle_type, c.year
FROM DOSPINA.VEHICLE V, DOSPINA.COLLISION C
WHERE v.cid = c.collision_id AND v.vehicle_type <> -1) A 
WHERE VEHICLE_TYPE = 23
GROUP BY A.YEAR, a.vehicle_type
ORDER BY YEAR, VEHICLE_TYPE)
WHERE YEAR BETWEEN 2000 AND 2005);

//D5
SELECT C.MORNING_S, D.MORNING_WS, E.AFTERNOON_S, F.AFTERNOON_wS, G.EVENING_S, H.EVENING_WS, I.NIGHT_S, J.NIGHT_WS
FROM (SELECT COUNT(*) AS MORNING_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 6 AND 11) C,
(SELECT COUNT(*) AS MORNING_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 6 AND 11) D,
(SELECT COUNT(*) AS AFTERNOON_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 12 AND 16) E,
(SELECT COUNT(*) AS AFTERNOON_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 12 AND 16) F,
(SELECT COUNT(*) AS EVENING_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 17 AND 19) G,
(SELECT COUNT(*) AS EVENING_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 17 AND 19) H,
(SELECT A.NIGHT_S + B.NIGHT_S AS NIGHT_S
FROM (SELECT COUNT(*) AS NIGHT_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 20 AND 23) A,
(SELECT COUNT(*) AS NIGHT_S
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used = 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 0 AND 5) B) I,
(SELECT A.NIGHT_WS + B.NIGHT_WS AS NIGHT_WS
FROM (SELECT COUNT(*) AS NIGHT_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position = 99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 20 AND 23) A,
(SELECT COUNT(*) AS NIGHT_WS
FROM DOSPINA.person P, DOSPINA.collision C, DOSPINA.vehicle V
WHERE P.CID = C.COLLISION_ID AND v.cid = C.COLLISION_ID AND p.position=99 AND p.safety_device_used <> 10 AND p.position<>-1 AND p.safety_device_used<>-1
AND c.hour BETWEEN 0 AND 5) B) J;

//D8
SELECT YEAR, WEEKDAY, WEEKEND, ROUND(WEEKDAY/4,0) AS "AVERAGE PER DAY ACCIDENTS ON WEEKDAY", ROUND(WEEKEND/3,0) AS "AVERAGE PER DAY ACCIDENTS ON WEEKEND"
FROM
(SELECT A.EVENING_WEEKEND + B.NIGHT_WEEKEND + C.NIGHT_WEEKEND AS WEEKEND, A.YEAR
FROM 
(SELECT COUNT(*) AS EVENING_WEEKEND, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 5 AND 7 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) A,
(SELECT COUNT(*) AS NIGHT_WEEKEND, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 5 AND 7 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) B,
(SELECT COUNT(*) AS NIGHT_WEEKEND, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 5 AND 7 AND c.hour BETWEEN 0 AND 5
GROUP BY YEAR
ORDER BY YEAR) C
WHERE A.YEAR = B.YEAR AND A.YEAR = C.YEAR)
NATURAL JOIN
(SELECT A.EVENING_WEEKDAY + B.NIGHT_WEEKDAY + C.NIGHT_WEEKDAY AS WEEKDAY, A.YEAR
FROM 
(SELECT COUNT(*) AS EVENING_WEEKDAY, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 1 AND 4 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) A,
(SELECT COUNT(*) AS NIGHT_WEEKDAY, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 1 AND 4 AND c.hour BETWEEN 20 AND 23
GROUP BY YEAR
ORDER BY YEAR) B,
(SELECT COUNT(*) AS NIGHT_WEEKDAY, C.YEAR
FROM DOSPINA.collision C
WHERE C.DAY BETWEEN 1 AND 4 AND c.hour BETWEEN 0 AND 5
GROUP BY YEAR
ORDER BY YEAR) C
WHERE A.YEAR = B.YEAR AND A.YEAR = C.YEAR)
WHERE YEAR BETWEEN 2000 AND 2005;

//AS5
#QUERY ONE, PRIMARY QUERY
SELECT *
FROM (SELECT *
FROM (SELECT COUNT(A.SEVERITY), a.roadconfig_id, a.year
FROM (SELECT C.SEVERITY, C.ROADCONFIG_ID, C.YEAR
FROM DOSPINA.collision C, DOSPINA.person P
WHERE C.COLLISION_ID = p.cid AND c.SEVERITY = 3 AND C.ROADCONFIG_ID <> -1) A
GROUP BY a.roadconfig_id, a.year
ORDER BY a.ROADCONFIG_ID) B
WHERE YEAR = 2000) X,
(SELECT *
FROM (SELECT COUNT(A.SEVERITY), a.roadconfig_id, a.year
FROM (SELECT C.SEVERITY, C.ROADCONFIG_ID, C.YEAR
FROM DOSPINA.collision C, DOSPINA.person P
WHERE C.COLLISION_ID = p.cid AND c.SEVERITY = 3 AND C.ROADCONFIG_ID <> -1) A
GROUP BY a.roadconfig_id, a.year
ORDER BY a.ROADCONFIG_ID) B
WHERE YEAR = 2010) Y
WHERE X.ROADCONFIG_ID = Y.ROADCONFIG_ID;
#QUERY TWO, SECONDARY QUERY
SELECT A.ACCIDENTS_2000, B.ACCIDENTS_2010, A.MONTH
FROM (SELECT COUNT(P.PID) AS "ACCIDENTS_2000", C.MONTH
FROM DOSPINA.collision C, DOSPINA.person P
WHERE C.COLLISION_ID = p.cid AND C.SEVERITY = 3 AND C.ROADCONFIG_ID = 2 AND YEAR = 2000
GROUP BY C.MONTH
ORDER BY MONTH) A,
(SELECT COUNT(P.PID) AS "ACCIDENTS_2010", C.MONTH
FROM DOSPINA.collision C, DOSPINA.person P
WHERE C.COLLISION_ID = p.cid AND C.SEVERITY = 3 AND C.ROADCONFIG_ID = 2 AND YEAR = 2010
GROUP BY C.MONTH
ORDER BY MONTH) B
WHERE A.MONTH = B.MONTH;

//AS4
SELECT *
FROM (SELECT COUNT(A.COLLISION_ID) AS "W_1", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 1
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS "W_2", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 2
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS "W_3", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 3
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS "W_4", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 4
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS "W_5", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 5
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS "W_6", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 6
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR) NATURAL JOIN
(SELECT COUNT(A.COLLISION_ID) AS "W_7", A.YEAR
FROM (SELECT C.COLLISION_ID, C.WEATHER_ID, C.YEAR
FROM DOSPINA.collision C
WHERE C.WEATHER_ID<>-1) A
WHERE A.WEATHER_ID = 7
GROUP BY A.WEATHER_ID, A.YEAR
ORDER BY A.WEATHER_ID, A.YEAR);

//N1
SELECT ROUND(FATALITIES*100/(FATALITIES+NF),2) AS FATALITIES, ROUND(NF*100/(FATALITIES+NF),2) AS "NON FATALITIES", YEAR
FROM(SELECT COUNT(A.PID) AS FATALITIES, A.YEAR
FROM (SELECT p.pid, C.YEAR
FROM dospina.PERSON P, DOSPINA.collision C
WHERE p.cid = C.COLLISION_ID AND P.MEDICAL_TREATMENT = 3) A
GROUP BY A.YEAR
ORDER BY A.YEAR) X
NATURAL JOIN
(SELECT COUNT(A.PID) AS "NF", A.YEAR
FROM (SELECT p.pid, C.YEAR
FROM dospina.PERSON P, DOSPINA.collision C
WHERE p.cid = C.COLLISION_ID AND P.MEDICAL_TREATMENT <> 3 AND P.MEDICAL_TREATMENT <> -1) A
GROUP BY A.YEAR
ORDER BY A.YEAR) Y;

//N5
SELECT YEAR, NI AS "ACCIDENTS OCCURING AT NON-INTERSECTION", I AS "ACCIDENTS OCCURING AT INTERSECTION"
FROM
(SELECT COUNT(*) AS NI , YEAR
FROM DOSPINA.COLLISION 
WHERE ROADCONFIG_ID = 1
GROUP BY YEAR
ORDER BY YEAR)
NATURAL JOIN
(SELECT A.I + B.I AS I, A.YEAR 
FROM
(SELECT COUNT(*) AS I , YEAR
FROM DOSPINA.COLLISION 
WHERE ROADCONFIG_ID = 2
GROUP BY YEAR
ORDER BY YEAR) A,
(SELECT COUNT(*) AS I , YEAR
FROM DOSPINA.COLLISION 
WHERE ROADCONFIG_ID = 3
GROUP BY YEAR
ORDER BY YEAR) B
WHERE A.YEAR = B.YEAR);

//AS1
