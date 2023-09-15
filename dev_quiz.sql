-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2023 at 03:51 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev_quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `answer`
--

CREATE TABLE `answer` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `is_good_answer` tinyint(4) NOT NULL DEFAULT 0,
  `question_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `answer`
--

INSERT INTO `answer` (`id`, `content`, `is_good_answer`, `question_id`) VALUES
(1, 'Home Tool Markup Language', 0, 1),
(2, 'Hyperlinks and Text Markup Language', 0, 1),
(3, 'Hyper Text Markup Langage', 1, 1),
(4, 'Google', 0, 2),
(5, 'Microsoft', 0, 2),
(6, 'Mozilla', 0, 2),
(7, 'Le World Wide Web Consortium', 1, 2),
(8, '<heading>', 0, 3),
(9, '<head>', 0, 3),
(10, '<h1>', 1, 3),
(11, '<h6>', 0, 3),
(12, '<lb>', 0, 4),
(13, '<break>', 0, 4),
(14, '<br>', 1, 4),
(15, '<background>yellow</background>', 0, 5),
(16, '<body style=\"background-color:yellow;\">', 1, 5),
(17, '<body bg=\"yellow\">', 0, 5),
(18, '<i>', 0, 6),
(19, '<important>', 0, 6),
(20, '<strong>', 1, 6),
(21, '<b>', 0, 6),
(22, '<italic>', 0, 7),
(23, '<em>', 1, 7),
(24, '<i>', 0, 7),
(25, '<a name=\"http://www.w3schools.com\">W3Schools.com</a>', 0, 8),
(26, '<a>http://www.w3schools.com</a>', 0, 8),
(27, '<a url=\"http://www.w3schools.com\">W3Schools.com</a>', 0, 8),
(28, '<a href=\"http://www.w3schools.com\">W3Schools</a>', 1, 8),
(29, '^', 0, 9),
(30, '<', 0, 9),
(31, '*', 0, 9),
(32, '/', 1, 9),
(33, '<a href=\"url\" target=\"_blank\">', 1, 10),
(34, '<a href=\"url\" target=\"new\">', 0, 10),
(35, '<a href=\"url\" new>', 0, 10),
(36, '<thead><body><tr>', 0, 11),
(37, '<table><tr><td>', 1, 11),
(38, '<table><tr><tt>', 0, 11),
(39, '<table><head><tfoot>', 0, 11),
(40, 'Vrai', 1, 12),
(41, 'Faux', 0, 12),
(42, '<ol>', 1, 13),
(43, '<list>', 0, 13),
(44, '<ul>', 0, 13),
(45, '<dl>', 0, 13),
(46, '<ul>', 1, 14),
(47, '<dl>', 0, 14),
(48, '<ol>', 0, 14),
(49, '<list>', 0, 14),
(50, '<input type=\"check\">', 0, 15),
(51, '<input type=\"checkbox\">', 1, 15),
(52, '<check>', 0, 15),
(53, '<checkbox>', 0, 15),
(54, '<input type=\"text\">', 1, 16),
(55, '<input type=\"textfield\">', 0, 16),
(56, '<textinput type=\"text\">', 0, 16),
(57, '<textfield>', 0, 16),
(58, '<input type=\"list\">', 0, 17),
(59, '<list>', 0, 17),
(60, '<input type=\"dropdown\">', 0, 17),
(61, '<select>', 1, 17),
(62, '<textarea>', 1, 18),
(63, '<input type=\"textarea\">', 0, 18),
(64, '<input type=\"textbox\">', 0, 18),
(65, '<img alt=\"MyImage\">image.gif</img>', 0, 19),
(66, '<img src=\"image.gif\" alt=\"MyImage\">', 1, 19),
(67, '<img href=\"image.gif\" alt=\"MyImage\">', 0, 19),
(68, '<image src=\"image.gif\" alt=\"MyImage\">', 0, 19),
(69, '<body style=\"background-image:url(background.gif)\">', 1, 20),
(70, '<background img=\"background.gif\">', 0, 20),
(71, '<body bg=\"background.gif\">', 0, 20),
(72, 'Il n\'existe pas de balise <iframe>', 0, 21),
(73, 'Vrai', 1, 21),
(74, 'Faux', 0, 21),
(75, 'Vrai', 1, 22),
(76, 'Faux', 0, 22),
(77, 'Vrai', 0, 23),
(78, 'Faux', 1, 23),
(79, '<title>', 1, 24),
(80, '<head>', 0, 24),
(81, '<meta>', 0, 24),
(82, 'title', 0, 25),
(83, 'src', 0, 25),
(84, 'alt', 1, 25),
(85, 'longdesc', 0, 25),
(86, '<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 5.0//EN\" \"http://www.w3.org/TR/html5/strict.dtd\">', 0, 26),
(87, '<!DOCTYPE html>', 1, 26),
(88, '<!DOCTYPE HTML5>', 0, 26),
(89, '<bottom>', 0, 27),
(90, '<section>', 0, 27),
(91, '<footer>', 1, 27),
(92, 'Vrai', 1, 28),
(93, 'Faux', 0, 28),
(94, '<video>', 1, 29),
(95, '<movie>', 0, 29),
(96, '<media>', 0, 29),
(97, '<mp3>', 0, 30),
(98, '<sound>', 0, 30),
(99, '<audio>', 1, 30),
(100, 'Retourner la position de la première occurrence trouvée de contenu dans une chaîne de caractère', 0, 31),
(101, 'Spécifier un menu contextuel pour un élément. Le menu apparaît lorsqu\'un utilisateur fait un clic droit sur l\'élément', 0, 31),
(102, 'Indiquer si le contenu d\'un élément doit être modifiable ou non', 1, 31),
(103, 'Mettre à jour le contenu depuis le serveur', 0, 31),
(104, 'Des éléments HTML', 0, 32),
(105, 'Des attributs de style', 0, 32),
(106, 'Des attributs d\'évènements', 1, 32),
(107, 'XML', 1, 33),
(108, 'CSS', 0, 33),
(109, 'HTML', 0, 33),
(110, 'Créer des éléments déplaçables', 0, 34),
(111, 'Manipuler des données dans MySQL', 0, 34),
(112, 'Dessiner des graphiques', 1, 34),
(113, 'Afficher les enregistrements de la base de données', 0, 34),
(114, 'formvalidate', 0, 35),
(115, 'validate', 0, 35),
(116, 'required', 1, 35),
(117, 'placeholder', 0, 35),
(118, 'search', 0, 36),
(119, 'controls', 0, 36),
(120, 'range', 1, 36),
(121, 'slider', 0, 36),
(122, '<measure>', 0, 37),
(123, '<range>', 0, 37),
(124, '<meter>', 1, 37),
(125, '<gauge>', 0, 37),
(126, '<nav>', 1, 38),
(127, '<navigation>', 0, 38),
(128, '<navigate>', 0, 38),
(129, 'Une partie de page dont le contenu n\'a qu\'un rapport indirect avec le contenu principal de la page', 1, 39),
(130, 'Le jeu de caractères ASCII pour envoyer des informations entre ordinateurs sur Internet', 0, 39),
(131, 'Une liste de navigation à afficher sur le côté gauche de la page', 0, 39),
(132, '<section>', 0, 40),
(133, '<header>', 1, 40),
(134, '<top>', 0, 40),
(135, '<head>', 0, 40),
(136, 'Colorful Style Sheets', 0, 41),
(137, 'Computer Style Sheets', 0, 41),
(138, 'Creative Style Sheets', 0, 41),
(139, 'Cascading Style Sheets', 1, 41),
(140, '<style src=\"mystyle.css\">', 0, 42),
(141, '<link rel=\"stylesheet\" type=\"text/css\" href=\"mystyle.css\">', 1, 42),
(142, '<stylesheet>mystyle.css</stylesheet>', 0, 42),
(143, 'In the <body> section', 0, 43),
(144, 'In the <head> section', 1, 43),
(145, 'At the end of the document', 0, 43),
(146, '<script>', 0, 44),
(147, '<css>', 0, 44),
(148, '<style>', 1, 44),
(149, 'styles', 0, 45),
(150, 'font', 0, 45),
(151, 'class', 0, 45),
(152, 'style', 1, 45),
(153, 'body {color: black;}', 1, 46),
(154, 'body:color=black;', 0, 46),
(155, '{body:color=black;}', 0, 46),
(156, '{body;color:black;}', 0, 46),
(157, '// this is a comment //', 0, 47),
(158, '\' this is a comment', 0, 47),
(159, '/* this is a comment */', 1, 47),
(160, '// this is a comment', 0, 47),
(161, 'color', 0, 48),
(162, 'background-color', 1, 48),
(163, 'bgcolor', 0, 48),
(164, 'all.h1 {background-color:#FFFFFF;}', 0, 49),
(165, 'h1 {background-color:#FFFFFF;}', 1, 49),
(166, 'h1.all {background-color:#FFFFFF;}', 0, 49),
(167, 'fgcolor', 0, 50),
(168, 'text-color', 0, 50),
(169, 'color', 1, 50),
(170, 'font-style', 0, 51),
(171, 'text-size', 0, 51),
(172, 'font-size', 1, 51),
(173, 'text-style', 0, 51),
(174, '<p style=\"font-size:bold;\">', 0, 52),
(175, 'p {font-weight:bold;}', 1, 52),
(176, 'p {text-size:bold;}', 0, 52),
(177, '<p style=\"text-size:bold;\">', 0, 52),
(178, 'a {decoration:no-underline;}', 0, 53),
(179, 'a {underline:none;}', 0, 53),
(180, 'a {text-decoration:no-underline;}', 0, 53),
(181, 'a {text-decoration:none;}', 1, 53),
(182, 'Ce n\'est pas possible avec CSS', 0, 54),
(183, 'text-style:capitalize', 0, 54),
(184, 'text-transform:capitalize', 1, 54),
(185, 'transform:capitalize', 0, 54),
(186, 'font-family', 1, 55),
(187, 'font-weight', 0, 55),
(188, 'font-style', 0, 55),
(189, 'font-weight:bold;', 1, 56),
(190, 'style:bold;', 0, 56),
(191, 'font:bold;', 0, 56),
(192, 'padding-left', 0, 57),
(193, 'indent', 0, 57),
(194, 'margin-left', 1, 57),
(195, 'Oui', 0, 58),
(196, 'Non', 1, 58),
(197, 'list-style-type: square;', 1, 59),
(198, 'list-type: square;', 0, 59),
(199, 'list: square;', 0, 59),
(200, '*demo', 0, 60),
(201, '#demo', 1, 60),
(202, '.demo', 0, 60),
(203, 'demo', 0, 60),
(204, '.test', 1, 61),
(205, '*test', 0, 61),
(206, 'test', 0, 61),
(207, '#test', 0, 61),
(208, 'div + p', 0, 62),
(209, 'div.p', 0, 62),
(210, 'div p', 1, 62),
(211, 'Séparez chaque sélecteur par un signe plus', 0, 63),
(212, 'Séparez chaque sélecteur par une virgule', 1, 63),
(213, 'Séparez chaque sélecteur par un espace', 0, 63),
(214, 'relative', 0, 64),
(215, 'static', 1, 64),
(216, 'absolute', 0, 64),
(217, 'fixed', 0, 64),
(218, '<javascript>', 0, 65),
(219, '<scripting>', 0, 65),
(220, '<script>', 1, 65),
(221, '<js>', 0, 65),
(222, 'document.getElementByName(\"p\").innerHTML = \"Hello World!\";', 0, 66),
(223, 'document.getElement(\"p\").innerHTML = \"Hello World!\";', 0, 66),
(224, '#demo.innerHTML = \"Hello World!\";', 0, 66),
(225, 'document.getElementById(\"demo\").innerHTML = \"Hello World!\";', 1, 66),
(226, 'The <head> section', 0, 67),
(227, 'The <body> section', 0, 67),
(228, 'Both the <head> section and the <body> section are correct', 1, 67),
(229, '<script href=\"xxx.js\">', 0, 68),
(230, '<script src=\"xxx.js\">', 1, 68),
(231, '<script name=\"xxx.js\">', 0, 68),
(232, 'Vrai', 0, 69),
(233, 'Faux', 1, 69),
(234, 'msg(\"Hello World\");', 0, 70),
(235, 'msgBox(\"Hello World\");', 0, 70),
(236, 'alert(\"Hello World\");', 1, 70),
(237, 'alertBox(\"Hello World\");', 0, 70),
(238, 'function maFonction()', 1, 71),
(239, 'function:maFonction()', 0, 71),
(240, 'function = maFonction()', 0, 71),
(241, 'maFonction()', 1, 72),
(242, 'call maFonction()', 0, 72),
(243, 'call function maFonction()', 0, 72),
(244, 'if i = 5 then', 0, 73),
(245, 'if i == 5 then', 0, 73),
(246, 'if (i == 5)', 1, 73),
(247, 'if i = 5', 0, 73),
(248, 'if i <> 5', 0, 74),
(249, 'if (i != 5)', 1, 74),
(250, 'if i =! 5 then', 0, 74),
(251, 'if (i <> 5)', 0, 74),
(252, 'while (i <= 10; i++)', 0, 75),
(253, 'while (i <= 10)', 1, 75),
(254, 'while i = 1 to 10', 0, 75),
(255, 'for (i = 0; i <= 5; i++)', 1, 76),
(256, 'for (i = 0; i <= 5)', 0, 76),
(257, 'for (i <= 5; i++)', 0, 76),
(258, 'for i = 1 to 5', 0, 76),
(259, '\'This is a comment', 0, 77),
(260, '<!--This is a comment-->', 0, 77),
(261, '//This is a comment', 1, 77),
(262, 'let colors = 1 = (\"red\"), 2 = (\"green\"), 3 = (\"blue\")', 0, 78),
(263, 'let colors = \"red\", \"green\", \"blue\"', 0, 78),
(264, 'let colors = [\"red\", \"green\", \"blue\"]', 1, 78),
(265, 'let colors = (1:\"red\", 2:\"green\", 3:\"blue\")', 0, 78),
(266, 'Math.rnd(7.25)', 0, 79),
(267, 'Math.round(7.25)', 1, 79),
(268, 'round(7.25)', 0, 79),
(269, 'rnd(7.25)', 0, 79),
(270, 'ceil(x, y)', 0, 80),
(271, 'Math.ceil(x, y)', 0, 80),
(272, 'top(x, y)', 0, 80),
(273, 'Math.max(x, y)', 1, 80),
(274, 'w2 = window.open(\"http://www.w3schools.com\");', 1, 81),
(275, 'w2 = window.new(\"http://www.w3schools.com\");', 0, 81),
(276, 'Vrai', 0, 82),
(277, 'Faux', 1, 82),
(278, 'navigator.appName', 1, 83),
(279, 'browser.name', 0, 83),
(280, 'client.navName', 0, 83),
(281, 'onmouseclick', 0, 84),
(282, 'onchange', 0, 84),
(283, 'onclick', 1, 84),
(284, 'onmouseover', 0, 84),
(285, 'var carName;', 1, 85),
(286, 'v carName;', 0, 85),
(287, 'variable carName;', 0, 85),
(288, '-', 0, 86),
(289, '*', 0, 86),
(290, 'x', 0, 86),
(291, '=', 1, 86),
(292, 'true', 1, 87),
(293, 'NaN', 0, 87),
(294, 'false', 0, 87),
(295, 'Oui', 1, 88),
(296, 'Non', 0, 88),
(297, 'Structured Query Language', 1, 89),
(298, 'Structured Question Language', 0, 89),
(299, 'Strong Question Language', 0, 89),
(300, 'OPEN', 0, 90),
(301, 'SELECT', 1, 90),
(302, 'GET', 0, 90),
(303, 'EXTRACT', 0, 90),
(304, 'SAVE', 0, 91),
(305, 'SAVE AS', 0, 91),
(306, 'UPDATE', 1, 91),
(307, 'MODIFY', 0, 91),
(308, 'COLLAPSE', 0, 92),
(309, 'REMOVE', 0, 92),
(310, 'DELETE', 1, 92),
(311, 'INSERT NEW', 0, 93),
(312, 'INSERT INTO', 1, 93),
(313, 'ADD RECORD', 0, 93),
(314, 'ADD NEW', 0, 93),
(315, 'SELECT Persons.FirstName', 0, 94),
(316, 'EXTRACT FirstName FROM Persons', 0, 94),
(317, 'SELECT FirstName FROM Persons', 1, 94),
(318, 'SELECT Persons', 0, 95),
(319, 'SELECT *.Persons', 0, 95),
(320, 'SELECT * FROM Persons', 1, 95),
(321, 'SELECT [all] FROM Persons', 0, 95),
(322, 'SELECT [all] FROM Persons WHERE FirstName LIKE \'Peter\'', 0, 96),
(323, 'SELECT * FROM Persons WHERE FirstName<>\'Peter\'', 0, 96),
(324, 'SELECT * FROM Persons WHERE FirstName=\'Peter\'', 1, 96),
(325, 'SELECT [all] FROM Persons WHERE FirstName=\'Peter\'', 0, 96),
(326, 'SELECT * FROM Persons WHERE FirstName LIKE \'%a\'', 0, 97),
(327, 'SELECT * FROM Persons WHERE FirstName LIKE \'a%\'', 1, 97),
(328, 'SELECT * FROM Persons WHERE FirstName=\'a\'', 0, 97),
(329, 'SELECT * FROM Persons WHERE FirstName=\'%a%\'', 0, 97),
(330, 'Vrai', 1, 98),
(331, 'Faux', 0, 98),
(332, 'SELECT FirstName=\'Peter\', LastName=\'Jackson\' FROM Persons', 0, 99),
(333, 'SELECT * FROM Persons WHERE FirstName<>\'Peter\' AND LastName<>\'Jackson\'', 0, 99),
(334, 'SELECT * FROM Persons WHERE FirstName=\'Peter\' AND LastName=\'Jackson\'', 1, 99),
(335, 'SELECT * FROM Persons WHERE LastName>\'Hansen\' AND LastName<\'Pettersen\'', 0, 100),
(336, 'SELECT LastName>\'Hansen\' AND LastName<\'Pettersen\' FROM Persons', 0, 100),
(337, 'SELECT * FROM Persons WHERE LastName BETWEEN \'Hansen\' AND \'Pettersen\'', 1, 100),
(338, 'SELECT DISTINCT', 1, 101),
(339, 'SELECT UNIQUE', 0, 101),
(340, 'SELECT DIFFERENT', 0, 101),
(341, 'ORDER BY', 1, 102),
(342, 'SORT BY', 0, 102),
(343, 'SORT', 0, 102),
(344, 'ORDER', 0, 102),
(345, 'SELECT * FROM Persons ORDER BY FirstName DESC', 1, 103),
(346, 'SELECT * FROM Persons SORT BY \'FirstName\' DESC', 0, 103),
(347, 'SELECT * FROM Persons SORT \'FirstName\' DESC', 0, 103),
(348, 'SELECT * FROM Persons ORDER FirstName DESC', 0, 103),
(349, 'INSERT INTO Persons VALUES (\'Jimmy\', \'Jackson\')', 1, 104),
(350, 'INSERT (\'Jimmy\', \'Jackson\') INTO Persons', 0, 104),
(351, 'INSERT VALUES (\'Jimmy\', \'Jackson\') INTO Persons', 0, 104),
(352, 'INSERT INTO Persons (LastName) VALUES (\'Olsen\')', 1, 105),
(353, 'INSERT (\'Olsen\') INTO Persons (LastName)', 0, 105),
(354, 'INSERT INTO Persons (\'Olsen\') INTO LastName', 0, 105),
(355, 'MODIFY Persons SET LastName=\'Nilsen\' WHERE LastName=\'Hansen\'', 0, 106),
(356, 'UPDATE Persons SET LastName=\'Nilsen\' WHERE LastName=\'Hansen\'', 1, 106),
(357, 'UPDATE Persons SET LastName=\'Hansen\' INTO LastName=\'Nilsen\'', 0, 106),
(358, 'MODIFY Persons SET LastName=\'Hansen\' INTO LastName=\'Nilsen', 0, 106),
(359, 'DELETE FROM Persons WHERE FirstName = \'Peter\'', 1, 107),
(360, 'DELETE FirstName=\'Peter\' FROM Persons', 0, 107),
(361, 'DELETE ROW FirstName=\'Peter\' FROM Persons', 0, 107),
(362, 'SELECT LEN(*) FROM Persons', 0, 108),
(363, 'SELECT NO(*) FROM Persons', 0, 108),
(364, 'SELECT COUNT(*) FROM Persons', 1, 108),
(365, 'SELECT COLUMNS(*) FROM Persons', 0, 108),
(366, 'JOINED', 0, 109),
(367, 'JOINED TABLE', 0, 109),
(368, 'INNER JOIN', 1, 109),
(369, 'INSIDE JOIN', 0, 109),
(370, 'RANGE', 0, 110),
(371, 'WITHIN', 0, 110),
(372, 'BETWEEN', 1, 110),
(373, 'Vrai', 1, 111),
(374, 'Faux', 0, 111),
(375, 'LIKE', 1, 112),
(376, 'GET', 0, 112),
(377, 'FROM', 0, 112),
(378, 'CREATE TABLE Customers', 1, 113),
(379, 'CREATE DATABASE TABLE Customers', 0, 113),
(380, 'CREATE DB Customers', 0, 113),
(381, 'CREATE DATABASE TAB Customers', 0, 113),
(382, 'Private Home Page', 0, 114),
(383, 'PHP: Hypertext Preprocessor', 1, 114),
(384, 'Personal Hypertext Processor', 0, 114),
(385, '<&>...</&>', 0, 115),
(386, '<?php>...</?>', 0, 115),
(387, '<script>...</script>', 0, 115),
(388, '<?php...?>', 1, 115),
(389, '\"Hello World\";', 0, 116),
(390, 'Document.Write(\"Hello World\");', 0, 116),
(391, 'echo \"Hello World\";', 1, 116),
(392, '$', 1, 117),
(393, '&', 0, 117),
(394, '!', 0, 117),
(395, '</php>', 0, 118),
(396, ';', 1, 118),
(397, '.', 0, 118),
(398, 'New line', 0, 118),
(399, 'VBScript', 0, 119),
(400, 'JavaScript', 0, 119),
(401, 'Perl and C', 1, 119),
(402, 'Request.QueryString;', 0, 120),
(403, '$_GET[];', 1, 120),
(404, 'Request.Form;', 0, 120),
(405, 'Vrai', 0, 121),
(406, 'False', 1, 121),
(407, 'Vrai', 1, 122),
(408, 'Faux', 0, 122),
(409, 'Vrai', 0, 123),
(410, 'Faux', 1, 123),
(411, '<?php include:\"time.inc\"; ?>', 0, 124),
(412, '<!-- include file=\"time.inc\" -->', 0, 124),
(413, '<?php include \"time.inc\"; ?>', 1, 124),
(414, '<?php include file=\"time.inc\"; ?>', 0, 124),
(415, 'create myFunction()', 0, 125),
(416, 'function myFunction()', 1, 125),
(417, 'new_function myFunction()', 0, 125),
(418, 'open(\"time.txt\");', 0, 126),
(419, 'fopen(\"time.txt\",\"r+\");', 0, 126),
(420, 'fopen(\"time.txt\",\"r\");', 1, 126),
(421, 'open(\"time.txt\",\"read\");', 0, 126),
(422, 'Vrai', 1, 127),
(423, 'Faux', 0, 127),
(424, '$GLOBALS', 0, 128),
(425, '$_SERVER', 1, 128),
(426, '$_GET', 0, 128),
(427, '$_SESSION', 0, 128),
(428, '$count =+1', 0, 129),
(429, '++count', 0, 129),
(430, 'count++;', 0, 129),
(431, '$count++;', 1, 129),
(432, '<comment>...</comment>', 0, 130),
(433, '<!--...-->', 0, 130),
(434, '/*...*/', 1, 130),
(435, '*\\...\\*', 0, 130),
(436, 'Vrai', 1, 131),
(437, 'Faux', 0, 131),
(438, 'Vrai', 1, 132),
(439, 'Faux', 0, 132),
(440, '$myVar', 0, 133),
(441, '$my-Var', 1, 133),
(442, '$my_Var', 0, 133),
(443, 'createcookie', 0, 134),
(444, 'setcookie()', 1, 134),
(445, 'makecookie()', 0, 134),
(446, 'Vrai', 0, 135),
(447, 'Faux', 1, 135),
(448, '$cars = array(\"Volvo\", \"BMW\", \"Toyota\");', 1, 136),
(449, '$cars = array[\"Volvo\", \"BMW\", \"Toyota\"];', 0, 136),
(450, '$cars = \"Volvo\", \"BMW\", \"Toyota\";', 0, 136),
(451, 'Vrai', 1, 137),
(452, 'Faux', 0, 137),
(453, '===', 1, 138),
(454, '=', 0, 138),
(455, '!=', 0, 138),
(456, '==', 0, 138);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'html'),
(2, 'css'),
(3, 'javascript'),
(4, 'php'),
(5, 'sql');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `title`, `category_id`) VALUES
(1, 'Que signifie HTML ?', 1),
(2, 'Qui élabore les standards du Web ?', 1),
(3, 'Choisissez le bon élément HTML pour le titre le plus grand :', 1),
(4, 'Quel est l\'élément HTML correct pour insérer un saut de ligne ?', 1),
(5, 'Quel est le HTML correct pour ajouter une couleur d’arrière-plan ?', 1),
(6, 'Choisissez le bon élément HTML pour définir le texte important', 1),
(7, 'Choisissez le bon élément HTML pour définir le texte souligné', 1),
(8, 'Quel est le code HTML correct pour créer un lien hypertexte ?', 1),
(9, 'Quel caractère est utilisé pour indiquer une balise de fin ?', 1),
(10, 'Comment ouvrir un lien dans un nouvel onglet/fenêtre de navigateur ?', 1),
(11, 'Lesquels de ces éléments sont tous des éléments <table> ?', 1),
(12, 'Les éléments en ligne sont normalement affichés sans commencer une nouvelle ligne', 1),
(13, 'Comment faire une liste numérotée ?', 1),
(14, 'Comment faire une liste à puces ?', 1),
(15, 'Quel est le code HTML correct pour créer une case à cocher ?', 1),
(16, 'Quel est le code HTML correct pour créer un champ de saisie de texte ?', 1),
(17, 'Quel est le code HTML correct pour créer une liste déroulante ?', 1),
(18, 'Quel est le code HTML correct pour créer une zone de texte ?', 1),
(19, 'Quel est le code HTML correct pour insérer une image ?', 1),
(20, 'Quel est le HTML correct pour insérer une image d’arrière-plan ?', 1),
(21, 'Un <iframe> est utilisé pour afficher une page Web dans une page Web', 1),
(22, 'Les commentaires HTML commencent par <!-- et se terminent par -->', 1),
(23, 'Les éléments de bloc sont normalement affichés sans commencer une nouvelle ligne', 1),
(24, 'Quel élément HTML définit le titre d\'un document ?', 1),
(25, 'Quel attribut HTML spécifie un texte alternatif pour une image, si l\'image ne peut pas être affichée ?', 1),
(26, 'Quel doctype est correct pour HTML5 ?', 1),
(27, 'Quel élément HTML est utilisé pour spécifier un pied de page pour un document ou une section ?', 1),
(28, 'En HTML, vous pouvez intégrer des éléments SVG directement dans une page HTML', 1),
(29, 'Quel est l\'élément HTML correct pour lire les fichiers vidéo ?', 1),
(30, 'Quel est l\'élément HTML correct pour lire des fichiers audio ?', 1),
(31, 'L\'attribut global HTML \"contenteditable\" permet de :', 1),
(32, 'En HTML, onblur et onfocus sont :', 1),
(33, 'Dans quel format les graphiques définis par SVG sont-ils ?', 1),
(34, 'L\'élément HTML <canvas> permet de :', 1),
(35, 'En HTML, quel attribut permet de préciser qu\'un champ de saisie doit être rempli ?', 1),
(36, 'Quel type d\'input définit un contrôle de curseur ?', 1),
(37, 'Quel élément HTML est utilisé pour afficher une mesure scalaire dans une plage ?', 1),
(38, 'Quel élément HTML définit les liens de navigation ?', 1),
(39, 'En HTML, que définit l\'élément <aside> ?', 1),
(40, 'Quel élément HTML est utilisé pour spécifier un en-tête pour un document ou une section ?', 1),
(41, 'Que signifie CSS ?', 2),
(42, 'Quel est le HTML correct pour faire référence à une feuille de style externe ?', 2),
(43, 'Où dans un document HTML se trouve le bon endroit pour faire référence à une feuille de style externe ?', 2),
(44, 'Quelle balise HTML est utilisée pour définir une feuille de style interne ?', 2),
(45, 'Quel attribut HTML est utilisé pour définir les styles en ligne ?', 2),
(46, 'Quelle est la syntaxe CSS correcte ?', 2),
(47, 'Comment insérer un commentaire dans un fichier CSS ?', 2),
(48, 'Quelle propriété est utilisée pour changer la couleur de fond ?', 2),
(49, 'Comment ajouter une couleur d\'arrière-plan pour tous les éléments <h1> ?', 2),
(50, 'Quelle propriété CSS est utilisée pour changer la couleur du texte d\'un élément ?', 2),
(51, 'Quelle propriété CSS contrôle la taille du texte ?', 2),
(52, 'Quelle est la syntaxe CSS correcte pour mettre tous les éléments <p> en gras ?', 2),
(53, 'Comment afficher des hyperliens sans soulignement ?', 2),
(54, 'Comment faire commencer chaque mot d’un texte par une majuscule ?', 2),
(55, 'Quelle propriété est utilisée pour changer la police d’un élément ?', 2),
(56, 'Comment mettre le texte en gras ?', 2),
(57, 'Quelle propriété est utilisée pour modifier la marge gauche d’un élément ?', 2),
(58, 'Lors de l\'utilisation de la propriété padding ; êtes-vous autorisé à utiliser des valeurs négatives ?', 2),
(59, 'Comment faire une liste qui répertorie ses éléments avec des carrés ?', 2),
(60, 'Comment sélectionner un élément avec l\'identifiant « démo » ?', 2),
(61, 'Comment sélectionner les éléments portant le nom de classe « test » ?', 2),
(62, 'Comment sélectionner tous les éléments p à l’intérieur d’un élément div ?', 2),
(63, 'Comment regrouper les sélecteurs ?', 2),
(64, 'Quelle est la valeur par défaut de la propriété position ?', 2),
(65, 'Dans quel élément HTML mettons-nous le JavaScript ?', 3),
(66, 'Quelle est la syntaxe JavaScript correcte pour modifier le contenu de l\'élément HTML ci-dessous ? <p id=\"demo\">Ceci est une démonstration.</p>', 3),
(67, 'Quel est le bon endroit pour insérer un JavaScript ?', 3),
(68, 'Quelle est la syntaxe correcte pour faire référence à un script externe appelé « xxx.js » ?', 3),
(69, 'Le fichier JavaScript externe doit contenir la balise <script>', 3),
(70, 'Comment écrire « Hello World » dans une boîte d\'alerte ?', 3),
(71, 'Comment créer une fonction en JavaScript ?', 3),
(72, 'Comment appeler une fonction nommée « maFonction » ?', 3),
(73, 'Comment écrire une instruction IF en JavaScript ?', 3),
(74, 'Comment écrire une instruction IF pour exécuter du code si « i » n\'est PAS égal à 5 ​​?', 3),
(75, 'Comment démarre une boucle WHILE ?', 3),
(76, 'Comment démarre une boucle FOR ?', 3),
(77, 'Comment ajouter un commentaire dans un JavaScript ?', 3),
(78, 'Quelle est la bonne façon d’écrire un tableau JavaScript ?', 3),
(79, 'Comment arrondir le nombre 7,25 à l’entier le plus proche ?', 3),
(80, 'Comment trouver le nombre avec la valeur la plus élevée de x et y ?', 3),
(81, 'Quelle est la syntaxe JavaScript correcte pour ouvrir une nouvelle fenêtre appelée « w2 » ?', 3),
(82, 'JavaScript est identique à Java.', 3),
(83, 'Comment détecter le nom du navigateur du client ?', 3),
(84, 'Quel événement se produit lorsque l\'utilisateur clique sur un élément HTML ?', 3),
(85, 'Comment déclarer une variable JavaScript ?', 3),
(86, 'Quel opérateur est utilisé pour attribuer une valeur à une variable ?', 3),
(87, 'Que renverra le code suivant : Boolean(10 > 9)', 3),
(88, 'JavaScript est-il sensible à la casse ?', 3),
(89, 'Que signifie SQL ?', 5),
(90, 'Quelle instruction SQL est utilisée pour extraire des données d’une base de données ?', 5),
(91, 'Quelle instruction SQL est utilisée pour mettre à jour les données dans une base de données ?', 5),
(92, 'Quelle instruction SQL est utilisée pour supprimer des données d’une base de données ?', 5),
(93, 'Quelle instruction SQL est utilisée pour insérer de nouvelles données dans une base de données ?', 5),
(94, 'Avec SQL, comment sélectionner une colonne nommée « FirstName» dans une table nommée « Persons » ?', 5),
(95, 'Avec SQL, comment sélectionner toutes les colonnes d\'une table nommée « Persons » ?', 5),
(96, 'Avec SQL, comment sélectionner tous les enregistrements d\'une table nommée « Persons » où la valeur de la colonne « FirstName» est « Peter» ?', 5),
(97, 'Avec SQL, comment sélectionner tous les enregistrements d\'une table nommée « Persons » où la valeur de la colonne « FirstName» commence par un « a » ?', 5),
(98, 'L\'opérateur OR affiche un enregistrement si UNE des conditions répertoriées est vraie. L\'opérateur AND affiche un enregistrement si TOUTES les conditions répertoriées sont vraies', 5),
(99, 'Avec SQL, comment sélectionner tous les enregistrements d\'une table nommée « Persons » où le « FirstName» est « Peter » et le « LastName» est « Jackson » ?', 5),
(100, 'Avec SQL, comment sélectionner tous les enregistrements d\'une table nommée « Persons » où le « LastName » se situe par ordre alphabétique entre (et y compris) « Hansen » et « Pettersen » ?', 5),
(101, 'Quelle instruction SQL est utilisée pour renvoyer uniquement des valeurs différentes ?', 5),
(102, 'Quel mot-clé SQL est utilisé pour trier l’ensemble de résultats ?', 5),
(103, 'Avec SQL, comment renvoyer tous les enregistrements d\'une table nommée « Persons » triés par ordre décroissant de « FirstName» ?', 5),
(104, 'Avec SQL, comment insérer un nouvel enregistrement dans la table « Persons » ?', 5),
(105, 'Avec SQL, comment insérer « Olsen » comme « LastName » dans la table « Persons » ?', 5),
(106, 'Comment pouvez-vous remplacer « Hansen » par « Nilsen » dans la colonne « LastName » de la table Persons ?', 5),
(107, 'Avec SQL, comment pouvez-vous supprimer les enregistrements dont le « FirstName» est « Peter » dans la table des Persons ?', 5),
(108, 'Avec SQL, comment renvoyer le nombre d\'enregistrements dans la table « Persons » ?', 5),
(109, 'Quel est le type de jointure le plus courant ?', 5),
(110, 'Quel opérateur est utilisé pour sélectionner des valeurs dans une plage ?', 5),
(111, 'La contrainte NOT NULL oblige une colonne à ne pas accepter les valeurs NULL', 5),
(112, 'Quel opérateur est utilisé pour rechercher un pattern spécifique dans une colonne ?', 5),
(113, 'Quelle instruction SQL est utilisée pour créer une table de base de données appelée « Customers» ?', 5),
(114, 'Que signifie PHP ?', 4),
(115, 'Les scripts du serveur PHP sont entourés de délimiteurs, lesquels ?', 4),
(116, 'Comment écrire \"Hello World\" en PHP', 4),
(117, 'Toutes les variables en PHP commencent par quel symbole ?', 4),
(118, 'Quelle est la bonne façon de terminer une instruction PHP ?', 4),
(119, 'La syntaxe PHP est la plus similaire à :', 4),
(120, 'Comment obtenir des informations à partir d\'un formulaire soumis à l\'aide de la méthode « get » ?', 4),
(121, 'Lors de l\'utilisation de la méthode POST, les variables sont affichées dans l\'URL :', 4),
(122, 'En PHP, vous pouvez utiliser à la fois des guillemets simples ( \' \' ) et des guillemets doubles ( \" \" ) pour les chaînes :', 4),
(123, 'Les fichiers à inclure doivent avoir l\'extension de fichier \".inc\"', 4),
(124, 'Quelle est la bonne façon d\'inclure le fichier \"time.inc\" ?', 4),
(125, 'Quelle est la bonne façon de créer une fonction en PHP ?', 4),
(126, 'Quelle est la bonne façon d\'ouvrir le fichier \"time.txt\" comme lisible ?', 4),
(127, 'PHP vous permet d\'envoyer des emails directement depuis un script', 4),
(128, 'Quelle variable superglobale contient des informations sur les en-têtes, les chemins et les emplacements de script ?', 4),
(129, 'Quelle est la bonne façon d’ajouter 1 à la variable $count ?', 4),
(130, 'Quelle est la bonne façon d’ajouter un commentaire en PHP ?', 4),
(131, 'PHP peut être exécuté sur Microsoft Windows IIS (Internet Information Server) :', 4),
(132, 'Les fonctions die() et exit() font exactement la même chose.', 4),
(133, 'Laquelle de ces variables a un nom illégal ?', 4),
(134, 'Comment créer un cookie en PHP ?', 4),
(135, 'En PHP, la seule façon de générer du texte est avec echo.', 4),
(136, 'Comment créer un tableau en PHP ?', 4),
(137, 'L\'instruction if est utilisée pour exécuter du code uniquement si une condition spécifiée est vraie', 4),
(138, 'Quel opérateur est utilisé pour vérifier si deux valeurs sont égales et du même type de données ?', 4);

-- --------------------------------------------------------

--
-- Table structure for table `score`
--

CREATE TABLE `score` (
  `id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `result` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `score`
--

INSERT INTO `score` (`id`, `created_at`, `result`, `user_id`, `category_id`) VALUES
(1, '2023-09-09 16:02:30', 100, 26, 1),
(3, '2023-09-09 16:26:25', 70, 26, 1),
(10, '2023-09-09 16:38:28', 50, 26, 1),
(11, '2023-09-09 16:52:53', 80, 26, 2),
(12, '2023-09-09 16:54:17', 90, 26, 3),
(13, '2023-09-09 16:55:13', 90, 26, 4),
(14, '2023-09-09 16:56:26', 80, 26, 5);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `alias`, `role`) VALUES
(20, 'admin@mail.com', '$2y$10$Fsxl3iHn7vNH7gInd8mRO.SwZKOFXnsoUKpK2z7ZiImy7CPEgeC72', 'Admin', 'admin'),
(26, 'user@mail.com', '$2y$10$Rq2pb.uJLTRxX8LmwaR85e5qq6GXtnLAFh6nYLNgXw8BafY/rYvIa', 'User480', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_answer_question` (`question_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answer`
--
ALTER TABLE `answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=460;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `FK_answer_question` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `FK_question_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `FK_score_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_score_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
