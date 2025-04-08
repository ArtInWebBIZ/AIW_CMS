-- DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
    `session_key` CHAR(32) NOT NULL,
    `token` CHAR(32) NOT NULL,
    `user_ip` VARCHAR(16) NOT NULL,
    `search_bots_ip` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `user_id` INT UNSIGNED DEFAULT 0,
    `time_difference` INT NULL,
    `tmp_status` TINYINT NOT NULL DEFAULT -1,
    `lang` CHAR(2) NOT NULL DEFAULT 'uk',
    `views` INT UNSIGNED NOT NULL DEFAULT 0,
    `created` INT UNSIGNED NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    `next_page_time` TINYINT UNSIGNED NOT NULL DEFAULT 1,
    `block_counter` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `rtl` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `save_session` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `enabled_to` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`session_key`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_session_user_ip ON session(`user_ip`);
CREATE INDEX idx_session_user_id ON session(`user_id`);
CREATE INDEX idx_session_enabled_to ON session(`enabled_to`);
