CREATE TABLE `memas107`.`equipments` (`asset_tag` VARCHAR(256) NULL , `commission_date` DATETIME NULL , `department` VARCHAR(256) NULL , `e_id` INT NULL , `make` VARCHAR(256) NULL , `model` VARCHAR(256) NULL , `name` VARCHAR(256) NULL , `serial_number` VARCHAR(256) NULL , `supplied_by` VARCHAR(256) NULL , `technical_specification_id` INT NULL , `e_oid` INT NOT NULL AUTO_INCREMENT , `technical_specification_oid` INT NULL , `created_at` DATETIME NULL , `updated_at` DATETIME NULL , PRIMARY KEY (`e_oid`)) ENGINE = InnoDB;

CREATE TABLE `memas107`.`technical_specifications` (`tss_id` INT NULL , `technical_specification` TEXT NULL , `tss_oid` INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (`tss_oid`)) ENGINE = InnoDB;

ALTER TABLE `memas107`.`equipments` ADD `uploaded_at` DATETIME NULL AFTER `created_at`;

ALTER TABLE `memas107`.`equipments` ADD `next_service_date` DATETIME NULL AFTER `supplied_by`, ADD `last_maintenance_date` DATETIME NULL AFTER `next_service_date`, ADD `status` VARCHAR(256) NOT NULL AFTER `last_maintenance_date`, ADD `update_status` VARCHAR(256) NOT NULL AFTER `status`;

CREATE TABLE `memas107`.`maintenance_logs` ( `date` DATETIME NULL , `description` TEXT NULL , `equipment_id` INT NULL , `equipment_oid` INT NULL , `maintenance_log_info_id` INT NULL , `ml_id` INT NULL , `type` VARCHAR(256) NULL , `ml_oid` INT NOT NULL AUTO_INCREMENT , `maintenance_log_info_oid` INT NULL , `created_at` DATETIME NULL , `uploaded_at` DATETIME NULL , `updated_at` DATETIME NULL , PRIMARY KEY (`ml_oid`)) ENGINE = InnoDB;

CREATE TABLE `memas107`.`maintenance_log_infos` ( `mli_id` INT NULL , `mli_oid` INT NOT NULL AUTO_INCREMENT , `maintenance_log_info` TEXT NULL , PRIMARY KEY (`mli_oid`)) ENGINE = InnoDB;
