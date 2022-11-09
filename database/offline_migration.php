CREATE TABLE `memas106`.`equipments` ( `id` INT NOT NULL , `oid` INT NOT NULL AUTO_INCREMENT , `name` INT NOT NULL , `technical_specification` TEXT NOT NULL , PRIMARY KEY (`oid`)) ENGINE = InnoDB;

ALTER TABLE `memas106`.`equipments` CHANGE `name` `name` VARCHAR(256) NOT NULL;

CREATE TABLE `memas106`.`technical_specifications` ( `id` INT NOT NULL AUTO_INCREMENT , `equipment_id` INT NOT NULL , `specification_name` VARCHAR(256) NOT NULL , `specification_value` VARCHAR(256) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `memas106`.`equipments` CHANGE `technical_specification` `asset_tag` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

ALTER TABLE `equipments` ADD `created_at` DATETIME NOT NULL AFTER `asset_tag`;

ALTER TABLE `equipments` ADD `updated_at` DATETIME NOT NULL AFTER `created_at`;

CREATE TABLE `memas106`.`mantenance_logs` ( `id` INT NOT NULL , `oid` INT NOT NULL AUTO_INCREMENT , `type` VARCHAR(256) NOT NULL , `equipment_oid` INT NOT NULL , `description` TEXT NOT NULL , `created_at` DATETIME NOT NULL , `updated_at` DATETIME NOT NULL , PRIMARY KEY (`oid`)) ENGINE = InnoDB;

ALTER TABLE `mantenance_logs` ADD `equipment_id` INT NOT NULL AFTER `equipment_oid`;

RENAME TABLE `memas106`.`mantenance_logs` TO `memas106`.`maintenance_logs`;



ALTER TABLE `equipments` ADD `make` TEXT NULL AFTER `asset_tag`, ADD `model` TEXT NULL AFTER `make`, ADD `serial_number` VARCHAR(256) NULL AFTER `model`;

ALTER TABLE `equipments` ADD `department` VARCHAR(256) NULL AFTER `serial_number`, ADD `commission_date` DATETIME NULL AFTER `department`, ADD `supplied_by` TEXT NULL AFTER `commission_date`;

CREATE TABLE `memas106`.`departments` (`id` INT NOT NULL , `oid` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(256) NULL DEFAULT NULL , PRIMARY KEY (`oid`)) ENGINE = InnoDB;

INSERT INTO `departments` (`id`, `oid`, `name`) VALUES ('1', NULL, 'Nursery ward'), ('2', NULL, 'Postnatal ward'), ('3', NULL, 'Labor Ward'), ('4', NULL, 'Paediatric ward'), ('5', NULL, 'Male ward'), ('6', NULL, 'Female ward'), ('6', NULL, 'TB ward'), ('7', NULL, 'Mortuary'), ('8', NULL, 'Kitchen'), ('9', NULL, 'Laundry'), ('10', NULL, 'OPD'), ('11', NULL, 'Minor theatre'), ('12', NULL, 'Operating theater'), ('13', NULL, 'Radiology'), ('14', NULL, 'Laboratory'), ('15', NULL, 'Under 5')
