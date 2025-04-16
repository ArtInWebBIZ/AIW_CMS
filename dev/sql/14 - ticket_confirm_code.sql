-- DROP TABLE IF EXISTS `ticket_confirm_code`;
CREATE TABLE IF NOT EXISTS `ticket_confirm_code` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ticket_id` INT UNSIGNED NOT NULL,
    `confirm_code` CHAR(88) NOT NULL,
    `created` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_ticket_confirm_code_ticket_id ON ticket_confirm_code(`ticket_id`);
CREATE INDEX idx_ticket_confirm_code_created ON ticket_confirm_code(`created`);
