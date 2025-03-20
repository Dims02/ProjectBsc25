/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: surveydb
-- ------------------------------------------------------
-- Server version	10.11.10-MariaDB

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
  CONSTRAINT `options_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=657 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES
(48,47,'Yes – we have formal, management-approved policies and conduct regular risk assessments.',1),
(49,47,'Partially – we have some informal or ad-hoc risk assessment processes.',0),
(50,47,'No – we do not have any formal risk analysis or documented policies.',0),
(57,52,'Yes – we have a comprehensive, documented plan that is regularly communicated and updated.',1),
(58,52,'Partially – we have some guidelines in place, but they are not fully formalized or regularly reviewed.',0),
(59,52,'No – we do not have a formal incident response plan.',0),
(62,54,'Yes – we have a comprehensive, documented plan covering continuity, disaster recovery, and crisis management.',1),
(63,54,'Partially – we have some procedures, but they are not fully formalized or comprehensive.',0),
(64,54,'No – we do not have a formal business continuity or disaster recovery plan.',0),
(65,56,'Yes – we have a scheduled review process for our cybersecurity policies.',1),
(66,56,'Partially – reviews occur occasionally but not on a regular basis.',0),
(67,56,'No – once established, the policies are rarely updated.',0),
(68,57,'Use of intrusion detection/prevention systems (IDS/IPS) or network monitoring tools.',1),
(69,57,'Deployment of Security Information and Event Management (SIEM) systems for log correlation.',1),
(70,57,'Use of endpoint detection and response (EDR) solutions.',1),
(71,57,'None of the above.',0),
(72,58,'Yes – we conduct regular tests of our backup and recovery processes.',1),
(73,58,'Partially – tests are conducted sporadically or not on a fixed schedule.',0),
(74,58,'No – we do not perform regular testing of our backup and recovery procedures.',0),
(75,59,'Yes – we conduct regular security assessments or audits of our critical vendors.',1),
(76,59,'Partially – assessments are done occasionally or only for a few key suppliers.',0),
(77,59,'No – we do not have a formal process to evaluate supplier cybersecurity.',0),
(78,60,'Yes – all key supplier contracts include clear cybersecurity clauses and requirements.',1),
(79,60,'Partially – only some contracts include basic security requirements, but it is not consistent across all vendors.',0),
(80,60,'No – we do not typically include cybersecurity requirements in supplier contracts.',0),
(81,61,'Yes – we regularly update our risk assessments for the supply chain, incorporating new threats and vendor performance reviews.',1),
(82,61,'Partially – reviews occur, but not on a regular or systematic basis.',0),
(83,61,'No – once the initial assessment is done, we rarely review or update our supply chain risk evaluations.',0),
(84,62,'Following a Secure Development Life Cycle (SDLC) – incorporating security in system design from the start.',1),
(85,62,'Regularly applying software patches and updates to address vulnerabilities in a timely manner.',1),
(86,62,'Having a formal process for vulnerability management including identification, reporting, and remediation.',1),
(87,62,'None of the above.',0),
(88,63,'We conduct periodic reviews or audits of our security policies, procedures, and controls.',1),
(89,63,'We use defined metrics or Key Performance Indicators (KPIs) to measure our security performance.',1),
(90,63,'We conduct regular tests, such as security drills, penetration tests, or internal audits.',1),
(91,63,'None of the above.',0),
(92,64,'Yes – we regularly engage third-party audits or assessments.',1),
(93,64,'Partially – we occasionally use external assessments, but not consistently.',0),
(94,64,'No – we do not use external audits or assessments.',0),
(95,65,'Regular cybersecurity awareness training for all employees.',1),
(96,65,'Enforcing strong password policies with periodic changes.',1),
(97,65,'Deploying endpoint protection and monitoring solutions.',1),
(98,65,'None of the above.',0),
(99,66,'Yes – training is provided on a regular basis.',1),
(100,66,'Partially – training is provided, but not consistently across all employees.',0),
(101,66,'No – cybersecurity training is not regularly provided.',0),
(102,67,'Yes – we consistently encrypt sensitive data in transit (e.g., via VPNs, SSL/TLS) and at rest (e.g., disk or database encryption).',1),
(103,67,'Partially – we encrypt data in one context (either in transit or at rest) but not consistently in both.',0),
(104,67,'No – encryption is not consistently implemented for sensitive data.',0),
(105,68,'Yes – all critical internal communications and remote access channels are secured using encryption.',1),
(106,68,'Partially – some channels are encrypted, but not all critical communications are secured.',0),
(107,68,'No – encryption is not used to secure internal communications or remote access.',0),
(108,70,'Yes – we have a defined process that controls account creation, access adjustments, and timely revocation upon departure.',1),
(109,70,'Partially – some procedures exist, but they are informal or inconsistently applied.',0),
(110,70,'No – there is no standard process for managing user accounts during onboarding or offboarding.',0),
(111,71,'Yes – we enforce strict access control policies and maintain a regularly updated inventory.',1),
(112,71,'Partially – access controls or asset inventories exist but are not comprehensively enforced or maintained.',0),
(113,71,'No – we do not actively manage user access or maintain an updated asset inventory.',0),
(114,72,'Yes – MFA is enforced for all critical accounts and systems.',1),
(115,72,'Partially – MFA is used for some systems, but not universally applied to all critical accesses.',0),
(116,72,'No – users authenticate solely with a password (single factor).',0),
(117,73,'At least once a year or whenever significant changes occur.',1),
(118,73,'Only on an ad-hoc basis or after a security incident.',0),
(119,73,'Rarely or never.',0),
(120,74,'Yes – regular training sessions and updates are provided to all stakeholders.',1),
(121,74,'Partially – only some groups receive periodic training or updates.',0),
(122,74,'No – there is little to no formal communication or training on these policies.',0),
(123,75,'Regularly (e.g., quarterly or semi-annually).',1),
(124,75,'Only after a significant security incident.',0),
(125,75,'Rarely or never.',0),
(126,76,'Yes – we maintain detailed records that are regularly reviewed and updated.',1),
(127,76,'Partially – records exist but are not systematically maintained or reviewed.',0),
(128,76,'No – we do not maintain a comprehensive log.',0),
(129,77,'Annually or more frequently.',1),
(130,77,'Less than once a year.',0),
(131,77,'Only when a security incident occurs.',0),
(132,78,'Yes – we have formal assessments and feedback mechanisms in place.',0),
(133,78,'Partially – we collect some feedback, but lack a structured evaluation process.',0),
(134,78,'No – we do not evaluate the effectiveness of our training programs.',0),
(138,80,'At least quarterly or semi-annually.',1),
(139,80,'Annually only.',0),
(140,80,'Rarely or never.',0),
(141,81,'Yes – we conduct thorough background checks and specialized security training regularly.',0),
(142,81,'Partially – background checks or specialized training are conducted, but not both consistently.',0),
(143,81,'No – we do not have formal background checks or specialized training for sensitive roles.',0),
(144,82,'At least once a year or whenever significant changes occur.',1),
(145,82,'Only on an ad-hoc basis or after a security incident.',0),
(146,82,'Rarely or never.',0),
(147,83,'Yes – regular training sessions and updates are provided to all stakeholders.',0),
(148,83,'Partially – only some groups receive periodic training or updates.',0),
(149,83,'No – there is little to no formal communication or training on these policies.',0),
(150,84,'Regularly (e.g., annually or semi-annually).',1),
(151,84,'Occasionally or only after a major incident.',0),
(152,84,'Rarely or never.',0),
(153,85,'Yes – a dedicated team is in place with clearly defined roles and responsibilities.',1),
(154,85,'Partially – responsibilities are assigned on an ad hoc basis without a formal team structure.',0),
(155,85,'No – there is no dedicated crisis management team.',0),
(156,86,'Yes – regular, structured security testing is integrated into the development process.',1),
(157,86,'Partially – security testing is performed, but not consistently across all projects.',0),
(158,86,'No – security testing is rarely or never performed during development.',0),
(400,300,'Yes, we have a fully documented consent process.',1),
(401,300,'We have an informal process in place.',0),
(402,300,'No, we do not have a documented process.',0),
(403,301,'Yes, clear information is provided at the point of data collection.',1),
(404,301,'Information is provided inconsistently.',0),
(405,301,'No, data subjects are not provided with sufficient information.',0),
(406,302,'Yes, consent records are securely stored and maintained.',1),
(407,302,'Records are maintained but not securely.',0),
(408,302,'No, consent is not properly recorded.',0),
(409,303,'Yes, robust security measures including encryption are in place.',1),
(410,303,'Some measures are in place, but improvements are needed.',0),
(411,303,'No, adequate security measures are not implemented.',0),
(412,304,'Yes, access controls and authentication mechanisms are regularly reviewed.',1),
(413,304,'Reviews occur only occasionally.',0),
(414,304,'No, there is no regular review process.',0),
(415,305,'Yes, data processing strictly adheres to documented procedures.',1),
(416,305,'Processing is sometimes aligned with procedures, but inconsistently.',0),
(417,305,'No, there is no adherence to documented procedures.',0),
(418,306,'Yes, comprehensive procedures exist for data access, rectification, and erasure.',1),
(419,306,'Procedures exist but are not clearly communicated to data subjects.',0),
(420,306,'No, such procedures are not in place.',0),
(421,307,'Yes, mechanisms for data portability and objection are fully implemented.',1),
(422,307,'Mechanisms are in place but are limited in scope.',0),
(423,307,'No, there are no mechanisms for these rights.',0),
(424,308,'Yes, information about data processing is provided promptly upon request.',1),
(425,308,'Information is provided, but not in a timely manner.',0),
(426,308,'No, there is no defined process for providing such information.',0),
(427,309,'Yes, we have a comprehensive incident response and breach notification plan.',1),
(428,309,'A plan exists but does not meet the 72-hour notification requirement.',0),
(429,309,'No, we do not have a breach notification plan.',0),
(430,310,'Yes, breach notifications are clear and sent in a timely manner.',1),
(431,310,'Notifications are sent but lack clarity.',0),
(432,310,'No, breach notifications are inadequate.',0),
(433,311,'Yes, regular training and reviews are conducted.',1),
(434,311,'Training is provided, but not on a regular basis.',0),
(435,311,'No, there is no regular training on breach notification procedures.',0),
(500,310,'Yes, we use an automated system that sends immediate alerts.',1),
(501,310,'We have some automated processes, but they are not fully integrated.',0),
(502,310,'No, incident detection is entirely manual.',0),
(503,311,'Yes, a dedicated team verifies incidents within 15 minutes.',1),
(504,311,'Verification occurs, but not within the 15-minute window.',0),
(505,311,'No, incidents are not promptly verified by a dedicated team.',0),
(536,322,'Annually',1),
(537,322,'Bi-annually',0),
(538,322,'No fixed schedule',0),
(539,323,'Yes, on a regular basis',1),
(540,323,'Occasionally, but not systematically',0),
(541,323,'No, penetration testing is not conducted',0),
(542,324,'Yes, all requests are resolved within 30 days',1),
(543,324,'Most requests are resolved within the timeframe',0),
(544,324,'No, requests often exceed the mandated timeframe',0),
(545,325,'Yes, a dedicated team meets regularly',1),
(546,325,'There is a team, but meetings are infrequent',0),
(547,325,'No, there is no designated breach response team',0),
(548,327,'Yes, a comprehensive data retention policy exists.',1),
(549,327,'A policy exists but needs improvement.',0),
(550,327,'No, there is no formal data retention policy.',0),
(551,328,'Yes, regular reviews and deletions are performed.',1),
(552,328,'Review is performed inconsistently.',0),
(553,328,'No, personal data is retained indefinitely.',0),
(554,329,'Yes, all third-party contracts include clear data protection clauses.',1),
(555,329,'Contracts exist, but they are vague on data protection.',0),
(556,329,'No, there are no formal contracts regarding data protection.',0),
(557,330,'Yes, all international transfers comply with GDPR safeguards.',1),
(558,330,'Some transfers comply, but not consistently.',0),
(559,330,'No, transfers do not meet GDPR requirements.',0),
(597,345,'Yes, an automated system is in place',1),
(598,345,'Partially, but with delays',0),
(599,345,'No, detection is manual',0),
(600,346,'Yes, verified within 15 minutes',1),
(601,346,'Verification occurs but not within 15 minutes',0),
(602,346,'No, verification is delayed or absent',0),
(603,347,'Yes, a clear protocol exists',1),
(604,347,'There is an informal process',0),
(605,347,'No, there is no predefined protocol',0),
(606,348,'Yes, fully integrated',1),
(607,348,'Partially integrated',0),
(608,348,'No, not integrated',0),
(609,349,'Yes, notifications are immediate',1),
(610,349,'Notifications occur with some delay',0),
(611,349,'No, there is no established process',0),
(612,350,'Yes, a clear escalation path exists',1),
(613,350,'There is an escalation path, but it is not clearly defined',0),
(614,350,'No, there is no escalation process',0),
(615,351,'Yes, roles are clearly defined',1),
(616,351,'Roles exist but are not clearly communicated',0),
(617,351,'No, roles are unclear',0),
(618,352,'Yes, there is a dedicated portal',1),
(619,352,'A portal exists but with limited functionality',0),
(620,352,'No, there is no dedicated portal',0),
(621,353,'Yes, procedures are in place',1),
(622,353,'Procedures exist but sometimes exceed timelines',0),
(623,353,'No, external notifications are not reliably made',0),
(624,354,'Yes, all notifications are reviewed',1),
(625,354,'Review occurs, but inconsistently',0),
(626,354,'No, notifications are not reviewed',0),
(627,355,'Yes, a dedicated team is in place',1),
(628,355,'A team exists but shares responsibilities with others',0),
(629,355,'No, external notifications are handled ad hoc',0),
(630,356,'Yes, templates are in place',1),
(631,356,'Templates exist but are seldom used',0),
(632,356,'No, there are no pre-approved templates',0),
(633,357,'Yes, formal reviews are conducted',1),
(634,357,'Reviews are informal or inconsistent',0),
(635,357,'No, reviews are not conducted',0),
(636,358,'Yes, lessons learned are systematically applied',1),
(637,358,'Some lessons are applied',0),
(638,358,'No, lessons learned are not used',0),
(639,359,'Yes, feedback is actively collected and acted upon',1),
(640,359,'Feedback is collected but rarely acted upon',0),
(641,359,'No, stakeholder feedback is not collected',0),
(642,360,'Yes, meetings are scheduled promptly',1),
(643,360,'Meetings are scheduled but sometimes delayed',0),
(644,360,'No, meetings are not regularly scheduled',0),
(645,361,'Yes, a formal process exists',1),
(646,361,'A process exists but is inconsistently applied',0),
(647,361,'No, there is no formal process',0),
(648,362,'Yes, lessons are systematically documented and reviewed',1),
(649,362,'They are documented but not regularly reviewed',0),
(650,362,'No, documentation is ad hoc',0),
(651,363,'Yes, a formal follow-up mechanism is in place',1),
(652,363,'There is an informal process for follow-up',0),
(653,363,'No, there is no follow-up mechanism',0),
(654,364,'Yes, regular audits are conducted',1),
(655,364,'Audits are sporadic and informal',0),
(656,364,'No, audits are not conducted',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=227 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_groups`
--

