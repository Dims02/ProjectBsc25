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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` VALUES (30,33,'Yellow',1),(31,33,'Black',0),(32,33,'White',1),(42,43,'I have this option! Im correct.',1),(43,43,'And this one too! Im not.',0),(44,44,'Oh not correct!',0),(45,44,'I am!',1),(46,46,'No....',0),(47,46,'I did!',1),(48,47,'I do',1),(49,47,'I do not',0);
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
  `recommendation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`),
  CONSTRAINT `question_groups_ibfk_1` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_groups`
--

LOCK TABLES `question_groups` WRITE;
/*!40000 ALTER TABLE `question_groups` DISABLE KEYS */;
INSERT INTO `question_groups` VALUES (9,14,'Understanding NIS2',''),(16,25,'First meeting','You should always be sure before accusing someone....'),(21,13,'Im the Title','And I have a recommendation'),(88,25,'Certainty','We must always be sure we saw the crime happen'),(89,15,'',''),(90,13,'',''),(91,14,'Sample Question','You should always agree with these...');
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (10,9,'<p>A Diretiva (UE) <strong>2022/2555 (NIS2)</strong> foi adotada pela Uni&atilde;o Europeia em dezembro de 2022, num contexto de crescente urg&ecirc;ncia em refor&ccedil;ar a ciberseguran&ccedil;a face ao aumento da frequ&ecirc;ncia e sofistica&ccedil;&atilde;o das ciberamea&ccedil;as. Esta diretiva substituiu a anterior NIS de 2016, colmatando lacunas e harmonizando as medidas de seguran&ccedil;a a n&iacute;vel europeu. O seu objetivo &eacute; garantir um elevado n&iacute;vel comum de ciberseguran&ccedil;a em todos os Estados-Membros, fortalecendo a resili&ecirc;ncia das infraestruturas cr&iacute;ticas e essenciais. Entre as principais novidades da NIS2 est&atilde;o a expans&atilde;o do seu &acirc;mbito de aplica&ccedil;&atilde;o, requisitos de seguran&ccedil;a mais rigorosos, obriga&ccedil;&otilde;es de notifica&ccedil;&atilde;o de incidentes mais exigentes e uma &ecirc;nfase especial na seguran&ccedil;a da cadeia de abastecimento e na gest&atilde;o de vulnerabilidades. A diretiva tamb&eacute;m estabelece mecanismos de coopera&ccedil;&atilde;o europeia, como a cria&ccedil;&atilde;o da Rede Europeia de Organiza&ccedil;&otilde;es de Coordena&ccedil;&atilde;o de Cibercrises (EU-CyCLONe), para responder de forma coordenada a incidentes de grande escala.</p>'),(33,16,'Who did it????'),(43,21,'This is a question'),(44,21,'And this is another!'),(46,88,'Are you sure you saw someone kill????'),(47,91,'Do you agree'),(49,9,'<p>A NIS2 entrou em vigor na UE a 16 de janeiro de 2023, com prazo para transposi&ccedil;&atilde;o para as legisla&ccedil;&otilde;es nacionais at&eacute; 17 de outubro de 2024. Em Portugal, a transposi&ccedil;&atilde;o est&aacute; a ser concretizada atrav&eacute;s de um Decreto-Lei que estabelece um novo regime jur&iacute;dico de ciberseguran&ccedil;a, alinhado com a diretiva europeia. O projeto de Decreto-Lei foi submetido a consulta p&uacute;blica (conclu&iacute;da em 31 de dezembro de 2024) e prev&ecirc;-se a sua aprova&ccedil;&atilde;o final no primeiro trimestre de 2025. Este novo diploma vem revogar o anterior regime (Lei n.&ordm; 46/2018 e Decreto-Lei n.&ordm; 65/2021, que transpunham a NIS original) e atualizar a estrat&eacute;gia nacional de ciberseguran&ccedil;a em conformidade com as diretivas europeias mais recentes.</p>\r\n<p><s>aaaaaaaaaaaaaaaaaa <span style=\"text-decoration: underline;\">aaaaaaaaaaaaaaaaaaaaaaaaaa</span></s></p>');
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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responses`
--

LOCK TABLES `responses` WRITE;
/*!40000 ALTER TABLE `responses` DISABLE KEYS */;
INSERT INTO `responses` VALUES (14,11,10,'No'),(15,11,33,'Yellow'),(17,11,44,'I am!'),(18,11,46,'No....'),(19,10,33,'Yellow'),(21,11,47,'I do not'),(22,16,43,'I have this option! Im correct.'),(24,16,47,'I do');
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
  CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES (13,'GDPR','General Data Protection Regulation survey',11,'2025-02-24 18:21:06'),(14,'NIS2','<p><strong>European Union Directive 2022/2555 (NIS2)</strong></p>',11,'2025-02-24 18:21:06'),(15,'27001','Your opinion matters in our workplace.',11,'2025-02-24 18:21:06'),(25,'Among us meeting','We should decide who committed the crime....',11,'2025-03-04 20:24:13');
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
  `entity` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'IPCB','Marta','Rodrigues','marta@gmail.com','$2y$10$KHtl6/WWwuUccR4n85VBu.rk5rUX80cMs.ATS7dnEzFapPoOX.VyW','Ireland','user','2025-02-24 17:08:55'),(11,'UBI','Diogo','Silva','admin@gmail.com','$2y$10$kuGGnnhLGuLLoLqzCAc/nuqxHs.HJe4mAugmHp/9PO.TnqDnyAbe.','Portugal','admin','2025-02-24 18:05:44'),(16,'','','','ana@gmail.com','$2y$10$0368o70EJmMc7/HD40tvFu3tI8IIhWXggQYkJkSiFdhjwMtLVo0sC',NULL,'user','2025-03-14 15:17:49'),(17,'','','','name@gmail.com','$2y$10$xL2ncyM0s9TaOdXobZdqtOVKKhN8HyNuemKshnYKL9e0FZZdpK/Bq',NULL,'user','2025-03-14 20:24:15');
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

-- Dump completed on 2025-03-14 20:27:10
