<?php
defined('TYPO3_MODE') || die;

call_user_func(
    function () {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
            'pxa_item_list',
            'tx_pxaitemlist_domain_model_item'
        );
    }
);
