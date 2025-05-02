-- DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `parent_id` INT NOT NULL,
    `ref_code` VARCHAR(12) NOT NULL,
    `type` TINYINT NOT NULL DEFAULT 0,
    `group` TINYINT NOT NULL DEFAULT 1,
    `email_hash` CHAR(96) NOT NULL,
    `phone_hash` CHAR(96) NOT NULL,
    `user` VARCHAR(2048) NOT NULL,
    `password` CHAR(96) NOT NULL,
    `balance` DECIMAL(12, 2) NOT NULL DEFAULT 0,
    `created` INT UNSIGNED NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    `edited_count` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `latest_visit` INT UNSIGNED NOT NULL,
    `lang` CHAR(2) NOT NULL DEFAULT 'uk',
    `status` TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY (`ref_code`),
    UNIQUE KEY (`email_hash`),
    UNIQUE KEY (`phone_hash`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_user_parent_id ON user(`parent_id`);
CREATE INDEX idx_user_group ON user(`group`);
CREATE INDEX idx_user_status ON user(`status`);
CREATE INDEX idx_user_created ON user(`created`);
CREATE INDEX idx_user_edited ON user(`edited`);
