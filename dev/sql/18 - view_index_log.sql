-- DROP TABLE IF EXISTS `view_index_log`;
CREATE TABLE IF NOT EXISTS `view_index_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `lang` TINYINT UNSIGNED NOT NULL,
    `url_id` INT UNSIGNED NOT NULL,
    `user_id` INT UNSIGNED NOT NULL,
    `user_ip` INT UNSIGNED NOT NULL,
    `token` CHAR(11) NOT NULL DEFAULT 'users_token',
    `created` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_view_index_log_lang ON view_index_log(`lang`);
CREATE INDEX idx_view_index_log_url_id ON view_index_log(`url_id`);
CREATE INDEX idx_view_index_log_user_id ON view_index_log(`user_id`);
CREATE INDEX idx_view_index_log_user_ip ON view_index_log(`user_ip`);
CREATE INDEX idx_view_index_log_created ON view_index_log(`created`);
