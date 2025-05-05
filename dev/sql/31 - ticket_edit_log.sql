-- DROP TABLE IF EXISTS `ticket_edit_log`;
CREATE TABLE IF NOT EXISTS `ticket_edit_log` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `ticket_id` INT UNSIGNED NOT NULL,
    `ticket_type` TINYINT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `edited_field` VARCHAR(32) NOT NULL,
    `old_value` VARCHAR(64) NULL DEFAULT '',
    `new_value` VARCHAR(64) NULL DEFAULT '',
    `edited` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (editor_id) REFERENCES user (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_ticket_edit_log_ticket_id ON ticket_edit_log(`ticket_id`);
CREATE INDEX idx_ticket_edit_log_ticket_type ON ticket_edit_log(`ticket_type`);
CREATE INDEX idx_ticket_edit_log_editor_id ON ticket_edit_log(`editor_id`);
CREATE INDEX idx_ticket_edit_log_edited_field ON ticket_edit_log(`edited_field`);
CREATE INDEX idx_ticket_edit_log_edited ON ticket_edit_log(`edited`);
