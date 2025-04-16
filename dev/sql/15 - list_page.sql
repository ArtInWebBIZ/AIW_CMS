-- DROP TABLE IF EXISTS `list_page`;
CREATE TABLE IF NOT EXISTS `list_page` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `lang` CHAR(2) NOT NULL,
    `url` VARCHAR(512) NOT NULL,
    `sitemap_order` TINYINT DEFAULT 0,
    `created` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
CREATE UNIQUE INDEX idx_list_page_lang_url ON list_page(`lang`, `url`);
CREATE INDEX idx_list_page_lang ON list_page(`lang`);
CREATE INDEX idx_list_page_url ON list_page(`url`);
CREATE INDEX idx_list_page_sitemap_order ON list_page(`sitemap_order`);
