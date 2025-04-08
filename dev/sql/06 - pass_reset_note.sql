-- DROP TABLE IF EXISTS `pass_reset_note`;
CREATE TABLE IF NOT EXISTS `pass_reset_note` (
    `user_id` INT UNSIGNED NOT NULL,
    `reset_code` CHAR(96) NOT NULL,
    `new_password` CHAR(96) NOT NULL,
    `enabled_to` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_pass_reset_new_password ON pass_reset_note(`new_password`);
