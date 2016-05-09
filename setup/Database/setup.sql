-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Hoszt: 127.0.0.1
-- Létrehozás ideje: 2016. Máj 09. 17:56
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- A tábla adatainak kiíratása `categories`
--

INSERT INTO `categories` (`id`, `name`, `title`, `contents`, `flagship`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`, `import_id`) VALUES
(1, 'sample-category', 'Sample category', '{1};{3};{2};{4}', 0, '2016-02-04 13:58:28', 27, '2016-02-04 15:53:58', 27, 1, 'f996dd7b-cb40-11e5-8e2c-1c6f65ad55b6');

--
-- Eseményindítók `categories`
--
DROP TRIGGER IF EXISTS `InsertCategories`;
DELIMITER //
CREATE TRIGGER `InsertCategories` BEFORE INSERT ON `categories`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

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
(1, 'post', 'Demo post', 'demo-post', 'Tricase', 39.93042, 18.355332, 1, '<h1>First demo post</h1>\r\n<p>Eror moditatiori solumqui consequam aut essum rate res aciduntem et pla quaestias aspelibusda sit, assi occus.<br />Et voluptate vel inum alictat et offic tet earum eum si dus.<br />Tempercia sit arum eum ide nit quiaerum landel moluption reiunt lam, tesequam, quas recatiaeris a volor aut ut eos dolupta ssitas cus.<br />Dit, saperuptate di doluptio iusam, incimodipit ma velicaes qui adis eum quatur alit dolendis mossed que officipsant, sit ma voluptia samenihilia pratiostrum que cor molupta sint hiciuntiatus dendiae volendem que debitas minim ullabo. Videnimetur reperfe riorumqui rem. Nequiderspel id quis rehenit, odis sequam fugiam, sitem aliquuntiur, abo. Ut rentus diatur magnamenis acerorr ovitiatio modi conet repel ipsum soluptatur sam sed magnatiam harum aut de as iunditat od que pelit, solectur? Ovid quam quam quam quis sum quidus ratumquia precturi omnisse quiam, omnimet et quis sunt.<br />Lat odistius aceaquisquid minus andusae cestrum quam, ut omnimi, tem volorep elliate imincil et quam vellume es sitinciis eatis sit quodis am delisciderum quam fuga. Rum restiorio te modis eate doluptiam aut a del il inisi cumendae ped eic torita adit quid eum unt laut etur, volorep elestio. Et la sitem. Agnis doles reprectur?<br />Bus. Veruntotati que estis poremod maximenis autae eles non cusdae. Lorae placcusania volore il inctem sinusam repel ipsapid eliquibusam, sinihicat qui aut as aut qui ipienia volorro bearcias susam que nobit poremquia pra volo mil es assitae. Nequis erionet esedita dolorep erchit vitatem ut aut dolestrum labores sintotae. Sum ut voluptatur, audam ea dendempe pedipitatem que odia quam, saersped mo ium quas secte voluptatum rem quatetum aut alicimos aut fugia corro et minus dus, omnimus apedit, optate ad et endiciis quat.<br />Ur? Vitaeperrum explatem quis asincid et reratur? Nonse pe pro minvele cepedipsum nessitatur ad quidusam, simustiam eosam aceaquam diae laborempera ese qui volupta dis volorerae nobitatio molores a doloreped quid et antur aut endignam qui ditem nullabo. Od es maximus ad quibus qui di doluptatur auditatur, quodis debit, sitaturendam ere, culpa explabor sa dolectis autempo ssitatq uosandi arum iusdam harcim voloreh enienis ius aut et volorem olupta venis nimolora pa as aut plandel ium nimilis quo velibus volorporepta poremporeped quatqui dessinv endipsu ntotati isitate verore volorit omnimus, ea que num in nusae maximet odipsap iendessunto berum alignisseque rectore puditionet volectia veleni omnis reperib uscipictios dolupta voluptam eum qui apit et ut ipiciuscit, sundandit occae reperumque consequia pra nonet est idellignihit aut aut odit optatquides a sam adi debis et pero inim venis mi, omniet rem volupta quodit lab inis entur solor autem explabo. Ut odicabor as mil inum quis sint utaerit in ped ute poribusanis inimus atur repe maximet lia consequ ianihic temodi blabor ad exeratus a prere nonse nos estrum volut quam, tempori busam, quameni hiligent hicia que paria pos magnam volorio enis</p>', NULL, NULL, NULL, '2016-02-04 14:17:46', 27, '2016-02-04 14:19:22', 27, 3, 0, 1, 'it', NULL, 'ae58d00a-cb41-11e5-8e2c-1c6f65ad55b6', NULL),
(2, 'event', 'Demo event', 'demo-event', 'Tricase', 39.93042, 18.355332, 1, '<h1>Demo event</h1>\r\n<p>Od mo te nonsequ istione venditis idist alis eaquia voluptat.<br />Rum sintium quosam et facest, simolesto ist ut ex etur resciae licit pliquid endestinciis molorerro cori tenis autaturitia cusa vollian imporporias abori voluptatias eum quas ea ex eius.<br />Cullictatiis il iminci dissi nullam di consectate optatur ibusandam, totatur sequaecatur, que cusam vellique nos abo. Itatentorro blaboratur?<br />Bor sapid magnia consed eni oditiorro beatur, corum fuga. Agni iur alignate ressimo luptate vendebit, sant.<br />Ut dollorae alia atibus est fugit que sum et, sum aciet ent.<br />Rate volorum et eium eum harum quae doluptatatem que pore conestrum vellatem exceribus rem quis idi doles nimint, sunda voluptatem errumquae parcid molor alianisqui od ernamus perum cullam ut disi qui repeles cimint possitatat.<br />Ibus ab inullupit, arum fugit veror aut acesse et, to quo con re nis dolor audicim re nonserit es derovidunt vel molores eost, voluptatia iderit, quat optat volut quis ipsunti rehendis ped maximai orrovid etur, voluptas andit autatus quae nihitaquibus vollabo rerchite excesedi vendionet et vera sum fugia num que litas dolest, cus ut ad moluptam am voloreh enimpore ipsunti num eturiti volut adi invererror magni restium quae nus.<br />Tur? Les as nonseque prae ad quam explaborro essecatus dolupid unt evella quo velent et qui omnis qui natat facernatur anisti unt alicias ipsanda ent eveleniet ulla eos erro mos as ipsaescia vendus estius adiciumet et apiderferum consequos aspidelessit esti imil ea volupta pores dit quaepel lectas quo iur, volor molorup taturia menihictem acil enimodi cuptae. Etur min re dolestem fugiae nis rem quatusa ndelige nimaios ea volorendus aut velit volorem dem laut fugit, consect oruptasserit dipic totatur rero te volectia iniscia qui vit qui corporae eum nonseceptur, cus, sanis veleserspid quo consed quo destio. Agnatem. Rerovid et dolorro quatiasit aut faceptiore pliqui quiae maiorerum quatibus autatec atendaectate as evella nos sedis aut quae sin evelit odignis as que nienem voluptati omnimiliquod earcimo diaspediciur asitis deliqui ant utem facea cuptam illa nimostrum, ut min el ipsum aut ut abo. Sum dolo occum fugitatur?<br />Seditibus aut mo eati temporaeped qui sitaquisqui debit ab is dent eum rem aliquid quia volum volorepe estrum vit est, omniminum audae. Uga. Aliaepe rumquia que netur magnam, vene sundusam natiunt ut voles inus repudae ctusciis re ditiosandist listotatque rem adis inctota coratiatur sin ne dolorem illab intia et assimporpos mo eatiae ipsa velecto volupta tiuntium seque optatio quae commo et fugit exerum reperum voluptat etum vella nonetum asita nobis re sitatia cus eum non non et, solorest, oditisqui aut latur recusci liaepe nihicitati am earchil liquost volutaquunt aliquatur, conestor reptiam ius ant iumquatur ateceatem. Uciumquae plate con excerovitat.<br />Modiciam, sequatur? Pidignient lignim ad moluptae. Peres prectotat voluptasit, sum ipiendeliti dolorec aeptatusto vit faccatur sam asperunt denderatem hitae et arum voluptasi offici dolupta epediam facepudios expellabore sim commolor simporem velibus ex eos se dolorec epratum faccum ipieturem esequae praerumqui corrore dita ipit odigent quides magnimporio beaturiantia volorro mi, vidissitas et lacea earchil itatur, con ra cum quibus, que nem reria volene eumet quuntios eum nimint molor magnat omnihitin con eaquia volorporis sequae. Nam, iliquaspiet vendis restrumquo exerchictore quid molupta ius, quo conempe lendige nditias dolum exerit officit provitatur, iur, si ullabor endest ligendaepra voluptis evernatur?<br />Genimus ratem fugit odipsum restecto beribus is ereheni siti corpor re re nem fugia eossimi, ommolorerio. Parum verem reici doloris ut et quatque nusapit inulparunt quatemquo tore ped mo omnis vent hicae nit, sinihit veliquae nume deliti acea prerunt harchita perior sundandunt exceperrum sitametus quam aut restibusam illique velique vent exerupti nonseque officipicta con evero qui berro officit rem fuga. Ut qui tentota nis deribus quidici cum, aspis qui totaepudam quis dolesed igniscimus, consenim harcilis utatibus abo. Em as illaturiatio magnam sed unt, tet aspelec toressunt illes dipsandae mos adiost antibus sintiasperro velitat ectaturest, in</p>', NULL, '2016-02-02 15:49:00', '2016-03-16 15:49:00', '2016-02-04 15:49:20', 27, '2016-02-04 15:50:56', 27, 2, 0, 1, 'it', NULL, '790ff5d1-cb4e-11e5-8e2c-1c6f65ad55b6', NULL),
(3, 'place', 'Demo place with draw', 'demo-place-with-draw', 'Tricase', 39.93042, 18.355332, 1, '<h1>Demo place with draw</h1>\r\n<p>Od mo te nonsequ istione venditis idist alis eaquia voluptat.<br />Rum sintium quosam et facest, simolesto ist ut ex etur resciae licit pliquid endestinciis molorerro cori tenis autaturitia cusa vollian imporporias abori voluptatias eum quas ea ex eius.<br />Cullictatiis il iminci dissi nullam di consectate optatur ibusandam, totatur sequaecatur, que cusam vellique nos abo. Itatentorro blaboratur?<br />Bor sapid magnia consed eni oditiorro beatur, corum fuga. Agni iur alignate ressimo luptate vendebit, sant.<br />Ut dollorae alia atibus est fugit que sum et, sum aciet ent.<br />Rate volorum et eium eum harum quae doluptatatem que pore conestrum vellatem exceribus rem quis idi doles nimint, sunda voluptatem errumquae parcid molor alianisqui od ernamus perum cullam ut disi qui repeles cimint possitatat.<br />Ibus ab inullupit, arum fugit veror aut acesse et, to quo con re nis dolor audicim re nonserit es derovidunt vel molores eost, voluptatia iderit, quat optat volut quis ipsunti rehendis ped maximai orrovid etur, voluptas andit autatus quae nihitaquibus vollabo rerchite excesedi vendionet et vera sum fugia num que litas dolest, cus ut ad moluptam am voloreh enimpore ipsunti num eturiti volut adi invererror magni restium quae nus.<br />Tur? Les as nonseque prae ad quam explaborro essecatus dolupid unt evella quo velent et qui omnis qui natat facernatur anisti unt alicias ipsanda ent eveleniet ulla eos erro mos as ipsaescia vendus estius adiciumet et apiderferum consequos aspidelessit esti imil ea volupta pores dit quaepel lectas quo iur, volor molorup taturia menihictem acil enimodi cuptae. Etur min re dolestem fugiae nis rem quatusa ndelige nimaios ea volorendus aut velit volorem dem laut fugit, consect oruptasserit dipic totatur rero te volectia iniscia qui vit qui corporae eum nonseceptur, cus, sanis veleserspid quo consed quo destio. Agnatem. Rerovid et dolorro quatiasit aut faceptiore pliqui quiae maiorerum quatibus autatec atendaectate as evella nos sedis aut quae sin evelit odignis as que nienem voluptati omnimiliquod earcimo diaspediciur asitis deliqui ant utem facea cuptam illa nimostrum, ut min el ipsum aut ut abo. Sum dolo occum fugitatur?<br />Seditibus aut mo eati temporaeped qui sitaquisqui debit ab is dent eum rem aliquid quia volum volorepe estrum vit est, omniminum audae. Uga. Aliaepe rumquia que netur magnam, vene sundusam natiunt ut voles inus repudae ctusciis re ditiosandist listotatque rem adis inctota coratiatur sin ne dolorem illab intia et assimporpos mo eatiae ipsa velecto volupta tiuntium seque optatio quae commo et fugit exerum reperum voluptat etum vella nonetum asita nobis re sitatia cus eum non non et, solorest, oditisqui aut latur recusci liaepe nihicitati am earchil liquost volutaquunt aliquatur, conestor reptiam ius ant iumquatur ateceatem. Uciumquae plate con excerovitat.<br />Modiciam, sequatur? Pidignient lignim ad moluptae. Peres prectotat voluptasit, sum ipiendeliti dolorec aeptatusto vit faccatur sam asperunt denderatem hitae et arum voluptasi offici dolupta epediam facepudios expellabore sim commolor simporem velibus ex eos se dolorec epratum faccum ipieturem esequae praerumqui corrore dita ipit odigent quides magnimporio beaturiantia volorro mi, vidissitas et lacea earchil itatur, con ra cum quibus, que nem reria volene eumet quuntios eum nimint molor magnat omnihitin con eaquia volorporis sequae. Nam, iliquaspiet vendis restrumquo exerchictore quid molupta ius, quo conempe lendige nditias dolum exerit officit provitatur, iur, si ullabor endest ligendaepra voluptis evernatur?<br />Genimus ratem fugit odipsum restecto beribus is ereheni siti corpor re re nem fugia eossimi, ommolorerio. Parum verem reici doloris ut et quatque nusapit inulparunt quatemquo tore ped mo omnis vent hicae nit, sinihit veliquae nume deliti acea prerunt harchita perior sundandunt exceperrum sitametus quam aut restibusam illique velique vent exerupti nonseque officipicta con evero qui berro officit rem fuga. Ut qui tentota nis deribus quidici cum, aspis qui totaepudam quis dolesed igniscimus, consenim harcilis utatibus abo. Em as illaturiatio magnam sed unt, tet aspelec toressunt illes dipsandae mos adiost antibus sintiasperro velitat ectaturest, in</p>', NULL, NULL, NULL, '2016-02-04 15:51:57', 27, '2016-02-04 15:52:35', 27, 2, 0, 1, 'it', NULL, 'd682be61-cb4e-11e5-8e2c-1c6f65ad55b6', 'GeometryCollection(POLYGON ((18.275608062394895 39.97016105168565, 18.256381988176145 39.95910931239242, 18.255695342668332 39.9356842469908, 18.277667998918332 39.91014442325539, 18.332256316789426 39.91093445747047, 18.333972930558957 39.952793230705204, 18.275608062394895 39.97016105168565)),POLYGON ((18.34667587245349 39.95463548145348, 18.34667587245349 39.978580225330965, 18.38512802089099 39.978580225330965, 18.38512802089099 39.95463548145348, 18.34667587245349 39.95463548145348)),POINT (18.27801132167224 39.909881076492184),POINT (18.364528655656613 39.96489854149751),LINESTRING (18.277324676164422 39.91014442325539, 18.275264739640985 39.8969758449126, 18.2869377132738 39.889073483087465, 18.337749480851922 39.89091744900417, 18.373455047258176 39.9025069560857, 18.370708465226926 39.92278387725036, 18.35560226405505 39.930945618158084))'),
(4, 'route', 'Demo route', 'demo-route', 'Tricase', 39.93042, 18.355332, 1, '<h1>Demo route</h1>\r\n<p>Od mo te nonsequ istione venditis idist alis eaquia voluptat.<br />Rum sintium quosam et facest, simolesto ist ut ex etur resciae licit pliquid endestinciis molorerro cori tenis autaturitia cusa vollian imporporias abori voluptatias eum quas ea ex eius.<br />Cullictatiis il iminci dissi nullam di consectate optatur ibusandam, totatur sequaecatur, que cusam vellique nos abo. Itatentorro blaboratur?<br />Bor sapid magnia consed eni oditiorro beatur, corum fuga. Agni iur alignate ressimo luptate vendebit, sant.<br />Ut dollorae alia atibus est fugit que sum et, sum aciet ent.<br />Rate volorum et eium eum harum quae doluptatatem que pore conestrum vellatem exceribus rem quis idi doles nimint, sunda voluptatem errumquae parcid molor alianisqui od ernamus perum cullam ut disi qui repeles cimint possitatat.<br />Ibus ab inullupit, arum fugit veror aut acesse et, to quo con re nis dolor audicim re nonserit es derovidunt vel molores eost, voluptatia iderit, quat optat volut quis ipsunti rehendis ped maximai orrovid etur, voluptas andit autatus quae nihitaquibus vollabo rerchite excesedi vendionet et vera sum fugia num que litas dolest, cus ut ad moluptam am voloreh enimpore ipsunti num eturiti volut adi invererror magni restium quae nus.<br />Tur? Les as nonseque prae ad quam explaborro essecatus dolupid unt evella quo velent et qui omnis qui natat facernatur anisti unt alicias ipsanda ent eveleniet ulla eos erro mos as ipsaescia vendus estius adiciumet et apiderferum consequos aspidelessit esti imil ea volupta pores dit quaepel lectas quo iur, volor molorup taturia menihictem acil enimodi cuptae. Etur min re dolestem fugiae nis rem quatusa ndelige nimaios ea volorendus aut velit volorem dem laut fugit, consect oruptasserit dipic totatur rero te volectia iniscia qui vit qui corporae eum nonseceptur, cus, sanis veleserspid quo consed quo destio. Agnatem. Rerovid et dolorro quatiasit aut faceptiore pliqui quiae maiorerum quatibus autatec atendaectate as evella nos sedis aut quae sin evelit odignis as que nienem voluptati omnimiliquod earcimo diaspediciur asitis deliqui ant utem facea cuptam illa nimostrum, ut min el ipsum aut ut abo. Sum dolo occum fugitatur?<br />Seditibus aut mo eati temporaeped qui sitaquisqui debit ab is dent eum rem aliquid quia volum volorepe estrum vit est, omniminum audae. Uga. Aliaepe rumquia que netur magnam, vene sundusam natiunt ut voles inus repudae ctusciis re ditiosandist listotatque rem adis inctota coratiatur sin ne dolorem illab intia et assimporpos mo eatiae ipsa velecto volupta tiuntium seque optatio quae commo et fugit exerum reperum voluptat etum vella nonetum asita nobis re sitatia cus eum non non et, solorest, oditisqui aut latur recusci liaepe nihicitati am earchil liquost volutaquunt aliquatur, conestor reptiam ius ant iumquatur ateceatem. Uciumquae plate con excerovitat.<br />Modiciam, sequatur? Pidignient lignim ad moluptae. Peres prectotat voluptasit, sum ipiendeliti dolorec aeptatusto vit faccatur sam asperunt denderatem hitae et arum voluptasi offici dolupta epediam facepudios expellabore sim commolor simporem velibus ex eos se dolorec epratum faccum ipieturem esequae praerumqui corrore dita ipit odigent quides magnimporio beaturiantia volorro mi, vidissitas et lacea earchil itatur, con ra cum quibus, que nem reria volene eumet quuntios eum nimint molor magnat omnihitin con eaquia volorporis sequae. Nam, iliquaspiet vendis restrumquo exerchictore quid molupta ius, quo conempe lendige nditias dolum exerit officit provitatur, iur, si ullabor endest ligendaepra voluptis evernatur?<br />Genimus ratem fugit odipsum restecto beribus is ereheni siti corpor re re nem fugia eossimi, ommolorerio. Parum verem reici doloris ut et quatque nusapit inulparunt quatemquo tore ped mo omnis vent hicae nit, sinihit veliquae nume deliti acea prerunt harchita perior sundandunt exceperrum sitametus quam aut restibusam illique velique vent exerupti nonseque officipicta con evero qui berro officit rem fuga. Ut qui tentota nis deribus quidici cum, aspis qui totaepudam quis dolesed igniscimus, consenim harcilis utatibus abo. Em as illaturiatio magnam sed unt, tet aspelec toressunt illes dipsandae mos adiost antibus sintiasperro velitat ectaturest, in</p>', NULL, NULL, NULL, '2016-02-04 15:53:35', 27, '2016-02-04 15:53:54', 27, 3, 0, 1, 'it', NULL, '111ae2dd-cb4f-11e5-8e2c-1c6f65ad55b6', 'GeometryCollection(POINT(18.355332 39.93042),POINT(18.297631 39.93712),POINT(18.3822022 39.9830189))');

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

--
-- Eseményindítók `content_media`
--
DROP TRIGGER IF EXISTS `InsertContent_media`;
DELIMITER //
CREATE TRIGGER `InsertContent_media` BEFORE INSERT ON `content_media`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

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

--
-- Eseményindítók `content_meta`
--
DROP TRIGGER IF EXISTS `InsertContent_meta`;
DELIMITER //
CREATE TRIGGER `InsertContent_meta` BEFORE INSERT ON `content_meta`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

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
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- A tábla adatainak kiíratása `menus`
--

INSERT INTO `menus` (`id`, `name`, `title`, `pages`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`, `import_id`) VALUES
(1, 'demo-menu', 'Demo menu', '{1}', '2016-02-04 13:59:39', 27, '2016-02-04 14:20:04', 27, 1, 'f998383e-cb40-11e5-8e2c-1c6f65ad55b6');

