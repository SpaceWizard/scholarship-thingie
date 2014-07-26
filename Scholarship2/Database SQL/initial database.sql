CREATE TABLE users (
          class    VARCHAR(20) NOT NULL,
          ufid     VARCHAR(20) NOT NULL,
            password     VARCHAR(128) NOT NULL
         
     )
            
            
                   
            INSERT INTO users
                 (class, ufid,password) 
          VALUES ('admin','student', '74dfc2b27acfa364da55f93a5caee29ccad3557247eda238831b3e9bd931b01d77fe994e4f12b9d4cfa92a124461d2065197d8cf7f33fc88566da2db2a4d6eae');
          
          select * from users
          
ALTER TABLE scholarships
ADD PRIMARY KEY (title, award)
 
ALTER TABLE scholarships
DROP PRIMARY KEY

SELECT student
FROM committee_students
WHERE committeeMember="cadence"
AND score=0

DELETE FROM committee_students
WHERE committeeMember="shiningarmor"
AND student="assign"
DROP TABLE scholarship_requirement

SELECT ufid
FROM students

		UPDATE scholarships
		SET quantity='10', award='5000', deadline='2013-04-23', title='J W Martin and A M Martin Phillips Scholarship Fund'
		WHERE award=4000 and title='J W Martin and A M Martin Phillips Scholarship Fund' 
		
SELECT requirements.ShortName, requirements.Description 
FROM
	requirements
	JOIN scholarship_requirements ON scholarship_requirements.Requirement = requirements.ShortName
WHERE ScholarshipName = 'John F and Marjorie J Alexander Scholarship'
	AND awardAmount = '1000' AND weight<>0;

	
SELECT DISTINCT requirements.ShortName, requirements.Description
FROM
	requirements
	LEFT JOIN scholarship_requirements ON scholarship_requirements.Requirement = requirements.ShortName
WHERE 
	ScholarshipName <> 'John F and Marjorie J Alexander Scholarship'
	AND awardAmount <> '1000'
	
INSERT INTO scholarship_requirements VALUES ()
SELECT * FROM scholarship_requirements
		SELECT requirements.ShortName, requirements.Description, scholarshipName 
			FROM
				requirements
				JOIN scholarship_requirements 
				ON scholarship_requirements.Requirement = requirements.ShortName
		WHERE ScholarshipName ='Everett L Holden Marian G Holden Memorial Scholarship Fund'
			AND awardAmount =4000
			AND scholarship_requirements.Weight=0;
			
	SELECT DISTINCT requirements.ShortName
		FROM
		requirements
	JOIN scholarship_requirements ON scholarship_requirements.Requirement = requirements.ShortName
	WHERE 
		ScholarshipName ='Everett L Holden Marian G Holden Memorial Scholarship Fund'
		AND awardAmount =4000
		
		
SELECT ShortName, Description
FROM requirements
	LEFT JOIN (	SELECT  ScholarshipName, Preference
	FROM
		scholarship_preferences	
	WHERE 
		ScholarshipName ='J W Martin and A M Martin Phillips Scholarship Fund'
		AND awardAmount =4000) AS used ON used.Preference = requirements.ShortName
WHERE ScholarshipName IS NULL

SELECT *
FROM requirements
WHERE 

SELECT Preference, Description, Weight
FROM scholarship_preferences
	JOIN requirements ON scholarship_preferences.preference = requirements.shortName
WHERE
	ScholarshipName ='J W Martin and A M Martin Phillips Scholarship Fund'
	AND awardAmount =4000


INSERT INTO scholarship_preferences VALUES ('J W Martin and A M Martin Phillips Scholarship Fund',4000,'Admitted',4)

DELETE FROM scholarship_preferences WHERE weight=5

SELECT ShortName, Description
FROM requirements
	LEFT JOIN (	SELECT  ufid, committee
	FROM
		scholarship_preferences	
	WHERE 
		ScholarshipName ='J W Martin and A M Martin Phillips Scholarship Fund'
		AND awardAmount =4000) AS used ON used.Preference = requirements.ShortName
WHERE ScholarshipName IS NULL


		SELECT student, COUNT(committee) AS "assing"
		FROM com_stu
		GROUP BY student
		
		
SELECT ufid, assnCount.assing
FROM students
LEFT JOIN (
		SELECT student, COUNT(committee) AS "assing"
		FROM com_stu
		GROUP BY student) AS assnCount ON assnCount.student = students.ufid
