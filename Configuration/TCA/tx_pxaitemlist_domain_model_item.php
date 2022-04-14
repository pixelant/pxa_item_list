<?php
return array(
    'ctrl' => array(
        'title'    => 'LLL:EXT:pxa_item_list/Resources/Private/Language/locallang_db.xlf:'.
        'tx_pxaitemlist_domain_model_item',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'versioningWS' => 2,
        'versioning_followPages' => true,

        'languageField' => 'sys_language_uid',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'searchFields' => 'name,year,customer,product_choice,architect,consultant,'.
        'installer,description,image,pdf,date,',
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('pxa_item_list') .
        'Resources/Public/Icons/tx_pxaitemlist_domain_model_item.gif'
    ),
    'types' => array(
        '1' => array(
            'showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, name,'.
            ' year, customer, product_choice, architect, consultant, installer, description, image,'.
            ' pdf, date, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime,'.
            ' --div--;LLL:EXT:lang/locallang_tca.xlf:sys_category.tabs.category, categories'
        ),
    ),
    'palettes' => array(
        '1' => array('showitem' => ''),
    ),
    'columns' => array(
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple',
                    ],
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => array(
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
            'config' => array(
                'type' => 'select',
                'items' => array(
                    array('', 0),
                ),
                'foreign_table' => 'tx_pxaitemlist_domain_model_item',
                'foreign_table_where' =>
                'AND tx_pxaitemlist_domain_model_item.pid=###CURRENT_PID###'.
                ' AND tx_pxaitemlist_domain_model_item.sys_language_uid IN (-1,0)',
            ),
        ),
        'l10n_diffsource' => array(
            'config' => array(
                'type' => 'passthrough',
            ),
        ),
        't3ver_label' => array(
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            )
        ),
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true,
                    ],
                ],
            ],
        ],
        'starttime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'endtime' => array(
            'exclude' => 1,
            'l10n_mode' => 'mergeIfNotBlank',
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'datetime',
                'checkbox' => 0,
                'default' => 0,
                'range' => array(
                    'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
                ),
            ),
        ),
        'name' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'year' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.year',
            'config' => array(
                'type' => 'input',
                'size' => 5,
                'eval' => 'year,required'
            ),
        ),
        'customer' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.customer',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'architect' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.architect',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'default' => '',
                'eval' => 'trim'
            ),
        ),
        'product_choice' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.product_choice',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ),
        ),
        'consultant' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.consultant',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'default' => '',
                'eval' => 'trim'
            ),
        ),
        'installer' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.installer',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'description' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim,required'
            )
        ),
        'image' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.image',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'image',
                array(
                    'appearance' => array(
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:images.addFileReference'
                    ),
                    'foreign_types' => array(
                        '0' => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:'.
                            'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:'.
                            'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:'.
                            'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:'.
                            'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:'.
                            'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:'.
                            'sys_file_reference.imageoverlayPalette;imageoverlayPalette,
                            --palette--;;filePalette'
                        )
                    ),
                    'maxitems' => 1,
                    'minitems' => 1,
                    'eval' => 'required'
                ),
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ),
        'pdf' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.pdf',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'pdf',
                array(
                    'appearance' => array(
                        'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:media.addFileReference'
                    ),
                    'foreign_types' => array(
                        '0' => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;'.
                            'imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;'.
                            'imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;'.
                            'imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;'.
                            'imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;'.
                            'imageoverlayPalette,
                            --palette--;;filePalette'
                        ),
                        \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => array(
                            'showitem' => '
                            --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;'.
                            'imageoverlayPalette,
                            --palette--;;filePalette'
                        )
                    ),
                    'maxitems' => 1
                )
            ),
        ),
        'date' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:pxa_item_list/Resources/Private/Language/'.
            'locallang_db.xlf:tx_pxaitemlist_domain_model_item.date',
            'config' => array(
                'type' => 'input',
                'size' => 7,
                'eval' => 'date',
                'checkbox' => 1,
                'default' => time()
            ),
        ),
    ),
);
