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
        <p>When creating this program, we were guided by several main criteria:</p>
        <ul class="uk-list uk-list-striped">
            <li><a href="#safety" uk-scroll>Safety</a></li>
            <li><a href="#speed" uk-scroll>Speed</a> </li>
            <li><a href="#simplicity" uk-scroll>Simplicity</a> </li>
        </ul>
        <h2 id="safety">1. Safety</h2>
        <h3>DDoS</h3>
        <p>The internal session system is the first line of defense against DDoS attacks. If a user accesses the site with an interval of less than a few seconds, he is shown a warning page. The number of warnings is recorded in the session. After a certain number of warnings, the user is shown a blocking page for 15 minutes. Each time the user accesses the site before the blocking period expires, the blocking period is reset. Only a few program files are involved in processing blocked requests and only text information with a blocking message is sent. This minimizes the server&#39;s return traffic, which in turn allows it to effectively handle the maximum possible number of requests. Thus, organizing a complete server crash will require using much more resources than for traditional CMS.</p>
        <p>If, during an attack, cookies on the user side are deleted or not saved with each request, then in this case, since each session is clearly tied to the user&#39;s IP, after several connections from the same IP, a 15-minute blocking of the user on this IP begins. The next access of the user with such an IP to the site will be possible only after all previous sessions from this IP have expired.</p>
        <p>Thus, effective DDoS from a limited number of IPs becomes simply impossible.</p>
        <h3>Injection Attacks</h3>
        <p>All data received from the user is necessarily processed and filtered. Only processed pure text in HTML format without the possibility of any impurities gets into the database.</p>
        <h3>Cross-Site Scripting (XSS)</h3>
        <h4>- Reflected XSS</h4>
        <p>URL correctness is the next level of ArtInWeb CMS protection. All data that the user can use in the URL is clearly structured and typified. Any deviations from the specified parameters redirect the user to the main page, and information about the blocking is recorded in the session. Upon reaching a certain number of blockings, this user will be blocked for 15 minutes. See the consequences above.</p>
        <h4>- Stored XSS/DOM-Based XSS</h4>
        <p>Users are allowed to use only a limited number of HTML tags to enter information and format it on the site. All other tags are deleted, and the text that was in them is converted to plain text without formatting. In addition, the program completely clears all internal attributes of HTML tags, returning only pure HTML for recording in the database without any styles, additional formatting, signs, symbols, etc.</p>
        <h4>- Cross-Site Request Forgery, CSRF</h4>
        <p>As mentioned above, the user&#39;s session is strictly tied to his IP. If the form token does not correspond to the user&#39;s session, such data from the user will not be processed by the site, and the user will receive a corresponding warning and it will be recorded in the session. After receiving several blockings, the user will be blocked for 15 minutes.</p>
        <h3>Brute Force Attacks</h3>
        <p>Brute Force Attacks (password brute force) &ndash; are possible only if the program allows multiple requests to the site in a short period of time. If we limit the number of such requests to one every few seconds &ndash; this type of attack loses all meaning, but does not affect ordinary users in any way. If the attacker uses several IPs for Brute Force Attacks &ndash; the rules described above come into play.</p>
        <h3>Man-in-the-Middle Attack, MitM</h3>
        <p>This type of attack is effectively resolved by using the HTTPS connection protocol. To protect against this type of attack, the program uses automatic redirection to this connection protocol if the corresponding setting is specified in the configuration file &#34;config.php&#34; in the &#34;http_type&#34; key. If the value of this key is &#34;https://&#34; - data transfer from and to the site will occur only via the HTTPS protocol, which virtually eliminates the possibility of interception of data at intermediate stages.</p>
        <h3>Authorized registration</h3>
        <p>The program uses a registration system based on a unique email address for each registered user. In this case, a newly registered user does not specify a password to enter the site. Addresses such as &laquo;<strong>username@email.com</strong>&raquo;, &laquo;<strong>user.name@email.com</strong>&raquo;, &laquo;<strong>us-er-na.me@email.com</strong>&raquo; etc. are perceived by the program as one email address.</p>
        <p>When a user registers, a password for entering the site is generated and sent to the email specified in the registration form. If the new user does not enter the site with the specified password within 48 hours after registration, his account will be automatically deleted.</p>
        <p>Thus, users can only use real verified email addresses when registering. Otherwise, their accounts are deleted and cannot be used in any way to influence the site.</p>
        <p>If an authorized user accesses the site from a different IP than during the last session, he will need to log in to the site again, indicating his email and password.</p>
        <p>Each user can change their password at any time through the appropriate form on the website in their user menu.</p>
        <p>The only mandatory field when registering a new user is their email. All other fields, such as first name, last name, phone number, etc., can be entered at will in any combination.</p>
        <h2 id="speed">2. Speed</h2>
        <p>The speed of page loading for the end user is primarily affected by the amount of information received by the browser (page weight). In order to minimize the number of JS scripts, for the correct formation of pages on the user side, we use only one CSS/JS framework - UIkit.</p>
        <p>&#34;ArtInWeb CMS&#34; is built on pure PHP.</p>
        <p>The PHP programming language was created to unify the ability to turn complex things into simple forms. In other words, getting information (and pushing data back) from/to databases and turning that information into simple HTML.</p>
        <p>In its early versions, the PHP programming language was not at all efficient in terms of loads and amount of data processing. Therefore, many &#34;class connection systems&#34;, &#34;templates&#34;, frameworks, etc. were created to improve these things.</p>
        <p>Over the past few years, starting with PHP 8.0, this programming language has become one of the leaders in performance!</p>
        <p>This project was created precisely to try to return website creation to the world of pure PHP/HTML/CSS/JS.</p>
        <p>The use of a minimum number of files in the processing of received and transmitted information should maximize the capabilities of projects that will be built on the basis of this content management system.</p>
        <h2 id="simplicity">3. Simplicity</h2>
        <p>As mentioned in the previous section, this CMS uses a minimum number of files with minimum dependencies to obtain content from the database and generate HTML source code. Therefore, even with minimal knowledge of PHP, you can figure out how to effectively expand the existing functionality to suit your needs.</p>
        <p>When writing this program, we used many ready-made solutions. However, since we almost completely remade everything beyond recognition, we did not leave any author&#39;s marks of other people. :( If you have found your code somewhere in its &#34;original form&#34;, write to us. We will be happy to list you as a co-author of a certain part of the code.</p>
        <p>For most operations on creating your own content type in this CMS, you need to:</p>
        <ul>
            <li>basic knowledge of HTML&amp;CSS;</li>
            <li>minimal knowledge of PHP;</li>
            <li>expert skill of pressing keys &#34;Ctrl+C&#34; and &#34;Ctrl+V&#34;.</li>
        </ul>
        <p>There&#39;s nothing we can do better than copy-paste :)</p>
        <p>All necessary snippet examples for creating new types of content of any complexity in &#34;AIW CMS&#34; are already in the &#34;dev&#34; folder of this repository.</p>
        <h2>So.</h2>
        <p>It is possible (and most likely) that you will find some errors in the code, ways to improve it and add new features. All this is certainly true, since almost all of this code (as of V0.1) was written or reworked by one person. Therefore, I will be happy to accept and consider any of your ideas. But... If they remain within the mainstream of the universal product.</p>
        <p>Based on this CMS, we have already created several highly specialized sites that have already demonstrated their high efficiency in countering various attacks by intruders, but their specialized code will always remain commercial.</p>
        <p><strong>In this same repository you get:</strong></p>
        <ul>
            <li>a system for managing multilingual or monolingual website content;</li>
            <li>content caching system;</li>
            <li>a user registration and management system with multiple combinations of user types and conditions for access and editing content;</li>
            <li>template system (one for many or unique (in any combination)) for any type of content;</li>
            <li>universal templates for &#34;Privacy Policy&#34;, &#34;User Agreement&#34;, &#34;Terms of Use of Cookies&#34; and &#34;HTML Tags Allowed and Prohibited on the Site&#34;. The first three pages are mandatory for placement on all EU websites;</li>
            <li>an example of a home page that can very easily display data from a wide variety of content types;</li>
            <li>menu formation system:
                <ul>
                    <li>main menu (drop-down on the left);</li>
                    <li>main menu (horizontal at the top);</li>
                    <li>user menu (drop-down on the right);</li>
                    <li>menu for changing the interface language (content).</li>
                </ul>
            </li>
            <li>breadcrumb menu;</li>
            <li>page pagination menu;</li>
            <li>administrative menu (under the main menu on the left);</li>
            <li>feedback system:
                <ul>
                    <li>contacts (adapted for search engines);</li>
                    <li>message form (for registered users) to site owners or managers.</li>
                </ul>
            </li>
            <li>system for managing messages (tickets) to the site administration;</li>
            <li>feedback system;</li>
            <li>feedback management system;</li>
            <li>system parameters management system;</li>
            <li>a system of logs of site visits by users;</li>
            <li>a system of logs of site visits by users belonging to the manager group;</li>
            <li>a system of logs of indexing on the site by search bots;</li>
            <li>a system for monitoring content indexing and creation based on a sitemap (sitemap.txt) in real time;</li>
            <li>a system of multilingual (monolingual) content of the &ldquo;Blog&rdquo; type with the possibility of its simple expansion to any type of content of any complexity with multiple filters;</li>
            <li>a system of notifications about errors in the site&#39;s operation;</li>
            <li>a floating key encryption system for storing confidential user data;</li>
            <li>system for displaying a site in editing mode. The editing mode can be of two types:
                <ul>
                    <li>total - the first page is the same for everyone without an authorization form;</li>
                    <li>personal &ndash; an editing page with an authorization form. The general editing mode page is displayed only for unauthorized users and users who do not have access rights to this mode of the site.</li>
                </ul>
            </li>
        </ul>
        <p><strong>All of the above is far from a complete set!</strong></p>
        <p>We will gradually tell you about it on the pages of the site <a href="https://cms.artinweb.biz/">cms.artinweb.biz</a> what and how to do it better and faster.</p>
        <p>Watch. Read. Create. Share. And&hellip; enjoy life!</p>
        <p><strong>She is one and unique!</strong></p>
        <p>Appreciate your family and communication with them!</p>
        <p>Peaceful skies and&hellip;</p>
        <p><strong>GLORY TO UKRAINE!!!<br />GLORY TO THE HEROES!!!</strong></p>
    </div>
</div>
