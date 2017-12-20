<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pixelant.' . $_EXTKEY,
    'Item',
    array(
        'Item' => 'list, show, latest, promotion',
        
    ),
    // non-cacheable actions
    array(
        'Item' => '',
        
    )
);
