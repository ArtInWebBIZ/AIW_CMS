-- DROP TABLE IF EXISTS `item_controller`;
CREATE TABLE IF NOT EXISTS `item_controller` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `controller_url` VARCHAR(32) NOT NULL,
    `filters_table` TINYINT DEFAULT 0,
    `created` INT UNSIGNED NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`controller_url`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
