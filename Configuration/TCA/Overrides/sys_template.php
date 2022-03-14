<?php
defined('TYPO3_MODE') || die('Access denied.');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
  'pxa_item_list',
  'Configuration/TypoScript',
  'Item list'
);