LOCK TABLES `question_groups` WRITE;
/*!40000 ALTER TABLE `question_groups` DISABLE KEYS */;
INSERT INTO `question_groups` VALUES
(9,14,'Understanding NIS2','',0),
(91,14,'Risk Analysis & Policy Framework','A robust framework for risk analysis and policy formulation is vital. It should be established through formal documentation, regular reviews, and effective communication to ensure that cybersecurity risks are systematically identified and addressed.',5),
(96,14,'Incident Handling & Response','Establish a comprehensive cybersecurity policy framework that includes formalized risk analysis procedures, scheduled reviews, and structured communication with all relevant stakeholders. This approach is fundamental for effective risk management and for ensuring alignment with NIS2 regulatory requirements.\r\n',1),
(97,14,'Business Continuity & Crisis Management','It is recommended to establish a robust business continuity and disaster recovery plan that specifically addresses cyber incidents. Regular testing of backup and restoration procedures is essential to ensure swift recovery and maintain operational resilience.\r\n',2),
(98,14,'Supply Chain Security','A robust process for supply chain security should be established, incorporating systematic assessments of key suppliers, clear cybersecurity requirements in all contracts, and periodic reviews of risk evaluations to address emerging threats.\r\n',3),
(100,14,'Secure System Acquisition, Development & Maintenance','A robust approach to secure system acquisition, development, and maintenance should be established. Security must be integrated throughout the system lifecycle, including secure development practices, prompt patch management, and a formal vulnerability management process to mitigate risks and satisfy NIS2 requirements.\r\n',4),
(101,14,'Assessing Effectiveness of Security Measures','A structured approach to evaluating the effectiveness of cybersecurity measures is essential. This should include periodic reviews, the use of defined metrics, and engagement with external audits or assessments. Continuous improvement through documented testing and follow-up actions ensures that security controls remain effective against evolving threats.\r\n',6),
(102,14,'Basic Cyber Hygiene & Training','Establish a comprehensive basic cyber hygiene and training program that incorporates regular cybersecurity awareness sessions, the enforcement of strong password policies, and robust endpoint protection. This approach is essential for mitigating common cyber threats and maintaining a secure operational environment.\r\n',7),
(103,14,'Use of Cryptography & Encryption','Ensure that sensitive data is protected through encryption both in transit and at rest. Implementing strong cryptographic measures for communications and data storage is essential to safeguard against unauthorized access and comply with NIS2 requirements.',9),
(104,14,'Human Resources Security & Access Control ','A formal framework for managing user access and identities should be established. This includes implementing structured onboarding and offboarding procedures, enforcing least-privilege access policies, maintaining an updated asset and account inventory, and requiring multi-factor authentication for critical systems. Such measures are essential to enhance security and mitigate unauthorized access.',8),
(200,100,'Data Collection and Consent','It is imperative that your organization implements a thoroughly documented and transparent data collection process. This should include robust mechanisms for obtaining explicit, informed consent from data subjects, ensuring they fully understand the purposes and scope of data collection. Such an approach not only reinforces legal compliance with GDPR but also builds trust with stakeholders.',1),
(201,100,'Data Security and Processing','Implement comprehensive and robust technical and organizational security measures. All data processing activities should be carried out with the utmost attention to data integrity and confidentiality. Regular reviews of access controls and authentication protocols must be performed to prevent unauthorized access and mitigate risks, ensuring alignment with GDPR standards.',2),
(202,100,'Data Subject Rights','Establish clear, accessible, and efficient procedures that enable data subjects to exercise their rights. Your organization must ensure that mechanisms for accessing, rectifying, and erasing personal data are not only fully compliant with GDPR but are also user-friendly and timely, thereby enhancing transparency and maintaining trust.',3),
(203,100,'Breach Notification and Accountability','Develop and maintain a detailed incident response plan that encompasses prompt breach notifications, comprehensive training, and regular reviews. This plan should ensure accountability and continuous improvement in your data protection practices, thereby fully satisfying GDPR breach notification requirements.',4),
(214,100,'Data Retention and Minimization','Ensure that data is retained only for as long as necessary and minimized to what is required.',5),
(215,100,'Third-Party Processing and International Transfers','Review your data sharing practices with third parties and ensure international transfers comply with GDPR.',6),
(217,100,'Understanding GDPR','',0),
(221,111,'Understanding the survey','',0),
(222,111,'Initial Incident Detection and Notification','Implement automated detection and predefined protocols to ensure rapid incident identification and immediate alerting of relevant teams.',1),
(223,111,'Internal Communication and Escalation','Establish clear internal communication channels and escalation paths to mobilize response teams without delay.',2),
(224,111,'External Communication and Stakeholder Notification','Ensure that external notifications (to regulators, clients, and partners) are clear, timely, and legally compliant.',3),
(225,111,'Post Incident Review and Improvement','Conduct formal reviews and gather stakeholder feedback to continuously improve incident communication protocols.',4),
(226,111,'Post Incident Analysis and Recovery','A structured process for post-incident analysis is crucial to identify root causes and implement corrective actions, leading to continuous improvement in incident response and recovery procedures.',5);
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
  `recommendation` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `question_groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=365 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES
(10,9,'<p>This survey assesses your organization&rsquo;s compliance with the <strong>NIS2</strong> Directive&rsquo;s risk management requirements.</p>\r\n<p>This survey is organized into <strong>nine sections</strong> (pages) covering key risk management areas under the NIS2 Directive. Each page presents multiple-choice question(s) related to that topic. If any answer is incorrect (indicating non-compliance), a Recommendation is provided to guide you on improving compliance. This recommendation will be available in the dashboard section.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>The survey is designed for large organizations but is also applicable to SMEs and public sector entities.</p>\r\n<p>&nbsp;</p>\r\n<p><strong><em data-end=\"844\" data-start=\"676\">(NIS2 requires measures appropriate to the entity&rsquo;s size, risk exposure, and impact, so answer according to your context.)</em></strong></p>','Reco test'),
(47,91,'<p>Do you have <strong>formal</strong>, <strong>documented</strong> policies for cybersecurity risk analysis?</p>','Establish and document formal risk analysis policies to provide a clear foundation for systematically identifying and managing cybersecurity risks.'),
(52,96,'<p>Do you have a documented incident response plan that defines roles, responsibilities, and procedures for handling cybersecurity incidents?</p>','Develop and formalize documented policies for cybersecurity risk analysis. Clear, management-approved documentation provides a solid foundation for systematic risk identification and measurement.'),
(54,97,'<p>Does your organization have a formal business continuity and disaster recovery plan that includes strategies for cyber incidents?</p>','It is recommended to establish a comprehensive business continuity and disaster recovery plan that addresses cyber incidents. Regular testing of backup and restoration procedures is critical to ensure that systems and data can be quickly restored following an incident.'),
(56,91,'<p>Are these policies <strong>regularly</strong> reviewed and updated to address evolving threats?</p>','Implement a structured review process to ensure that cybersecurity policies remain current and effectively address new threats as they emerge.'),
(57,96,'<p>Which of the following measures has your organization implemented to detect and respond to security incidents? (Select one that applies)</p>','Implement a regular review and update process for cybersecurity policies to ensure they remain current and are promptly adjusted in response to emerging threats.'),
(58,97,'<p>Are your backup and recovery procedures regularly tested to ensure data and system restoration in case of an incident?</p>','A consistent testing schedule for backup and recovery procedures should be implemented. Regular tests are essential to verify that systems and data can be promptly restored after an incident, ensuring minimal disruption and rapid recovery.'),
(59,98,'<p>Do you evaluate the cybersecurity posture of your key suppliers and service providers?</p>','Establish a formal procedure for routinely assessing the cybersecurity posture of key suppliers and service providers to proactively identify and mitigate vulnerabilities.'),
(60,98,'<p>Are cybersecurity requirements (e.g., compliance with specific security standards, incident reporting obligations) included in contracts with your suppliers?</p>','Ensure that comprehensive cybersecurity requirements are integrated into all supplier contracts to guarantee that third parties adhere to necessary security standards.'),
(61,98,'<p>Do you periodically review and update your supply chain risk assessments to address emerging threats?</p>','Implement a consistent review process for supply chain risk assessments to promptly address changes in the threat landscape and vendor performance.'),
(62,100,'<p>Which secure development and maintenance practices has your organization adopted for its networks and information systems? (Select one that applies)</p>','Comprehensive secure development and maintenance practices should be integrated into the system lifecycle. This includes implementing an SDLC, ensuring timely patch updates, and establishing a formal vulnerability management process to promptly address potential security issues.'),
(63,101,'<p>How do you evaluate the effectiveness of your cybersecurity risk management measures? (Select all that apply)</p>','Establish a systematic process for evaluating security measures that includes audits, defined metrics, and regular tests. This approach helps ensure that cybersecurity controls remain robust and responsive to emerging threats.'),
(64,101,'<p>Do you engage external audits or third-party assessments to validate the effectiveness of your cybersecurity measures?</p>','Incorporate external audits or third-party assessments into the evaluation process to gain objective insights into security effectiveness and identify areas for improvement.'),
(65,102,'<p>Which of the following basic cyber hygiene practices are implemented in your organization? (Select all that apply)</p>','Ensure the implementation of structured cyber hygiene practices by consistently providing regular training, enforcing strict password policies, and deploying effective endpoint protection measures to safeguard against common cyber risks.'),
(66,102,'<p>Do you provide regular cybersecurity training to all employees?</p>','Maintain a consistent schedule for cybersecurity training for all employees to continuously enhance awareness, update knowledge on emerging threats, and ensure that security best practices are effectively communicated throughout the organization.'),
(67,103,'<p>Do you implement encryption to protect sensitive data both in transit and at rest?</p>','Encryption should be applied uniformly to all sensitive data, both during transmission and while stored, to ensure robust protection against unauthorized access and data breaches.'),
(68,103,'<p>Are internal communications and remote access channels secured using encryption (e.g., secure email, VPNs, encrypted messaging)?</p>','Secure all internal communications and remote access channels with robust encryption methods to protect sensitive information from interception and unauthorized access.'),
(70,104,'<p>Do you have formal onboarding and offboarding procedures to manage user accounts, ensuring that access rights are granted and revoked appropriately?</p>','Establish a clear and consistent process for onboarding and offboarding that ensures access rights are properly granted and revoked. This is crucial for maintaining secure user account management.'),
(71,104,'<p>Does your organization enforce access control policies (such as least-privilege access) and maintain an updated inventory of assets and user accounts?</p>','Ensure that robust access control policies are in place and that an up-to-date inventory of all assets and user accounts is maintained. This helps limit access to only those who need it and reduces potential vulnerabilities.'),
(72,104,'<p>Is Multi-Factor Authentication (MFA) required for access to critical systems and sensitive data?</p>','Implement MFA across all critical systems and sensitive data access points. This additional layer of security significantly reduces the risk of unauthorized access and enhances overall system security.'),
(73,91,'<p>How frequently does your organization conduct formal cybersecurity risk assessments?</p>','Conduct formal risk assessments on a regular basis, ideally annually or following significant operational changes, to proactively identify and mitigate cybersecurity risks.'),
(74,91,'<p>Are all relevant stakeholders (e.g., IT, management, and end-users) adequately <strong>informed</strong> and <strong>trained</strong> on the cybersecurity risk policies?</p>','Ensure that structured and comprehensive training programs are in place for all relevant stakeholders to enhance understanding and effective implementation of cybersecurity policies.'),
(75,101,'<p>How frequently are your security metrics and controls reviewed and updated?</p>','Implement a consistent review cycle for security metrics and controls, such as quarterly or semi-annually, to ensure that cybersecurity measures are continually optimized in response to new threats.'),
(76,101,'<p>Do you maintain a comprehensive, documented log of all security assessments, test results, and follow-up actions?</p>','Keep a thorough, documented log of all security assessments, test outcomes, and corrective actions. This documentation is critical for tracking improvements over time and ensuring accountability in the risk management process.'),
(77,102,'<p>How often is cybersecurity awareness training provided to employees?</p>','Provide cybersecurity awareness training on a regular basis (e.g., annually or more frequently) to ensure that all employees remain updated on emerging threats and best practices.'),
(78,102,'<p>Do you have a formal evaluation process to measure the effectiveness of your cybersecurity training programs?</p>','Implement a formal evaluation process to measure the effectiveness of cybersecurity training programs. This process should include assessments and feedback mechanisms to continuously refine and improve training content.'),
(80,103,'<p>How frequently are user access rights and privileges reviewed to ensure they adhere to the principle of least privilege?</p>','User access rights and privileges should be reviewed on a frequent schedule, such as quarterly or semi-annually, to ensure adherence to the principle of least privilege and to minimize potential security risks.'),
(81,103,'<p>Do you conduct periodic background checks and provide specialized security training for employees in sensitive or privileged roles?</p>','Periodic background checks and specialized security training for employees in sensitive or privileged roles are essential to mitigate insider risks and ensure that those with elevated access are well-prepared to manage security responsibilities.'),
(82,96,'<p>How frequently does your organization conduct formal cybersecurity risk assessments?</p>','Adopt a consistent schedule for conducting formal cybersecurity risk assessments—ideally on an annual basis or following significant operational changes—to maintain a proactive risk management posture.'),
(83,96,'<p>Are all relevant stakeholders (e.g., IT, management, and end-users) adequately informed and trained on the cybersecurity risk policies?</p>','Ensure that all relevant stakeholders, including IT personnel, management, and end-users, receive structured and ongoing training on cybersecurity risk policies. Formalized communication and training are vital for fostering a culture of security awareness and ensuring effective policy implementation.'),
(84,97,'<p>How frequently are your business continuity and disaster recovery plans tested?</p>','It is recommended to test business continuity and disaster recovery plans on a regular schedule, such as annually or semi-annually. Regular tests ensure that procedures are effective, gaps are identified, and timely corrective actions can be taken.'),
(85,97,'<p>Is there a dedicated crisis management team with clearly defined roles and responsibilities to handle cybersecurity incidents that affect business continuity?</p>','A dedicated crisis management team with clearly defined roles and responsibilities should be established. This ensures a coordinated and efficient response during cybersecurity incidents, thereby minimizing disruptions and enhancing overall operational resilience.'),
(86,100,'<p>Do you conduct regular security testing&mdash;such as code reviews, penetration tests, or static code analysis&mdash;during the system development process?</p>','Incorporating structured security testing during development helps identify and remediate vulnerabilities early. It is essential to integrate regular code reviews, penetration tests, and static analysis into the development process to ensure that the system is secure before deployment.'),
(300,200,'<p>Does your organization have a documented process for obtaining explicit consent for data collection?</p>','Formalizing your consent process is essential to ensure that all data subjects provide explicit, informed agreement for the collection of their personal data. A well-documented process will not only strengthen your legal compliance but also enhance trust among stakeholders by clearly communicating data usage purposes.'),
(301,200,'<p>Are data subjects provided with clear and comprehensive information about the purpose and scope of data collection at the time of consent?</p>','Ensure that all communications regarding data collection are thorough and unambiguous. Providing clear, comprehensive information at the time of data collection helps uphold transparency, making it easier for data subjects to understand the purpose and scope of data usage.'),
(302,200,'<p>Is consent recorded and stored securely for future reference and audit purposes?</p>','Secure record-keeping is vital for demonstrating compliance. Ensure that all consent records are stored safely and maintained over time so that they can be readily produced during audits or compliance reviews, thereby reinforcing your adherence to GDPR standards.'),
(303,201,'Do you have technical and organizational measures in place to ensure the integrity and confidentiality of personal data during processing?','Implement strong security controls, including state-of-the-art encryption and rigorous access management protocols, to ensure the integrity and confidentiality of personal data during processing. This proactive approach minimizes risks and underpins your overall data security strategy.'),
(304,201,'Are access controls and authentication mechanisms regularly reviewed and updated to prevent unauthorized access?','Regularly reviewing and updating your access controls and authentication mechanisms is crucial for preventing unauthorized access. This ongoing vigilance not only mitigates potential risks but also supports a robust security framework in compliance with GDPR.'),
(305,201,'Is personal data processed only for legitimate purposes in accordance with documented procedures?','Ensure that all data processing activities are conducted strictly in accordance with documented, lawful purposes. Adherence to established procedures is key to maintaining data protection standards and minimizing the risk of non-compliance under GDPR.'),
(306,202,'Does your organization have procedures that allow data subjects to access, rectify, or erase their personal data upon request?','Establish and clearly document procedures that enable data subjects to access, rectify, or erase their personal data upon request. A well-structured process empowers data subjects and reinforces your commitment to GDPR compliance.'),
(307,202,'Are there mechanisms in place to facilitate data portability and allow data subjects to object to certain processing activities?','Ensure that your systems support data portability and that robust mechanisms are in place to accommodate objections to data processing. This comprehensive approach reinforces the rights of data subjects and aligns with GDPR mandates.'),
(308,202,'Is there a process to provide data subjects with information about data processing activities in a timely manner?','Providing timely and detailed information about data processing activities is essential for maintaining transparency and accountability. This practice not only meets regulatory requirements but also builds confidence among data subjects.'),
(309,203,'Does your organization have an incident response plan that includes procedures for notifying supervisory authorities within 72 hours of a data breach?','Develop a comprehensive incident response plan that includes protocols for prompt notification of supervisory authorities within 72 hours of a data breach. This ensures swift action, minimizes potential harm, and upholds regulatory standards.'),
(310,203,'Are breach notifications communicated to affected data subjects in a clear and timely manner?','Breach notifications should be clear, concise, and delivered without delay. Ensure that all affected data subjects are informed promptly in a manner that is both legally compliant and transparent, thereby maintaining trust and accountability.'),
(311,203,'Is there regular training and review of breach notification procedures for relevant staff?','Conduct regular training sessions and simulation exercises to ensure that your team is well-prepared to manage data breaches. Ongoing education and drills are critical for minimizing damage and refining your response strategy.'),
(322,200,'How often is the consent mechanism reviewed to incorporate changes in legal requirements?','Regular reviews help ensure that the consent mechanism remains compliant with evolving regulations.'),
(323,201,'Do you conduct regular penetration testing to evaluate the effectiveness of your security measures?','Regular testing is essential for identifying vulnerabilities and strengthening security controls.'),
(324,202,'Are data subject requests resolved within the legally mandated timeframe?','Timely resolution of data subject requests is critical for compliance and for maintaining trust with data subjects.'),
(325,203,'Is there a designated breach response team that meets periodically to review and update incident response protocols?','A dedicated breach response team ensures that lessons learned are integrated into improved incident response procedures.'),
(327,214,'Do you have a documented data retention policy that defines the retention period for different categories of personal data?','A documented policy helps ensure compliance with data minimization principles.'),
(328,214,'Is personal data regularly reviewed and deleted when no longer necessary for the purpose it was collected?','Regular reviews help maintain data minimization and reduce risks.'),
(329,215,'Do you have contracts in place with third parties that clearly define data protection obligations?','Contracts with third parties should specify clear data protection responsibilities.'),
(330,215,'Are international transfers of personal data conducted in compliance with GDPR requirements, such as using standard contractual clauses or approved mechanisms?','Ensure that international transfers are governed by appropriate safeguards.'),
(331,217,'<p data-start=\"0\" data-end=\"116\">This survey assesses your organization&rsquo;s compliance with the <strong>General Data Protection Regulation (GDPR)</strong> requirements.</p>\r\n<p data-start=\"0\" data-end=\"116\">&nbsp;</p>\r\n<p data-start=\"118\" data-end=\"477\">This survey is organized into multiple sections (pages) covering key data protection areas under GDPR. Each page presents multiple-choice question(s) related to that topic. If any answer is incorrect (indicating non-compliance), a Recommendation is provided to guide you on improving compliance. This recommendation will be available in the <strong>dashboard section</strong>.</p>\r\n<p data-start=\"118\" data-end=\"477\">&nbsp;</p>\r\n<p data-start=\"479\" data-end=\"584\">The survey is designed for large organizations but is also applicable to SMEs and public sector entities.</p>\r\n<p data-start=\"479\" data-end=\"584\">&nbsp;</p>\r\n<p data-start=\"586\" data-end=\"730\" data-is-last-node=\"\" data-is-only-node=\"\">(GDPR requires measures appropriate to the entity&rsquo;s data processing operations, risk exposure, and impact, so answer according to your context.)</p>',''),
(344,221,'<p>This survey assesses your organization&rsquo;s compliance with the <strong>NIS2</strong> Incident Notification requirements.</p>\r\n<p>This survey is organized into <strong>five sections</strong> (pages) covering key risk management areas under the NIS2 Directive. Each page presents multiple-choice question(s) related to that topic. If any answer is incorrect (indicating non-compliance), a Recommendation is provided to guide you on improving compliance. This recommendation will be available in the dashboard section.&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>The survey is designed for large organizations but is also applicable to SMEs and public sector entities.</p>\r\n<p>&nbsp;</p>\r\n<p><strong><em data-end=\"844\" data-start=\"676\">(NIS2 requires measures appropriate to the entity&rsquo;s size, risk exposure, and impact, so answer according to your context.)</em></strong></p>',''),
(345,222,'Do you have an automated incident detection system that triggers immediate alerts when unusual activity is detected?','Implementing an automated detection system minimizes delays and ensures prompt incident response.'),
(346,222,'Are incidents verified by a dedicated incident response team within the first 15 minutes of detection?','Rapid verification ensures that alerts are accurate and actionable.'),
(347,222,'Is there a predefined protocol for initiating incident notifications to the relevant teams once an incident is detected?','A predefined protocol ensures consistent and timely incident notifications.'),
(348,222,'Are automated alert systems integrated with your incident management platform to facilitate immediate action?','Integration of automated alert systems can accelerate response times and ensure seamless coordination among teams.'),
(349,223,'Are internal stakeholders immediately notified through an established communication channel when an incident is detected?','Timely internal notifications help mobilize the response team quickly.'),
(350,223,'Is there a clear escalation path for incidents that require senior management involvement?','Defining an escalation path ensures that critical incidents receive appropriate attention.'),
(351,223,'Are roles and responsibilities clearly defined for each team member involved in incident response?','Clear role definitions improve coordination and reduce response time.'),
(352,223,'Is there a dedicated internal incident management portal to centralize communication among stakeholders?','A centralized portal enhances internal communication by consolidating all incident-related information, facilitating quick decision-making.'),
(353,224,'Do you have procedures to notify external stakeholders (e.g., regulators, clients, partners) within the required regulatory timelines?','Timely external notifications are essential for legal compliance and maintaining trust.'),
(354,224,'Are external notifications reviewed for clarity, consistency, and legal compliance before they are sent?','Reviewing notifications ensures clear and compliant communications.'),
(355,224,'Is there a dedicated communication team responsible for handling external incident notifications?','A specialized team ensures that external communications are handled effectively and consistently.'),
(356,224,'Do you have pre-approved templates for external communication to ensure consistency during incident notifications?','Utilizing pre-approved templates ensures clear, consistent, and compliant external notifications.'),
(357,225,'Do you conduct a formal post-incident review to assess the effectiveness of your notification and communication processes?','Regular reviews help identify gaps and improve incident response procedures.'),
(358,225,'Are lessons learned from past incidents used to update and improve your incident notification protocols?','Incorporating lessons learned is key to continuous improvement.'),
(359,225,'Is feedback from both internal and external stakeholders on the incident communication process systematically collected and acted upon?','Collecting stakeholder feedback helps refine processes and build trust for future incidents.'),
(360,225,'Are incident review meetings scheduled immediately after major incidents to capture lessons learned?','Prompt review meetings are essential to capture critical insights for improving future incident responses.'),
(361,226,'Does your organization have a formal process for post-incident analysis to identify root causes and implement corrective actions?','A formal post-incident analysis process enables your organization to learn from each incident, address underlying issues, and enhance response strategies.'),
(362,226,'Are lessons learned from each incident formally documented and reviewed to update incident response and recovery plans?','Documenting and reviewing lessons learned is critical for continuous improvement. It allows your organization to analyze incidents, identify root causes, and adjust response strategies accordingly.'),
(363,226,'Is there a follow-up mechanism to ensure that corrective actions identified during post-incident reviews are implemented effectively?','A formal follow-up mechanism is essential to ensure that identified corrective actions are executed promptly, reducing the risk of recurrence.'),
(364,226,'Does your organization conduct periodic audits of post-incident recovery processes to assess their effectiveness and compliance with internal standards?','Regular audits of recovery processes are essential to verify that corrective actions are effective and that recovery procedures remain robust.');
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
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
INSERT INTO `responses` VALUES
(25,20,47,'Partially – we have some informal or ad-hoc risk assessment processes.'),
(26,21,47,'I do'),
(29,20,52,'Yes – we have a comprehensive, documented plan that is regularly communicated and updated.'),
(31,20,56,'Yes – we have a scheduled review process for our cybersecurity policies.'),
(32,20,57,'Use of intrusion detection/prevention systems (IDS/IPS) or network monitoring tools.'),
(33,20,54,'Yes – we have a comprehensive, documented plan covering continuity, disaster recovery, and crisis management.'),
(34,20,58,'Yes – we conduct regular tests of our backup and recovery processes.'),
(35,20,70,'No – there is no standard process for managing user accounts during onboarding or offboarding.'),
(36,20,59,'Yes – we conduct regular security assessments or audits of our critical vendors.'),
(37,20,60,'Yes – all key supplier contracts include clear cybersecurity clauses and requirements.'),
(38,20,61,'Yes – we regularly update our risk assessments for the supply chain, incorporating new threats and vendor performance reviews.'),
(39,20,62,'Following a Secure Development Life Cycle (SDLC) – incorporating security in system design from the start.'),
(40,20,63,'We conduct periodic reviews or audits of our security policies, procedures, and controls.'),
(41,20,73,'At least once a year or whenever significant changes occur.'),
(42,20,74,'No – there is little to no formal communication or training on these policies.'),
(43,20,300,'We have an informal process in place.'),
(44,20,301,'Yes, clear information is provided at the point of data collection.'),
(45,20,302,'No, consent is not properly recorded.'),
(46,20,306,'Yes, comprehensive procedures exist for data access, rectification, and erasure.'),
(47,20,307,'Mechanisms are in place but are limited in scope.'),
(48,20,308,'No, there is no defined process for providing such information.'),
(49,20,309,'Yes, we have a comprehensive incident response and breach notification plan.'),
(50,20,310,'Yes, breach notifications are clear and sent in a timely manner.'),
(51,20,311,'Training is provided, but not on a regular basis.'),
(52,20,345,'Yes, an automated system is in place'),
(53,20,346,'No, verification is delayed or absent'),
(54,20,347,'No, there is no predefined protocol'),
(55,20,348,'Yes, fully integrated'),
(56,20,349,'Yes, notifications are immediate'),
(57,20,350,'Yes, a clear escalation path exists'),
(58,20,351,'Yes, roles are clearly defined'),
(59,20,352,'No, there is no dedicated portal'),
(60,20,353,'No, external notifications are not reliably made'),
(61,20,354,'No, notifications are not reviewed'),
(62,20,355,'No, external notifications are handled ad hoc'),
(63,20,356,'Yes, templates are in place'),
(64,20,357,'Yes, formal reviews are conducted'),
(65,20,358,'Some lessons are applied'),
(66,20,359,'Yes, feedback is actively collected and acted upon'),
(67,20,360,'No, meetings are not regularly scheduled'),
(68,20,361,'Yes, a formal process exists'),
(69,20,362,'Yes, lessons are systematically documented and reviewed'),
(70,20,363,'No, there is no follow-up mechanism'),
(71,20,364,'Yes, regular audits are conducted');
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
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES
(14,'NIS2 Risk Management','A survey assessing your compliance with the European Union Directive 2022/2555 (NIS2) (Portugal Transposition)',NULL,'2025-02-24 18:21:06'),
(100,'GDPR Compliance Survey','A comprehensive survey designed to assess your organization’s adherence to GDPR standards, evaluating policies and procedures.',NULL,'2025-03-19 22:29:58'),
(111,'NIS2 Incident Notification','This survey assesses your organization’s compliance with the NIS2 Directive’s incident notification',NULL,'2025-03-20 14:11:38');
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
INSERT INTO `users` VALUES
(20,'UBI','Diogo','Silva','dimatos.silva@gmail.com','$2y$10$gemJlDmS9GGYJo8OsXTp8.P/60U5Za2eld1rp.SRV99hNXso3W5sy','Portugal','admin','2025-03-17 12:29:33'),
(21,NULL,NULL,NULL,'joao.novais@ubi.pt','$2y$10$iyp9vVfMmNEl1Mr0E2Ovoexp3xZ9/sWBlov38ZtzcJos57ZmXjbwq',NULL,'user','2025-03-17 12:42:35');
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

-- Dump completed on 2025-03-20 14:38:20
