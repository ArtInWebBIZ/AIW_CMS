-- DROP TABLE IF EXISTS `ticket_answer`;
CREATE TABLE IF NOT EXISTS `ticket_answer` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `ticket_id` INT UNSIGNED NOT NULL,
    `author_id` INT UNSIGNED NOT NULL,
    `answer` VARCHAR(1024) NOT NULL,
    `created` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_ticket_answer_author_id ON ticket_answer(`author_id`);
CREATE INDEX idx_ticket_answer_created ON ticket_answer(`created`);
