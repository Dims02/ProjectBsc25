-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: surveydb
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (30,33,'Yellow',1),(31,33,'Black',0),(32,33,'White',1),(42,43,'I have this option! Im correct.',1),(43,43,'And this one too! Im not.',0),(44,44,'Oh not correct!',0),(45,44,'I am!',1),(46,46,'No....',0),(47,46,'I did!',1),(48,47,'Yes – we have formal, management-approved policies and conduct regular risk assessments.',1),(49,47,'Partially – we have some informal or ad-hoc risk assessment processes.',0),(50,47,'No – we do not have any formal risk analysis or documented policies.',0),(57,52,'Yes – we have a comprehensive, documented plan that is regularly communicated and updated.',1),(58,52,'Partially – we have some guidelines in place, but they are not fully formalized or regularly reviewed.',0),(59,52,'No – we do not have a formal incident response plan.',0),(62,54,'Yes – we have a comprehensive, documented plan covering continuity, disaster recovery, and crisis management.',1),(63,54,'Partially – we have some procedures, but they are not fully formalized or comprehensive.',0),(64,54,'No – we do not have a formal business continuity or disaster recovery plan.',0),(65,56,'Yes – we have a scheduled review process for our cybersecurity policies.',1),(66,56,'Partially – reviews occur occasionally but not on a regular basis.',0),(67,56,'No – once established, the policies are rarely updated.',0),(68,57,'Use of intrusion detection/prevention systems (IDS/IPS) or network monitoring tools.',1),(69,57,'Deployment of Security Information and Event Management (SIEM) systems for log correlation.',1),(70,57,'Use of endpoint detection and response (EDR) solutions.',1),(71,57,'None of the above.',0),(72,58,'Yes – we conduct regular tests of our backup and recovery processes.',1),(73,58,'Partially – tests are conducted sporadically or not on a fixed schedule.',0),(74,58,'No – we do not perform regular testing of our backup and recovery procedures.',0),(75,59,'Yes – we conduct regular security assessments or audits of our critical vendors.',1),(76,59,'Partially – assessments are done occasionally or only for a few key suppliers.',0),(77,59,'No – we do not have a formal process to evaluate supplier cybersecurity.',0),(78,60,'Yes – all key supplier contracts include clear cybersecurity clauses and requirements.',1),(79,60,'Partially – only some contracts include basic security requirements, but it is not consistent across all vendors.',0),(80,60,'No – we do not typically include cybersecurity requirements in supplier contracts.',0),(81,61,'Yes – we regularly update our risk assessments for the supply chain, incorporating new threats and vendor performance reviews.',1),(82,61,'Partially – reviews occur, but not on a regular or systematic basis.',0),(83,61,'No – once the initial assessment is done, we rarely review or update our supply chain risk evaluations.',0),(84,62,'Following a Secure Development Life Cycle (SDLC) – incorporating security in system design from the start.',1),(85,62,'Regularly applying software patches and updates to address vulnerabilities in a timely manner.',1),(86,62,'Having a formal process for vulnerability management including identification, reporting, and remediation.',1),(87,62,'None of the above.',0),(88,63,'We conduct periodic reviews or audits of our security policies, procedures, and controls.',1),(89,63,'We use defined metrics or Key Performance Indicators (KPIs) to measure our security performance.',1),(90,63,'We conduct regular tests, such as security drills, penetration tests, or internal audits.',1),(91,63,'None of the above.',0),(92,64,'Yes – we regularly engage third-party audits or assessments.',1),(93,64,'Partially – we occasionally use external assessments, but not consistently.',0),(94,64,'No – we do not use external audits or assessments.',0),(95,65,'Regular cybersecurity awareness training for all employees.',1),(96,65,'Enforcing strong password policies with periodic changes.',1),(97,65,'Deploying endpoint protection and monitoring solutions.',1),(98,65,'None of the above.',0),(99,66,'Yes – training is provided on a regular basis.',1),(100,66,'Partially – training is provided, but not consistently across all employees.',0),(101,66,'No – cybersecurity training is not regularly provided.',0),(102,67,'Yes – we consistently encrypt sensitive data in transit (e.g., via VPNs, SSL/TLS) and at rest (e.g., disk or database encryption).',1),(103,67,'Partially – we encrypt data in one context (either in transit or at rest) but not consistently in both.',0),(104,67,'No – encryption is not consistently implemented for sensitive data.',0),(105,68,'Yes – all critical internal communications and remote access channels are secured using encryption.',1),(106,68,'Partially – some channels are encrypted, but not all critical communications are secured.',0),(107,68,'No – encryption is not used to secure internal communications or remote access.',0),(108,70,'Yes – we have a defined process that controls account creation, access adjustments, and timely revocation upon departure.',1),(109,70,'Partially – some procedures exist, but they are informal or inconsistently applied.',0),(110,70,'No – there is no standard process for managing user accounts during onboarding or offboarding.',0),(111,71,'Yes – we enforce strict access control policies and maintain a regularly updated inventory.',1),(112,71,'Partially – access controls or asset inventories exist but are not comprehensively enforced or maintained.',0),(113,71,'No – we do not actively manage user access or maintain an updated asset inventory.',0),(114,72,'Yes – MFA is enforced for all critical accounts and systems.',1),(115,72,'Partially – MFA is used for some systems, but not universally applied to all critical accesses.',0),(116,72,'No – users authenticate solely with a password (single factor).',0),(117,73,'At least once a year or whenever significant changes occur.',1),(118,73,'Only on an ad-hoc basis or after a security incident.',0),(119,73,'Rarely or never.',0),(120,74,'Yes – regular training sessions and updates are provided to all stakeholders.',1),(121,74,'Partially – only some groups receive periodic training or updates.',0),(122,74,'No – there is little to no formal communication or training on these policies.',0);
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_groups`
--

DROP TABLE IF EXISTS `question_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `recommendation` text DEFAULT NULL,
  `page` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `question_groups_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_groups`
