-- DROP TABLE IF EXISTS `item_edit_log`;
CREATE TABLE IF NOT EXISTS `item_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_controller_id` INT UNSIGNED NOT NULL,
    `item_id` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `edited_field` VARCHAR(32) NOT NULL,
    `old_value` VARCHAR(512) NOT NULL,
    `new_value` VARCHAR(512) NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES item (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_item_edit_log_item_controller_id ON item_edit_log(`item_controller_id`);
CREATE INDEX idx_item_edit_log_editor_id ON item_edit_log(`editor_id`);
CREATE INDEX idx_item_edit_log_edited_field ON item_edit_log(`edited_field`);
CREATE INDEX idx_item_edit_log_edited ON item_edit_log(`edited`);
