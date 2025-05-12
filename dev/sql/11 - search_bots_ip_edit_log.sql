-- DROP TABLE IF EXISTS `search_bots_ip_edit_log`;
CREATE TABLE IF NOT EXISTS `search_bots_ip_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `edited_id` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `edited_field` VARCHAR(32) NOT NULL,
    `old_value` VARCHAR(64) NULL DEFAULT '',
    `new_value` VARCHAR(64) NULL DEFAULT '',
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_search_bots_ip_edit_log_edited_field ON search_bots_ip_edit_log(`edited_field`);
CREATE INDEX idx_search_bots_ip_edit_log_edited ON search_bots_ip_edit_log(`edited`);
