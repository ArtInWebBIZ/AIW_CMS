-- DROP TABLE IF EXISTS `user_edit_log`;
CREATE TABLE IF NOT EXISTS `user_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `edited_id` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `edited_field` VARCHAR(32) NOT NULL,
    `old_value` VARCHAR(64) NULL DEFAULT '',
    `new_value` VARCHAR(64) NULL DEFAULT '',
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (edited_id) REFERENCES user (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_user_edit_log_editor_id ON user_edit_log(`editor_id`);
CREATE INDEX idx_user_edit_log_edited_field ON user_edit_log(`edited_field`);
CREATE INDEX idx_user_edit_log_edited ON user_edit_log(`edited`);
