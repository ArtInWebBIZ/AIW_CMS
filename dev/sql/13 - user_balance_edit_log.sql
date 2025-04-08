-- DROP TABLE IF EXISTS `user_balance_edit_log`;
CREATE TABLE IF NOT EXISTS `user_balance_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `type_code` TINYINT NOT NULL DEFAULT 0,
    `content_id` INT UNSIGNED NOT NULL DEFAULT 0,
    `paid_to` INT UNSIGNED NOT NULL,
    `paid_from` INT UNSIGNED NOT NULL,
    `paid_sum` DECIMAL(12, 2) NOT NULL,
    `paid_type` TINYINT UNSIGNED NOT NULL,
    `old_value` VARCHAR(64) NULL DEFAULT '',
    `new_value` VARCHAR(64) NULL DEFAULT '',
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_user_balance_edit_log_user_id ON user_balance_edit_log(`user_id`);
CREATE INDEX idx_user_balance_edit_log_type_code ON user_balance_edit_log(`type_code`);
CREATE INDEX idx_user_balance_edit_log_content_id ON user_balance_edit_log(`content_id`);
CREATE INDEX idx_user_balance_edit_log_paid_to ON user_balance_edit_log(`paid_to`);
CREATE INDEX idx_user_balance_edit_log_paid_from ON user_balance_edit_log(`paid_from`);
CREATE INDEX idx_user_balance_edit_log_paid_type ON user_balance_edit_log(`paid_type`);
CREATE INDEX idx_user_balance_edit_log_edited ON user_balance_edit_log(`edited`);
