-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2013 at 06:23 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `derpii`
--

-- --------------------------------------------------------

--
-- Table structure for table `banlist`
--

CREATE TABLE IF NOT EXISTS `banlist` (
  `ip` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `committee_item_score`
--

CREATE TABLE IF NOT EXISTS `committee_item_score` (
  `committeeMember` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `student` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `score` int(2) NOT NULL,
  PRIMARY KEY (`committeeMember`,`student`,`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `committee_item_score`
--

INSERT INTO `committee_item_score` (`committeeMember`, `student`, `item`, `score`) VALUES
('cadence', 'applejack', 'Essay_Career', 4),
('cadence', 'applejack', 'Essay_Interest', 5),
('cadence', 'applejack', 'GPA', 12),
('cadence', 'applejack', 'GRE', 2),
('cadence', 'applejack', 'Recc1', 1),
('cadence', 'applejack', 'Recc2', 2),
('cadence', 'applejack', 'Resume', 3),
('shiningarmor', 'applejack', 'GRE', 12),
('shiningarmor', 'pinkiepie', 'GPA', 20),
('shiningarmor', 'pinkiepie', 'GRE', 12);

-- --------------------------------------------------------

--
-- Table structure for table `committee_members`
--

CREATE TABLE IF NOT EXISTS `committee_members` (
  `userName` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `committee_members`
--

INSERT INTO `committee_members` (`userName`, `name`, `email`) VALUES
('cadence', 'Janie D. Fuller', 'JanieDFuller@ufl.edu'),
('shiningarmor', 'William M. Schmidt', 'WilliamMSchmidt@ufl.edu');

-- --------------------------------------------------------

--
-- Table structure for table `committee_students`
--

CREATE TABLE IF NOT EXISTS `committee_students` (
  `committeeMember` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `student` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `score` decimal(4,2) NOT NULL,
  PRIMARY KEY (`committeeMember`,`student`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `committee_students`
--

INSERT INTO `committee_students` (`committeeMember`, `student`, `score`) VALUES
('cadence', 'applejack', '0.00'),
('cadence', 'baileyd', '0.00'),
('shiningarmor', 'applejack', '0.00'),
('shiningarmor', 'baileyd', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `com_score`
--

CREATE TABLE IF NOT EXISTS `com_score` (
  `title` varchar(64) NOT NULL,
  `score` int(16) NOT NULL,
  `comment` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `com_score`
--

INSERT INTO `com_score` (`title`, `score`, `comment`) VALUES
('GPA', 20, '4.0~3.86'),
('GPA', 18, '3.85~3.71'),
('GRE', 15, '1600~1460'),
('GRE', 12, '1450~1280');

-- --------------------------------------------------------

--
-- Table structure for table `highschools`
--

CREATE TABLE IF NOT EXISTS `highschools` (
  `highschool` varchar(128) NOT NULL,
  `location` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `highschools`
--

INSERT INTO `highschools` (`highschool`, `location`) VALUES
('Celestia''s School for Gifted Unicorns', 'Canterlot'),
('others', 'nowhere');

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE IF NOT EXISTS `majors` (
  `major` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`major`) VALUES
('mathematics education'),
('Leadership Educational Administration Doctorate'),
('Early Childhood or Elementary Education'),
('others');

-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE IF NOT EXISTS `recommendations` (
  `recommender` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `student` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `item` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `score` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`recommender`,`student`,`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`recommender`, `student`, `item`, `score`) VALUES
('castle', 'applejack', 'academic', 'Below Average'),
('castle', 'applejack', 'attention', 'Unknown'),
('castle', 'applejack', 'capacity', 'Professor'),
('castle', 'applejack', 'comments', 'Blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah blah!'),
('castle', 'applejack', 'competence', 'Above Average'),
('castle', 'applejack', 'creativity', 'Below Average'),
('castle', 'applejack', 'dependability', 'Exceptional'),
('castle', 'applejack', 'enthusiasm', 'Average'),
('castle', 'applejack', 'growth', 'Exceptional'),
('castle', 'applejack', 'intellectual', 'Unknown'),
('castle', 'applejack', 'leadership', 'Average'),
('castle', 'applejack', 'length', '1 year'),
('castle', 'applejack', 'maturity', 'Exceptional'),
('castle', 'applejack', 'motivation', 'Average'),
('castle', 'applejack', 'oral', 'Below Average'),
('castle', 'applejack', 'overall', '10'),
('castle', 'applejack', 'potential', 'Below Average'),
('castle', 'applejack', 'quality', 'Above Average'),
('castle', 'applejack', 'research', 'Above Average'),
('castle', 'applejack', 'volunteerism', 'Above Average'),
('castle', 'applejack', 'written', 'Average'),
('castle', 'baileyd', 'academic', 'Above Average'),
('castle', 'baileyd', 'attention', 'Below Average'),
('castle', 'baileyd', 'capacity', 'Professor'),
('castle', 'baileyd', 'comments', 'I have known Katie for two years in my capacity as a teacher at Smithtown Middle School School. Katie took English and Spanish from me and earned superior grades in those classes. Based on Katie''s grades, attendance and class participation, I''d rate Katie''s academic performance in my class as superior. '),
('castle', 'baileyd', 'competence', 'Exceptional'),
('castle', 'baileyd', 'creativity', 'Average'),
('castle', 'baileyd', 'dependability', 'Above Average'),
('castle', 'baileyd', 'enthusiasm', 'Average'),
('castle', 'baileyd', 'growth', 'Exceptional'),
('castle', 'baileyd', 'leadership', 'Average'),
('castle', 'baileyd', 'length', '5 years'),
('castle', 'baileyd', 'maturity', 'Below Average'),
('castle', 'baileyd', 'motivation', 'Above Average'),
('castle', 'baileyd', 'oral', 'Below Average'),
('castle', 'baileyd', 'overall', '1'),
('castle', 'baileyd', 'potential', 'Average'),
('castle', 'baileyd', 'quality', 'Below Average'),
('castle', 'baileyd', 'research', 'Unknown'),
('castle', 'baileyd', 'volunteerism', 'Above Average'),
('castle', 'baileyd', 'written', 'Unknown');

-- --------------------------------------------------------

--
-- Table structure for table `recommendation_items`
--

CREATE TABLE IF NOT EXISTS `recommendation_items` (
  `item` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `recommendation_items`
--

INSERT INTO `recommendation_items` (`item`, `description`) VALUES
('competence', 'Competence in chosen field'),
('growth', 'Commitment to professional growth/development'),
('motivation', 'Motivation/Initiative');

-- --------------------------------------------------------

--
-- Table structure for table `referrer`
--

CREATE TABLE IF NOT EXISTS `referrer` (
  `username` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(260) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `referrer`
--

INSERT INTO `referrer` (`username`, `name`, `email`, `phone`) VALUES
('applujakku', 'applujakku', 'lordshaman@126.com', ''),
('castle', 'Jesse Richey', ' JesseTRichey@gmail.com', '248-636-6759');

-- --------------------------------------------------------

--
-- Table structure for table `requirements`
--

CREATE TABLE IF NOT EXISTS `requirements` (
  `ShortName` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ShortName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `requirements`
--

INSERT INTO `requirements` (`ShortName`, `Description`) VALUES
('Admitted', 'The student has been admitted to the College of Education.'),
('Financial Need', 'The student can demonstrate financial need.'),
('First Generation', 'The student is a first generation college student.'),
('Full-time', 'The student meets the credit hour requirements to be labeled as a full-time student.'),
('Grad', 'The student is currently in graduate school.'),
('HS Alachua County', 'The student attended high school in Alachua county.'),
('LCCC Grad', 'Student is a graduate of or employee of Lake City Community College.'),
('Min 2.5 GPA', 'The student has a GPA of at least 2.5.'),
('PROTEACH', 'The student is in the ProTeach program.'),
('Undergrad', 'The student is currently an undergraduate student.');

-- --------------------------------------------------------

--
-- Table structure for table `scholarships`
--

CREATE TABLE IF NOT EXISTS `scholarships` (
  `title` varchar(128) NOT NULL,
  `quantity` int(8) NOT NULL,
  `award` int(8) NOT NULL,
  `deadline` date NOT NULL,
  PRIMARY KEY (`title`,`award`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scholarships`
--

INSERT INTO `scholarships` (`title`, `quantity`, `award`, `deadline`) VALUES
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 2, 1000, '2013-02-01'),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 6, 3000, '2013-02-01'),
('J W Martin and A M Martin Phillips Scholarship Fund', 10, 4000, '2013-04-23'),
('John F and Marjorie J Alexander Scholarship', 1, 1000, '2013-02-01'),
('Lancaster Scholarship', 2, 1000, '2013-04-04'),
('Mary Bradshaw Wood Award', 1, 500, '2013-02-01'),
('William T Phelps Scholarship Fund', 2, 2000, '2013-02-01');

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_preferences`
--

CREATE TABLE IF NOT EXISTS `scholarship_preferences` (
  `ScholarshipName` varchar(128) CHARACTER SET latin1 NOT NULL,
  `AwardAmount` int(8) NOT NULL,
  `Preference` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Weight` int(2) NOT NULL,
  PRIMARY KEY (`ScholarshipName`,`AwardAmount`,`Preference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scholarship_preferences`
--

INSERT INTO `scholarship_preferences` (`ScholarshipName`, `AwardAmount`, `Preference`, `Weight`) VALUES
('J W Martin and A M Martin Phillips Scholarship Fund', 4000, 'HS Alachua County', 1),
('John F and Marjorie J Alexander Scholarship', 1000, 'First Generation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_requirements`
--

CREATE TABLE IF NOT EXISTS `scholarship_requirements` (
  `ScholarshipName` varchar(128) CHARACTER SET latin1 NOT NULL,
  `AwardAmount` int(8) NOT NULL,
  `Requirement` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `Weight` int(2) NOT NULL,
  PRIMARY KEY (`ScholarshipName`,`AwardAmount`,`Requirement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `scholarship_requirements`
--

INSERT INTO `scholarship_requirements` (`ScholarshipName`, `AwardAmount`, `Requirement`, `Weight`) VALUES
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 1000, 'Financial Need', 1),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 1000, 'First Generation', 0),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 1000, 'Full-time', 0),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 1000, 'Grad', 2),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'Financial Need', 0),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'Grad', 0),
('J W Martin and A M Martin Phillips Scholarship Fund', 4000, 'Financial Need', 0),
('J W Martin and A M Martin Phillips Scholarship Fund', 4000, 'Full-time', 0),
('J W Martin and A M Martin Phillips Scholarship Fund', 4000, 'Undergrad', 0),
('John F and Marjorie J Alexander Scholarship', 1000, 'Financial Need', 0),
('John F and Marjorie J Alexander Scholarship', 1000, 'Grad', 1),
('John F and Marjorie J Alexander Scholarship', 1000, 'Min 2.5 GPA', 0),
('John F and Marjorie J Alexander Scholarship', 1000, 'Undergrad', 1),
('Lancaster Scholarship', 1000, 'Admitted', 0),
('Lancaster Scholarship', 1000, 'Full-time', 0),
('Lancaster Scholarship', 1000, 'Undergrad', 0),
('Mary Bradshaw Wood Award', 500, 'Admitted', 1),
('Mary Bradshaw Wood Award', 500, 'Full-time', 1),
('Mary Bradshaw Wood Award', 500, 'Undergrad', 0),
('William T Phelps Scholarship Fund', 2000, 'Admitted', 1),
('William T Phelps Scholarship Fund', 2000, 'Full-time', 1),
('William T Phelps Scholarship Fund', 2000, 'PROTEACH', 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE IF NOT EXISTS `students` (
  `ufid` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `degree` varchar(128) NOT NULL,
  `program_major` varchar(260) NOT NULL,
  `graduate_time` date NOT NULL,
  `current` tinyint(1) NOT NULL,
  `GPA` decimal(3,2) NOT NULL,
  `GRE_SAT_ACT` int(4) NOT NULL,
  `highschool` varchar(128) NOT NULL,
  `college` varchar(128) NOT NULL,
  `lockon` tinyint(1) NOT NULL,
  `local_address` varchar(128) NOT NULL,
  `perm_address` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `local_phone` varchar(128) NOT NULL,
  `perm_phone` varchar(128) NOT NULL,
  `specializations` varchar(128) NOT NULL,
  `ApplicationComp` tinyint(1) NOT NULL,
  `ApplicationStarted` tinyint(1) NOT NULL,
  `score` decimal(10,8) NOT NULL,
  PRIMARY KEY (`ufid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`ufid`, `name`, `degree`, `program_major`, `graduate_time`, `current`, `GPA`, `GRE_SAT_ACT`, `highschool`, `college`, `lockon`, `local_address`, `perm_address`, `email`, `local_phone`, `perm_phone`, `specializations`, `ApplicationComp`, `ApplicationStarted`, `score`) VALUES
('applejack', 'William Bodine', 'BAE', 'Marriage and Family Counseling', '2013-04-12', 1, '4.00', 0, 'Canterlot', 'nowhere', 0, 'sweet apple acres', 'sweet apple acres', '', '', '', 'None', 0, 1, '0.00000000'),
('baileyd', 'Bailey Vickers', 'MED', 'Elementry Education ProTeach', '2013-05-01', 1, '3.86', 30, '', '', 0, '8137 Burning Leaf Front Burning Leaf Front, Coffee Hill, Oklahoma, 74403', '3678 Iron Hickory Private, Port Safety, Washington, 98808', 'bvickers@gmail.com', '(918) 401-8330', '(360) 133-9077', 'Social Studies Education', 1, 1, '0.00000000'),
('kbecket', 'Kate Becket', '', '', '0000-00-00', 0, '0.00', 0, '', '', 0, '', '', '', '', '', '', 1, 1, '0.00000000'),
('pinkiepie', 'Meredith Bury', 'BAE', 'Marriage and Family Counseling', '0000-00-00', 0, '0.00', 0, '', '', 0, '', '', '', '', '', 'None', 0, 1, '0.00000000');

-- --------------------------------------------------------

--
-- Table structure for table `student_extra_materials`
--

CREATE TABLE IF NOT EXISTS `student_extra_materials` (
  `student` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Essay` varchar(8000) COLLATE utf8_unicode_ci NOT NULL,
  `Transcript` varchar(8000) COLLATE utf8_unicode_ci NOT NULL,
  `Resume` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`student`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_extra_materials`
--

INSERT INTO `student_extra_materials` (`student`, `Essay`, `Transcript`, `Resume`) VALUES
('applejack', '', '							', '							'),
('baileyd', 'She sat at the window of the train, her head thrown back, one leg stretched across to the empty seat before her. The window frame trembled with the speed of the motion, the pane hung over empty darkness, and dots of light slashed across the glass as luminous streaks, once in a while. \r\nHer leg, sculptured by the tight sheen of the stocking, its long line running straight, over an arched instep, to the tip of a foot in a high-heeled pump, had a feminine elegance that seemed out of place in the dusty train car and oddly incongruous with the rest of her. She wore a battered camel’s hair coat that had been expensive, wrapped shapelessly about her slender, nervous body. The coat collar was raised to the slanting brim of her hat. A sweep of brown hair fell back, almost touching the line of her shoulders. Her face was made of angular planes, the shape of her mouth clear-cut, a sensual mouth held closed with inflexible precision. She kept her hands in the coat pockets, her posture taut, as if she resented immobility, and unfeminine, as if she were unconscious of her own body and that it was a woman’s body. \r\nShe sat listening to the music. It was a symphony of triumph. The notes flowed up, they spoke of rising and they were the rising itself, they were the essence and the form of upward motion, they seemed to embody every human act and thought that had ascent as its motive. It was a sunburst of sound, breaking out of hiding and spreading open. It had the freedom of release and the tension of purpose. It swept space clean, and left nothing but the joy of an unobstructed effort. Only a faint echo within the sounds spoke of that from which the music had escaped, but spoke in laughing astonishment at the discovery that there was no ugliness or pain, and there never had had to be. It was the song of an immense deliverance.\r\nShe thought: For just a few moments—while this lasts—it is all right to surrender completely—to forget everything and just permit yourself to feel. She thought: Let go—drop the controls—this is it.\r\nSomewhere on the edge of her mind, under the music, she heard the sound of train wheels. They knocked in an even rhythm, every fourth knock accented, as if stressing a conscious purpose. She could relax, because she heard the wheels. She listened to the symphony, thinking: This is why the wheels have to be kept going, and this is where they’re going.\r\nShe had never heard that symphony before, but she knew that it was written by Richard Halley. She recognized the violence and the magnificent intensity. She recognized the style of the theme; it was a clear, complex melody—at a time when no one wrote melody any longer . . . . She sat looking up at the ceiling of the car, but she did not see it and she had forgotten where she was. She did not know whether she was hearing a full symphony orchestra or only the theme; perhaps she was hearing the orchestration in her own mind.\r\nShe thought dimly that there had been premonitory echoes of this theme in all of Richard Halley’s work, through all the years of his long struggle, to the day, in his middle-age, when fame struck him suddenly and knocked him out. This—she thought, listening to the symphony—had been the goal of his struggle. She remembered half-hinted attempts in his music, phrases that promised it, broken bits of melody that started but never quite reached it; when Richard Halley wrote this, he . . . She sat up straight. When did Richard Halley write this?\r\nIn the same instant, she realized where she was and wondered for the first time where that music came from.\r\nA few steps away, at the end of the car, a brakeman was adjusting the controls of the air-conditioner. He was blond and young. He was whistling the theme of the symphony. She realized that he had been whistling it for some time and that this was all she had heard. She watched him incredulously for a while, before she raised her voice to ask, “Tell me please, what are you whistling?”\r\nThe boy turned to her. She met a direct glance and saw an open, eager smile, as if he were sharing a confidence with\r\n', 'Grade/Hour Totals\r\nHours Earned	Hours Carried	Grade Points	GPA	Transfer Hours\r\n92.00	62.00	229.01	3.69 	\r\nCollege Level Academic Skills Test\r\nMATH 997	READING 997	WRITING 997	ESSAY 97	DATE: 03/26/08 \r\n***** FALL 2008 * CLASS = 1 COLLEGE = LS \r\nCREDIT BY EXAM - ADV PLACEMENT \r\nCOURSE 	SECT	GRADE	CREDIT	CREDIT EARNED	CREDIT FOR GPA	COURSE TITLE\r\nAMH 0301 	0000	P 	3.0			U S HISTORY \r\nARH 2002 	0000	P 	1.0	1.0 		ART HISTORY \r\nARH 2002 	0000	P 	2.0			ART HISTORY \r\nBSC 2010 	0000	P 	3.0	3.0 		BIOLOGY \r\nBSC 2010L	0000	P 	1.0	1.0 		BIOLOGY \r\nBSC 2011 	0000	P 	3.0	3.0 		BIOLOGY \r\nBSC 2011L	0000	P 	1.0	1.0 		BIOLOGY \r\nCHM 0301L	0000	P 	1.0	1.0 		CHEMISTRY \r\nCHM 1030 	0000	P 	3.0			CHEMISTRY \r\nECO 2013 	0000	P 	3.0	3.0 		ECONOMICS: MACRO \r\nENC 1101 	0000	P 	3.0	3.0 		ENGLISH LANG/COMP \r\nMAC 2311 	0000	P 	4.0			CALC SUBSCORE \r\nMAC 2311 	0000	P 	4.0			CALCULUS AB \r\nMAC 2311 	0000	P 	4.0	4.0 		CALCULUS BC \r\nMAC 2312 	0000	P 	4.0			CALCULUS BC \r\nPHY 2048 	0000	P 	3.0	3.0 		PHYSICS C: MECHANICS \r\nPHY 2048L	0000	P 	1.0	1.0 		PHYSICS C: MECHANICS \r\nPOS 2041 	0000	P 	3.0	3.0 		GOVT & POLITICS-U.S. \r\nWOH 0301 	0000	P 	3.0	3.0 		WORLD HISTORY \r\nCOMMUNICATION & COMPUTATION COMPLETE \r\nMAXIMUM 30 SEM HOURS AWARDED BY EXAM \r\n* EARNED 30.00 HRS \r\n***** FALL 2008 * CLASS = 2 COLLEGE = EG \r\nCOURSE 	SECT	GRADE	CREDIT	CREDIT EARNED	CREDIT FOR GPA	COURSE TITLE\r\nARC 1701 	6946	A 	3.0	3.0 	3.0 	ARCHITECT HIST 1 \r\nCHM 2045 	8750	B+ 	3.0	3.0 	3.0 	GENERAL CHEMISTRY \r\nCHM 2045L	0737	A 	1.0	1.0 	1.0 	GENERAL CHEMISTRY LAB \r\nECO 2023 	1192	A 	3.0	3.0 	3.0 	PRIN MICROECONOMICS \r\nMAC 2312 	3181	A 	4.0	4.0 	4.0 	ANALYT GEOM & CALC 2 \r\nSLS 1102 	7665	B+ 	1.0	1.0 	1.0 	ENGINEERING FRSHMN EX \r\nTERM GPA = 3.86 * EARNED 15.00 HRS * EARNED 58.00 GPTS * CARRIED 15.00 HRS\r\n*** SPRING 2009 * CLASS = 2 COLLEGE = EG \r\nCOURSE 	SECT	GRADE	CREDIT	CREDIT EARNED	CREDIT FOR GPA	COURSE TITLE\r\nCGS 2531 	6426	A 	3.0	3.0 	3.0 	PROB SOLV COMPU SOFTW \r\nENC 3254 	8636	B+ 	3.0	3.0 	3.0 	PROF COMM ENGINEERS \r\nMAC 2313 	5032	A 	4.0	4.0 	4.0 	ANALYT GEOM & CALC 3 \r\nPHY 2049 	3707	B+ 	3.0	3.0 	3.0 	PHYSICS WITH CALC 2 \r\nSTA 2023 	2168	A 	3.0	3.0 	3.0 	INTRO TO STATISTICS 1 \r\nTERM GPA = 3.81 * EARNED 16.00 HRS * EARNED 61.00 GPTS * CARRIED 16.00 HRS\r\n***** FALL 2009 * CLASS = 3 COLLEGE = EG \r\nCOURSE 	SECT	GRADE	CREDIT	CREDIT EARNED	CREDIT FOR GPA	COURSE TITLE\r\nACG 2021C	3168	B 	4.0	4.0 	4.0 	INTRO FINAN ACCOUNTNG \r\nEML 2023 	5729	A 	3.0	3.0 	3.0 	COMPU AIDED GRAPH/DES \r\nMAP 2302 	6554	B+ 	3.0	3.0 	3.0 	ELEM DIFF EQUATIONS \r\nSTA 4321 	5488	A 	3.0	3.0 	3.0 	INTRO TO PROBABILITY \r\nELECTED GOLDEN KEY INTERNATL HONOR SOC \r\nTERM GPA = 3.53 * EARNED 13.00 HRS * EARNED 45.99 GPTS * CARRIED 13.00 HRS\r\n*** SPRING 2010 * CLASS = 3 COLLEGE = EG \r\nCOURSE 	SECT	GRADE	CREDIT	CREDIT EARNED	CREDIT FOR GPA	COURSE TITLE\r\nCGS 2421 	5265	A 	2.0	2.0 	2.0 	COMP PRG ENGRS VB.NET \r\nCGS 2421L	5275	A 	1.0	1.0 	1.0 	COM PRG ENG VB.NET LA \r\nEGM 2511 	6583	A- 	3.0	3.0 	3.0 	ENGR MECH-STATICS \r\nEIN 3101C	4457	A- 	2.0	2.0 	2.0 	INTRO INDUS & SYSTEMS \r\nEMA 3010 	2965	B 	3.0	3.0 	3.0 	MATERIALS \r\nPHY 2049L	3409	A- 	1.0	1.0 	1.0 	LAB FOR PHY 2049 \r\nSTA 4322 	7477	B+ 	3.0	3.0 	3.0 	INTRO STATISTICS THRY \r\nTERM GPA = 3.53 * EARNED 15.00 HRS * EARNED 53.01 GPTS * CARRIED 15.00 HRS\r\n* SUMMER C 2010 * CLASS = 3 COLLEGE = EG \r\nCOURSE 	SECT	GRADE	CREDIT	CREDIT EARNED	CREDIT FOR GPA	COURSE TITLE\r\nEIN 4354 	8831	A- 	3.0	3.0 	3.0 	ENGINEERING ECONOMY \r\nTERM GPA = 3.67 * EARNED 3.00 HRS * EARNED 11.01 GPTS * CARRIED 3.00 HRS\r\n			', 'Marilyn M. Arnold\r\n4500 Ridgewood Road\r\nMemphis, Tennessee 38116\r\n901-599-0316\r\nemail@yahoo.com\r\n\r\nObjective \r\nTo obtain a position that will enable me to utilize my strong organizational skills, educational background, and ability to work well with people.\r\n\r\nExperience\r\n\r\nLead Teacher\r\nLa Petite Academy,  Memphis, TN.\r\nJune, 2011 – present                         \r\n\r\n    Plan activities that stimulate growth in language, social and motor skills.\r\n    Provide children with individual attention.\r\n    Communicate with parents on a regular basis.\r\n\r\nOwner/ Director\r\nMarilyn’s Lovin’ Touch, Memphis, TN.\r\nMay, 1999 – May, 2011                              \r\n\r\n    Oversaw daily operations, managing a staff of 12 employees.\r\n    Responsibilities included administrative, billing, personnel issues, policies and procedures, payroll and quarterly tax preparation and submission.\r\n    Implemented curriculum plans.\r\n    Maintained ongoing communication with parents regarding childrens'' activities, behavior, and development, and responded to all parents concerns as they arise.\r\n    Maintained records and reports on each child.\r\n\r\nOvernight Stocking/Sales Associate/ Department Manager\r\nWal-Mart, Memphis, TN.\r\nApril, 1999 – January, 2004                              \r\n\r\n    Responsible for customer service.\r\n    Ordered merchandise and kept track of inventory.\r\n    Created displays.\r\n    Helped on the front line (Cashier).\r\n    Unload merchandise off truc.k\r\n    Assembly line.\r\n\r\nEducation\r\nCurrently pursing B.S. in Elementary Education (Early Childhood PK-3 emphasis) at The University of Memphis.\r\n\r\nSouthwest Tennessee Community College, Memphis, TN.\r\n\r\n    Associate of Science Degree\r\n    Grade Point Average /4.0\r\n    Earned 80% of tuition by working while carrying a full course load.\r\n\r\nKnoxville Job Corps, Knoxville, TN.\r\n\r\n    Nursing Assistant Certification\r\n													'),
('pinkiepie', '', '	', '	');

-- --------------------------------------------------------

--
-- Table structure for table `student_referer_list`
--

CREATE TABLE IF NOT EXISTS `student_referer_list` (
  `Student` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Reference` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Complete` tinyint(1) NOT NULL,
  PRIMARY KEY (`Student`,`Reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_referer_list`
--

INSERT INTO `student_referer_list` (`Student`, `Reference`, `Complete`) VALUES
('applejack', 'applujakku', 0),
('baileyd', 'castle', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student_requirements`
--

CREATE TABLE IF NOT EXISTS `student_requirements` (
  `Student` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `Requirement` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Student`,`Requirement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `student_requirements`
--

INSERT INTO `student_requirements` (`Student`, `Requirement`) VALUES
('applejack', 'Admitted'),
('applejack', 'Financial Need'),
('applejack', 'First Generation'),
('applejack', 'Full-time'),
('applejack', 'Grad'),
('applejack', 'LCCC Grad'),
('applejack', 'Min 2.5 GPA'),
('applejack', 'PROTEACH'),
('applejack', 'Save and Continue'),
('applejack', 'Undergrad'),
('baileyd', 'Admitted'),
('baileyd', 'Full-time'),
('baileyd', 'Grad'),
('baileyd', 'Min 2.5 GPA'),
('pinkiepie', 'Admitted'),
('pinkiepie', 'Save and Continue');

-- --------------------------------------------------------

--
-- Table structure for table `student_scholarship`
--

CREATE TABLE IF NOT EXISTS `student_scholarship` (
  `ScholarshipName` varchar(128) NOT NULL,
  `AwardAmount` int(8) NOT NULL,
  `Student` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_scholarship`
--

INSERT INTO `student_scholarship` (`ScholarshipName`, `AwardAmount`, `Student`) VALUES
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'baileyd'),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'applejack'),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'baileyd');

-- --------------------------------------------------------

--
-- Table structure for table `temp_app`
--

CREATE TABLE IF NOT EXISTS `temp_app` (
  `ScholarshipName` varchar(128) DEFAULT NULL,
  `AwardAmount` int(11) DEFAULT NULL,
  `Student` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `temp_app`
--

INSERT INTO `temp_app` (`ScholarshipName`, `AwardAmount`, `Student`) VALUES
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'applejack'),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'baileyd');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ufid` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `iv` varchar(128) NOT NULL,
  `class` varchar(64) NOT NULL,
  PRIMARY KEY (`ufid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ufid`, `password`, `iv`, `class`) VALUES
('applejack', 'fFpAy+fFGF+uygCPGdD+ht4hwOxEl/VDjR/kpuGOOt4=', '16', 'student'),
('applujakku', '9G3qBq/cMHNRIjFaY+Q1I29IZlCxzHQ9zofhyjcbqcc=', '16', 'referer'),
('baileyd', '2IVurv4lhCQPYwhNcEkh8mIkgWNEtVJ48Z9nJgUgzmM=', '16', 'student'),
('cadence', 'ImV/V/Bzh22stGCrffDzmczxlI/rOoq+wKn+a62eRXw=', '16', 'committee'),
('derpy', 'egMF1EKLbaTUFCKIl6RNRxiADz7wQseyUpKvkVNjAGw=', '16', 'admin'),
('Jesse Richey', 'Lo1m5npRPEPU6ARnYxyk2hClkYpE30yjAg1oNFuCrnE=', '16', 'referer'),
('pinkiepie', 'DHGnPoD8ZSOB3JVPOdYeSqlbrKCzMBgi22V7ydgDTrU=', '16', 'student'),
('sdgfgd', 'MoelQvOSUGKoMOJXGkfjyd9Ohw4AuWIqLiXsyRV8Tdc=', '16', 'referer'),
('shiningarmor', 'kBHuaDkhwDAuRMMBmUPgYGKSjdPl8b3CE5a7DPdfQF4=', '16', 'committee');

-- --------------------------------------------------------

--
-- Table structure for table `winners`
--

CREATE TABLE IF NOT EXISTS `winners` (
  `scholarship` varchar(128) NOT NULL,
  `amount` int(11) NOT NULL,
  `student` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `winners`
--

INSERT INTO `winners` (`scholarship`, `amount`, `student`) VALUES
('J W Martin and A M Martin Phillips Scholarship Fund', 4000, 'baileyd'),
('John F and Marjorie J Alexander Scholarship', 1000, 'applejack'),
('Lancaster Scholarship', 1000, 'pinkiepie'),
('Lancaster Scholarship', 1000, 'baileyd'),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'applejack'),
('Everett L Holden Marian G Holden Memorial Scholarship Fund', 3000, 'baileyd');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
