-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Gen 21, 2015 alle 21:15
-- Versione del server: 5.6.17-log
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mappiamo_test`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `contents` text COLLATE utf8_unicode_ci,
  `flagship` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dump dei dati per la tabella `categories`
--

INSERT INTO `categories` (`id`, `name`, `title`, `contents`, `flagship`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(1, 'sea', 'Sea', '{931};{932}', 0, '2015-01-20 09:05:04', 27, '2015-01-20 09:09:10', 27, 1),
(2, 'mount', 'Mount', '{931};{932}', 0, '2015-01-20 09:05:52', 27, '2015-01-20 09:09:11', 27, 1),
(3, 'cities', 'Cities', '{933};{934}', 0, '2015-01-20 10:00:39', 27, '2015-01-20 10:12:52', 27, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(555) COLLATE utf8_unicode_ci NOT NULL,
  `lat` double NOT NULL DEFAULT '0',
  `lng` double NOT NULL DEFAULT '0',
  `license` int(11) NOT NULL DEFAULT '1',
  `text` longtext COLLATE utf8_unicode_ci,
  `url` text COLLATE utf8_unicode_ci,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `translation` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `language` varchar(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'it',
  `parent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=935 ;

--
-- Dump dei dati per la tabella `contents`
--

INSERT INTO `contents` (`id`, `type`, `name`, `title`, `address`, `lat`, `lng`, `license`, `text`, `url`, `start`, `end`, `created`, `createdby`, `modified`, `modifiedby`, `hits`, `translation`, `enabled`, `language`, `parent`) VALUES
(931, 'place', 'somewhere-beyond-the-sea-', 'Somewhere Beyond The Sea ', 'Palagruza', 42.3928482, 16.2592586, 3, NULL, NULL, NULL, NULL, '2015-01-20 09:00:00', 27, '2015-01-20 09:04:01', 27, 6, 0, 1, 'it', NULL),
(932, 'place', 'somewhere-beyond-the-sea--en', 'Somewhere Beyond The Sea  (en)', 'Palagruza', 42.3928482, 16.2592586, 3, NULL, NULL, NULL, NULL, '2015-01-20 09:09:10', 27, '2015-01-20 09:09:18', 27, 1, 0, 1, 'en', 931),
(933, 'place', 'budapest', 'Budapest', 'Budapest', 47.4983815, 19.0404707, 4, '<p><strong>Budapest</strong> (<a title="Aiuto:IPA" href="http://it.wikipedia.org/wiki/Aiuto:IPA"><span class="IPA" title="Questa è una trascrizione IPA della pronuncia. Vedere l''alfabeto fonetico internazionale.">[ˈbudɒpɛʃt]</span></a> <span class="noprint"><span class="unicode audiolink"><a class="internal" title="Hu-Budapest.ogg" href="http://upload.wikimedia.org/wikipedia/commons/d/d9/Hu-Budapest.ogg"><small>ascolta</small></a></span><sup>[<a title="Aiuto:File multimediali" href="http://it.wikipedia.org/wiki/Aiuto:File_multimediali">?</a>·<a title="File:Hu-Budapest.ogg" href="http://it.wikipedia.org/wiki/File:Hu-Budapest.ogg">info</a>]</sup></span>) è la <a title="Capitale (città)" href="http://it.wikipedia.org/wiki/Capitale_%28citt%C3%A0%29">capitale</a> dell''<a title="Ungheria" href="http://it.wikipedia.org/wiki/Ungheria">Ungheria</a> e <a title="Suddivisioni amministrative dell''Ungheria" href="http://it.wikipedia.org/wiki/Suddivisioni_amministrative_dell%27Ungheria">provincia</a> autonoma. È la maggiore città ungherese per numero di abitanti, circa 1.700.000, con un agglomerato urbano di 2.551.247 e un''area metropolitana di 3.284.110 abitanti, nonché centro primario del paese per la vita politica, economica, industriale e culturale. La sua massima espansione si è avuta nel <a title="1989" href="http://it.wikipedia.org/wiki/1989">1989</a> quando ha toccato quota 2.113.645 abitanti. Budapest nasce ufficialmente nel <a title="1873" href="http://it.wikipedia.org/wiki/1873">1873</a> con l''unione delle città di <a title="Buda" href="http://it.wikipedia.org/wiki/Buda">Buda</a> e <a title="Óbuda" href="http://it.wikipedia.org/wiki/%C3%93buda">Óbuda</a>, situate sulla sponda occidentale del <a title="Danubio" href="http://it.wikipedia.org/wiki/Danubio">Danubio</a>, con la città di <a title="Pest" href="http://it.wikipedia.org/wiki/Pest">Pest</a>, situata sulla sponda orientale.<br /> Budapest è molto popolare tra i turisti: nel <a title="2011" href="http://it.wikipedia.org/wiki/2011">2011</a> 4,7 milioni di turisti l''hanno visitata secondo l''Euromonitor International, per questo è la 25ª città più visitata del mondo.<sup class="reference"><a href="http://it.wikipedia.org/wiki/Budapest#cite_note-1">[1]</a></sup></p>', NULL, NULL, NULL, '2015-01-20 10:01:28', 27, '2015-01-20 10:12:42', 27, 3, 0, 1, 'it', NULL),
(934, 'place', 'budapest-en', 'Budapest (en)', 'Budapest', 47.4983815, 19.0404707, 4, '<p><strong>Budapest</strong> (<a title="Aiuto:IPA" href="http://it.wikipedia.org/wiki/Aiuto:IPA"><span class="IPA" title="Questa è una trascrizione IPA della pronuncia. Vedere l''alfabeto fonetico internazionale.">[ˈbudɒpɛʃt]</span></a> <span class="noprint"><span class="unicode audiolink"><a class="internal" title="Hu-Budapest.ogg" href="http://upload.wikimedia.org/wikipedia/commons/d/d9/Hu-Budapest.ogg"><small>ascolta</small></a></span><sup>[<a title="Aiuto:File multimediali" href="http://it.wikipedia.org/wiki/Aiuto:File_multimediali">?</a>·<a title="File:Hu-Budapest.ogg" href="http://it.wikipedia.org/wiki/File:Hu-Budapest.ogg">info</a>]</sup></span>) è la <a title="Capitale (città)" href="http://it.wikipedia.org/wiki/Capitale_%28citt%C3%A0%29">capitale</a> dell''<a title="Ungheria" href="http://it.wikipedia.org/wiki/Ungheria">Ungheria</a> e <a title="Suddivisioni amministrative dell''Ungheria" href="http://it.wikipedia.org/wiki/Suddivisioni_amministrative_dell%27Ungheria">provincia</a> autonoma. È la maggiore città ungherese per numero di abitanti, circa 1.700.000, con un agglomerato urbano di 2.551.247 e un''area metropolitana di 3.284.110 abitanti, nonché centro primario del paese per la vita politica, economica, industriale e culturale. La sua massima espansione si è avuta nel <a title="1989" href="http://it.wikipedia.org/wiki/1989">1989</a> quando ha toccato quota 2.113.645 abitanti. Budapest nasce ufficialmente nel <a title="1873" href="http://it.wikipedia.org/wiki/1873">1873</a> con l''unione delle città di <a title="Buda" href="http://it.wikipedia.org/wiki/Buda">Buda</a> e <a title="Óbuda" href="http://it.wikipedia.org/wiki/%C3%93buda">Óbuda</a>, situate sulla sponda occidentale del <a title="Danubio" href="http://it.wikipedia.org/wiki/Danubio">Danubio</a>, con la città di <a title="Pest" href="http://it.wikipedia.org/wiki/Pest">Pest</a>, situata sulla sponda orientale.<br /> Budapest è molto popolare tra i turisti: nel <a title="2011" href="http://it.wikipedia.org/wiki/2011">2011</a> 4,7 milioni di turisti l''hanno visitata secondo l''Euromonitor International, per questo è la 25ª città più visitata del mondo.<sup class="reference"><a href="http://it.wikipedia.org/wiki/Budapest#cite_note-1">[1]</a></sup></p>', NULL, NULL, NULL, '2015-01-20 10:12:51', 27, '2015-01-20 10:13:49', 27, 0, 0, 1, 'en', 933);

