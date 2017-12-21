<?php
namespace Pixelant\PxaItemList\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2015 Pixelant <info@pixelant.se>, Pixelant AB
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * Class ItemController
 */
class ItemController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * itemRepository
     *
     * @var    \Pixelant\PxaItemList\Domain\Repository\ItemRepository
     * @inject
     */
    protected $itemRepository = null;

    /**
     * categoryRepository
     *
     * @var    \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        if ($this->settings['js']['dontInlcudeInController'] != 1) {
            $pageRenderer = GeneralUtility::makeInstance(
                \TYPO3\CMS\Core\Page\PageRenderer::class
            );
            $pageRenderer->addJsFooterFile(
                'typo3conf/ext/pxa_item_list/Resources/Public/Js/pxa_filtering.js'
            );
            $pageRenderer->addJsFooterFile(
                'typo3conf/ext/pxa_item_list/Resources/Public/Js/pxa_item_list.js'
            );
        }
        $items = $this->itemRepository->findAll();

        $this->getItemListLabels($pageRenderer);

        $this->view->assign('items', $items);
        $this->view->assign('filterCategories', $this->getFilterCategories($items));
    }

    /**
     * Add labels for JS
     *
     * @return void
     */
    protected function getItemListLabels($pageRenderer)
    {
        static $jsLabelsAdded;
        if ($jsLabelsAdded === null) {
            $labelsJs = [];
            if (is_array($this->settings['translateJsLabels'])) {
                foreach ($this->settings['translateJsLabels'] as $translateJsLabelSet) {
                    $translateJsLabels = GeneralUtility::trimExplode(',', $translateJsLabelSet, true);
                    foreach ($translateJsLabels as $translateJsLabel) {
                        $labelsJs[$translateJsLabel] = LocalizationUtility::translate($translateJsLabel, 'PxaItemList');
                    }
                }
            }
            if (!empty($labelsJs)) {
                $pageRenderer->addInlineLanguageLabelArray($labelsJs);
            }
            $jsLabelsAdded = true;
        }
    }

    /**
     * getItemCategories Loops through all items and collects categories
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $items Items to collect used categories from
     * @return array           An array of used categories
     */
    private function getItemCategories($items, $subCategories)
    {
        $itemCategories = array();
        foreach ($items as $item) {
            foreach ($subCategories as $subCategory) {
                foreach ($item->getCategories() as $category) {
                    $title = $subCategory->getTitle();
                    if ($title === $category->getTitle()) {
                        if (!in_array($itemCategories)) {
                            $itemCategories[$title] = $subCategory;
                        }
                    }
                }
            }
        }

        return $itemCategories;
    }

    /**
     * getItemCategories Loops through all items and collects categories
     *
     * @return array An array of used categories
     */
    private function getFilterCategories($items)
    {
        $categoryColumns = intval($this->settings['filter']['categoryColumns']);
        $filterCategories = [];

        $filterCategories[1]['category'] = $this->categoryRepository->findByUid(
            $this->settings['filterCategory1']
        );
        $subCategories = $this->categoryRepository->findByParent(
            $this->settings['filterCategory1']
        );
        $subCategoriesCount = count($subCategories);
        $filterCategories[1]['subCategories'] = $subCategories;
        // filter out categories bot in any itemscol-md-12
        $filterCategories[1]['subCategories'] = $this->getItemCategories(
            $items,
            $filterCategories[1]['subCategories']
        );
        if ($subCategoriesCount > 12/$categoryColumns) {
            $filterCategories[1]['maxColumnItem'] = $subCategoriesCount % $categoryColumns === 0 ?
            $subCategoriesCount/$categoryColumns : intval($subCategoriesCount / $categoryColumns) + 1;
        }


        $filterCategories[2]['category'] = $this->categoryRepository->findByUid($this->settings['filterCategory2']);
        $subCategories = $this->categoryRepository->findByParent($this->settings['filterCategory2']);
        $filterCategories[2]['subCategories'] = $subCategories;
        // filter out categories bot in any items
        $filterCategories[2]['subCategories'] = $this->getItemCategories(
            $items,
            $filterCategories[2]['subCategories']
        );
        $subCategoriesCount = count($subCategories);
        if ($subCategoriesCount > 12/$categoryColumns) {
            $filterCategories[2]['maxColumnItem'] = $subCategoriesCount % $categoryColumns === 0 ?
            $subCategoriesCount / $categoryColumns : intval($subCategoriesCount / $categoryColumns) + 1;
        }

        return $filterCategories;
    }
}
