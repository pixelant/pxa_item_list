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

use Pixelant\PxaItemList\Domain\Model\Item;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\Category;
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
        $items = $this->itemRepository->findAll();

        $this->getItemListLabels();

        $this->view->assign('items', $items);
        $this->view->assign('filterCategories', $this->getFilterCategories($items));
    }

    /**
     * Add labels for JS
     *
     * @return void
     */
    protected function getItemListLabels()
    {
        static $jsLabelsAdded;
        if ($jsLabelsAdded === null) {
            /** @var PageRenderer $pageRenderer */
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

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
        $itemCategories = [];
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
    public function getFilterCategories($items)
    {
        $availableCategories = $this->getListOfVisibleCategories($items);
        $maxItemsInColumn = (int)$this->settings['filter']['maxColumnItem'] ?: 5;
        $columnGridMaxValue = (int)$this->settings['filter']['columnGridMaxValue'] ?: 12;

        $filterCategories = [];
        $parentCategoriesUids = [
            $this->settings['filterCategory1'],
            $this->settings['filterCategory2']
        ];

        $totalColumns = 0;
        foreach ($parentCategoriesUids as $parentCategoriesUid) {
            /** @var Category $parentCategory */
            $parentCategory = $this->categoryRepository->findByUid($parentCategoriesUid);
            if ($parentCategory === null) {
                continue;
            }

            $filterCategories[$parentCategory->getUid()] = [
                'category' => $parentCategory,
                'subCategories' => []
            ];
            /** @noinspection PhpUndefinedMethodInspection */
            $subCategories = $this->categoryRepository->findByParent($parentCategory->getUid());

            /** @var Category $subCategory */
            foreach ($subCategories as $subCategory) {
                if (in_array($subCategory->getUid(), $availableCategories)) {
                    $filterCategories[$parentCategory->getUid()]['subCategories'][$subCategory->getUid()] = $subCategory;
                }
            }
            $columns = 1;
            $countSubCategories = count($filterCategories[$parentCategory->getUid()]['subCategories']);
            if ($countSubCategories > 0) {
                $columns = (int)ceil($countSubCategories / $maxItemsInColumn);
            }
            $filterCategories[$parentCategory->getUid()]['columns'] = $columns;
            $totalColumns += $columns;
        }


        // Now count grid value for each category
        foreach ($filterCategories as &$filterCategory) {
            $filterCategory['parentGridClassValue'] = $columnGridMaxValue / $totalColumns * $filterCategory['columns'];
            $filterCategory['subGridClassValue'] = $columnGridMaxValue / $filterCategory['columns'];
        }

        return $filterCategories;
    }

    /**
     * Generate array of available categories
     *
     * @param $items
     * @return array
     */
    protected function getListOfVisibleCategories($items)
    {
        $list = [];
        /** @var Item $item */
        foreach ($items as $item) {
            /** @var Category $category */
            foreach ($item->getCategories() as $category) {
                $list[] = $category->getUid();
            }
        }

        return array_unique($list);
    }
}
