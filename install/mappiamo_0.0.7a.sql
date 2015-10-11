-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2015. Aug 29. 18:14
-- Szerver verzió: 5.6.16
-- PHP verzió: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `travocia_mappi`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `categories`
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
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `contents`
--

CREATE TABLE IF NOT EXISTS `contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
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
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `route` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- A tábla adatainak kiíratása `contents`
--

INSERT INTO `contents` (`id`, `type`, `title`, `name`, `address`, `lat`, `lng`, `license`, `text`, `url`, `start`, `end`, `created`, `createdby`, `modified`, `modifiedby`, `hits`, `translation`, `enabled`, `language`, `parent`, `import_id`, `route`) VALUES
(2, 'place', 'testing valid geom', 'testing-valid-geom', 'Tricase', 0, 0, 1, 'this is valid geom', NULL, NULL, NULL, '2015-08-28 19:06:59', 27, '2015-08-28 19:07:15', 27, 13, 0, 1, 'it', NULL, '31d2f287-4da7-11e5-a1ea-00ff159b033b', 'GeometryCollection(LINESTRING (18.25226211512927 39.96621420702385, 18.270114898332395 39.977001709273395, 18.28522109950427 39.957530346657215, 18.326763152726926 39.97489696447749, 18.33019638026599 39.957530346657215, 18.37757492030505 39.97410766846727, 18.38959121669177 39.95253004797611, 18.373798370012082 39.930945618158084, 18.37414169276599 39.91330450544451),POLYGON ((18.250202178605832 39.957530346657215, 18.267368316301145 39.96858234116624, 18.281787871965207 39.951214119140296, 18.318180083879266 39.965161676628334, 18.327793120988645 39.94726618073137, 18.368305205949582 39.963845990846615, 18.377231597551145 39.952793230705204, 18.36315536464099 39.93068235138136, 18.31543350184802 39.91251449856508, 18.275608062394895 39.919887541747364, 18.259128570207395 39.934894498301546, 18.250202178605832 39.957530346657215)),POINT (18.257068633683957 39.90013653453592),POINT (18.36487197841052 39.89276136531822),POLYGON ((18.273891448625363 39.885385402448236, 18.273891448625363 39.905667390592754, 18.298610686906613 39.905667390592754, 18.298610686906613 39.885385402448236, 18.273891448625363 39.885385402448236)),POLYGON ((18.311313628801145 39.884331628681, 18.311313628801145 39.904350560598196, 18.342212676652707 39.904350560598196, 18.342212676652707 39.884331628681, 18.311313628801145 39.884331628681)))'),
(3, 'post', 'testing valid geom 2', 'testing-valid-geom-2', 'Tricase', 0, 0, 1, 'geom test 2', NULL, NULL, NULL, '2015-08-28 19:17:21', 27, '2015-08-28 19:17:30', 27, 6, 0, 1, 'it', NULL, 'a496f457-4da8-11e5-a1ea-00ff159b033b', 'GeometryCollection(LINESTRING (18.250888824113645 39.95902159035327, 18.273548125871457 39.97507235967662, 18.30719375575427 39.98164945505294, 18.346332549699582 39.98164945505294, 18.38650131190661 39.97480926269457, 18.400234222062863 39.95717945775459, 18.406414031633176 39.949020845476525),POLYGON ((18.259815215715204 39.95349504368804, 18.278354644426145 39.9692839921107, 18.320240020402704 39.9705995732383, 18.358692168840207 39.970862686425406, 18.386157989152707 39.94796805042382, 18.377231597551145 39.91927314912139, 18.342212676652707 39.89451742729756, 18.28110122645739 39.90004873689111, 18.25329208339099 39.9237492925147, 18.259815215715204 39.95349504368804)),POLYGON ((18.24573898280505 39.88503414364552, 18.24573898280505 39.89978535131964, 18.261875152238645 39.89978535131964, 18.261875152238645 39.88503414364552, 18.24573898280505 39.88503414364552)),POLYGON ((18.35937881434802 39.881609302139275, 18.35937881434802 39.89399061262403, 18.379291534074582 39.89399061262403, 18.379291534074582 39.881609302139275, 18.35937881434802 39.881609302139275)),POINT (18.273548125871457 39.88239966536291),POINT (18.312000274308957 39.880818929805486),POINT (18.34289932216052 39.880818929805486))'),
(4, 'post', 'testing geom 3', 'testing-geom-3', 'miskolc', 48.1031517, 20.7902158, 1, 'testing 3 example', NULL, NULL, NULL, '2015-08-28 19:20:42', 27, '2015-08-28 19:20:57', 27, 6, 0, 1, 'it', NULL, '1c41477e-4da9-11e5-a1ea-00ff159b033b', 'GeometryCollection(POLYGON ((20.708393096574582 48.13842012028725, 20.691570281633176 48.12077556474221, 20.731052398332395 48.095099934246406, 20.7698478695238 48.11756681240265, 20.7588615413988 48.1423148545612, 20.708393096574582 48.13842012028725)),POLYGON ((20.857395171769895 48.12490080897993, 20.866321563371457 48.128109103235474, 20.873874663957395 48.130171472286335, 20.871814727433957 48.13269203309794, 20.8687248226488 48.132462896318344, 20.866321563371457 48.13406683230366, 20.862888335832395 48.13406683230366, 20.860141753801145 48.13635808251609, 20.858425140031613 48.14025297322402, 20.8577384945238 48.13589984065327, 20.855335235246457 48.13085891023194, 20.857395171769895 48.12490080897993)),POLYGON ((20.804180144914426 48.1386492304829, 20.806240081437863 48.133379437301905, 20.80486679042224 48.129484025138396, 20.80521011317614 48.125129979501565, 20.808643340715207 48.12260904752603, 20.805896758683957 48.120317183821115, 20.816196441301145 48.11894201651733, 20.82031631434802 48.11229485561447, 20.825122832902707 48.10472979886196, 20.830959319719113 48.103124946693825, 20.84057235682849 48.10197859303902, 20.84778213466052 48.10106149170854, 20.85052871669177 48.10060293490776, 20.847095489152707 48.1070223578973, 20.847095489152707 48.111607169197676, 20.843662261613645 48.11756681240265, 20.84057235682849 48.1276507877546, 20.835422515519895 48.13154633897524, 20.833362578996457 48.13635808251609, 20.804180144914426 48.1386492304829)),LINESTRING (20.79285049403552 48.10014437401659, 20.800403594621457 48.09899795389317, 20.804523467668332 48.09555854013226, 20.810016631730832 48.08982567255504, 20.8137931820238 48.089367015537825, 20.821689605363645 48.0808811228781, 20.827182769426145 48.07377024302576, 20.8302726742113 48.06711723986775, 20.825466155656613 48.06252846069394, 20.825122832902707 48.057021385676826, 20.8302726742113 48.05610348256619, 20.84022903407458 48.058398209659835, 20.84778213466052 48.06803494661152, 20.85052871669177 48.08317474543954, 20.84949874843005 48.09280684346001),POINT (20.749248504289426 48.078128640811606),POINT (20.72967910731677 48.12077556474221),POINT (20.825466155656613 48.12215068296515),POINT (20.834735870012082 48.07101738051832),POINT (20.882114410051145 48.07354084344167))');

--
-- Eseményindítók `contents`
--
DROP TRIGGER IF EXISTS `InsertContents`;
DELIMITER //
CREATE TRIGGER `InsertContents` BEFORE INSERT ON `contents`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `content_media`
--

CREATE TABLE IF NOT EXISTS `content_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `external_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` text COLLATE utf8_unicode_ci,
  `default_media` tinyint(1) NOT NULL DEFAULT '0',
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `content_meta`
--