--

LOCK TABLES `question_groups` WRITE;
/*!40000 ALTER TABLE `question_groups` DISABLE KEYS */;
INSERT INTO `question_groups` VALUES (9,14,'Understanding NIS2','',0),(16,25,'First meeting','You should always be sure before accusing someone....',0),(21,13,'Im the Title','And I have a recommendation',0),(88,25,'Certainty','We must always be sure we saw the crime happen',0),(91,14,'Risk Analysis & Policy Framework','To enhance compliance with NIS2 requirements, your organization should establish and maintain a robust cybersecurity policy framework. This includes documenting formal risk analysis procedures, scheduling regular reviews, and updating policies to reflect new threats and vulnerabilities. Additionally, conducting risk assessments on a regular basis and ensuring that all relevant stakeholders are well-informed and trained on these policies are key to a proactive risk management strategy. A well-defined and dynamic policy framework is the foundation of effective risk management.',5),(96,14,'Incident Handling & Response','To ensure effective incident handling under NIS2, it is crucial to develop and maintain a detailed incident response plan that defines clear roles, responsibilities, and procedures. Additionally, invest in detection and monitoring tools—such as IDS/IPS, SIEM, and EDR—to enable rapid identification and response to cybersecurity incidents. Regular testing and updating of these measures will further strengthen your organization\'s resilience.',1),(97,14,'Business Continuity & Crisis Management','For effective risk management, it\'s essential to have a robust business continuity and disaster recovery plan that specifically addresses cyber incidents. Regular testing of backup and restoration processes is critical to ensure that your organization can quickly recover from any disruption. Strengthening these areas will help maintain operational resilience during a cyber crisis.',2),(98,14,'Supply Chain Security','To enhance your compliance with NIS2 risk management standards, it is crucial to establish robust processes for supply chain security. Ensure that you conduct regular and systematic cybersecurity assessments of your key suppliers, include comprehensive cybersecurity requirements in all contracts, and periodically review and update your supply chain risk evaluations. Strengthening these practices will help reduce vulnerabilities originating from third-party relationships and improve overall resilience.',3),(100,14,'Secure System Acquisition, Development & Maintenance','If your organization has not yet adopted comprehensive secure development practices, we strongly recommend implementing a Secure Development Life Cycle (SDLC) that integrates security into every phase of system design, development, and maintenance. Additionally, ensure regular patch management and establish a formal vulnerability management process to promptly identify, report, and remediate security issues. These practices are crucial to reducing vulnerabilities and maintaining compliance with NIS2 risk management requirements.',4),(101,14,'Assessing Effectiveness of Security Measures','Regular reviews, defined metrics, and external audits are critical to ensure that your cybersecurity controls remain effective against evolving threats. Continuously testing and improving your security measures will help maintain compliance with NIS2 and minimize risk.',6),(102,14,'Basic Cyber Hygiene & Training','Implementing basic cyber hygiene practices and ensuring regular cybersecurity training for all employees is essential. By enforcing strong password policies, maintaining endpoint protection, and conducting ongoing awareness programs, you can significantly reduce the risk of cyber incidents.',7),(103,14,'Use of Cryptography & Encryption','Ensure that sensitive data is protected through encryption both in transit and at rest. Implementing strong cryptographic measures for communications and data storage is essential to safeguard against unauthorized access and comply with NIS2 requirements.',9),(104,14,'Human Resources Security & Access Control (Including MFA)','Implement formal onboarding/offboarding procedures, enforce least-privilege access policies, and require multi-factor authentication (MFA) for critical systems. These measures help reduce the risk of unauthorized access and ensure that user accounts are properly managed in compliance with NIS2.',8);
/*!40000 ALTER TABLE `question_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `question_groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (10,9,'<p>This survey assesses your organization&rsquo;s compliance with the <strong>NIS2</strong> Directive&rsquo;s risk management requirements.</p>\r\n<p>This survey is organized into <strong>nine sections</strong> (pages) covering key risk management areas under the NIS2 Directive. Each page presents multiple-choice question(s) related to that topic. If any answer is incorrect (indicating non-compliance), a Recommendation is provided to guide you on improving compliance. This recommendation will be available in the dashboard section.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>The survey is designed for large organizations but is also applicable to SMEs and public sector entities.</p>\r\n<p>&nbsp;</p>\r\n<p><strong><em data-end=\"844\" data-start=\"676\">(NIS2 requires measures appropriate to the entity&rsquo;s size, risk exposure, and impact, so answer according to your context.)</em></strong></p>'),(33,16,'Who did it????'),(43,21,'This is a question'),(44,21,'And this is another!'),(46,88,'Are you sure you saw someone kill????'),(47,91,'<p>Do you have <strong>formal</strong>, <strong>documented</strong> policies for cybersecurity risk analysis?</p>'),(52,96,'<p>Do you have a documented incident response plan that defines roles, responsibilities, and procedures for handling cybersecurity incidents?</p>'),(54,97,'<p>Does your organization have a formal business continuity and disaster recovery plan that includes strategies for cyber incidents?</p>'),(56,91,'<p>Are these policies <strong>regularly</strong> reviewed and updated to address evolving threats?</p>'),(57,96,'<p>Which of the following measures has your organization implemented to detect and respond to security incidents? (Select one that applies)</p>'),(58,97,'<p>Are your backup and recovery procedures regularly tested to ensure data and system restoration in case of an incident?</p>'),(59,98,'Do you evaluate the cybersecurity posture of your key suppliers and service providers?'),(60,98,'Are cybersecurity requirements (e.g., compliance with specific security standards, incident reporting obligations) included in contracts with your suppliers?'),(61,98,'Do you periodically review and update your supply chain risk assessments to address emerging threats?'),(62,100,'<p>Which secure development and maintenance practices has your organization adopted for its networks and information systems? (Select one that applies)</p>'),(63,101,'<p>How do you evaluate the effectiveness of your cybersecurity risk management measures? (Select all that apply)</p>'),(64,101,'<p>Do you engage external audits or third-party assessments to validate the effectiveness of your cybersecurity measures?</p>'),(65,102,'Which of the following basic cyber hygiene practices are implemented in your organization? (Select all that apply)'),(66,102,'Do you provide regular cybersecurity training to all employees?'),(67,103,'Do you implement encryption to protect sensitive data both in transit and at rest?'),(68,103,'Are internal communications and remote access channels secured using encryption (e.g., secure email, VPNs, encrypted messaging)?'),(70,104,'Do you have formal onboarding and offboarding procedures to manage user accounts, ensuring that access rights are granted and revoked appropriately?'),(71,104,'Does your organization enforce access control policies (such as least-privilege access) and maintain an updated inventory of assets and user accounts?'),(72,104,'Is Multi-Factor Authentication (MFA) required for access to critical systems and sensitive data?'),(73,91,'<p>How frequently does your organization conduct formal cybersecurity risk assessments?</p>'),(74,91,'<p>Are all relevant stakeholders (e.g., IT, management, and end-users) adequately <strong>informed</strong> and <strong>trained</strong> on the cybersecurity risk policies?</p>');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`),
  KEY `responses_ibfk_1` (`user_id`),
  CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `responses_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
INSERT INTO `responses` VALUES (25,20,47,'Partially – we have some informal or ad-hoc risk assessment processes.'),(26,21,47,'I do'),(29,20,52,'Yes – we have a comprehensive, documented plan that is regularly communicated and updated.'),(31,20,56,'Yes – we have a scheduled review process for our cybersecurity policies.'),(32,20,57,'Use of intrusion detection/prevention systems (IDS/IPS) or network monitoring tools.'),(33,20,54,'Yes – we have a comprehensive, documented plan covering continuity, disaster recovery, and crisis management.'),(34,20,58,'Yes – we conduct regular tests of our backup and recovery processes.'),(35,20,70,'No – there is no standard process for managing user accounts during onboarding or offboarding.'),(36,20,59,'Yes – we conduct regular security assessments or audits of our critical vendors.'),(37,20,60,'Yes – all key supplier contracts include clear cybersecurity clauses and requirements.'),(38,20,61,'Yes – we regularly update our risk assessments for the supply chain, incorporating new threats and vendor performance reviews.'),(39,20,62,'Following a Secure Development Life Cycle (SDLC) – incorporating security in system design from the start.'),(40,20,63,'We conduct periodic reviews or audits of our security policies, procedures, and controls.'),(41,20,73,'At least once a year or whenever significant changes occur.'),(42,20,74,'No – there is little to no formal communication or training on these policies.');
/*!40000 ALTER TABLE `responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `surveys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES (13,'GDPR','General Data Protection Regulation survey',NULL,'2025-02-24 18:21:06'),(14,'NIS2 Risk Management','European Union Directive 2022/2555 (NIS2)',NULL,'2025-02-24 18:21:06'),(15,'27001','Your opinion matters in our workplace.',NULL,'2025-02-24 18:21:06'),(25,'Among us meeting','We should decide who committed the crime....',NULL,'2025-03-04 20:24:13');
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entity` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (20,'UBI','Diogo','Silva','dimatos.silva@gmail.com','$2y$10$gemJlDmS9GGYJo8OsXTp8.P/60U5Za2eld1rp.SRV99hNXso3W5sy','Portugal','admin','2025-03-17 12:29:33'),(21,NULL,NULL,NULL,'joao.novais@ubi.pt','$2y$10$iyp9vVfMmNEl1Mr0E2Ovoexp3xZ9/sWBlov38ZtzcJos57ZmXjbwq',NULL,'user','2025-03-17 12:42:35');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-19 17:51:28
