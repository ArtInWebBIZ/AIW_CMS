-- DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `ticket_type` TINYINT NOT NULL,
    `author_id` INT UNSIGNED NOT NULL,
    `text` TEXT NOT NULL,
    `lang` CHAR(2) NOT NULL DEFAULT 'ru',
    `created` INT UNSIGNED NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    `editor_id` INT UNSIGNED NOT NULL DEFAULT 0,
    `responsible` INT UNSIGNED NOT NULL DEFAULT 0,
    `answer_count` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
    `ticket_status` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_ticket_type ON ticket(`ticket_type`);
CREATE INDEX idx_ticket_author_id ON ticket(`author_id`);
CREATE INDEX idx_ticket_created ON ticket(`created`);
CREATE INDEX idx_ticket_edited ON ticket(`edited`);
CREATE INDEX idx_ticket_editor_id ON ticket(`editor_id`);
CREATE INDEX idx_ticket_responsible ON ticket(`responsible`);
CREATE INDEX idx_ticket_status ON ticket(`ticket_status`);
