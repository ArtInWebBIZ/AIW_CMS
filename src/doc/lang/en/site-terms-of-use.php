<?php

/**
 * @package    ArtInWebCMS.Core
 *
 * @copyright  (C) 2024 Igor Kruk <https://cms.artinweb.biz>
 * @license    GNU General Public License version 3 - see LICENSE.txt
 */

defined('AIW_CMS') or die;

use Core\Plugins\Ssl;
use Core\{Session, Trl};

$p30px = Session::getRtl() === 0 ? 'style="padding-left: 30px"' : 'style="padding-right: 30px"';

?>
<h1 class="uk-text-center">Website User Agreement</h1>
<h3>1. General provisions</h3>
<p>1.1. This User Agreement ("Agreement") applies to the <strong><?= Trl::_('OV_SITE_FULL_NAME') ?></strong> website located at <strong><?= Ssl::getLink() ?></strong> and to all related sites linked to <strong><?= Trl::_('OV_SITE_FULL_NAME') ?></strong>.</p>
<p>1.2. The website <strong><?= Trl::_('OV_SITE_FULL_NAME') ?></strong> (hereinafter referred to as the Site) is the property of <?= Trl::_('OV_OWNER_NAME') ?>.</p>
<p>1.3. This Agreement regulates the relationship between the Administration of the Site <strong><?= Trl::_('OV_SITE_FULL_NAME') ?></strong> (hereinafter - the Administration of the Site) and the User of this Site.</p>
<p>1.4. The Website Administration reserves the right to change, add or delete paragraphs of this Agreement at any time without notice to the User.</p>
<p>1.5. The User's continued use of the Site constitutes acceptance of the Agreement and the changes made to this Agreement.</p>
<p>1.6. It is the user's personal responsibility to check this Agreement for changes to it.</p>
<h3>2. Definitions of terms</h3>
<p>2.1. The following terms shall have the following meaning for the purposes of this Agreement:</p>
<p>2.2. <strong><?= Trl::_('OV_SITE_FULL_NAME') ?></strong> - Website located on the domain name <strong><?= Ssl::getLink() ?></strong>, operating through an Internet resource and related services.</p>
<p>2.3. Website - an Internet resource containing information about Services, Vendor, articles, notes, comments enabling the selection, ordering and (or) purchasing of Services, leaving a review or comment on an article or blog.</p>
<p>2.4. Site Administration - authorised staff members acting on behalf of <?= Trl::_('OV_OWNER_NAME') ?> to operate this site.</p>
<p>2.5. Website User (hereinafter referred to as "User") means a person who accesses and uses the Website through the Internet.</p>
<p>2.6. The Content of the Website (hereinafter referred to as the Content) means the protected results of intellectual activity, including texts of literary works, their titles, prefaces, annotations, articles, illustrations, covers, musical works with or without text, graphic, textual, photographic, derivative, composite and other works, user interfaces, visual interfaces, trademark names, logos, computer programs, databases, as well as the design, structure, selection, coordination, appearance, general style and arrangement of this Content, included on the Site and other intellectual property, all together and/or separately, contained on the Site.</p>
<h3>3. Subject of the agreement</h3>
<p>3.1. The subject of this Agreement is to provide the User with access to the services, materials, articles and blogs provided.</p>
<p <?= $p30px ?>>3.1.1. The website provides the user with the following services:</p>
<ul>
    <li>Access to electronic content on a free-of-charge basis, with the right to purchase (download), view content;</li>
    <li>access to the search and navigation facilities of the website;</li>
    <li>enabling the User to post messages, comments, reviews of Users and rate the content of the Site;</li>
    <li>access to information about the Services and information about the purchase of the Services;</li>
    <li>other types of services provided on the pages of the website.</li>