--
-- Eseményindítók `menus`
--
DROP TRIGGER IF EXISTS `InsertMenus`;
DELIMITER //
CREATE TRIGGER `InsertMenus` BEFORE INSERT ON `menus`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=223 ;

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
(219, 'event', 'Event', '0.0.6', 'Event module', 0, 0, 1),
(220, 'finder', 'Finder', '0.0.6', 'Finder module', 0, 0, 1),
(221, 'passrenew', 'Password renew', '0.0.6', 'Password renew module', 0, 1, 1),
(222, 'mxmlimport', 'mxmlimport', '0.0.6', 'mxmlimport', 0, 1, 1);

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
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` char(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- A tábla adatainak kiíratása `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `type`, `url`, `blank`, `created`, `createdby`, `modified`, `modifiedby`, `enabled`, `import_id`, `parent_id`) VALUES
(1, 'sample-category', 'Sample category', 'url', 'index.php?module=category&object=1', 0, '2016-02-04 13:59:18', 27, '2016-02-04 15:56:55', 27, 1, 'f997a76a-cb40-11e5-8e2c-1c6f65ad55b6', NULL);

--
-- Eseményindítók `pages`
--
DROP TRIGGER IF EXISTS `InsertPages`;
DELIMITER //
CREATE TRIGGER `InsertPages` BEFORE INSERT ON `pages`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- A tábla adatainak kiíratása `preferences`
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
(12, 'default_language', 'it'),
(13, 'domain', 'mappiamo.org'),
(14, 'website_name', '#mappiamo demo'),
(15, 'location', 'Tricase'),
(16, 'DefaultLatitude', '39.93042'),
(17, 'DefaultLongitude', '18.355332'),
(18, 'flickr_apikey', 'a868bb5f7da2815b93ab063fa6f04c36'),
(19, 'flickr_bbox', '17.832308, 39.743896,18.580752, 40.450872'),
(20, 'flickr_numofpics', '250'),
(21, 'DisqusName', ''),
(22, 'Reacaptcha_key', '');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=212 ;

