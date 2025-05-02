-- DROP TABLE IF EXISTS `cash_log`;
CREATE TABLE IF NOT EXISTS `cash_log` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `list_page_id` INT UNSIGNED NOT NULL,
    `enabled_to` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_cash_log_list_page_id ON cash_log(`list_page_id`);
CREATE INDEX idx_cash_log_enabled_to ON cash_log(`enabled_to`);
