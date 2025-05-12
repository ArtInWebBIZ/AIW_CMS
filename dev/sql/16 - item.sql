-- DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `item_controller_id` INT UNSIGNED NOT NULL,
    `author_id` INT UNSIGNED NOT NULL,
    `promo_code` VARCHAR(12) NOT NULL,
    `def_lang` CHAR(2) NOT NULL,
    `created` INT UNSIGNED NOT NULL,
    `edited` INT UNSIGNED NOT NULL,
    `status` TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `self_order` INT UNSIGNED NOT NULL DEFAULT 5000,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE INDEX idx_item_item_controller_id ON item(`item_controller_id`);
CREATE INDEX idx_item_author_id ON item(`author_id`);
CREATE INDEX idx_item_promo_code ON item(`promo_code`);
CREATE INDEX idx_item_def_lang ON item(`def_lang`);
CREATE INDEX idx_item_self_order ON item(`self_order`);
