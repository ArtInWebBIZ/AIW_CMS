-- DROP TABLE IF EXISTS `activation`;
CREATE TABLE IF NOT EXISTS `activation` (
    `user_id` INT UNSIGNED NOT NULL,
    `user_ip` VARCHAR(16) NOT NULL,
    `enabled_to` INT NOT NULL,
    PRIMARY KEY (`user_id`),
    FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_activation_user_ip ON activation(`user_ip`);
CREATE INDEX idx_activation_enabled_to ON activation(`enabled_to`);
