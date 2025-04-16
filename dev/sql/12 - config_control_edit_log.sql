-- DROP TABLE IF EXISTS `config_control_edit_log`;
CREATE TABLE IF NOT EXISTS `config_control_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `edited_id` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `edited_params` VARCHAR(32) NOT NULL,
    `old_value` VARCHAR(64) NULL DEFAULT '',
    `new_value` VARCHAR(64) NULL DEFAULT '',
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_config_edit_log_edited_id ON config_control_edit_log(`edited_id`);
CREATE INDEX idx_config_edit_log_editor_id ON config_control_edit_log(`editor_id`);
CREATE INDEX idx_config_edit_log_edited ON config_control_edit_log(`edited`);
