-- DROP TABLE IF EXISTS `filter_value_note`;
CREATE TABLE IF NOT EXISTS `filter_value_note` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `token` VARCHAR(32) NOT NULL,
    `controller_name` VARCHAR(32) NOT NULL,
    `action_name` VARCHAR(32) NOT NULL,
    `post_note` TEXT NOT NULL,
    `enabled_to` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_filter_value_note_token ON filter_value_note(`token`);
CREATE INDEX idx_filter_value_note_enabled_to ON filter_value_note(`enabled_to`);
