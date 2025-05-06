-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3308
-- Vytvořeno: Úte 06. kvě 2025, 00:50
-- Verze serveru: 8.0.18
-- Verze PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `mydb`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `kosik`
--

DROP TABLE IF EXISTS `kosik`;
CREATE TABLE IF NOT EXISTS `kosik` (
  `idKosik` int(11) NOT NULL AUTO_INCREMENT,
  `uzivatel_iduzivatel` int(11) NOT NULL,
  `produkt_idprodukt` int(11) NOT NULL,
  `velikost` varchar(45) DEFAULT NULL,
  `pocet` int(16) NOT NULL,
  PRIMARY KEY (`idKosik`),
  KEY `fk_uzivatel_has_produkt_produkt1_idx` (`produkt_idprodukt`),
  KEY `fk_uzivatel_has_produkt_uzivatel1_idx` (`uzivatel_iduzivatel`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `kosik`
--

INSERT INTO `kosik` (`idKosik`, `uzivatel_iduzivatel`, `produkt_idprodukt`, `velikost`, `pocet`) VALUES
(1, 2, 4, 'm', 1),
(2, 2, 20, 's', 5),
(145, 23, 2, 'm', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavky`
--

DROP TABLE IF EXISTS `objednavky`;
CREATE TABLE IF NOT EXISTS `objednavky` (
  `idobjednavky` int(11) NOT NULL AUTO_INCREMENT,
  `uzivatel_iduzivatel` int(11) NOT NULL,
  `datum` date DEFAULT NULL,
  `mesto` varchar(255) NOT NULL,
  `adresa_cp` varchar(255) NOT NULL,
  `psc` int(11) NOT NULL,
  `odeslano` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idobjednavky`),
  KEY `fk_objednavky_uzivatel1_idx` (`uzivatel_iduzivatel`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `objednavky`
--

INSERT INTO `objednavky` (`idobjednavky`, `uzivatel_iduzivatel`, `datum`, `mesto`, `adresa_cp`, `psc`, `odeslano`) VALUES
(96, 3, '2021-04-09', 'd', 'd', 352, 1),
(99, 3, '2021-04-14', 'da', 'da', 5, 1),
(100, 21, '2021-04-19', 'dsasadas', 'dasdas', 465561, 1),
(101, 22, '2021-04-20', 'ano', 'ano', 6541, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `objednavky_has_produkt`
--

DROP TABLE IF EXISTS `objednavky_has_produkt`;
CREATE TABLE IF NOT EXISTS `objednavky_has_produkt` (
  `objednavky_idobjednavky` int(11) NOT NULL,
  `produkt_idprodukt` int(11) NOT NULL,
  `velikost` varchar(45) DEFAULT NULL,
  `pocet` int(11) NOT NULL,
  PRIMARY KEY (`objednavky_idobjednavky`,`produkt_idprodukt`),
  KEY `fk_objednavky_has_produkt_produkt1_idx` (`produkt_idprodukt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `objednavky_has_produkt`
--

INSERT INTO `objednavky_has_produkt` (`objednavky_idobjednavky`, `produkt_idprodukt`, `velikost`, `pocet`) VALUES
(96, 3, 'm', 1),
(99, 2, 'm', 3),
(99, 4, 'm', 2),
(99, 5, 'm', 1),
(99, 8, 'm', 1),
(99, 61, 'm', 1),
(100, 2, 'm', 1),
(100, 3, 'm', 1),
(101, 3, 'm', 1),
(101, 4, 'm', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `produkt`
--

DROP TABLE IF EXISTS `produkt`;
CREATE TABLE IF NOT EXISTS `produkt` (
  `idProdukt` int(11) NOT NULL AUTO_INCREMENT,
  `jmenoProdukt` varchar(45) DEFAULT NULL,
  `popisProdukt` varchar(255) DEFAULT NULL,
  `cenaProdukt` int(11) DEFAULT NULL,
  `imageProdukt` varchar(45) DEFAULT NULL,
  `kategorieProdukt` varchar(45) DEFAULT NULL,
  `znackaProdukt` varchar(45) DEFAULT NULL,
  `barvaProdukt` varchar(45) DEFAULT NULL,
  `pohlaviProdukt` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idProdukt`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `produkt`
--

INSERT INTO `produkt` (`idProdukt`, `jmenoProdukt`, `popisProdukt`, `cenaProdukt`, `imageProdukt`, `kategorieProdukt`, `znackaProdukt`, `barvaProdukt`, `pohlaviProdukt`) VALUES
(1, 'Puhlos bunda', 'Stylová barevná bunda značky puhlos vás zahřeje a k tomu přidá styl.', 950, 'fotky/bunda1.jpg', 'bunda', 'Puhlos', 'mix', 'pánské'),
(2, 'Costiy bunda', 'Dámská bunda značky costiy, která je zateplená vlnou a vytvořena pro maximální komfort.', 1200, 'fotky/bunda2.jpg', 'bunda', 'Costiy', 'modrá', 'dámské'),
(3, 'Anderson  kožená bunda', 'Kožená bunda anderson ze sebe svým stylem a jedinečností dělá velmi kvalitní a módní bundu.', 2100, 'fotky/bunda3.jpg', 'bunda', 'Anderson', 'černá', 'pánské'),
(4, 'Tik&Lik růžová bunda', 'Bunda značky Tik&Lik, která na první pohled zaujme. S tepelnou izolací a pohledným designem se s touto bundou vždy budete cítit jako v bavlnce.', 1600, 'fotky/bunda4.jpg', 'bunda', 'Tik&Lik', 'růžová', 'dámské'),
(5, 'Costiy zelené džíny', 'Zářívé dámské džíny značky costiy. Vytvořeno s láskou.', 700, 'fotky/dziny1.jpg', 'džíny', 'Costiy', 'zelená', 'dámské'),
(7, 'Tik&Lik skinny džíny', 'Dámské džíny od firmy Tik&Lik.', 800, 'fotky/dziny3.jpg', 'džíny', 'Tik&Lik', 'modrá', 'dámské'),
(8, 'Sproot džíny', 'Dámské džíny značky sproot s potiskem garfielda.', 900, 'fotky/dziny5.jpg', 'džíny', 'Sproot', 'modrá', 'dámské'),
(9, 'Anderson džíny', 'Velmi stylové džíny známe firmy anderson. Dovezeno z polska', 700, 'fotky/dziny2.jpg', 'džíny', 'Anderson', 'modrá', 'pánské'),
(11, 'Tik&Lik motýlí klobouk', 'Letní motýlí klobouk značky Tik&Lik.', 450, 'fotky/hat4.jpg', 'klobouk', 'Tik&Lik', 'bílá', 'unisex'),
(12, 'Sproot klobouk be happy', 'Žlutý letní klobouk značky sproot.', 300, 'fotky/hat2.jpg', 'klobouk', 'Sproot', 'žlutá', 'unisex'),
(13, 'Puhlos checkers klobouk', 'Klobouk značky puhlos. Ideální na letní akce.', 500, 'fotky/hat3.jpg', 'klobouk', 'Puhlos', 'mix', 'unisex'),
(14, 'Sproot kimono', 'Saténové kimono značky sproot.', 1100, 'fotky/kimono.jpg', 'kimono', 'Sproot', 'žlutá', 'unisex'),
(15, 'Tik&Lik kraťasy', 'Dámské letní růžové tik&Lik kraťasy.', 750, 'fotky/kratasy1.jpg', 'kraťasy', 'Tik&Lik', 'růžová', 'dámské'),
(16, 'XDanku chad kraťasy', 'kraťasy chad firmy xdanku. Pánové, podívejte se na svoje kraťasy, teď na chad kraťasy, zpátky na svoje, zpátky na chad. Bohužel, vaše kraťasy nejsou chad, ale mohly by. S těmito kraťasy může být každý chad.', 950, 'fotky/kratasy3.jpg', 'kraťasy', 'XDanku', 'hnědá', 'pánské'),
(17, 'Anderson tmavé kraťasy', 'Letní kraťasy značky anderson.', 300, 'fotky/kratasy4.jpg', 'kraťasy', 'Anderson', 'modrá', 'pánské'),
(18, 'Puhlos mikina s kapucí', 'Zateplená pánská mikina puhlos.', 1200, 'fotky/mikina1.jpg', 'mikina', 'Puhlos', 'mix', 'pánské'),
(19, 'Anderson mikina', 'Dámská crop top mikina s kapucí značky anderson.', 1650, 'fotky/mikina2.jpg', 'mikina', 'Anderson', 'žlutá', 'dámské'),
(20, 'XDanku mikina lolly', 'Mikina s moderním potiskem značky xdanku.', 1450, 'fotky/mikina4.jpg', 'mikina', 'XDanku', 'černá', 'dámské'),
(21, 'Anderson pruhovaný svetr', 'Trojbarevný svetr značky Anderson.', 999, 'fotky/svetr2.jpg', 'svetr', 'Anderson', 'mix', 'pánské'),
(22, 'Costiy dámský svetr', 'Dámský černý svetr zndačky costiy.', 1100, 'fotky/svetr1.jpg', 'svetr', 'Costiy', 'černá', 'dámské'),
(34, 'Puhlos tričko ah!', 'Pánské šedivé tričko s nápisem the element of surprise.', 699, 'fotky/tricko3.jpg', 'tričko', 'Puhlos', 'šedivá', 'pánské'),
(59, 'XDanku dámské tričko', 'šedivé lehké tričko značky xdanku.', 499, 'fotky/XDanku dámské tričko1612452039.jpg', 'tričko', 'XDanku', 'šedivá', 'dámské'),
(61, 'dootdoot', 'i cant breath', 69, 'fotky/ano1615484892.png', 'skřet', 'ano', 'červená', 'neznámé');

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

DROP TABLE IF EXISTS `uzivatel`;
CREATE TABLE IF NOT EXISTS `uzivatel` (
  `idUzivatel` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(64) NOT NULL,
  `prijmeni` varchar(64) NOT NULL,
  `email` varchar(80) NOT NULL,
  `heslo` varchar(120) NOT NULL,
  PRIMARY KEY (`idUzivatel`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`idUzivatel`, `jmeno`, `prijmeni`, `email`, `heslo`) VALUES
(2, 'adam', 'svatoš', 'uzivatel@email.cz', '$2y$10$28A6Vlrq1rS.A3t2Oe9HKuiYZfoy7/ovx7UCHfZdTnHTeC3l/LBMK'),
(3, 'admin', 'admin', 'admin@email.cz', '$2y$10$HrApUwd18jD9rftY7tmB9ehG/1NcW2GOJ3ojoADETRk1Vb4sECV7C'),
(15, 'dada', 'dada', 'da@s', '$2y$10$FRDJDyD7e53Xh75u.RKe9uG1464NK2aNCj/A7ST.w1RIIiBVXL0AO'),
(21, 'da', 'xsaxasx', 'svatosad@zaci.spse.cz', '$2y$10$F3NwlYNvJHRBd2/JGcFe4.lGGo8K1PNfYhX8d7PdqcJbr5hwhG20u'),
(22, 'dsadas', 'dasdassfd', 'adamsvatos000@gmail.com', '$2y$10$8GAsy3m0mljxw2ZTrWDBTeWcB411PZmknSk5sBjUPwvXzmRaiCHh.'),
(23, 'ada', 'ada', 'ada@ada.ada', '$2y$10$yLXZc0A8YT1H38GJXpLhhOjRbs8yc7k07DaFEk5h5/EI4CbGt/Kbq');

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `kosik`
--
ALTER TABLE `kosik`
  ADD CONSTRAINT `fk_uzivatel_has_produkt_produkt1` FOREIGN KEY (`produkt_idprodukt`) REFERENCES `produkt` (`idProdukt`),
  ADD CONSTRAINT `fk_uzivatel_has_produkt_uzivatel1` FOREIGN KEY (`uzivatel_iduzivatel`) REFERENCES `uzivatel` (`idUzivatel`);

--
-- Omezení pro tabulku `objednavky`
--
ALTER TABLE `objednavky`
  ADD CONSTRAINT `fk_objednavky_uzivatel1` FOREIGN KEY (`uzivatel_iduzivatel`) REFERENCES `uzivatel` (`idUzivatel`);

--
-- Omezení pro tabulku `objednavky_has_produkt`
--
ALTER TABLE `objednavky_has_produkt`
  ADD CONSTRAINT `fk_objednavky_has_produkt_produkt1` FOREIGN KEY (`produkt_idprodukt`) REFERENCES `produkt` (`idProdukt`),
  ADD CONSTRAINT `objednavky_has_produkt_ibfk_1` FOREIGN KEY (`objednavky_idobjednavky`) REFERENCES `objednavky` (`idobjednavky`) ON DELETE CASCADE,
  ADD CONSTRAINT `objednavky_has_produkt_ibfk_2` FOREIGN KEY (`objednavky_idobjednavky`) REFERENCES `objednavky` (`idobjednavky`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
