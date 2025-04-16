-- DROP TABLE IF EXISTS `item_lang`;
CREATE TABLE IF NOT EXISTS `item_lang` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_id` INT UNSIGNED NOT NULL,
    `cur_lang` CHAR(2) NOT NULL,
    `keywords` VARCHAR(256) NOT NULL,
    `description` VARCHAR(256) NOT NULL,
    `heading` VARCHAR(128) NOT NULL,
    `intro_img` VARCHAR(128) NOT NULL DEFAULT '',
    `intro_text` VARCHAR(512) NOT NULL,
    `text` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`item_id`) REFERENCES item (`id`) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE UNIQUE INDEX idx_item_lang_item_id_cur_lang ON item_lang(`item_id`, `cur_lang`);
CREATE INDEX idx_item_lang_cur_lang ON item_lang(`cur_lang`);
CREATE INDEX idx_item_lang_heading ON item_lang(`heading`);
