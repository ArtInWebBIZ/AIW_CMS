-- DROP TABLE IF EXISTS `edit_note`;
CREATE TABLE IF NOT EXISTS `edit_note` (
    `token` CHAR(32) NOT NULL,
    `content_type` VARCHAR(32) NOT NULL,
    `edited_id` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL,
    `enabled_to` INT UNSIGNED NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_edit_note_content_type ON edit_note(`content_type`);
CREATE INDEX idx_edit_note_edited_id ON edit_note(`edited_id`);
CREATE INDEX idx_edit_note_editor_id ON edit_note(`editor_id`);
CREATE INDEX idx_edit_note_enabled_to ON edit_note(`enabled_to`);
