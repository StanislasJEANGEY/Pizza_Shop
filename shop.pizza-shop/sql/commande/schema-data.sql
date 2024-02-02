

-- Adminer 4.8.1 MySQL 5.5.5-10.3.11-MariaDB-1:10.3.11+maria~bionic dump

SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `commande`;
CREATE TABLE `commande`
(
    `delai`          tinyint(4) DEFAULT 0,
    `id`             varchar(64)    NOT NULL,
    `date_commande`  datetime       NOT NULL,
    `type_livraison` int(11) NOT NULL DEFAULT 1,
    `etat`           int(11) NOT NULL DEFAULT 1,
    `montant_total`  decimal(10, 2) NOT NULL DEFAULT 0.00,
    `mail_client`    varchar(128)   NOT NULL,
    KEY              `id_client` (`mail_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `item`;
CREATE TABLE `item`
(
    `id`             int(11) NOT NULL AUTO_INCREMENT,
    `numero`         int(11) NOT NULL,
    `libelle`        varchar(32)   NOT NULL,
    `taille`         int(11) NOT NULL,
    `libelle_taille` varchar(32)   NOT NULL,
    `tarif`          decimal(6, 2) NOT NULL,
    `quantite`       int(11) NOT NULL,
    `commande_id`    varchar(64)   NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2023-09-06 14:47:17

-- Adminer 4.8.1 MySQL 5.5.5-10.3.11-MariaDB-1:10.3.11+maria~bionic dump

SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `commande` (`delai`, `id`, `date_commande`, `type_livraison`, `etat`, `montant_total`, `mail_client`)
VALUES (0, '112e7ee1-3e8d-37d6-89cf-be3318ad6368', '2023-05-17 01:46:37', 3, 1, 61.91, 'ThéodoreLeger@sfr.fr'),
       (0, '9b5e8d97-2be9-3c2a-a33f-86305746f1e0', '2022-10-17 17:39:52', 3, 1, 39.92, 'RenéePeron@yahoo.fr'),
       (0, 'eedeea63-4032-3b84-af42-3c257d5c3c33', '2023-09-03 01:38:22', 3, 1, 26.93, 'BrigitteRenard@sfr.fr'),
       (0, '206e6cab-bb03-39e3-9cec-e7b3d7aed520', '2022-10-22 06:23:29', 3, 1, 30.92, 'MauriceRobin@yahoo.fr'),
       (0, '199bbb01-cc36-3eed-a43d-5832ab4cb005', '2022-09-12 15:51:06', 3, 1, 57.94, 'MargaudGodard@free.fr'),
       (0, 'c5eb6255-2198-3546-93e0-717222893bdf', '2022-11-15 06:49:09', 3, 1, 43.95, 'GuillaumePerret@live.com'),
       (0, 'd57db8a0-b6f3-354c-8e57-b9b85c1e9e10', '2022-12-02 14:34:55', 3, 1, 59.92, 'SusanneCouturier@tele2.fr'),
       (0, '539585f1-df45-3961-bf64-08a963bd5c38', '2023-07-29 06:24:08', 1, 1, 94.89, 'ThéophileBouvier@live.com'),
       (0, 'cd8280da-915b-3cf1-bc65-fd9e9b5fe7c3', '2023-01-11 14:05:28', 1, 1, 141.88, 'LucasBailly@yahoo.fr'),
       (0, 'dd65282e-ad71-3659-a31c-32088c084217', '2022-10-05 11:31:48', 2, 1, 36.92, 'ZacharieLefort@sfr.fr'),
       (0, 'cc1e6220-774a-37bd-b8cf-e7b9dc5c446a', '2022-10-03 08:39:21', 3, 2, 62.94, 'GrégoireDupont@tele2.fr'),
       (0, 'a2915aaf-1eea-3630-9158-ac2025dfbf9f', '2023-04-02 12:21:46', 2, 2, 99.86,
        'CélinaDeschamps@club-internet.fr'),
       (0, '46efe7ab-e8f4-383b-a88f-ea29e3f39280', '2022-12-14 21:38:22', 2, 2, 49.92, 'VincentLaine@tele2.fr'),
       (0, '51b570bb-f9cf-3923-ba2b-901192226c02', '2023-07-03 09:33:11', 2, 2, 50.92, 'AlphonseFleury@sfr.fr'),
       (0, 'c3ca1405-b543-3733-ae76-955d0e641bec', '2023-05-07 06:37:42', 2, 2, 24.95, 'GuyBoutin@sfr.fr'),
       (0, '073b5d59-0bd2-32a6-aac6-0d573edbd30e', '2023-05-30 23:06:25', 1, 2, 42.91, 'EugèneClement@sfr.fr'),
       (0, 'ed50da62-7ce6-31bd-9523-a04a0bef3bdd', '2022-09-07 23:47:20', 2, 2, 70.93, 'ArnaudeLeblanc@hotmail.fr'),
       (0, '17200d83-4d2f-3dae-ac7c-cba93c0f55d2', '2022-10-06 16:30:59', 3, 2, 119.88, 'RobertRey@dbmail.com'),
       (0, '21921f75-f21b-3c6c-8535-498dec5c7418', '2022-11-09 19:33:35', 3, 2, 59.85, 'OcéaneBonnin@live.com'),
       (0, '61eef959-bd20-30e7-bcdb-cd418fab1140', '2023-01-14 06:26:53', 1, 2, 16.97, 'AlixPerrot@free.fr'),
       (0, '06aa0d00-c592-3c1d-8a69-9780daa90c4d', '2022-09-26 14:19:12', 3, 3, 45.90, 'OlivieGillet@club-internet.fr'),
       (0, '82277f9d-56c1-34df-812a-850a33c19973', '2023-05-28 05:21:48', 3, 3, 48.94,
        'StéphaneLouis@club-internet.fr'),
       (0, 'b2dd56c2-700b-3b49-915d-d3be96f7f6af', '2023-03-27 22:50:22', 2, 3, 57.90, 'MathildePayet@orange.fr'),
       (0, 'ce852d5f-4845-354e-8ef8-c86a1a0d8736', '2023-08-28 14:35:31', 2, 3, 106.89, 'LaurenceLambert@live.com'),
       (0, 'f64bec4a-18b3-3b50-b9a0-31387c6a9c81', '2023-03-04 10:39:49', 3, 3, 66.88, 'LucyColas@yahoo.fr'),
       (0, '1e02f244-ea3a-3d94-a406-c17edf39a3ef', '2022-11-10 06:47:53', 1, 3, 50.91, 'HélèneCoulon@orange.fr'),
       (0, '745451c5-86ca-3169-9779-f27823e51983', '2023-07-14 04:30:23', 3, 3, 28.92, 'FranckRemy@noos.fr'),
       (0, '750d81aa-853a-3361-a60c-4dbababa0d81', '2023-04-15 18:33:33', 2, 3, 42.90, 'BertrandMallet@orange.fr'),
       (0, '0b39de47-d46f-34f8-b43d-fa15874e6fa9', '2023-07-31 11:04:38', 3, 3, 60.92, 'EmmanuelBlin@dbmail.com'),
       (0, 'df35ddf2-b347-3fe8-b875-9d6f1ec76aa9', '2023-07-01 19:10:30', 3, 3, 47.90, 'GérardMartins@sfr.fr'),
       (0, '34c347bc-5680-3971-a171-b44b8c5216e9', '2023-05-22 22:31:21', 3, 4, 79.89, 'MarcMarin@gmail.com'),
       (0, 'ccbb88cd-46d1-30da-aa85-a8492818dd74', '2023-04-21 11:01:36', 3, 4, 40.92, 'FrançoiseFischer@sfr.fr'),
       (0, 'e94376b0-c72a-359a-85f1-72711ec0af17', '2023-05-18 00:29:30', 2, 4, 85.92, 'PaulRemy@noos.fr'),
       (0, '217904d4-5999-3775-8916-35775a8d5abd', '2023-04-26 04:20:40', 3, 4, 95.90, 'GeorgesGuichard@laposte.net'),
       (0, '93d90540-7580-3e7f-8977-a403d9608b9f', '2023-04-02 15:08:58', 2, 4, 85.90, 'ÉtienneGuyon@gmail.com'),
       (0, '7f1bc17f-ee1d-39c6-a926-051f51ddc9d0', '2023-07-26 02:51:31', 3, 4, 60.93, 'HélèneGuillaume@hotmail.fr'),
       (0, '70e47102-6bcf-3592-90f4-b41ef907928b', '2022-10-24 23:52:23', 3, 4, 67.90,
        'RolandSchmitt@club-internet.fr'),
       (0, 'c37c16c9-355b-30c7-b2ff-85fd3ceca312', '2023-03-25 18:46:42', 2, 4, 38.90, 'RogerCarlier@wanadoo.fr'),
       (0, 'fe5875d5-0368-3d56-832d-9c003ef06e8e', '2023-03-28 23:08:45', 2, 4, 26.94, 'ThomasBaudry@dbmail.com'),
       (0, '14f755ac-df58-39f2-bc60-8552b1b9e169', '2023-05-12 00:20:19', 3, 4, 55.92, 'LuceNicolas@club-internet.fr'),
       (0, '2b2d555d-05a6-45b4-afa2-b0ef425b4c06', '2023-09-06 10:20:54', 2, 1, 9.99, 'miche@gmal.com');

INSERT INTO `item` (`id`, `numero`, `libelle`, `taille`, `libelle_taille`, `tarif`, `quantite`, `commande_id`)
VALUES (187, 8, 'salade tomate', 1, 'normale', 4.99, 1, '112e7ee1-3e8d-37d6-89cf-be3318ad6368'),
       (188, 10, 'panna cotta', 2, 'grande', 5.99, 5, '112e7ee1-3e8d-37d6-89cf-be3318ad6368'),
       (189, 1, 'Margherita', 1, 'normale', 8.99, 3, '112e7ee1-3e8d-37d6-89cf-be3318ad6368'),
       (190, 8, 'salade tomate', 1, 'normale', 4.99, 3, '9b5e8d97-2be9-3c2a-a33f-86305746f1e0'),
       (191, 7, 'salade verte', 2, 'grande', 4.99, 2, '9b5e8d97-2be9-3c2a-a33f-86305746f1e0'),
       (192, 8, 'salade tomate', 1, 'normale', 4.99, 3, '9b5e8d97-2be9-3c2a-a33f-86305746f1e0'),
       (193, 6, 'eau', 2, 'grande', 2.99, 2, 'eedeea63-4032-3b84-af42-3c257d5c3c33'),
       (194, 5, 'cola', 1, 'normale', 2.99, 4, 'eedeea63-4032-3b84-af42-3c257d5c3c33'),
       (195, 1, 'Margherita', 1, 'normale', 8.99, 1, 'eedeea63-4032-3b84-af42-3c257d5c3c33'),
       (196, 7, 'salade verte', 1, 'normale', 3.99, 5, '206e6cab-bb03-39e3-9cec-e7b3d7aed520'),
       (197, 5, 'cola', 2, 'grande', 3.99, 2, '206e6cab-bb03-39e3-9cec-e7b3d7aed520'),
       (198, 5, 'cola', 1, 'normale', 2.99, 1, '206e6cab-bb03-39e3-9cec-e7b3d7aed520'),
       (199, 4, 'Pepperoni', 2, 'grande', 12.99, 2, '199bbb01-cc36-3eed-a43d-5832ab4cb005'),
       (200, 2, 'Reine', 1, 'normale', 9.99, 2, '199bbb01-cc36-3eed-a43d-5832ab4cb005'),
       (201, 10, 'panna cotta', 2, 'grande', 5.99, 2, '199bbb01-cc36-3eed-a43d-5832ab4cb005'),
       (202, 10, 'panna cotta', 2, 'grande', 5.99, 2, 'c5eb6255-2198-3546-93e0-717222893bdf'),
       (203, 2, 'Reine', 1, 'normale', 9.99, 2, 'c5eb6255-2198-3546-93e0-717222893bdf'),
       (204, 1, 'Margherita', 2, 'grande', 11.99, 1, 'c5eb6255-2198-3546-93e0-717222893bdf'),
       (205, 5, 'cola', 1, 'normale', 2.99, 2, 'd57db8a0-b6f3-354c-8e57-b9b85c1e9e10'),
       (206, 5, 'cola', 2, 'grande', 3.99, 1, 'd57db8a0-b6f3-354c-8e57-b9b85c1e9e10'),
       (207, 2, 'Reine', 1, 'normale', 9.99, 5, 'd57db8a0-b6f3-354c-8e57-b9b85c1e9e10'),
       (208, 7, 'salade verte', 2, 'grande', 4.99, 3, '539585f1-df45-3961-bf64-08a963bd5c38'),
       (209, 4, 'Pepperoni', 1, 'normale', 9.99, 4, '539585f1-df45-3961-bf64-08a963bd5c38'),
       (210, 4, 'Pepperoni', 1, 'normale', 9.99, 4, '539585f1-df45-3961-bf64-08a963bd5c38'),
       (211, 2, 'Reine', 2, 'grande', 12.99, 5, 'cd8280da-915b-3cf1-bc65-fd9e9b5fe7c3'),
       (212, 3, 'Savoyarde', 1, 'normale', 10.99, 4, 'cd8280da-915b-3cf1-bc65-fd9e9b5fe7c3'),
       (213, 3, 'Savoyarde', 1, 'normale', 10.99, 3, 'cd8280da-915b-3cf1-bc65-fd9e9b5fe7c3'),
       (214, 1, 'Margherita', 2, 'grande', 11.99, 1, 'dd65282e-ad71-3659-a31c-32088c084217'),
       (215, 9, 'tiramisu', 2, 'grande', 4.99, 2, 'dd65282e-ad71-3659-a31c-32088c084217'),
       (216, 6, 'eau', 2, 'grande', 2.99, 5, 'dd65282e-ad71-3659-a31c-32088c084217'),
       (217, 1, 'Margherita', 2, 'grande', 11.99, 4, 'cc1e6220-774a-37bd-b8cf-e7b9dc5c446a'),
       (218, 1, 'Margherita', 1, 'normale', 8.99, 1, 'cc1e6220-774a-37bd-b8cf-e7b9dc5c446a'),
       (219, 8, 'salade tomate', 2, 'grande', 5.99, 1, 'cc1e6220-774a-37bd-b8cf-e7b9dc5c446a'),
       (220, 7, 'salade verte', 2, 'grande', 4.99, 4, 'a2915aaf-1eea-3630-9158-ac2025dfbf9f'),
       (221, 4, 'Pepperoni', 2, 'grande', 12.99, 5, 'a2915aaf-1eea-3630-9158-ac2025dfbf9f'),
       (222, 5, 'cola', 1, 'normale', 2.99, 5, 'a2915aaf-1eea-3630-9158-ac2025dfbf9f'),
       (223, 4, 'Pepperoni', 1, 'normale', 9.99, 3, '46efe7ab-e8f4-383b-a88f-ea29e3f39280'),
       (224, 7, 'salade verte', 1, 'normale', 3.99, 2, '46efe7ab-e8f4-383b-a88f-ea29e3f39280'),
       (225, 7, 'salade verte', 1, 'normale', 3.99, 3, '46efe7ab-e8f4-383b-a88f-ea29e3f39280'),
       (226, 1, 'Margherita', 1, 'normale', 8.99, 4, '51b570bb-f9cf-3923-ba2b-901192226c02'),
       (227, 6, 'eau', 2, 'grande', 2.99, 1, '51b570bb-f9cf-3923-ba2b-901192226c02'),
       (228, 7, 'salade verte', 1, 'normale', 3.99, 3, '51b570bb-f9cf-3923-ba2b-901192226c02'),
       (229, 8, 'salade tomate', 1, 'normale', 4.99, 2, 'c3ca1405-b543-3733-ae76-955d0e641bec'),
       (230, 9, 'tiramisu', 2, 'grande', 4.99, 2, 'c3ca1405-b543-3733-ae76-955d0e641bec'),
       (231, 10, 'panna cotta', 1, 'normale', 4.99, 1, 'c3ca1405-b543-3733-ae76-955d0e641bec'),
       (232, 8, 'salade tomate', 2, 'grande', 5.99, 4, '073b5d59-0bd2-32a6-aac6-0d573edbd30e'),
       (233, 6, 'eau', 2, 'grande', 2.99, 3, '073b5d59-0bd2-32a6-aac6-0d573edbd30e'),
       (234, 7, 'salade verte', 2, 'grande', 4.99, 2, '073b5d59-0bd2-32a6-aac6-0d573edbd30e'),
       (235, 6, 'eau', 1, 'normale', 1.99, 1, 'ed50da62-7ce6-31bd-9523-a04a0bef3bdd'),
       (236, 1, 'Margherita', 1, 'normale', 8.99, 3, 'ed50da62-7ce6-31bd-9523-a04a0bef3bdd'),
       (237, 3, 'Savoyarde', 2, 'grande', 13.99, 3, 'ed50da62-7ce6-31bd-9523-a04a0bef3bdd'),
       (238, 7, 'salade verte', 1, 'normale', 3.99, 4, '17200d83-4d2f-3dae-ac7c-cba93c0f55d2'),
       (239, 2, 'Reine', 2, 'grande', 12.99, 3, '17200d83-4d2f-3dae-ac7c-cba93c0f55d2'),
       (240, 2, 'Reine', 2, 'grande', 12.99, 5, '17200d83-4d2f-3dae-ac7c-cba93c0f55d2'),
       (241, 7, 'salade verte', 1, 'normale', 3.99, 5, '21921f75-f21b-3c6c-8535-498dec5c7418'),
       (242, 7, 'salade verte', 1, 'normale', 3.99, 5, '21921f75-f21b-3c6c-8535-498dec5c7418'),
       (243, 9, 'tiramisu', 1, 'normale', 3.99, 5, '21921f75-f21b-3c6c-8535-498dec5c7418'),
       (244, 5, 'cola', 1, 'normale', 2.99, 1, '61eef959-bd20-30e7-bcdb-cd418fab1140'),
       (245, 7, 'salade verte', 1, 'normale', 3.99, 1, '61eef959-bd20-30e7-bcdb-cd418fab1140'),
       (246, 2, 'Reine', 1, 'normale', 9.99, 1, '61eef959-bd20-30e7-bcdb-cd418fab1140'),
       (247, 9, 'tiramisu', 2, 'grande', 4.99, 4, '06aa0d00-c592-3c1d-8a69-9780daa90c4d'),
       (248, 9, 'tiramisu', 2, 'grande', 4.99, 2, '06aa0d00-c592-3c1d-8a69-9780daa90c4d'),
       (249, 5, 'cola', 2, 'grande', 3.99, 4, '06aa0d00-c592-3c1d-8a69-9780daa90c4d'),
       (250, 8, 'salade tomate', 1, 'normale', 4.99, 2, '82277f9d-56c1-34df-812a-850a33c19973'),
       (251, 5, 'cola', 1, 'normale', 2.99, 1, '82277f9d-56c1-34df-812a-850a33c19973'),
       (252, 1, 'Margherita', 2, 'grande', 11.99, 3, '82277f9d-56c1-34df-812a-850a33c19973'),
       (253, 10, 'panna cotta', 1, 'normale', 4.99, 2, 'b2dd56c2-700b-3b49-915d-d3be96f7f6af'),
       (254, 10, 'panna cotta', 2, 'grande', 5.99, 3, 'b2dd56c2-700b-3b49-915d-d3be96f7f6af'),
       (255, 10, 'panna cotta', 2, 'grande', 5.99, 5, 'b2dd56c2-700b-3b49-915d-d3be96f7f6af'),
       (256, 10, 'panna cotta', 2, 'grande', 5.99, 4, 'ce852d5f-4845-354e-8ef8-c86a1a0d8736'),
       (257, 1, 'Margherita', 1, 'normale', 8.99, 3, 'ce852d5f-4845-354e-8ef8-c86a1a0d8736'),
       (258, 3, 'Savoyarde', 2, 'grande', 13.99, 4, 'ce852d5f-4845-354e-8ef8-c86a1a0d8736'),
       (259, 1, 'Margherita', 1, 'normale', 8.99, 4, 'f64bec4a-18b3-3b50-b9a0-31387c6a9c81'),
       (260, 7, 'salade verte', 2, 'grande', 4.99, 5, 'f64bec4a-18b3-3b50-b9a0-31387c6a9c81'),
       (261, 6, 'eau', 1, 'normale', 1.99, 3, 'f64bec4a-18b3-3b50-b9a0-31387c6a9c81'),
       (262, 6, 'eau', 2, 'grande', 2.99, 3, '1e02f244-ea3a-3d94-a406-c17edf39a3ef'),
       (263, 9, 'tiramisu', 2, 'grande', 4.99, 4, '1e02f244-ea3a-3d94-a406-c17edf39a3ef'),
       (264, 3, 'Savoyarde', 1, 'normale', 10.99, 2, '1e02f244-ea3a-3d94-a406-c17edf39a3ef'),
       (265, 6, 'eau', 1, 'normale', 1.99, 4, '745451c5-86ca-3169-9779-f27823e51983'),
       (266, 8, 'salade tomate', 2, 'grande', 5.99, 3, '745451c5-86ca-3169-9779-f27823e51983'),
       (267, 5, 'cola', 1, 'normale', 2.99, 1, '745451c5-86ca-3169-9779-f27823e51983'),
       (268, 4, 'Pepperoni', 2, 'grande', 12.99, 1, '750d81aa-853a-3361-a60c-4dbababa0d81'),
       (269, 6, 'eau', 1, 'normale', 1.99, 5, '750d81aa-853a-3361-a60c-4dbababa0d81'),
       (270, 10, 'panna cotta', 1, 'normale', 4.99, 4, '750d81aa-853a-3361-a60c-4dbababa0d81'),
       (271, 4, 'Pepperoni', 1, 'normale', 9.99, 1, '0b39de47-d46f-34f8-b43d-fa15874e6fa9'),
       (272, 2, 'Reine', 2, 'grande', 12.99, 2, '0b39de47-d46f-34f8-b43d-fa15874e6fa9'),
       (273, 9, 'tiramisu', 2, 'grande', 4.99, 5, '0b39de47-d46f-34f8-b43d-fa15874e6fa9'),
       (274, 9, 'tiramisu', 1, 'normale', 3.99, 4, 'df35ddf2-b347-3fe8-b875-9d6f1ec76aa9'),
       (275, 10, 'panna cotta', 2, 'grande', 5.99, 2, 'df35ddf2-b347-3fe8-b875-9d6f1ec76aa9'),
       (276, 7, 'salade verte', 2, 'grande', 4.99, 4, 'df35ddf2-b347-3fe8-b875-9d6f1ec76aa9'),
       (277, 10, 'panna cotta', 1, 'normale', 4.99, 2, '34c347bc-5680-3971-a171-b44b8c5216e9'),
       (278, 4, 'Pepperoni', 1, 'normale', 9.99, 5, '34c347bc-5680-3971-a171-b44b8c5216e9'),
       (279, 8, 'salade tomate', 1, 'normale', 4.99, 4, '34c347bc-5680-3971-a171-b44b8c5216e9'),
       (280, 9, 'tiramisu', 2, 'grande', 4.99, 4, 'ccbb88cd-46d1-30da-aa85-a8492818dd74'),
       (281, 10, 'panna cotta', 1, 'normale', 4.99, 3, 'ccbb88cd-46d1-30da-aa85-a8492818dd74'),
       (282, 8, 'salade tomate', 2, 'grande', 5.99, 1, 'ccbb88cd-46d1-30da-aa85-a8492818dd74'),
       (283, 1, 'Margherita', 2, 'grande', 11.99, 1, 'e94376b0-c72a-359a-85f1-72711ec0af17'),
       (284, 4, 'Pepperoni', 1, 'normale', 9.99, 3, 'e94376b0-c72a-359a-85f1-72711ec0af17'),
       (285, 3, 'Savoyarde', 1, 'normale', 10.99, 4, 'e94376b0-c72a-359a-85f1-72711ec0af17'),
       (286, 5, 'cola', 1, 'normale', 2.99, 3, '217904d4-5999-3775-8916-35775a8d5abd'),
       (287, 1, 'Margherita', 2, 'grande', 11.99, 4, '217904d4-5999-3775-8916-35775a8d5abd'),
       (288, 4, 'Pepperoni', 2, 'grande', 12.99, 3, '217904d4-5999-3775-8916-35775a8d5abd'),
       (289, 1, 'Margherita', 2, 'grande', 11.99, 5, '93d90540-7580-3e7f-8977-a403d9608b9f'),
       (290, 10, 'panna cotta', 1, 'normale', 4.99, 4, '93d90540-7580-3e7f-8977-a403d9608b9f'),
       (291, 10, 'panna cotta', 2, 'grande', 5.99, 1, '93d90540-7580-3e7f-8977-a403d9608b9f'),
       (292, 4, 'Pepperoni', 2, 'grande', 12.99, 2, '7f1bc17f-ee1d-39c6-a926-051f51ddc9d0'),
       (293, 4, 'Pepperoni', 2, 'grande', 12.99, 2, '7f1bc17f-ee1d-39c6-a926-051f51ddc9d0'),
       (294, 6, 'eau', 2, 'grande', 2.99, 3, '7f1bc17f-ee1d-39c6-a926-051f51ddc9d0'),
       (295, 7, 'salade verte', 1, 'normale', 3.99, 2, '70e47102-6bcf-3592-90f4-b41ef907928b'),
       (296, 1, 'Margherita', 1, 'normale', 8.99, 4, '70e47102-6bcf-3592-90f4-b41ef907928b'),
       (297, 8, 'salade tomate', 2, 'grande', 5.99, 4, '70e47102-6bcf-3592-90f4-b41ef907928b'),
       (298, 10, 'panna cotta', 1, 'normale', 4.99, 3, 'c37c16c9-355b-30c7-b2ff-85fd3ceca312'),
       (299, 6, 'eau', 1, 'normale', 1.99, 2, 'c37c16c9-355b-30c7-b2ff-85fd3ceca312'),
       (300, 7, 'salade verte', 1, 'normale', 3.99, 5, 'c37c16c9-355b-30c7-b2ff-85fd3ceca312'),
       (301, 9, 'tiramisu', 1, 'normale', 3.99, 4, 'fe5875d5-0368-3d56-832d-9c003ef06e8e'),
       (302, 10, 'panna cotta', 1, 'normale', 4.99, 1, 'fe5875d5-0368-3d56-832d-9c003ef06e8e'),
       (303, 8, 'salade tomate', 2, 'grande', 5.99, 1, 'fe5875d5-0368-3d56-832d-9c003ef06e8e'),
       (304, 7, 'salade verte', 1, 'normale', 3.99, 3, '14f755ac-df58-39f2-bc60-8552b1b9e169'),
       (305, 1, 'Margherita', 2, 'grande', 11.99, 3, '14f755ac-df58-39f2-bc60-8552b1b9e169'),
       (306, 7, 'salade verte', 1, 'normale', 3.99, 2, '14f755ac-df58-39f2-bc60-8552b1b9e169'),
       (307, 2, 'Reine', 1, 'normale', 9.99, 1, '2b2d555d-05a6-45b4-afa2-b0ef425b4c06');

-- 2023-09-06 14:47:34