CREATE TABLE IF NOT EXISTS `content_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `external_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(20000) COLLATE utf8_unicode_ci NOT NULL,
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `content_id` (`external_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `licenses`
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
-- A tábla adatainak kiíratása `licenses`
--

INSERT INTO `licenses` (`id`, `title`, `description`, `url`, `enabled`) VALUES
(1, 'Copyright', 'Copyrighted content.', '', 1),
(2, 'ODbL', '', 'http://opendatacommons.org/licenses/odbl/', 1),
(3, 'CC0', '', 'https://creativecommons.org/publicdomain/zero/1.0/', 1),
(4, 'CC-BY-SA', '', 'https://creativecommons.org/licenses/by-sa/2.0/', 1),
(5, 'IODL v2.0', '', 'http://www.dati.gov.it/iodl/2.0/', 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `menus`
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
-- A tábla adatainak kiíratása `menus`
--

INSERT INTO `menus` (`id`, `name`, `title`, `pages`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(4, 'main', 'Main', '{1};{2}', '2014-02-03 19:57:40', 26, '2014-02-04 20:09:36', 26, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `modules`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=220 ;

--
-- A tábla adatainak kiíratása `modules`
--

INSERT INTO `modules` (`id`, `name`, `title`, `version`, `description`, `default_module`, `manager`, `enabled`) VALUES
(222, 'page404', 'Page 404', '0.0.1', 'Display a 404 page', 0, 0, 1),
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
(217, 'api', 'Api', '0.0.6', 'API for data reading', 0, 0, 1),
(218, 'ajax', 'Ajax module', '0.0.6', 'Frontend ajax run', 0, 0, 1),
(219, 'event', 'event', '0.0.6', 'event', 0, 0, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `pages`
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
-- A tábla adatainak kiíratása `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `type`, `url`, `blank`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(1, 'sea', 'Sea', 'category', 'http://travocial.com/index.php?module=category&object=1', 0, '2015-01-20 09:09:59', 27, '2015-06-08 18:37:01', 27, 1),
(2, 'mount', 'Mount', 'category', 'http://travocial.com/index.php?module=category&object=2', 0, '2015-01-20 09:11:00', 27, '2015-06-08 18:36:26', 27, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `preferences`
--

CREATE TABLE IF NOT EXISTS `preferences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- A tábla adatainak kiíratása `preferences`
--

INSERT INTO `preferences` (`id`, `name`, `value`) VALUES
(2, 'force_php_errors_and_warnings', 'yes'),
(3, 'routing', 'default'),
(5, 'website_title', '#mappiamo'),
(6, 'website_description', 'mappiamo.org'),
(7, 'website_email', 'info@mappiamo.com'),
(8, 'new_user_default_group', '3'),
(9, 'facebook_app_id', '488785261198856'),
(10, 'facebook_secret', '2f8e52496f1efdce948de72383814d4c'),
(11, 'registration', 'yes'),
(12, 'default_language', 'it'),
(13, 'domain', 'travocial.com'),
(14, 'website_name', '#mappiamo'),
(15, 'location', 'Tricase'),
(16, 'DefaultLatitude', '39.93042'),
(17, 'DefaultLongitude', '18.355332'),
(18, 'flickr_apikey', 'a868bb5f7da2815b93ab063fa6f04c36'),
(19, 'flickr_bbox', '17.832308, 39.743896,18.580752, 40.450872'),
(20, 'flickr_numofpics', '250');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `templates`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=210 ;

--
-- A tábla adatainak kiíratása `templates`
--

INSERT INTO `templates` (`id`, `name`, `title`, `version`, `description`, `default_template`, `manager`, `enabled`) VALUES
(201, 'mappiamo', 'Mappiamo', '0.0.6', 'Mappiamo template', 1, 0, 1),
(101, 'manager', 'Manager', '0.0.6', 'Manager template', 0, 1, 1),
(209, 'gal2', 'Gal template', '0.0.1', 'Frontend template', 0, 0, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
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
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `group_id`, `username`, `password`, `email`, `name`, `created`, `createdby`, `modified`, `modifiedby`, `lastlogin`, `activation`, `enabled`) VALUES
(1, 100, 'mappiamo', '23a304827dd47c13ec8523bb58699fd5', '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 'bWFwcGlhbW8gc1FHVmVWMzUhUWhrXlAlc3huViNSQ2M3|MjAxNC0wMi0xNSAxNTozNjo0Ng==|TW96aWxsYS81LjAgKE1hY2ludG9zaDsgSW50ZWwgTWFjIE9TIFggMTBfOV8xKSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMzIuMC4xNzAwLjEwNyBTYWZhcmkvNTM3LjM2', NULL, 0),
(27, 1, 'demo', 'c4aadc5a85db61399dbb70f187c2ceda', 'info@mappiamo.com', '#mappiamo', '2014-02-02 12:11:26', 1001, '2014-02-02 12:11:26', 1001, 'ZGVtbyAxdjBKTzgpeWIyM09pZyYkWXdsRkZwNnI=|MjAxNS0wOC0yOCAxOToxNjoyNA==|TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgNi4zOyBXT1c2NDsgcnY6NDAuMCkgR2Vja28vMjAxMDAxMDEgRmlyZWZveC80MC4w', NULL, 1);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_groups`
--

CREATE TABLE IF NOT EXISTS `user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- A tábla adatainak kiíratása `user_groups`
--

INSERT INTO `user_groups` (`id`, `name`, `title`) VALUES
(1, 'admin', 'Admin'),
(2, 'editor', 'Editor'),
(3, 'collaborator', 'Collaborator'),
(4, 'viewer', 'Viewer');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `widgets`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=27 ;

--
-- A tábla adatainak kiíratása `widgets`
--

INSERT INTO `widgets` (`id`, `name`, `title`, `version`, `description`, `manager`, `enabled`) VALUES
(5, 'content', 'Content', '0.0.6', 'Display content widget', 0, 1),
(6, 'content_image', 'Content Image', '0.0.6', 'Display content image widget', 0, 1),
(7, 'map', 'Map Widget', '0.0.6', 'Display a map widget', 0, 1),
(8, 'content_market', 'Content Market', '0.0.6', 'Display content short text in a widget', 0, 1),
(9, 'menu', 'Menu', '0.0.6', 'Display menu items', 0, 1),
(10, 'language_switch', 'Language switch widget', '0.0.6', 'Display language switch box in widget', 0, 1),
(11, 'intro', 'Intro widget', '0.0.6', 'Intro image widget for contents', 0, 1),
(12, 'routes', 'Routes widget', '0.0.6', 'Routes widget', 0, 1),
(13, 'weather', 'Weather widget', '0.0.6', 'Weather widget', 0, 1),
(14, 'flickr', 'flickr plugin', '0.0.6', 'flickr plugin', 0, 1),
(22, 'box_allmeta', 'box_allmeta', '0.0.6', 'box_allmeta', 0, 1),
(16, 'breadcrumbs', 'breadcrumbs', '0.0.6', 'breadcrumbs', 0, 1),
(17, 'share', 'share', '0.0.6', 'share', 0, 1),
(18, 'videobox', 'videobox', '0.0.6', 'videobox', 0, 1),
(19, 'panoramabox', 'panoramabox', '0.0.6', 'panoramabox', 0, 1),
(20, 'content_slideshow', 'content_slideshow', '0.0.6', 'content_slideshow', 0, 1),
(21, 'content_headline', 'content_headline', '0.0.6', 'content_headline', 0, 1),
(23, 'box_onemeta', 'box_onemeta', '0.0.6', 'box_onemeta', 0, 1),
(24, 'box_distance', 'box_distance', '0.0.6', 'box_distance', 0, 1),
(25, 'box_events', 'box_events', '0.0.6', 'box_events', 0, 1),
(26, 'togglemenu', 'togglemenu', '0.0.6', 'togglemenu', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
