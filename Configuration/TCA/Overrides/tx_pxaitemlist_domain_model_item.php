<?php
defined('TYPO3_MODE') || die;

call_user_func(
    function () {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
            'pxa_item_list',
            'tx_pxaitemlist_domain_model_item',
            // optional: in case the field would need a different name as "categories".
            // The field is mandatory for TCEmain to work internally.
            'categories',
            // optional: add TCA options which controls how the field is displayed. e.g position and name of the category tree.
            [
                'fieldConfiguration' => [
                    'foreign_table_where' =>  'AND sys_category.pid=###CURRENT_PID### AND sys_category.sys_language_uid IN (-1, 0)'
                ]
            ]
        );
    }
);