</ul>
<p <?= $p30px ?>>3.1.2. This Agreement shall apply to all currently available (actually functioning) Site services, as well as any subsequent modifications and additional Site services that may appear in the future.</p>
<p>3.2. Access to the Site is free of charge.</p>
<p>3.3. This Agreement is a public offer. By accessing the Site, the User is deemed to have acceded to this Agreement.</p>
<p>3.4. Use of the materials and services on this website is governed by the laws of the European Union.</p>
<h3>4. Rights and obligations of the parties</h3>
<p>4.1. The Site Administration may:</p>
<p <?= $p30px ?>>4.1.1. Modify the terms of use of the Website and change the content of this Website. The changes shall take effect as soon as the new version of the Agreement is published on the Website.</p>
<p <?= $p30px ?>>4.1.2. Restrict access to the Site if the User breaches the terms of this Agreement.</p>
<p>4.2. The user has the right:</p>
<p <?= $p30px ?>>4.2.1. Gain access to use the Site after complying with the registration requirements.</p>
<p <?= $p30px ?>>4.2.2. Use all the services available on the Site and purchase any Goods, Services offered on the Site.</p>
<p <?= $p30px ?>>4.2.3. Ask any questions relating to the services using the details found in the "Contact Us" section of the website.</p>
<p <?= $p30px ?>>4.2.4. Use the Site only for the purposes and in the manner prescribed in the Agreement and not prohibited by the laws of Ukraine.</p>
<p>4.3. The User of this Website undertakes:</p>
<p <?= $p30px ?>>4.3.1. Provide, at the request of the Site Administration, additional information that is directly related to the services provided on this Site.</p>
<p <?= $p30px ?>>4.3.2. Respect the proprietary and non-proprietary rights of authors and other rights holders when using the Site.</p>
<p <?= $p30px ?>>4.3.3. Do not take any action that could be seen as disruptive to the normal operation of the Site.</p>
<p <?= $p30px ?>>4.3.4. Do not use the Site to disseminate any information about individuals or legal entities that is confidential and protected by European Union law.</p>
<p <?= $p30px ?>>4.3.5. Avoid any action that could result in a breach of the confidentiality of information protected under European Union law.</p>
<p <?= $p30px ?>>4.3.6. Do not use the Site to distribute advertising or promotional information other than with the consent of the Site Administration.</p>
<p <?= $p30px ?>>4.3.7. Do not use the services of the website for the purpose of:</p>
<ul>
    <li>uploading content that is illegal violates any third party rights;</li>
    <li>propagates violence, cruelty, hatred and/or discrimination on racial, national, gender, religious or social grounds;</li>
    <li>contains inaccurate information and/or insults against specific individuals, organisations or authorities;</li>
    <li>inducement to commit unlawful acts as well as assistance to persons whose actions are aimed at violating restrictions and prohibitions in force in the territory of the European Union;</li>
    <li>violations of the rights of minors and/or any form of harm caused to them;</li>
    <li>the infringement of minority rights;</li>
    <li>impersonating another person or a representative of an organisation and/or community without sufficient authority, including employees of this Site;</li>
    <li>misleading as to the properties and characteristics of any Service from the catalogue on the Site posted on the Site;</li>
    <li>inappropriate comparisons of Services, as well as negative attitudes towards (non-) users of certain Services or judgemental attitudes towards such users.</li>
</ul>
<p>4.4. The user is not permitted:</p>
<p <?= $p30px ?>>4.4.1. Use any device, programme, procedure, algorithm or method, automatic device or equivalent manual process to access, acquire, copy or monitor the content of this Site;</p>
<p <?= $p30px ?>>4.4.2. Disrupt the proper functioning of the Site;</p>
<p <?= $p30px ?>>4.4.3. By any means circumvent the navigational structure of the Site to obtain or attempt to obtain any information, documents or materials through any means not specifically made available through the services of this Site;</p>
<p <?= $p30px ?>>4.4.4. Unauthorised access to the functions of the Site, any other systems or networks relating to this Site and any services offered on the Site;</p>
<p <?= $p30px ?>>4.4.5. Violate the security or authentication system on the Site or on any network related to the Site.</p>
<p <?= $p30px ?>>4.4.6. Perform a reverse search, trace or attempt to trace any information on any other User on the Site.</p>
<p <?= $p30px ?>>4.4.7. Use the Site and its Contents for any purpose prohibited by EU law and to incite any illegal activity or other activity that infringes the rights or the rights of others.</p>
<h3>5. Site usage</h3>
<p>5.1. The Site and the Content forming part of the Site are owned and operated by the Site Administration.</p>
<p>5.2. The content of the Site may not be copied, published, reproduced, transmitted or distributed in any way, or posted on the Internet without the prior written consent of the Site Administration.</p>
<p>5.3. The content of the Site is protected by copyright, trademark law and other rights relating to intellectual property and unfair competition law.</p>
<p>5.4. Any activity by User on the Site (other than browsing the publicly accessible pages of the Site) requires the creation of a User account.</p>
<p>5.5. The User is personally responsible for maintaining the confidentiality of their account information, including their password, and for any and all activities undertaken on behalf of the Account User.</p>
<p <?= $p30px ?>>5.5.1. The User's email address and phone number are stored in the Site's database in encrypted form using a floating key (the same value for any number of records in the database will have a different value).</p>
<p>5.6. The user must immediately notify the Site Administration of any unauthorised use of their account or password or any other breach of security.</p>
<p>5.7. The Website Administration has the right to unilaterally cancel the User's account if it has not been used for more than 24 consecutive calendar months without notice to the User.</p>
<p>5.8. This Agreement applies to all additional terms and conditions relating to the purchase and provision of Services provided on the Site.</p>
<p>5.9. The information posted on the Site should not be construed as an amendment to this Agreement.</p>
<p>5.10. The Website Administration has the right to change the list of services offered on the Website and/or the prices applicable to their sale and/or the services provided by the Website at any time without notice to the User.</p>
<p>5.11. The documents referred to in Clause 5.11.1 of this Agreement govern, in relevant part, and extend to the use of the Site by the User. The following documents are included in this Agreement:</p>
<p <?= $p30px ?>>5.11.1. Privacy Policy;</p>
<p <?= $p30px ?>>5.11.2. User Agreement;</p>
<p <?= $p30px ?>>5.11.3. Terms and conditions for the use of cookies;</p>
<p>5.12. Any of the documents listed in clause 5.11. hereof may be subject to update. Changes shall take effect as soon as they are published on the Website.</p>
<h3>6. Responsibility</h3>
<p>6.1. Any losses that the User may incur in case of intentional or negligent violation of any provision of this Agreement, as well as due to unauthorised access to the communications of another User, shall not be compensated by the Site Administration.</p>
<p>6.2. The Site Administration is not responsible for:</p>
<p <?= $p30px ?>>6.2.1. Delays or failures in the transaction process due to force majeure and any case of malfunction in telecommunication, computer, electrical and other related systems.</p>
<p <?= $p30px ?>>6.2.2. Actions of transfer systems, banks, payment systems and for delays related to their operation.</p>
<p <?= $p30px ?>>6.2.3. The proper functioning of the Website, in the event that the User does not have the necessary technical means to use it, and has no obligation to provide users with such means.</p>
<h3>7. Breach of the terms of the user agreement</h3>
<p>7.1. The Website Administration reserves the right to disclose any information collected about this Website User if such disclosure is necessary in connection with an investigation or complaint regarding misuse of the Website, or to identify the User, who may violate or interfere with the rights of the Website Administration or other Website Users.</p>
<p>7.2. The Site Administration may disclose any information about the User that it deems necessary to comply with applicable law or court orders, enforce the terms of this Agreement, or protect the rights or safety of <?= Trl::_('OV_OWNER_NAME') ?> and Users.</p>
<p>7.3. The Website Administration has the right to disclose information about the User if applicable law requires such disclosure.</p>
<p>7.4. The Website Administration has the right to terminate and/or block access to the Website without prior notice to the User if the User has violated this Agreement or the terms of use contained in other documents, or if the Website is terminated, or due to a technical failure or problem.</p>
<p>7.5. The Website Administration shall not be liable to the User or any third party for termination of access to the Website if the User violates any provision of this Agreement or any other document containing the terms of use of the Website.</p>
<h3>8. Dispute resolution</h3>
<p>8.1. In the event of any disagreement or dispute between the parties to this Agreement, a claim (written offer for voluntary settlement of the dispute) shall be a prerequisite before recourse to the courts.</p>
<p>8.2. The recipient of the claim shall, within 30 calendar days of receipt of the claim, notify the claimant in writing of the outcome of the claim.</p>
<p>8.3. If the dispute cannot be resolved voluntarily, either Party may apply to the courts for the protection of its rights, which are granted to it by the law in force.</p>
<p>8.4. Any action in respect of the terms of use of this Site must be brought within seven (7) days after the cause of action arises, except in respect of copyright in legally protected material on this Site. Any action or cause of action for breach of this clause shall be barred by the statute of limitations.</p>
<h3>9. Additional conditions</h3>
<p>9.1. The Website Administration does not accept counter-proposals from the User regarding changes to this User Agreement.</p>
<p>9.2. User feedback, comments posted on the Site are not confidential and may be used by the Site Administration without restrictions.</p>
