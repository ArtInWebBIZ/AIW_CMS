-- DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `author_id` INT UNSIGNED NOT NULL,
    `lang` CHAR(2) NOT NULL,
    `text` VARCHAR(1024) NOT NULL,
    `rating` TINYINT UNSIGNED NOT NULL,
    `created` INT UNSIGNED NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    `status` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`author_id`) REFERENCES user (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_review_author_id ON review(`author_id`);
CREATE INDEX idx_review_lang ON review(`lang`);
CREATE INDEX idx_review_rating ON review(`rating`);
CREATE INDEX idx_review_created ON review(`created`);
CREATE INDEX idx_review_edited ON review(`edited`);
CREATE INDEX idx_review_status ON review(`status`);
