-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               12.0.2-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.11.0.7065
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table jobboard.applications: ~9 rows (approximately)
INSERT INTO `applications` (`app_id`, `job_id`, `seeker_id`, `status`, `applied_at`) VALUES
	(1, 8, 2, 'pending', '2026-02-21 14:53:15'),
	(2, 8, 4, 'pending', '2026-02-21 15:13:57'),
	(3, 7, 4, 'pending', '2026-02-21 15:14:07'),
	(4, 6, 4, 'pending', '2026-02-21 15:14:13'),
	(5, 5, 4, 'pending', '2026-02-21 15:14:17'),
	(6, 4, 4, 'pending', '2026-02-21 15:14:22'),
	(7, 3, 4, 'pending', '2026-02-21 15:14:29'),
	(8, 2, 4, 'pending', '2026-02-21 15:14:33'),
	(9, 1, 4, 'pending', '2026-02-21 15:14:37');

-- Dumping data for table jobboard.company_profile: ~0 rows (approximately)

-- Dumping data for table jobboard.job_listings: ~8 rows (approximately)
INSERT INTO `job_listings` (`job_id`, `recruiter_id`, `title`, `description`, `location`, `status`, `posted_at`) VALUES
	(1, 3, 'Data Manager', 'All plan Navigation detail maintain', 'Dumdum', 'open', '2026-01-17 18:36:26'),
	(2, 3, 'Pilot', 'Focused', 'Dumdum,Kolkata', 'open', '2026-01-17 18:55:04'),
	(3, 5, 'Web Developer', 'Location: Gujarat, India\n\nJob Summary\n\nWe are looking for a skilled and motivated Web Developer to design, develop, and maintain responsive websites and web applications. The candidate should have a strong understanding of front-end and back-end technologies and be able to work independently as well as in a team.\n\nKey Responsibilities\n\nDesign, develop, and maintain websites and web applications\n\nWrite clean, efficient, and well-documented code\n\nDevelop responsive and user-friendly UI\n\nIntegrate databases and third-party APIs\n\nTest and debug applications to ensure performance and security\n\nCollaborate with designers, content writers, and project managers\n\nMaintain and update existing websites\n\nFollow best practices in web development and security\n\nRequired Skills\n\nProficiency in HTML, CSS, JavaScript\n\nExperience with PHP / Python / Node.js (any one)\n\nKnowledge of MySQL / MongoDB\n\nFamiliarity with Bootstrap, jQuery, or React\n\nUnderstanding of responsive design and cross-browser compatibility\n\nBasic knowledge of version control tools (Git)\n\nPreferred Skills\n\nExperience with frameworks like Laravel, Django, React, or Angular\n\nKnowledge of SEO principles\n\nFamiliarity with hosting platforms and domain management\n\nExperience with RESTful APIs\n\nQualifications\n\nBachelor’s degree in Computer Science / IT / related field\nOR equivalent practical experience\n\nFreshers with good project experience can apply\n\nExperience\n\n0–3 years (Freshers welcome)\n\nSalary\n\nAs per industry standards (Negotiable based on skills and experience)\n\nJob Type\n\nFull-time / Part-time / Internship (as applicable)', 'Gujrat', 'open', '2026-01-17 19:01:11'),
	(4, 5, 'Front-End Developer', 'The Front-End Developer will create responsive and user-friendly interfaces. The role requires strong knowledge of UI design, browser compatibility, and modern JavaScript frameworks.', 'Surat, Gujarat', 'open', '2026-01-17 19:02:12'),
	(5, 6, 'Back-End Developer', 'We are hiring a Back-End Developer to manage server-side logic, database operations, and API integration. The candidate should ensure high performance and security of applications.', 'Vadodara, Gujarat', 'open', '2026-01-17 19:03:04'),
	(6, 6, 'Full Stack Developer (Fresher)', 'This role is suitable for freshers who want to build complete web applications. The candidate will work on both front-end and back-end development under guidance.', 'Rajkot, Gujarat', 'open', '2026-01-17 19:03:40'),
	(7, 7, 'Web Developer Intern', 'We are offering an internship for students interested in web development. Interns will work on live projects and gain practical industry experience.', 'Gandhinagar, Gujarat', 'open', '2026-01-17 19:06:10'),
	(8, 7, 'Junior Web Developer', 'We are looking for a Junior Web Developer to assist in developing and maintaining websites. The candidate should have basic knowledge of web technologies and a willingness to learn and grow in a professional environment.', 'Bhavnagar, Gujarat', 'open', '2026-01-17 19:07:06');