WHERE assnCount.assing <> 2	OR assnCount.assing IS NULL	

SELECT ApplicationComp
FROM students
WHERE ufid = "applejack"

SELECT name, local_address, perm_address, email, local_phone, perm_phone, current, program_major, specializations, degree, graduate_time
FROM students
WHERE ufid="baileyd"

SELECT name, local_address, perm_address, email, local_phone
FROM students
WHERE ufid="baileyd"

UPDATE students
SET ApplicationStarted = 1
WHERE ufid="baileyd"

SELECT student
FROM student_extra_materials
WHERE student="baileyd"

INSERT INTO student_extra_materials (student)
VALUES (?)

DELETE 
FROM student_extra_materials
WHERE student="baileyd"

SELECT Essay, Transcript, Resume
FROM student_extra_materials
WHERE student="baileyd"

SELECT ShortName, Description
FROM requirements

INSERT INTO student_requirements
VALUES(?,?)

DELETE 
FROM student_extra_materials
WHERE student="baileyd"

SELECT student
FROM student_requirements
WHERE Student="baileyd"
AND Requirement="HS Alachua County"

		DELETE
		FROM student_requirements
		WHERE student="baileyd"
		
		
DROP TABLE com_stu

INSERT INTO committee_item_score (committeeMember, student, item, score) VALUES
('shiningarmor', 'pinkiepie', 'GPA', 20),
('shiningarmor', 'pinkiepie', 'GRE', 12),
('shiningarmor', 'applejack', 'GPA', 20),
('shiningarmor', 'applejack', 'GRE', 12);

SELECT students.name
FROM students

SELECT students.name, students.ufid
FROM students
LEFT JOIN (
		SELECT student, COUNT(committeeMember) AS "assing"
		FROM committee_students
		GROUP BY student) AS assnCount ON assnCount.student = students.ufid
WHERE (assnCount.assing <> 2	OR assnCount.assing IS NULL	)
AND students.ApplicationComp = 1

SELECT userName, Name
FROM committee_members
WHERE username<>(
SELECT committeeMember
FROM committee_students
WHERE student="pinkiepie")

WHERE student="pinkiepie"

SELECT COUNT(committeeMember)
FROM committee_students
WHERE student="pinkiepie"
GROUP BY student

INSERT INTO committee_students
VALUES(?,?)

SELECT student, students.name
FROM student_referer_list
JOIN students ON student_referer_list.student = students.ufid
WHERE reference = "castle"

INSERT INTO recommendations (recommender, student, item, score)
VALUES 

INSERT INTO recommendations (recommender, student, item, score)
VALUES ("castle","applejack","comments","Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah Blah!")

DELETE FROM recommendations
WHERE student = "applejack"

SELECT score
FROM recommendations
WHERE recommender = "castle"
AND Student = "applejack" 
AND Item = "growth"

DELETE FROM winners
WHERE Scholarship = "J W Martin and A M Martin Phillips Scholarship Fund"
		AND student = ?
		AND key = ?
		
		SELECT student
		FROM student_requirements
		WHERE student = ?
		AND Requirement = ?
		
		
SELECT ufid, students.name
FROM Winners
JOIN students ON students.ufid = winners.student
WHERE scholarship="Everett L Holden Marian G Holden Memorial Scholarship Fund"
AND amount="3000"

SELECT ufid, name, winners.scholarship
FROM students
LEFT JOIN winners ON students.ufid = winners.student
WHERE scholarship

SELECT students.name, students.ufid
FROM students
LEFT JOIN (
		SELECT scholarship, student
		FROM winners
		WHERE scholarship="Everett L Holden Marian G Holden Memorial Scholarship Fund"
		AND amount="1000") AS winnerSc ON winnerSc.student = students.ufid
WHERE (winnerSC.scholarship IS NULL	)

SELECT student, students.name, count(scholarship)
FROM winners
JOIN students ON students.ufid = winners.student
GROUP BY student

SELECT Reference, referrer.name, referrer.email
		FROM student_referer_list
		JOIN referrer ON student_referer_list.Reference = referrer.username
		WHERE student_referer_list.student = "baileyd"
		
DROP TABLE temp_eligible

SELECT score, comment
		FROM com_score
		WHERE title="GPA"
		ORDER BY score DESC