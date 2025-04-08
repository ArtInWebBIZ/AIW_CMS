-- DROP TABLE IF EXISTS `control_post_note`;
CREATE TABLE IF NOT EXISTS `control_post_note` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `token` VARCHAR(32) NOT NULL,
    `controller_name` VARCHAR(32) NOT NULL,
    `action_name` VARCHAR(32) NOT NULL,
    `post_note` TEXT NOT NULL,
    `enabled_to` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_control_post_note_token ON control_post_note(`token`);
CREATE INDEX idx_control_post_note_enabled_to ON control_post_note(`enabled_to`);
