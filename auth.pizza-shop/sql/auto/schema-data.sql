SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `email`                              varchar(128) NOT NULL,
    `password`                           varchar(256) NOT NULL,
    `active`                             tinyint(4) NOT NULL DEFAULT 0,
    `activation_token`                   varchar(64) DEFAULT NULL,
    `activation_token_expiration_date`   timestamp NULL DEFAULT NULL,
    `refresh_token`                      varchar(64) DEFAULT NULL,
    `refresh_token_expiration_date`      timestamp NULL DEFAULT NULL,
    `reset_passwd_token`                 varchar(64) DEFAULT NULL,
    `reset_passwd_token_expiration_date` timestamp NULL DEFAULT NULL,
    `username`                           varchar(64) DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO `users` (`email`, `password`, `active`, `activation_token`, `activation_token_expiration_date`,
                     `refresh_token`, `refresh_token_expiration_date`, `reset_passwd_token`,
                     `reset_passwd_token_expiration_date`, `username`)
VALUES ('AlixPerrot@free.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        'ac590b521c41d3d4dd0c901b040d1b6317817b693a7b830b5f1d1e010e411a9a', '2023-09-29 09:12:52', NULL, NULL,
        'AlixPerrot'),
       ('AlphonseFleury@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'AlphonseFleury'),
       ('ArnaudeLeblanc@hotmail.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'ArnaudeLeblanc'),
       ('BertrandMallet@orange.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'BertrandMallet'),
       ('BrigitteRenard@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'BrigitteRenard'),
       ('CélinaDeschamps@club-internet.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL,
        NULL, NULL, NULL, NULL, NULL, 'CélinaDeschamps'),
       ('EmmanuelBlin@dbmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'EmmanuelBlin'),
       ('ÉtienneGuyon@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'ÉtienneGuyon'),
       ('EugèneClement@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'EugèneClement'),
       ('FranckRemy@noos.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'FranckRemy'),
       ('FrançoiseFischer@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'FrançoiseFischer'),
       ('GeorgesGuichard@laposte.net', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL,
        NULL, NULL, NULL, NULL, NULL, 'GeorgesGuichard'),
       ('GérardMartins@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'GérardMartins'),
       ('GrégoireDupont@tele2.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'GrégoireDupont'),
       ('GuillaumePerret@live.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'GuillaumePerret'),
       ('GuyBoutin@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'GuyBoutin'),
       ('HélèneCoulon@orange.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'HélèneCoulon'),
       ('HélèneGuillaume@hotmail.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'HélèneGuillaume'),
       ('LaurenceLambert@live.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'LaurenceLambert'),
       ('LucasBailly@yahoo.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'LucasBailly'),
       ('LuceNicolas@club-internet.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL,
        NULL, NULL, NULL, NULL, NULL, 'LuceNicolas'),
       ('LucyColas@yahoo.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'LucyColas'),
       ('MarcMarin@gmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'MarcMarin'),
       ('MargaudGodard@free.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'MargaudGodard'),
       ('MathildePayet@orange.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'MathildePayet'),
       ('MauriceRobin@yahoo.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'MauriceRobin'),
       ('miche@gmal.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL, NULL,
        NULL, NULL, 'miche'),
       ('OcéaneBonnin@live.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'OcéaneBonnin'),
       ('OlivieGillet@club-internet.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL,
        NULL, NULL, NULL, NULL, NULL, 'OlivieGillet'),
       ('PaulRemy@noos.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'PaulRemy'),
       ('RenéePeron@yahoo.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'RenéePeron'),
       ('RobertRey@dbmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'RobertRey'),
       ('RogerCarlier@wanadoo.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'RogerCarlier'),
       ('RolandSchmitt@club-internet.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL,
        NULL, NULL, NULL, NULL, NULL, 'RolandSchmitt'),
       ('StéphaneLouis@club-internet.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL,
        NULL, NULL, NULL, NULL, NULL, 'StéphaneLouis'),
       ('SusanneCouturier@tele2.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'SusanneCouturier'),
       ('ThéodoreLeger@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL, NULL,
        NULL, NULL, NULL, 'ThéodoreLeger'),
       ('ThéophileBouvier@live.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'ThéophileBouvier'),
       ('ThomasBaudry@dbmail.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'ThomasBaudry'),
       ('VincentLaine@tele2.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'VincentLaine'),
       ('ZacharieLefort@sfr.fr', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 0, NULL, NULL,
        NULL, NULL, NULL, NULL, 'ZacharieLefort');
