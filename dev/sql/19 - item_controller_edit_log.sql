-- DROP TABLE IF EXISTS `item_controller_edit_log`;
CREATE TABLE IF NOT EXISTS `item_controller_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `edited_id` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `edited_field` VARCHAR(32) NOT NULL,
    `old_value` VARCHAR(64) NULL DEFAULT '',
    `new_value` VARCHAR(64) NULL DEFAULT '',
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`edited_id`) REFERENCES item_controller (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_item_controller_edit_log_edited_id ON item_controller_edit_log(`edited_id`);
CREATE INDEX idx_item_controller_edit_log_editor_id ON item_controller_edit_log(`editor_id`);
CREATE INDEX idx_item_controller_edit_log_edited_field ON item_controller_edit_log(`edited_field`);
CREATE INDEX idx_item_controller_edit_log_edited ON item_controller_edit_log(`edited`);
