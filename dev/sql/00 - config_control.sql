-- DROP TABLE IF EXISTS `config_control`;
CREATE TABLE IF NOT EXISTS `config_control` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `params_name` VARCHAR(32) NOT NULL,
    `params_value` VARCHAR(64) NOT NULL,
    `value_type` VARCHAR(12) NOT NULL,
    `group_access` VARCHAR(2) NOT NULL,
    `edited` INT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`params_name`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
