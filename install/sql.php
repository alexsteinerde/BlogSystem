<?php

command("CREATE TABLE `{praefix}activity` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `link` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL,
  `group` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");


command("CREATE TABLE `{praefix}article` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `titel` text CHARACTER SET latin1 NOT NULL,
  `text` mediumtext CHARACTER SET latin1 NOT NULL,
  `time` varchar(15) CHARACTER SET latin1 NOT NULL,
  `ort` varchar(100) CHARACTER SET latin1 NOT NULL,
  `kategorie` varchar(100) CHARACTER SET latin1 NOT NULL,
  `beschreibung` text CHARACTER SET latin1 NOT NULL,
  `link` text CHARACTER SET latin1 NOT NULL,
  `autor` varchar(50) CHARACTER SET latin1 NOT NULL,
  `show` varchar(20) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2");

command("INSERT INTO `{praefix}article` (`id`, `titel`, `text`, `time`, `kategorie`, `beschreibung`, `link`, `autor`, `show`) VALUES
(1, 'Willkommen', '<h2>Hallo und herzlich Willkommen auf dieser Website!</h2>', '$time', '1', 'Hallo und herzlich Willkommen auf dieser Website!', 'welcome', '$username', '1')");


command("CREATE TABLE `{praefix}events` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `class` varchar(100) NOT NULL,
  `function` varchar(100) NOT NULL,
  `point` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3");

command("INSERT INTO `{praefix}events` (`id`, `class`, `function`, `point`) VALUES
(1, 'Session', 'set', 'start'),
(2, 'PageRight', 'start', 'start'),
(3, 'modul_updater', 'display', 'modul')");

command("CREATE TABLE `{praefix}extensions` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `link` text NOT NULL,
  `beschreibung` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `type` varchar(10) NOT NULL,
  `version` varchar(10) NOT NULL,
  `authorName` varchar(100) NOT NULL,
  `authorLink` varchar(100) NOT NULL,
  `license` varchar(100) NOT NULL,
  `licenseUrl` varchar(100) NOT NULL,
  `docuUrl` varchar(100) NOT NULL,
  `data` text NOT NULL,
  `time` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2");

command("INSERT INTO `{praefix}extensions` (`id`, `name`, `link`, `beschreibung`, `status`, `type`, `version`, `authorName`, `authorLink`, `license`, `licenseUrl`, `docuUrl`, `data`, `time`) VALUES
(1, 'Standart', 'default', 'beschreibung', '1', 'skin', '1.0', 'Alex Steiner', 'http://alexsteiner.de', 'CC', 'http://creativecommons.org/licenses/by-nc-sa/3.0/de/legalcode', 'http://alexsteiner.de', '', '$time')");

command("CREATE TABLE `{praefix}groups` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

command("CREATE TABLE `{praefix}groupsfollower` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `group` int(8) NOT NULL,
  `user` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2");

command("INSERT INTO `{praefix}groupsfollower` (`id`, `group`, `user`) VALUES
(1, 1, 7)");

command("CREATE TABLE `{praefix}kategorie` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `q` text CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2");

command("INSERT INTO `{praefix}kategorie` (`id`, `q`, `description`) VALUES
(1, 'Allgemein', 'Allgemeine Kategorie')");


command("CREATE TABLE `{praefix}keywords` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ");

command("INSERT INTO `{praefix}keywords` (`id`, `keyword`) VALUES
(1, 'welcome')");

command("CREATE TABLE `{praefix}keywords_to` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `article` varchar(8) NOT NULL,
  `keyword` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2");

command("INSERT INTO `{praefix}keywords_to` (`id`, `article`, `keyword`) VALUES
(1, '1', '1'");


command("CREATE TABLE `{praefix}kommentare` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `myid` varchar(8) NOT NULL,
  `name` text NOT NULL,
  `mail` varchar(100) NOT NULL,
  `webseite` text NOT NULL,
  `text` text NOT NULL,
  `time` text NOT NULL,
  `status` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");

command("CREATE TABLE `{praefix}login` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) NOT NULL,
  `pw` varchar(50) NOT NULL,
  `first_time` varchar(20) NOT NULL,
  `last_time` varchar(20) NOT NULL,
  `pageright` varchar(8) NOT NULL,
  `functionright` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ");

command("INSERT INTO `{praefix}login` (`id`, `mail`, `pw`, `first_time`, `last_time`, `pageright`, `functionright`) VALUES
(1, '$username', '$userpw', '1373809849', '', '1', 6)");


command("CREATE TABLE `{praefix}menu` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link` varchar(100) NOT NULL,
  `list` varchar(8) NOT NULL,
  `dir` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16");

command("INSERT INTO `{praefix}menu` (`id`, `title`, `link`, `list`, `dir`) VALUES
(1, 'Startseite', '/home', '0', ''),
(2, 'Dashboard', '/admin/home', '0', '/admin'),
(3, '&Uuml;ber Mich', '/admin/about', '6', '/admin'),
(4, 'Artikel', '/admin/artikel', '2', '/admin'),
(5, 'Kategorien', '/admin/categorie', '3', '/admin'),
(6, 'Erweiterungen', '/admin/extensions', '8', '/admin'),
(7, 'Impressum', '/admin/impressum', '7', '/admin'),
(8, 'Kommentare', '/admin/kommentare', '5', '/admin'),
(9, 'Artikel erstellen', '/admin/new', '1', '/admin'),
(10, 'Bilder', '/admin/newpic', '4', '/admin'),
(11, 'Einstellungen', '/admin/settings', '9', '/admin'),
(12, 'Archiv', '/archiv', '1', ''),
(13, '&Uuml;ber Mich', '/about', '2', ''),
(14, 'Impressum', '/impressum', '3', ''),
(15, 'Login', '/login', '4', '')");

command("CREATE TABLE `{praefix}pageright` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `page` varchar(50) NOT NULL,
  `right` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4");

command("INSERT INTO `{praefix}pageright` (`id`, `page`, `right`) VALUES
(1, '/', '0'),
(2, '/admin/', '1'),
(3, '/', '1')");


command("CREATE TABLE `{praefix}pages` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `praefix` varchar(100) NOT NULL,
  `class` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22");

command("INSERT INTO `{praefix}pages` (`id`, `title`, `praefix`, `class`) VALUES
(1, 'Startseite', '/home', 'page_home'),
(2, 'Error', '/error', 'page_error'),
(3, 'Über Mich', '/about', 'page_about'),
(4, 'Archiv', '/archiv', 'page_archiv'),
(5, 'Artikel', '/article', 'page_article'),
(6, 'Kategorie', '/categorie', 'page_categorie'),
(7, 'Kommentare', '/comment', 'page_comment'),
(8, 'Impressum', '/impressum', 'page_impressum'),
(9, 'Login', '/login', 'page_login'),
(10, 'Suche', '/search', 'page_search'),
(11, 'Über Mich', '/admin/about', 'page_admin_about'),
(12, 'Artikel', '/admin/artikel', 'page_admin_artikel'),
(13, 'Kategorie', '/admin/categorie', 'page_admin_categorie'),
(14, 'Editor', '/admin/editor', 'page_admin_editor'),
(15, 'Dashboard', '/admin/home', 'page_admin_home'),
(16, 'Impressum', '/admin/impressum', 'page_admin_impressum'),
(17, 'Kommentare', '/admin/kommentare', 'page_admin_kommentare'),
(18, 'Editor', '/admin/new', 'page_admin_new'),
(19, 'Bilder', '/admin/newpic', 'page_admin_newpic'),
(20, 'Einstellungen', '/admin/settings', 'page_admin_settings'),
(21, 'Erweiterungen', '/admin/extensions', 'page_admin_extensions')");

command("CREATE TABLE `{praefix}session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `value` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1");

command("CREATE TABLE `{praefix}settingpoints` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `setting` varchar(50) NOT NULL,
  `type` int(11) NOT NULL,
  `default` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5");

command("INSERT INTO `{praefix}settingpoints` (`id`, `title`, `setting`, `type`, `default`) VALUES
(1, 'Titel', 'title', 1, ''),
(2, 'Beschreibung', 'description', 2, ''),
(3, 'Nach Updates suchen', 'update', 3, ''),
(4, 'Artikel sofort ver&ouml;ffentlichen', 'article', 3, '')");


command("CREATE TABLE `{praefix}settings` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `var` varchar(50) CHARACTER SET latin1 NOT NULL,
  `value` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13");

command("INSERT INTO `{praefix}settings` (`id`, `var`, `value`) VALUES
(1, 'title', '$title'),
(2, 'host', '$pagehost'),
(3, 'skin', 'default'),
(4, 'description', 'Beschreibung'),
(5, 'version', '0.1.1'),
(6, 'about', '&lt;p&gt;&amp;Uuml;ber mich&lt;/p&gt;'),
(7, 'impressum', '&lt;p&gt;Impressum&lt;/p&gt;'),
(8, 'skin_admin', 'admin'),
(9, 'update', '1'),
(10, 'error', 'error'),
(11, 'article', 1)"); //0.1.1
?>