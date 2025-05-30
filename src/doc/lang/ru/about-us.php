<?php

/**
 * @package    ArtInWebCMS.doc
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */
defined('AIW_CMS') or die;

use Core\Plugins\View\Tpl;

$header = Tpl::view(PATH_INC . 'doc' . DS . 'about-us.php');

?>
<div class="uk-padding" itemscope="" itemtype="http://schema.org/Offer">
    <?= $header ?>
    <div itemprop="description">
        <p>При создании этой программы мы руководствовались несколькими основными критериями:</p>
        <ul class="uk-list uk-list-striped">
            <li><a href="#safety" uk-scroll>Безопасность</a></li>
            <li><a href="#speed" uk-scroll>Скорость</a></li>
            <li><a href="#simplicity" uk-scroll>Простота</a></li>
        </ul>
        <h2 id="safety">1. Безопасность</h2>
        <h3>Ddos</h3>
        <p>Внутренняя система сессий &ndash; первая линия защиты от Ddos атак. Если пользователь обращается к сайту с интервалом менее нескольких секунд &ndash; ему отображается страница с предупреждением. Количество предупреждений фиксируется в сессии. После определенного количества предупреждений &ndash; пользователю выводится страница блокировки на 15 минут. При каждом обращении пользователя к сайту до истечения срока блокировки &ndash; срок блокировки обнуляется. В обработке заблокированных запросов принимают участие всего несколько файлов программы и отправляется только текстовая информация с сообщением о блокировке. Это сводит к минимуму обратный трафик сервера, что в свою очередь позволяет ему эффективно справляться с максимально возможным количеством запросов. Таким образом, для организации полного падения сервера потребуется использовать гораздо большие ресурсы, чем для традиционных CMS.</p>
        <p>Если при атаке с каждым запросом cookie файлы на пользовательской стороне удаляются или не сохраняются, то в этом случае, поскольку каждая сессия четко привязывается к IP пользователя, после нескольких соединений с одного и того же IP начинается отсчет 15-минутной блокировки пользователя по этому IP. Следующий доступ пользователя с таким IP к сайту будет возможен только после того, как истечет срок всех предыдущих сессий из этого IP.</p>
        <p>Таким образом, эффективная Ddos из ограниченного количества IP становится просто невозможна.</p>
        <h3>Injection Attacks</h3>
        <p>Все данные, попадающие от пользователя, обязательно обрабатываются и фильтруются. В базу данных попадает только обработанный чистый текст в формате HTML без возможности каких-либо примесей.</p>
        <h3>Cross-Site Scripting, XSS</h3>
        <h4>- Reflected XSS</h4>
        <p>Корректность URL &ndash; следующий уровень защиты ArtInWeb CMS. Все данные, которые пользователь может использовать в URL, четко структурированы и типизированы. Любые отклонения от заданных параметров перенаправляют пользователя на главную страницу, а в сессию записывается информация о блокировке. При достижении определенного количества блокировок &ndash; этот пользователь заблокируется на 15 минут. Последствия смотрите выше.</p>
        <h4>- Stored XSS/DOM-Based XSS</h4>
        <p>Пользователям на сайте для внесения информации и ее форматирования разрешено использовать только ограниченное количество HTML-тегов. Все остальные теги удаляются, а текст, который был в них, преобразуется в обычный текст без форматирования. Кроме того, программа полностью очищает все внутренние атрибуты тегов HTML, возвращая для записи в БД только чистый HTML без каких-либо стилей, дополнительного форматирования, знаков, символов и т.д..</p>
        <h4>- Cross-Site Request Forgery, CSRF</h4>
        <p>Как было сказано выше, сессия пользователя четко привязана к его IP. Если токен формы не соответствует сессии пользователя &ndash; такие данные от пользователя сайтом не будут обработаны, а пользователю будет выведено соответствующее предупреждение и записано в сессии. После получения нескольких блокировок &ndash; пользователь будет заблокирован на 15 минут.</p>
        <h3>Brute Force Attacks</h3>
        <p>Brute Force Attacks (перебор пароля) &ndash; возможна только в том случае, если программа позволяет проводить множество запросов на сайт за короткий промежуток времени. Если же мы ограничиваем количество таких запросов до одного в несколько секунд &ndash; этот вид атаки теряет всякий смысл, но никак не влияет на обычных пользователей. Если для Brute Force Attacks злоумышленник использует несколько IP &ndash; в игру вступают правила, описанные выше.</p>
        <h3>Man-in-the-Middle Attack, MitM</h3>
        <p>Этот вид атак эффективно разрешается использованием протокола соединения HTTPS. Для защиты от этого вида атак программа использует автоматическое перенаправление на этот протокол соединения, если соответствующая настройка указана в файле конфигурации &laquo;config.php&raquo; в ключе &laquo;http_type&raquo;. Если значение этого ключа будет &laquo;https://&raquo; &ndash; передача данных с сайта и на сайт будет происходить только через протокол HTTPS, что практически исключит возможность перехвата данных на промежуточных этапах.</p>
        <h3>Авторизованная регистрация</h3>
        <p>Программа использует систему регистрации на основе уникального адреса электронной почты (email) для каждого зарегистрированного пользователя. При этом новый зарегистрированный пользователь не указывает пароль входа на сайт. Адреса типа &laquo;<strong>username@email.com</strong>&raquo;, &laquo;<strong>user.name@email.com</strong>&raquo;, &laquo;<strong>us-er-na.me@email.com</strong>&raquo; и т.п., воспринимаются программой как один адрес электронной почты.</p>
        <p>При регистрации пользователя формируется пароль для входа на сайт и высылается на указанный в форме регистрации email. Если новый пользователь не войдет на сайт с указанным паролем в течение 48 часов после регистрации, его аккаунт будет автоматически удален.</p>
        <p>Таким образом, пользователи могут использовать при регистрации только реально существующие верифицированные адреса электронной почты. В противном случае, их аккаунты удаляются и никак в дальнейшем не могут использоваться для какого-либо влияния на сайт.</p>
        <p>Если авторизованный пользователь заходит на сайт с другого IP, чем при крайней сессии &ndash; ему снова нужно будет авторизоваться на сайте, указав свой email и пароль.</p>
        <p>Каждый пользователь может в любой момент изменить свой пароль через соответствующую форму на сайте в своем меню пользователя.</p>
        <p>Единственное обязательное поле при регистрации нового пользователя &ndash; его email. Все остальные поля, например, имя, фамилия, телефон и т.д., могут вноситься по желанию в любой комбинации.</p>
        <h2 id="speed">2. Скорость</h2>
        <p>На скорость загрузки страницы для конечного пользователя в первую очередь влияет количество получаемой браузером информации (вес страницы). Чтобы максимально снизить количество JS скриптов, для корректного формирования страниц на стороне пользователя мы используем только один CSS/JS фреймворк &ndash; <strong>UIkit</strong>.</p>
        <p>&laquo;ArtInWeb CMS&raquo; построена на чистом PHP.</p>
        <p>Язык программирования PHP был создан для объединения возможности превращения сложных вещей в простые формы. Другими словами, получение информации (и обратное внесение данных) из/в базы данных и превращение этой информации в простой HTML.</p>
        <p>В первых вариантах язык программирования PHP отнюдь не был эффективным в плане нагрузок и количества обработки данных. Поэтому для улучшения этих вещей было создано множество &laquo;систем подключения классов&raquo;, &laquo;шаблонизаторов&raquo;, фреймворков и т.д.</p>
        <p>За последние несколько лет, начиная с версии PHP 8.0, этот язык программирования превратился в одного из лидеров по производительности!</p>
        <p>Именно для того чтобы попытаться вернуть создание сайтов в мир чистого PHP/HTML/CSS/JS и был создан этот проект.</p>
        <p>Использование минимального количества файлов в обработке получаемой и передаваемой информации должно максимально увеличить возможности проектов, которые будут построены на основе этой системы управления контентом.</p>
        <h2 id="simplicity">3. Простота</h2>
        <p>Как было сказано в предыдущем разделе, для получения контента из БД и формирования исходного кода HTML эта CMS использует минимальное количество файлов с минимальными зависимостями. Следовательно, даже при минимальном знании PHP можно разобраться как эффективно расширить существующий функционал именно под свои нужды.</p>
        <p>При написании этой программы мы использовали множество готовых решений. Однако, поскольку мы практически все переделали до &laquo;неузнаваемости&raquo; &ndash; каких-либо авторских меток других людей мы не оставили. :( Если же вы нашли где-то свой код в &laquo;первозданном виде&raquo; &ndash; пишите. Мы с удовольствием укажем вас в соавторах определенной части кода.</p>
        <p>Для большинства операций по созданию своего типа контента в этой CMS, вам нужно:</p>
        <ul>
            <li>элементарное знание HTML&amp;CSS;</li>
            <li>минимальное знание PHP;</li>
            <li>экспертное умение нажатия клавиш &laquo;Ctrl+C&raquo; и &laquo;Ctrl+V&raquo;.</li>
        </ul>
        <p>Ничто мы не умеем лучше, чем копипастить :)</p>
        <p>Все необходимые примеры снипетов для создания новых типов контента любой сложности в &laquo;AIW CMS&raquo; уже есть в папке &laquo;dev&raquo; этого репозитория.</p>
        <h2>Итак.</h2>
        <p>Возможно (и, скорее всего), вы найдете какие-то ошибки кода, пути его улучшения и добавления новых функций. Все это, безусловно, да, поскольку практически весь этот код (по состоянию на V0.1) написан или переработан одним человеком. Поэтому буду рад принимать и рассматривать любые ваши идеи. Но&hellip; Если они останутся в русле универсального продукта.</p>
        <p>На основе этой CMS нами уже создано несколько узкоспециализированных сайтов, которые уже показали свою высокую эффективность в противодействии различным атакам злоумышленников, но их специализированный код всегда будет оставаться коммерческим.</p>
        <p><strong>В этом же репозитории вы получаете:</strong></p>
        <ul>
            <li>система управления многоязычным или одноязычным контентом сайта;</li>
            <li>система кэширования контента;</li>
            <li>система регистрации и управления пользователями с множеством комбинаций типов пользователей и условий доступа и редактирования контента;</li>
            <li>система шаблонов (один для многих или уникальный (в любых комбинациях)) для любого типа контента;</li>
            <li>универсальные шаблоны &laquo;Политики конфиденциальности&raquo;, &laquo;Пользовательское соглашение&raquo;, &laquo;Условия использования файлов cookie&raquo; и &laquo;Запрещенные и разрешенные на сайте HTML-теги&raquo;. Первые три страницы обязательны для размещения на всех сайтах ЕС;</li>
            <li>пример главной страницы, на которую могут очень легко выводиться данные из самых разных типов контента;</li>
            <li>систему формирования меню:
                <ul>
                    <li>главное меню (выпадающее слева); </li>
                    <li>главное меню (горизонтальное сверху); </li>
                    <li>меню пользователя (выпадающее справа); </li>
                    <li>меню смены языка интерфейса (контента). </li>
                </ul>
            </li>
            <li>меню &laquo;хлебных крошек&raquo;;</li>
            <li>меню пагинации страниц;</li>
            <li>административное меню (под главным меню слева);</li>
            <li>система обратной связи:
                <ul>
                    <li>контакты (адаптированные для поисковиков); </li>
                    <li>форма сообщений (для зарегистрированных пользователей) владельцам или менеджерам сайта. </li>
                </ul>
            </li>
            <li>система управления сообщениями (тикетами) в администрацию сайта;</li>
            <li>система отзывов;</li>
            <li>система управления отзывами;</li>
            <li>система управления системными параметрами;</li>
            <li>система логов посещения сайта пользователями;</li>
            <li>система логов посещения сайта пользователями, относящимися к группе менеджеров;</li>
            <li>система логов индексирования на сайте поисковыми ботами;</li>
            <li>система мониторинга индексирования контента и создания на основе карты сайта (sitemap.txt) в режиме реального времени;</li>
            <li>систему многоязычного (одноязычного) контента типа &laquo;Блог&raquo; с возможностью его простого расширения до любого по сложности типа контента с множеством фильтров;</li>
            <li>система уведомлений об ошибках в работе сайта;</li>
            <li>система шифрования с плавающим ключом для хранения конфиденциальных данных пользователей;</li>
            <li>система отображения сайта в режиме редактирования. Режим редактирования может быть двух типов:
                <ul>
                    <li>тотальная &ndash; первая страница одна для всех без формы авторизации; </li>
                    <li>персональная &ndash; страница редактирования с формой авторизации. Общая страница режима редактирования отображается только для не авторизованных пользователей и пользователей, не имеющих прав доступа к этому режиму работы сайта. </li>
                </ul>
            </li>
            <li>страница 404;</li>
            <li>станица «У вас нет права доступа к этой странице».</li>
        </ul>
        <p><strong>Все перечисленное &ndash; далеко не полный набор!</strong></p>
        <p>Постепенно мы будем рассказывать на страницах сайта <a href="https://cms.artinweb.biz/">cms.artinweb.biz</a> что и как лучше и быстрее делать.</p>
        <p>Смотрите. Читайте. Создавайте. Делитесь. И&hellip; наслаждайтесь жизнью!</p>
        <p><strong>Она одна и уникальна!</strong></p>
        <p>Цените родных и общение с ними!</p>
        <p>Мирного неба и&hellip;</p>
        <p><strong>СЛАВА УКРАИНЕ !!!<br /> ГЕРОЯМ СЛАВА !!!</strong></p>
    </div>
</div>
