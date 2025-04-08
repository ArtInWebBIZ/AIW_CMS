<?php

defined('AIW_CMS') or die;

use Core\Trl;

?>
<hr class="uk-divider-icon uk-margin-large-top uk-margin-remove-bottom">
<div class="uk-section uk-section-large">
    <div class="uk-container uk-container-xlarge">
        <h2 class="uk-text-center uk-margin-large-bottom"><?= Trl::_('FP_WHY_ARE_WE') ?></h2>
        <div class="uk-grid-divider uk-flex uk-flex-center uk-child-width-1-1 uk-child-width-1-2@m uk-child-width-1-3@xl" uk-grid>
            <div>
                <div class="uk-card uk-card-body" uk-scrollspy="cls:uk-animation-fade; repeat: true">
                    <div class="circle-number-div">1</div>
                    <h4 class="uk-text-center"><?= Trl::_('FP_PERSONALISED_APPROACH') ?></h4>
                    <p class="uk-text-center"><?= Trl::_('FP_PERSONALISED_APPROACH_TEXT') ?></p>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-body" uk-scrollspy="cls:uk-animation-fade; repeat: true">
                    <div class="circle-number-div">2</div>
                    <h4 class="uk-text-center"><?= Trl::_('FP_LEGAL_ACTIVITY') ?></h4>
                    <p class="uk-text-center"><?= Trl::_('FP_LEGAL_ACTIVITY_TEXT') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
