<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Pixelant.pxa_item_list',
    'Item',
    array(
        'Item' => 'list',
    ),
    // non-cacheable actions
    array(
        'Item' => '',
    )
);

// Register icons
$icons = [
    'ext-pxa-item-list' => 'Extension.svg',
];
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
    \TYPO3\CMS\Core\Imaging\IconRegistry::class
);

foreach ($icons as $identifier => $path) {
    $iconRegistry->registerIcon(
        $identifier,
        \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
        ['source' => 'EXT:pxa_item_list/Resources/Public/Icons/Svg/' . $path]
    );
}

// Include page TS
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
    '<INCLUDE_TYPOSCRIPT: source="DIR:EXT:pxa_item_list/Configuration/TypoScript/PageTS/" extensions="ts">'
);
