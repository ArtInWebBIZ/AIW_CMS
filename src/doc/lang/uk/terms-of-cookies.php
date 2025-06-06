<?php

/**
 * @package    ArtInWebCMS.doc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Ssl;
use Core\Trl;

?>
<h1 class="uk-text-center">Умови використання файлів cookie</h1>
<p>Сайт <strong><?= Trl::_('OV_SITE_FULL_NAME') ?></strong>, надалі <em>Сайт</em>, що працює на домені <strong><?= Ssl::getLink() ?></strong> та його під-доменах, використовуються файли <em>cookie</em> для забезпечення авторизації користувачів, а також перешкоджанням</em>.
<p><em>Сайти</em> використовують кілька <em>cookie-файлів</em>.</p>
<p><em>Cookie-файл</em> <strong>SESSION</strong> використовується для зберігання <em>ключа сесії</em>.</p>
<p><em>Cookie-файл</em> <strong>SESSION</strong> зберігається для авторизованих користувачів протягом 2-х тижнів. Для не авторизованих користувачів протягом 15 хвилин з моменту крайнього входу на <em>Сайт</em>.</p>
<p>У <em>cookie-файлі</em> <strong>messages_cookies</strong> зберігається інформація про підтвердження згоди Користувача на використання <em>Сайту</em> відповідно до Умов користування сайтом, як Публічного договору оферти.</p>
<p>На комп'ютерах Користувачів cookie-файл <strong>messages_cookies</strong> зберігається протягом двох тижнів з моменту останнього звернення до Сайту.</p>
<p>У <em>cookie-файлі</em> <strong>time_difference</strong> зберігається час (у секундах) різниці між поточним часом Користувача та Всесвітнім координованим часом.</p>
<p>Якщо Користувач не згоден з використанням <em>Сайтом</em> cookie-файлів згідно з Умовами користування сайтом, як Публічним договором оферти, Користувач не може користуватися Сайтом.</p>
<p>Будь-яке продовження використання Користувачем <em>Сайту</em>, є актом акцепту Умов користування сайтом, як Публічного договору оферти.</p>
