<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'Pixelant.' . $_EXTKEY,
	'Recipe',
	array(
		'Recipe' => 'list, show, latest, promotion',
		
	),
	// non-cacheable actions
	array(
		'Recipe' => '',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder