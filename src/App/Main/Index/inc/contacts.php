<?php

use Core\Trl;

defined('AIW_CMS') or die;

$class = 'uk-width-1-1 uk-width-1-2@m uk-width-1-3@xl';
$cardClass = 'uk-text-center uk-card uk-card-default uk-card-body';

?>
<div class="uk-section uk-padding-large uk-section-muted">
    <div class="uk-container uk-container-xlarge uk-margin-large-top uk-margin-large-bottom">
        <div class="uk-grid-large uk-grid-match uk-flex uk-flex-center" uk-grid>
            <div class="<?= $class ?>">
                <div class="<?= $cardClass ?>">
                    <h2><span uk-icon="icon: phone; ratio: 4"></span></h2>
                    <p class="uk-text-center"><a itemprop="telephone" href="tel:+987654321987">+987 654 321 987</a> -
                        <a href="https://wa.me/987654321987?text=<?= Trl::_('CONTACTS_CONSULTING_MSG') ?>">WhatsApp</a> /
                        <a href="viber://chat?number=%2B987654321987">Viber</a>
                    </p>
                </div>
            </div>
            <div class="<?= $class ?>">
                <div class="<?= $cardClass ?>">
                    <h2 class="uk-text-center"><?= Trl::_('OV_WE_IN_SOC_NET') ?></h2>
                    <table class="uk-table uk-table-small">
                        <tr>
                            <td>
                                <a href="https://instagram.com/artinweb_biz" target="_blank" rel="noopener noreferrer" class="uk-text-primary" uk-icon="icon: instagram; ratio: 2"></a><br>
                                <a href="https://instagram.com/artinweb_biz" target="_blank" rel="noopener noreferrer"><?= Trl::_('OV_INSTAGRAM') ?></a>
                            </td>
                            <td>
                                <a href="https://www.facebook.com/artinweb-biz/" target="_blank" rel="noopener noreferrer" class="uk-text-primary" uk-icon="icon: facebook; ratio: 2"></a><br>
                                <a href="https://www.facebook.com/artinweb-biz/" target="_blank" rel="noopener noreferrer"><?= Trl::_('OV_FACEBOOK') ?></a>

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="<?= $class ?>">
                <div class="<?= $cardClass ?>">
                    <h2><span uk-icon="icon: location; ratio: 4"></span></h2>
                    <p class="uk-text-center"><?= Trl::_('OV_COUNTRY') ?>, <?= Trl::_('OV_REGION') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