-- --------------------------------------------------------

--
-- Struttura della tabella `content_media`
--

CREATE TABLE IF NOT EXISTS `content_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `external_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `default_media` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `content_media`
--

INSERT INTO `content_media` (`id`, `external_id`, `title`, `url`, `default_media`) VALUES
(1, 933, 'Budai_palota_1930', 'http://test.mappiamo.com/mapi/media/contents/bc13e631623c285ec2db00596a2a6fd2e5231927_Budai_palota_1930.jpg', 1),
(2, 934, 'Budai_palota_1930', 'http://test.mappiamo.com/mapi/media/contents/bc13e631623c285ec2db00596a2a6fd2e5231927_Budai_palota_1930.jpg', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `content_meta`
--

CREATE TABLE IF NOT EXISTS `content_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `external_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`external_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `content_meta`
--

INSERT INTO `content_meta` (`id`, `external_id`, `name`, `value`) VALUES
(1, 933, 'photo-source', 'http://it.wikipedia.org/wiki/Budapest#mediaviewer/File:Budai_palota_1930.jpg'),
(2, 933, 'text-source', 'http://it.wikipedia.org/wiki/Budapest'),
(3, 934, 'photo-source', 'http://it.wikipedia.org/wiki/Budapest#mediaviewer/File:Budai_palota_1930.jpg'),
(4, 934, 'text-source', 'http://it.wikipedia.org/wiki/Budapest');

-- --------------------------------------------------------

--
-- Struttura della tabella `licenses`
--

CREATE TABLE IF NOT EXISTS `licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dump dei dati per la tabella `licenses`
--

INSERT INTO `licenses` (`id`, `title`, `description`, `url`, `enabled`) VALUES
(1, 'Copyright', 'Copyrighted content.', '', 1),
(2, 'ODbL', '', 'http://opendatacommons.org/licenses/odbl/', 1),
(3, 'CC0', '', 'https://creativecommons.org/publicdomain/zero/1.0/', 1),
(4, 'CC-BY-SA', '', 'https://creativecommons.org/licenses/by-sa/2.0/', 1),
(5, ' IODL v2.0', '', 'http://www.dati.gov.it/iodl/2.0/', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `pages` text COLLATE utf8_unicode_ci,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `menus`
--

INSERT INTO `menus` (`id`, `name`, `title`, `pages`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(4, 'main', 'Main', '{1};{2}', '2014-02-03 19:57:40', 26, '2014-02-04 20:09:36', 26, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_module` tinyint(1) DEFAULT '0',
  `manager` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=218 ;

--
-- Dump dei dati per la tabella `modules`
--

INSERT INTO `modules` (`id`, `name`, `title`, `version`, `description`, `default_module`, `manager`, `enabled`) VALUES
(202, 'content', 'Content', '0.0.6', 'Display content', 0, 0, 1),
(203, 'blog', 'Blog', '0.0.6', 'Display content list', 0, 0, 1),
(201, 'home', 'Home', '0.0.6', 'HomePage', 1, 0, 1),
(101, 'dashboard', 'Dashboard', '0.0.6', 'Dashboard', 0, 1, 1),
(110, 'mcontent', 'ManageContents', '0.0.6', 'Manage contents', 0, 1, 1),
(102, 'mnotfound', 'NotFound', '0.0.6', 'Object not found', 0, 1, 1),
(111, 'mcategory', 'Categories', '0.0.6', 'Manage categories', 0, 1, 1),
(112, 'mmodule', 'Modules', '0.0.6', 'Manage modules', 0, 1, 1),
(113, 'mtemplate', 'Templates', '0.0.6', 'Manage templates', 0, 1, 1),
(114, 'muser', 'User', '0.0.6', 'Manage users', 0, 1, 1),
(199, 'majax', 'Ajax', '0.0.6', 'Ajax run for manager', 0, 1, 1),
(119, 'profile', 'Profile', '0.0.6', 'Profile management', 0, 1, 1),
(115, 'mpage', 'Pages', '0.0.6', 'Manage pages', 0, 1, 1),
(116, 'mmenu', 'Menus', '0.0.6', 'Manage menus', 0, 1, 1),
(100, 'login', 'Login', '0.0.6', 'Mappiamo manager login', 0, 1, 1),
(117, 'preferences', 'Preferences', '0.0.6', 'Mappiamo preferences', 0, 1, 1),
(118, 'mwidget', 'Widgets', '0.0.6', 'Manage widgets', 0, 1, 1),
(120, 'denied', 'Access denied', '0.0.6', 'Access denied message', 0, 1, 1),
(121, 'register', 'Register', '0.0.6', 'User registration', 0, 1, 1),
(216, 'category', 'Category', '0.0.6', 'Displaying category items in blog layout', 0, 0, 1),
(217, 'api', 'Api', '0.0.6', 'API for data reading', 0, 0, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(25) CHARACTER SET ucs2 COLLATE ucs2_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `blank` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dump dei dati per la tabella `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `type`, `url`, `blank`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(1, 'sea', 'Sea', 'category', 'index.php?module=category&object=1', 0, '2015-01-20 09:09:59', 27, '2015-01-20 09:09:59', 27, 1),
(2, 'mount', 'Mount', 'category', 'index.php?module=category&object=2', 0, '2015-01-20 09:11:00', 27, '2015-01-20 09:11:00', 27, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dump dei dati per la tabella `preferences`
--

INSERT INTO `preferences` (`id`, `name`, `value`) VALUES
(2, 'force_php_errors_and_warnings', 'no'),
(3, 'routing', 'default'),
(5, 'website_title', '#mappiamo'),
(6, 'website_description', 'mappiamo.org'),
(7, 'website_email', 'info@mappiamo.com'),
(8, 'new_user_default_group', '3'),
(9, 'facebook_app_id', '488785261198856'),
(10, 'facebook_secret', '2f8e52496f1efdce948de72383814d4c'),
(11, 'registration', 'yes'),
(12, 'default_language', 'en');

-- --------------------------------------------------------

--
-- Struttura della tabella `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_template` tinyint(1) DEFAULT '0',
  `manager` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=209 ;

--
-- Dump dei dati per la tabella `templates`
--

INSERT INTO `templates` (`id`, `name`, `title`, `version`, `description`, `default_template`, `manager`, `enabled`) VALUES
(201, 'mappiamo', 'Mappiamo', '0.0.6', 'Mappiamo template', 1, 0, 1),
(101, 'manager', 'Manager', '0.0.6', 'Manager template', 0, 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `username` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `createdby` int(11) NOT NULL,
  `modified` datetime NOT NULL,
  `modifiedby` int(11) NOT NULL,
  `lastlogin` text COLLATE utf8_unicode_ci,
  `activation` text CHARACTER SET ucs2 COLLATE ucs2_unicode_ci,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `group_id`, `username`, `password`, `email`, `name`, `created`, `createdby`, `modified`, `modifiedby`, `lastlogin`, `activation`, `enabled`) VALUES
(1, 100, 'mappiamo', '23a304827dd47c13ec8523bb58699fd5', '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 'bWFwcGlhbW8gc1FHVmVWMzUhUWhrXlAlc3huViNSQ2M3|MjAxNC0wMi0xNSAxNTozNjo0Ng==|TW96aWxsYS81LjAgKE1hY2ludG9zaDsgSW50ZWwgTWFjIE9TIFggMTBfOV8xKSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMzIuMC4xNzAwLjEwNyBTYWZhcmkvNTM3LjM2', NULL, 0),
(27, 1, 'demo', 'c4aadc5a85db61399dbb70f187c2ceda', 'info@mappiamo.com', '#mappiamo', '2014-02-02 12:11:26', 1001, '2014-02-02 12:11:26', 1001, 'ZGVtbyA3cm5QJDh1clg4a2F4NSFUM0ozYnkkS2I=|MjAxNS0wMS0yMCAwOTo1MToxMQ==|TW96aWxsYS81LjAgKFgxMTsgVWJ1bnR1OyBMaW51eCBpNjg2OyBydjozMC4wKSBHZWNrby8yMDEwMDEwMSBGaXJlZm94LzMwLjA=', NULL, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dump dei dati per la tabella `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `title`) VALUES
(1, 'admin', 'Admin'),
(2, 'editor', 'Editor'),
(3, 'collaborator', 'Collaborator'),
(4, 'viewer', 'Viewer');

-- --------------------------------------------------------

--
-- Struttura della tabella `widgets`
--

CREATE TABLE IF NOT EXISTS `widgets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `version` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `manager` tinyint(1) NOT NULL DEFAULT '0',
  `enabled` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dump dei dati per la tabella `widgets`
--

INSERT INTO `widgets` (`id`, `name`, `title`, `version`, `description`, `manager`, `enabled`) VALUES
(5, 'content', 'Content', '0.0.6', 'Display content widget', 0, 1),
(6, 'content_image', 'Content Image', '0.0.6', 'Display content image widget', 0, 1),
(7, 'map', 'Map Widget', '0.0.6', 'Display a map widget', 0, 1),
(8, 'content_market', 'Content Market', '0.0.6', 'Display content short text in a widget', 0, 1),
(9, 'menu', 'Menu', '0.0.6', 'Display menu items', 0, 1),
(10, 'language_switch', 'Language switch widget', '0.0.6', 'Display language switch box in widget', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
