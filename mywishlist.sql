SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
-- SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';








-- ITEM

DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `liste_id` int(11) NOT NULL,
  `nom` text NOT NULL,
  `descr` text,
  `img` text,
  `url` text,
  `tarif` decimal(7,2) DEFAULT NULL,
  `reservation` text,
  `message` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT -1,
  `cagnote` decimal(7,2) NOT NULL DEFAULT -1,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `item` ( `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`) VALUES
(	2,	'Champagne',	'Bouteille de champagne + flutes + jeux à gratter',	'champagne.jpg',	'',	20.00),
(	2,	'Musique',	'Partitions de piano à 4 mains',	'musique.jpg',	'',	25.00),
(	2,	'Exposition',	'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel',	'poirelregarder.jpg',	'http://nancybuzz.fr/nancy-exposition-rendez-vous-estivaux-galerie-poirel-regarder/',	14.00),
(	3,	'Goûter',	'Goûter au FIFNL',	'gouter.jpg',	'',	20.00),
(	3,	'Projection',	'Projection courts-métrages au FIFNL',	'film.jpg',	'',	10.00),
(	2,	'Bouquet',	'Bouquet de roses et Mots de Marion Renaud',	'rose.jpg',	'',	16.00),
(	2,	'Diner Stanislas',	'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)',	'bonroi.jpg',	'',	60.00),
(	3,	'Origami',	'Baguettes magiques en Origami en buvant un thé',	'origami.jpg',	'',	12.00),
(	3,	'Livres',	'Livre bricolage avec petits-enfants + Roman',	'bricolage.jpg',	'',	24.00),
(	2,	'Diner  Grand Rue ',	'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)',	'grandrue.jpg',	'',	59.00),
(	0,	'Visite guidée',	'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas',	'place.jpg',	'',	11.00),
(	2,	'Bijoux',	'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil',	'bijoux.jpg',	'',	29.00),
(	0,	'Jeu contacts',	'Jeu pour échange de contacts',	'contact.png',	'',	5.00),
(	0,	'Concert',	'Un concert à Nancy',	'concert.jpg',	'',	17.00),
(	1,	'Appart Hotel',	'Appart’hôtel Coeur de Ville, en plein centre-ville',	'apparthotel.jpg',	'',	56.00),
(	2,	'Hôtel d\'Haussonville',	'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas',	'hotel_haussonville_logo.jpg',	'',	169.00),
(	1,	'Boite de nuit',	'Discothèque, Boîte tendance avec des soirées à thème & DJ invités',	'boitedenuit.jpg',	'',	32.00);


INSERT INTO `item` ( `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`,`reservation`,`message`) VALUES
(	1,	'Planètes Laser',	'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.',	'laser.jpg',	'',	15.00,'Guillaume','sympa'),
(	1,	'Fort Aventure',	'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.',	'fort.jpg',	'',	25.00,'Tom','Je prends'),
(	2,	'Voila',	'Petite description',	'',	'',	10.00,'Matéo','cool');

INSERT INTO `item` ( `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`) VALUES
(	7,	'Bob',	'L\'éponge',	'banbob.jpg',	'',	20.00),
(	7,	'Cd Hit parade 2020',	'Pour du bon son',	'',	'',	10.00),
(	8,	'Coca',	'Une bouteille ou deux',	'coca-cola.jpg',	'https://www.cocacola.fr/fr/home/',	4.00),
(	8,	'Cable réseau',	'Pour aller encore plus vite',	'',	'https://www.fnac.com/Quel-role-joue-le-cable-reseau-dans-votre-debit-Internet/cp35214/w-4',	2.00);








-- LISTES

DROP TABLE IF EXISTS `liste`;
CREATE TABLE `liste` (
  `no` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `titre` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `expiration` date DEFAULT NULL,
  `token` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token_visu` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `public` bool DEFAULT 0,
  PRIMARY KEY (`no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token`, `token_visu`) VALUES
(1,	1,	'Pour fêter le bac !',	'Pour un week-end à Nancy qui nous fera oublier les épreuves. ',	'2018-06-27',	'nosecure1','nosecure1_visu'),
(2,	2,	'Liste de mariage d\'Alice et Bob',	'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)',	'2018-06-30',	'nosecure2','nosecure2_visu'),
(3,	3,	'C\'est l\'anniversaire de Charlie',	'Pour lui préparer une fête dont il se souviendra :)',	'2017-12-12',	'nosecure3','nosecure3_visu'),
(4,	1,	'BlaBla',	'Bla',	'2018-06-30',	'nosecure4','nosecure4_visu');

INSERT INTO `liste` (`user_id`, `titre`, `description`, `expiration`, `token`,`token_visu`,`public`) VALUES
(3,	'Coucou',	'Lorem Ipsum',	'2019-12-12',	'sacréToken','sacréToken_visu','1'),
(1,	'Nouvelle liste',	'Lorem Ipsum',	'2020-06-30',	'Waw','Waw_visu','1');

INSERT INTO `liste` (`user_id`, `titre`, `description`, `expiration`, `token`,`public`) VALUES
(4,	'Nouvel an',	'Bonnée année !',	'2020-01-31',	'GoodListe','1'),
(3,	'Pour fêter notre S3',	'Petite soirée de code',	'2020-02-20',	'GrosseFête','1'),
(1,	'Coucou',	'Lorem Ipsum',	'2019-12-12',	'sacréToken','1');









-- USER


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `prenom` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `droit` int(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img` text,

  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user` (`prenom`, `mail`, `hash`) VALUES
-- mdp : prof
('Professeur','p@gmail.com',"$2y$12$np8p7GaF1R9OPQQ2x12b0uCdSEHBcVwOOSgWL1x.CMs/fDkih6WOC"),
-- mdp : guillaume
('Guillaume','g@gmail.com',"$2y$12$KDS6kJpFzJkYoUksUoANR.lQ3sHZxWRLG5fpjNKtgOy/vshQazh3."),
-- mdp : matéo
('Mateo','m@gmail.com',"$2y$12$4TyrxuzlZCZqO4n/89lLCuHUfWt4dmEI2L0LRFelrn75.ixDPlK9C"),
-- mdp : tom
('Tom','t@gmail.com',"$2y$12$m3.pveCaREtFA4n2TS1Q6e0kuUjQh0S1QjED/CMeQ2f.5tvhY0Vbi");







-- MessagesListes

DROP TABLE IF EXISTS `messagesListes`;
CREATE TABLE `messagesListes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `liste_id` int(11) NOT NULL,
  `auteur` text NOT NULL,
  `message` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `messagesListes` (`liste_id`, `auteur`, `message`) VALUES
(2,	'Guillaume',	'Salut c\'est top cette liste'),
(3,	'Guillaume',	'Sacré idée'),
(2,	'Matéo',	'Super');