-- Dumping data for table jobboard.job_skills: ~41 rows (approximately)
INSERT INTO `job_skills` (`job_id`, `skill_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 3),
	(2, 4),
	(3, 5),
	(3, 6),
	(3, 7),
	(3, 8),
	(3, 9),
	(3, 10),
	(3, 11),
	(3, 12),
	(4, 5),
	(4, 6),
	(4, 7),
	(4, 10),
	(4, 13),
	(4, 14),
	(5, 15),
	(5, 16),
	(5, 17),
	(5, 18),
	(5, 19),
	(5, 20),
	(6, 5),
	(6, 6),
	(6, 7),
	(6, 15),
	(6, 17),
	(6, 21),
	(7, 5),
	(7, 6),
	(7, 7),
	(7, 17),
	(7, 22),
	(8, 5),
	(8, 6),
	(8, 7),
	(8, 10),
	(8, 15),
	(8, 17);

-- Dumping data for table jobboard.saved_jobs: ~4 rows (approximately)
INSERT INTO `saved_jobs` (`saved_id`, `seeker_id`, `job_id`) VALUES
	(2, 4, 7),
	(4, 4, 8),
	(6, 8, 7),
	(7, 8, 8);

-- Dumping data for table jobboard.skills: ~20 rows (approximately)
INSERT INTO `skills` (`skill_id`, `skill_name`) VALUES
	(1, 'sql'),
	(2, 'mongodb'),
	(3, 'navigation controll'),
	(4, 'driving'),
	(5, 'html'),
	(6, 'css'),
	(7, 'javascript'),
	(8, 'php / python / node.js'),
	(9, 'mysql / mongodb'),
	(10, 'bootstrap'),
	(11, 'jquery'),
	(12, 'or react'),
	(13, 'react'),
	(14, 'responsive design'),
	(15, 'php'),
	(16, 'laravel'),
	(17, 'mysql'),
	(18, 'rest api'),
	(19, 'node.js'),
	(20, 'git'),
	(21, 'basic react'),
	(22, 'basic php');

-- Dumping data for table jobboard.users: ~7 rows (approximately)
INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `status`, `phone`, `created_at`) VALUES
	(2, 'Sneha Dey', 'snehadey142@gmail.com', '$2y$10$Hl2RfZ.DHpLiONCuQ8tPbOtODrZ.FTec9LtA.qQbT7K7Xxh7xoY5C', 'admin', 'approved', NULL, '2026-01-17 12:31:00'),
	(3, 'Indigo', 'indigo09@gmail.com', '$2y$10$xK9rzPbBoY7FHJzClH.NpuS1dZgXf9rLSzUPKV/QQYFS5vrMcc2Fm', 'recruiter', 'approved', NULL, '2026-01-17 17:42:24'),
	(4, 'Soumyadeep Bhattacharya', 's@gmail.com', '$2y$10$iuAnSD4EfKyCY5MKwVat8erJJtYmSK5b9y/MqpMH.T2xFISXOXGEy', 'job_seeker', 'approved', NULL, '2026-01-17 18:44:00'),
	(5, 'TCS', 't@gmail.com', '$2y$10$S8W7OrwwCEGOv3X0wtQEnudGqsIk/KqpxXfo/YS0WGWVCnToVfLAa', 'recruiter', 'approved', NULL, '2026-01-17 18:55:29'),
	(6, 'wipro', 'w@gmail.com', '$2y$10$fdD0x73p.n/0fRdZPPKLEea/NB6tcXhCmYpwH18txCg1mW/PRxXNC', 'recruiter', 'approved', NULL, '2026-01-17 18:56:17'),
	(7, 'Google', 'g@gmail.com', '$2y$10$Ff3lqPsXlTKVe2B5oeEaeuoIwCvac1m/G9aLCBHB74hXxOBpO5MJS', 'recruiter', 'approved', NULL, '2026-01-17 18:56:44'),
	(8, 'Tarak Dey', 'tarak@gmail.com', '$2y$10$3ePH.0avGg/Bz9preEE2s.Co48ojW50qarNFJdliCZdlflHf4LcEe', 'job_seeker', 'approved', NULL, '2026-04-07 17:33:05');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
