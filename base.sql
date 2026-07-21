CREATE DATABASE `4110-4016-mobile-money`;

-- Table: operateurs
CREATE TABLE operateurs (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: prefixes
CREATE TABLE prefixes (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    code VARCHAR(3) NOT NULL,
    actif TINYINT(1) NOT NULL DEFAULT 1,
    est_interne TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY code (code)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: clients
CREATE TABLE clients (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    telephone VARCHAR(15) NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prefixe_id INT(5) UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY telephone (telephone),
    CONSTRAINT fk_clients_prefixe FOREIGN KEY (prefixe_id) REFERENCES prefixes (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: comptes
CREATE TABLE comptes (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    client_id INT(5) UNSIGNED NOT NULL,
    solde DECIMAL(12,2) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    UNIQUE KEY client_id (client_id),
    CONSTRAINT fk_comptes_client FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: types_operation
CREATE TABLE types_operation (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(50) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: baremes
CREATE TABLE baremes (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    type_operation_id INT(5) UNSIGNED NOT NULL,
    montant_min DECIMAL(12,2) NOT NULL,
    montant_max DECIMAL(12,2) NOT NULL,
    frais DECIMAL(12,2) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_baremes_type_operation FOREIGN KEY (type_operation_id) REFERENCES types_operation (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: transactions
CREATE TABLE transactions (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    client_id INT(5) UNSIGNED NOT NULL,
    client_destinataire_id INT(5) UNSIGNED NULL,
    type_operation_id INT(5) UNSIGNED NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    frais DECIMAL(12,2) NOT NULL,
    date_creation DATETIME NOT NULL,
    commission_externe DECIMAL(12,2) NULL DEFAULT 0,
    PRIMARY KEY (id),
    CONSTRAINT fk_transactions_client FOREIGN KEY (client_id) REFERENCES clients (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_transactions_type_operation FOREIGN KEY (type_operation_id) REFERENCES types_operation (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: commission_config
CREATE TABLE commission_config (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    pourcentage DECIMAL(5,2) NOT NULL,
    date_creation DATETIME NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: commission_config
CREATE TABLE promotion_config (
    id INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    pourcentage DECIMAL(5,2) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Suppression des tables (ordre inverse des créations)
DROP TABLE IF EXISTS commission_config;
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS baremes;
DROP TABLE IF EXISTS types_operation;
DROP TABLE IF EXISTS comptes;
DROP TABLE IF EXISTS clients;
DROP TABLE IF EXISTS prefixes;
DROP TABLE IF EXISTS operateurs;

--donne pour la promotion
INSERT INTO promotion_config(pourcentage) VALUE (20);