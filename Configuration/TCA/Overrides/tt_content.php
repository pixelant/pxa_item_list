<?php
defined('TYPO3_MODE') || die;

call_user_func(
    function () {
        $pluginSignature = 'pxaitemlist_item';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
            $pluginSignature,
            'FILE:EXT:pxa_item_list/Configuration/FlexForms/flexform_item.xml'
        );
    }
);
