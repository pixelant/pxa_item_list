<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
    'tx_pxaitemlist_domain_model_item',
    'EXT:pxa_item_list/Resources/Private/Language/locallang_csh_tx_pxaitemlist_domain_model_item.xlf'
);
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
    'tx_pxaitemlist_domain_model_item'
);
