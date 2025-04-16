<?php

defined('AIW_CMS') or die;

$sectionId    = isset($v['section_id']) && $v['section_id'] != '' ? $v['section_id'] : '';
$sectionStyle = isset($v['section_style']) && $v['section_style'] != '' ? $v['section_style'] : '';

?>
<section <?= $sectionId ?> class="uk-section <?= $v['section_css'] ?>" <?= $sectionStyle ?>>
    <div class="uk-container <?= $v['container_css'] ?>">
        <div class="uk-grid uk-flex uk-flex-center">
            <div class="uk-width-1-1 <?= isset($v['overflow_css']) ? $v['overflow_css'] : 'overflow-hidden' ?>">