--
-- A tábla adatainak kiíratása `templates`
--

INSERT INTO `templates` (`id`, `name`, `title`, `version`, `description`, `default_template`, `manager`, `enabled`) VALUES
(201, 'mappiamo', 'Mappiamo', '0.0.6', 'Mappiamo template', 1, 0, 1),
(101, 'manager', 'Manager', '0.0.6', 'Manager template', 0, 1, 1);

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
  `import_id` char(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=28 ;

--
-- A tábla adatainak kiíratása `users`
--

INSERT INTO `users` (`id`, `group_id`, `username`, `password`, `email`, `name`, `created`, `createdby`, `modified`, `modifiedby`, `lastlogin`, `activation`, `enabled`, `import_id`) VALUES
(1, 100, 'mappiamo', '23a304827dd47c13ec8523bb58699fd5', '', '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 0, 'bWFwcGlhbW8gc1FHVmVWMzUhUWhrXlAlc3huViNSQ2M3|MjAxNC0wMi0xNSAxNTozNjo0Ng==|TW96aWxsYS81LjAgKE1hY2ludG9zaDsgSW50ZWwgTWFjIE9TIFggMTBfOV8xKSBBcHBsZVdlYktpdC81MzcuMzYgKEtIVE1MLCBsaWtlIEdlY2tvKSBDaHJvbWUvMzIuMC4xNzAwLjEwNyBTYWZhcmkvNTM3LjM2', NULL, 0, 'f9996909-cb40-11e5-8e2c-1c6f65ad55b6'),
(27, 1, 'demo', 'c4aadc5a85db61399dbb70f187c2ceda', 'info@mappiamo.com', '#mappiamo', '2014-02-02 12:11:26', 1001, '2014-02-02 12:11:26', 1001, 'ZGVtbyB3SzA3d0trbFVhSFBoJWNrWEYyMSRSb1E=|MjAxNi0wNS0wOSAxNzo1MzoxOQ==|TW96aWxsYS81LjAgKFdpbmRvd3MgTlQgNi4zOyBXaW42NDsgeDY0OyBydjo0NC4wKSBHZWNrby8yMDEwMDEwMSBGaXJlZm94LzQ0LjA=', NULL, 1, 'f9998230-cb40-11e5-8e2c-1c6f65ad55b6');

--
-- Eseményindítók `users`
--
DROP TRIGGER IF EXISTS `InsertUsers`;
DELIMITER //
CREATE TRIGGER `InsertUsers` BEFORE INSERT ON `users`
 FOR EACH ROW BEGIN 
		SET NEW.import_id = UUID();
	END
//
DELIMITER ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=51 ;

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
(14, 'flickr', 'Flickr plugin', '0.0.6', 'Flickr widget', 0, 1),
(22, 'box_allmeta', 'Box All Meta widget', '0.0.6', 'Display meta data', 0, 1),
(16, 'breadcrumbs', 'Breadcrumbs', '0.0.6', 'Display breadcrumbs', 0, 1),
(17, 'share', 'Share widget', '0.0.6', 'Displat content share options', 0, 1),
(18, 'videobox', 'Videobox widget', '0.0.6', 'Display video content', 0, 1),
(19, 'panoramabox', 'Panoramabox widget', '0.0.6', 'Display 3D panorama images', 0, 1),
(20, 'content_slideshow', 'Slideshow widget', '0.0.6', 'display images as slideshow', 0, 1),
(21, 'content_headline', 'Content headline widget', '0.0.6', 'Display content headline', 0, 1),
(23, 'box_onemeta', 'Onemeta widget', '0.0.6', 'Display one meta data', 0, 1),
(24, 'box_distance', 'Distance widget', '0.0.6', 'Display contents by distance', 0, 1),
(25, 'box_events', 'Events widget', '0.0.6', 'Display events', 0, 1),
(26, 'togglemenu', 'Togglemenu widget', '0.0.6', 'Display togglemenu', 0, 1),
(27, 'slider', 'Slider widget', '0.0.6', 'Display slider', 0, 1),
(28, 'lastcontent', 'Lastcontent widget', '0.0.6', 'Display latests contents', 0, 1),
(29, 'box_youtube', 'Youtube widget', '0.0.6', 'Display youtube contents', 0, 1),
(30, 'box_instagram', 'Instagram widget', '0.0.6', 'Display instagram content', 0, 1),
(31, 'gravatar', 'Gravatar widget', '0.0.6', 'Display gravatar icons', 0, 1),
(32, 'box_gpsbooking', 'Gpsbooking widget', '0.0.6', 'Display hotels', 0, 1),
(33, 'disqus', 'Disqus widget', '0.0.6', 'Display comment box', 0, 1),
(34, 'address', 'Address widget', '0.0.6', 'Jump to address on the map', 0, 1),
(35, 'bottommenu', 'Bottom menu widget', '0.0.6', 'Display bottom menu', 0, 1),
(36, 'box', 'Box widget', '0.0.6', 'Display box', 0, 1),
(37, 'box_collabrators', 'Collabrators widget', '0.0.6', 'Display collaborators articles', 0, 1),
(38, 'box_cookie', 'Cookie widget', '0.0.6', 'Display cookie accept box', 0, 1),
(39, 'content_allmeta', 'Allmeta content widget', '0.0.6', 'Display all meta data on content', 0, 1),
(40, 'dividedmenu', 'Divided menu widget', '0.0.6', 'Display divided menu', 0, 1),
(41, 'dropdownmenu', 'Dropdown menu widget', '0.0.6', 'Display dropdown menu', 0, 1),
(42, 'form_contact', 'Contact form widget', '0.0.6', 'Display contact form', 0, 1),
(43, 'jplayer', 'Jplayer widget', '0.0.6', 'Audio player', 0, 1),
(44, 'leaflet_panel', 'Leaflet panel widget', '0.0.6', 'Display leaflet panel', 0, 1),
(45, 'menu_full', 'Menu full widget', '0.0.6', 'Configurable menu', 0, 1),
(46, 'owl_image', 'Owl image widget', '0.0.6', 'Image carousel', 0, 1),
(47, 'owl_video', 'Owl video widget', '0.0.6', 'Video carousel', 0, 1),
(48, 'soccorso', 'Soccorso widget', '0.0.6', 'Display soccorso', 0, 1),
(49, 'topmenu', 'Topmenu widget', '0.0.6', 'Display top menu', 0, 1),
(50, 'website_title', 'Website title widget', '0.0.6', 'Display website title', 0, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
