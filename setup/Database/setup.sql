-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2015. Sze 20. 19:00
-- Szerver verzió: 5.6.16
-- PHP verzió: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Adatbázis: `mappiamo_demo`
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`id`, `name`, `title`, `contents`, `flagship`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`, `import_id`) VALUES
(1, 'posts', 'Posts', '{1}', 0, '2015-09-20 16:01:36', 27, '2015-09-20 16:03:22', 27, 1, NULL),
(2, 'places', 'Places', '{2};{5};{6};{7};{8}', 0, '2015-09-20 16:01:44', 27, '2015-09-20 18:49:51', 27, 1, NULL),
(3, 'events', 'Events', '{4};{9}', 0, '2015-09-20 16:01:51', 27, '2015-09-20 18:53:55', 27, 1, NULL),
(4, 'routes', 'Routes', '{3};{10}', 0, '2015-09-20 16:01:58', 27, '2015-09-20 18:53:37', 27, 1, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- A tábla adatainak kiíratása `contents`
--

INSERT INTO `contents` (`id`, `type`, `title`, `name`, `address`, `lat`, `lng`, `license`, `text`, `url`, `start`, `end`, `created`, `createdby`, `modified`, `modifiedby`, `hits`, `translation`, `enabled`, `language`, `parent`, `import_id`, `route`) VALUES
(1, 'post', 'Sample content 1', 'sample-content-1', 'Tricase', 39.93042, 18.355332, 1, 'This is post.', NULL, NULL, NULL, '2015-09-20 15:53:37', 27, '2015-09-20 16:03:27', 27, 3, 0, 1, 'it', NULL, NULL, NULL),
(2, 'place', 'Sample content 2', 'sample-content-2', 'Specchia', 39.9411672, 18.2999958, 1, 'This is place.', NULL, NULL, NULL, '2015-09-20 15:54:59', 27, '2015-09-20 15:55:13', 27, 5, 0, 1, 'it', NULL, NULL, NULL),
(3, 'route', 'Route test', 'route-test', 'Tricase', 39.93042, 18.355332, 1, 'This is route.', NULL, NULL, NULL, '2015-09-20 15:56:49', 27, '2015-09-20 16:03:55', 27, 6, 0, 1, 'it', NULL, NULL, 'GeometryCollection(POINT(18.355332 39.93042),POINT(18.3615327 39.9611275),POINT(18.311631 39.95972),POINT(18.297631 39.93712),POINT(18.3312082 39.8896785),POINT(18.364433 39.905819),POINT(18.355332 39.93042))'),
(4, 'event', 'Event test', 'event-test', 'Tricase', 39.93042, 18.355332, 1, 'This is event.', NULL, '2015-09-21 15:57:00', '2015-09-30 15:57:00', '2015-09-20 15:57:36', 27, '2015-09-20 16:04:24', 27, 3, 0, 1, 'it', NULL, NULL, NULL),
(5, 'place', 'Place 2', 'place-2', 'Tricase', 39.93042, 18.355332, 1, 'Place 2', NULL, NULL, NULL, '2015-09-20 16:31:11', 27, '2015-09-20 16:31:37', 27, 2, 0, 1, 'it', NULL, NULL, NULL),
(6, 'place', 'Place - Budapest', 'place---budapest', 'Budapest', 47.497912, 19.040235, 1, NULL, NULL, NULL, NULL, '2015-09-20 18:46:21', 27, '2015-09-20 18:46:36', 27, 1, 0, 1, 'it', NULL, NULL, NULL),
(7, 'place', 'Place - Miskolc', 'place---miskolc', 'Miskolc', 48.0963631, 20.762386, 1, 'Place test', NULL, NULL, NULL, '2015-09-20 18:47:01', 27, '2015-09-20 18:47:12', 27, 1, 0, 1, 'it', NULL, NULL, NULL),
(8, 'place', 'Place with lines', 'place-with-lines', 'Tápióbicske', 47.3661203, 19.6863365, 1, 'Drawind samples', NULL, NULL, NULL, '2015-09-20 18:49:40', 27, '2015-09-20 18:50:02', 27, 1, 0, 1, 'it', NULL, NULL, 'GeometryCollection(POLYGON ((19.670087814156428 47.376214815315315, 19.671976089302913 47.37760974774237, 19.67884254438104 47.37586607644249, 19.684679031197447 47.37133226121006, 19.693262100045104 47.3814456216379, 19.70321845990838 47.37760974774237, 19.69755363446893 47.369937162719225, 19.701501846138854 47.36784444578889, 19.697381973091975 47.36179835267775, 19.702531814400572 47.35772847674406, 19.69909858686151 47.35400717258351, 19.696180343453307 47.35319310231545, 19.685194015328307 47.35749590292253, 19.683477401558775 47.35668188647431, 19.679529189888854 47.35830990681287, 19.679185867134947 47.35993787692001, 19.67781257611932 47.36086812299986, 19.673177718941588 47.36144951847065, 19.673521041695494 47.36365876282776, 19.662019729439635 47.36714685502695, 19.663049697701354 47.369123338224, 19.670087814156428 47.36714685502695, 19.671976089302913 47.369007076556734, 19.686738967720885 47.3627285659537, 19.687940597359557 47.36505402738543, 19.668714523140807 47.37551733526325, 19.670087814156428 47.376214815315315)),POINT (19.71660804731073 47.384002715860724),POINT (19.634553909127135 47.35144862373945),LINESTRING (19.662534713570494 47.368425764376255, 19.65910148603143 47.369123338224, 19.653779983345885 47.36819323771014, 19.648286819283385 47.36819323771014, 19.6409053800744 47.36923959963501, 19.639360427681822 47.36726312079464, 19.637815475289244 47.36156579679595, 19.634553909127135 47.3521464220896, 19.63421058637323 47.34993669566256, 19.627000808541197 47.34958778303236, 19.62494087201776 47.34877364459174),POLYGON ((19.63764381391229 47.36133323988905, 19.633523940865416 47.362612290191166, 19.630262374703307 47.35551898404987, 19.626314163033385 47.35249531780482, 19.624769210640807 47.35051821158713, 19.62494087201776 47.34842472427284, 19.626829147164244 47.34784318528222, 19.630090713326354 47.34819210944546, 19.629747390572447 47.34668008807918, 19.637987136666197 47.345400651554165, 19.637815475289244 47.349355173330764, 19.641592025582213 47.35249531780482, 19.64279365522088 47.35389087759979, 19.63987541181268 47.354704937103804, 19.641592025582213 47.35749590292253, 19.637300491158385 47.35830990681287, 19.63764381391229 47.36133323988905)))'),
(9, 'event', 'Event with lines', 'event-with-lines', 'Tricase', 39.93042, 18.355332, 1, 'Event sample with lines', NULL, '2015-09-21 18:50:00', '2015-10-21 18:50:00', '2015-09-20 18:51:50', 27, '2015-09-20 18:53:59', 27, 3, 0, 1, 'it', NULL, NULL, 'GeometryCollection(POLYGON ((18.250202178605832 39.95726718215682, 18.250202178605832 39.97516006112189, 18.274921416887082 39.97516006112189, 18.274921416887082 39.95726718215682, 18.250202178605832 39.95726718215682)),POLYGON ((18.29483413661364 39.95726718215682, 18.29483413661364 39.97489696447749, 18.32092666591052 39.97489696447749, 18.32092666591052 39.95726718215682, 18.29483413661364 39.95726718215682)),POLYGON ((18.33843612635974 39.957530346657215, 18.33843612635974 39.97410766846727, 18.367961883195676 39.97410766846727, 18.367961883195676 39.957530346657215, 18.33843612635974 39.957530346657215)),POINT (18.262905120500363 39.963582850651996),POINT (18.307880401262082 39.964635405353945),POINT (18.35388565028552 39.963582850651996),LINESTRING (18.24505233729724 39.943844449806555, 18.367961883195676 39.94252835388208, 18.367961883195676 39.893551599982466, 18.240932464250363 39.889600335553695),POLYGON ((18.25500869716052 39.93673723106695, 18.24127578700427 39.913567839046095, 18.263935088762082 39.899609763055544, 18.29483413661364 39.9025069560857, 18.305820464738645 39.926733228225174, 18.26324844325427 39.93673723106695, 18.25500869716052 39.93673723106695)),POLYGON ((18.309597015031613 39.92515351517317, 18.299640655168332 39.90329707837962, 18.31543350184802 39.8969758449126, 18.35113906825427 39.8969758449126, 18.35525894130114 39.91962423244488, 18.314746856340207 39.93041908359209, 18.309597015031613 39.92515351517317)))'),
(10, 'route', 'Route sample 2', 'route-sample-2', 'tápióbicske', 47.3661203, 19.6863365, 1, 'Another route', NULL, NULL, NULL, '2015-09-20 18:53:26', 27, '2015-09-20 18:53:46', 27, 2, 0, 1, 'it', NULL, NULL, 'GeometryCollection(POINT(19.6867411 47.3622153),POINT(19.7503736 47.4138187),POINT(19.6303259 47.3992437),POINT(19.6332241 47.3509828))');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- A tábla adatainak kiíratása `menus`
--

INSERT INTO `menus` (`id`, `name`, `title`, `pages`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(1, 'places', 'Places', '{2};{9};{10};{11};{12}', '2015-09-20 15:58:19', 27, '2015-09-20 18:56:54', 27, 1),
(2, 'posts', 'Posts', '{4}', '2015-09-20 15:58:26', 27, '2015-09-20 16:07:44', 27, 1),
(3, 'events', 'Events', '{3};{13};{15}', '2015-09-20 15:58:37', 27, '2015-09-20 18:58:45', 27, 1),
(4, 'routes', 'Routes', '{1};{14}', '2015-09-20 15:58:45', 27, '2015-09-20 18:57:51', 27, 1),
(5, 'categories', 'Categories', '{5};{6};{7};{8}', '2015-09-20 17:25:18', 27, '2015-09-20 17:27:59', 27, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- A tábla adatainak kiíratása `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `type`, `url`, `blank`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`) VALUES
(1, 'routes', 'Routes', 'content', 'http://projects/Mappiamo_DEV/index.php?module=content&object=3', 0, '2015-09-20 16:05:18', 27, '2015-09-20 18:32:46', 27, 1),
(2, 'places', 'Places', 'content', 'http://projects/Mappiamo_DEV/index.php?module=content&object=5', 0, '2015-09-20 16:05:47', 27, '2015-09-20 18:32:26', 27, 1),
(3, 'events', 'Events', 'content', 'http://projects/Mappiamo_DEV/index.php?module=content&object=4', 0, '2015-09-20 16:06:00', 27, '2015-09-20 18:32:11', 27, 1),
(4, 'posts', 'Posts', 'content', 'http://projects/Mappiamo_DEV/index.php?module=content&object=1', 0, '2015-09-20 16:07:33', 27, '2015-09-20 18:31:48', 27, 1),
(5, 'category---posts', 'Category - Posts', 'url', 'http://projects/Mappiamo_DEV/index.php?module=category&object=1', 0, '2015-09-20 17:26:10', 27, '2015-09-20 17:26:10', 27, 1),
(6, 'category---places', 'Category - Places', 'url', 'http://projects/Mappiamo_DEV/index.php?module=category&object=2', 0, '2015-09-20 17:26:51', 27, '2015-09-20 17:28:14', 27, 1),
(7, 'category---events', 'Category - Events', 'url', 'http://projects/Mappiamo_DEV/index.php?module=category&object=3', 0, '2015-09-20 17:27:20', 27, '2015-09-20 17:27:29', 27, 1),
(8, 'category---routes', 'Category - Routes', 'url', 'http://projects/Mappiamo_DEV/index.php?module=category&object=4', 0, '2015-09-20 17:27:53', 27, '2015-09-20 17:28:01', 27, 1),
(9, 'another-place', 'Another place', 'url', 'http://projects/Mappiamo_DEV/index.php?module=content&object=2', 0, '2015-09-20 18:33:13', 27, '2015-09-20 18:33:22', 27, 1),
(10, 'budapest', 'Budapest', 'url', 'http://projects/Mappiamo_DEV/index.php?module=content&object=6', 0, '2015-09-20 18:55:51', 27, '2015-09-20 18:56:06', 27, 1),
(11, 'miskolc', 'Miskolc', 'url', 'http://projects/Mappiamo_DEV/index.php?module=content&object=7', 0, '2015-09-20 18:56:21', 27, '2015-09-20 18:56:28', 27, 1),
(12, 'drawind-sample', 'Drawind sample', 'url', 'http://projects/Mappiamo_DEV/index.php?module=content&object=8', 0, '2015-09-20 18:56:51', 27, '2015-09-20 18:56:56', 27, 1),
(13, 'event-with-lines', 'Event with lines', 'content', 'http://projects/Mappiamo_DEV/index.php?module=content&object=9', 0, '2015-09-20 18:57:20', 27, '2015-09-20 18:57:20', 27, 1),
(14, 'one-more-route', 'One more route', 'content', 'http://projects/Mappiamo_DEV/index.php?module=content&object=10', 0, '2015-09-20 18:57:45', 27, '2015-09-20 18:57:45', 27, 1),
(15, 'filtered-events', 'Filtered events', 'url', 'http://projects/Mappiamo_DEV/index.php?module=event&object={All}&sort=start&filter=year&expired=all&filterby=start&user_filter=yes&pid=15', 0, '2015-09-20 18:58:41', 27, '2015-09-20 18:58:48', 27, 1);

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
(6, 'website_description', 'galcapodileuca.it'),
(7, 'website_email', 'info@mappiamo.com'),
(8, 'new_user_default_group', '3'),
(9, 'facebook_app_id', '488785261198856'),
(10, 'facebook_secret', '2f8e52496f1efdce948de72383814d4c'),
(11, 'registration', 'yes'),
(12, 'default_language', 'it'),
(13, 'domain', 'galcapodileuca.it'),
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=211 ;

--
-- A tábla adatainak kiíratása `templates`
--

INSERT INTO `templates` (`id`, `name`, `title`, `version`, `description`, `default_template`, `manager`, `enabled`) VALUES
(201, 'mappiamo', 'Mappiamo', '0.0.6', 'Mappiamo template', 0, 0, 1),
(101, 'manager', 'Manager', '0.0.6', 'Manager template', 0, 1, 1),
(209, 'gal2', 'Gal template', '0.0.1', 'Frontend template', 0, 0, 1),
(210, 'squares', 'squares', '0.0.1', 'squares', 1, 0, 1);

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
(27, 1, 'demo', 'c4aadc5a85db61399dbb70f187c2ceda', 'info@mappiamo.com', '#mappiamo', '2014-02-02 12:11:26', 1001, '2014-02-02 12:11:26', 1001, 'ZGVtbyBeT0NTVVEzdVhRSWwlSnZxNGszayZPRVQ=|MjAxNS0wOS0yMCAxODozMDo1OA==|TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgNi4zOyBXT1c2NDsgcnY6NDAuMCkgR2Vja28vMjAxMDAxMDEgRmlyZWZveC80MC4w', NULL, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

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
(26, 'togglemenu', 'togglemenu', '0.0.6', 'togglemenu', 0, 1),
(27, 'jplayer', 'jplayer', '0.0.6', 'jplayer', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
