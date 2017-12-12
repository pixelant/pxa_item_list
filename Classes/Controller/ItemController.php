<?php
namespace Pixelant\PxaItemList\Controller;

/***************************************************************
 *
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

/**
 * ItemController
 */
class ItemController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * itemRepository
	 *
	 * @var \Pixelant\PxaItemList\Domain\Repository\ItemRepository
	 * @inject
	 */
	protected $itemRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		if ($this->settings['js']['dontInlcudeInController'] != 1) {
			$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
			$pageRenderer->addJsFooterFile('typo3conf/ext/pxa_item_list/Resources/Public/Js/pxa_item_list.js');
		}
		$items = $this->itemRepository->findAll();
		$this->view->assign('items', $items);
		$this->view->assign('filterCategories', $this->getItemCategories($items));
	}


	/**
	 * action simple list
	 *
	 * @return void
	 */
	public function simpleAction() {
		if ($this->settings['js']['dontInlcudeInController'] != 1) {
			$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
			$pageRenderer->addJsFooterFile('typo3conf/ext/pxa_item_list/Resources/Public/Js/pxa_item_list.js');
		}
		$items = $this->itemRepository->findAll();
		$this->view->assign('items', $items);
		$this->view->assign('filterCategories', $this->getItemCategories($items));
	}

	/**
	 * action show
	 *
	 * @param \Pixelant\PxaItemList\Domain\Model\Item $item
	 * @return void
	 */
	public function showAction(\Pixelant\PxaItemList\Domain\Model\Item $item) {
		$this->view->assign('item', $item);
	}

	/**
	 * action latest
	 *
	 * @return void
	 */
	public function latestAction() {
		$items = $this->itemRepository->getLatest(3,1);
		$this->view->assign('items', $items);
	}

	/**
	 * getItemCategories Loops through all items and collects categories
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $items Items to collect used categories from
	 * @return array           An array of used categories
	 */
	private function getItemCategories($items) {
		$categories = array();
		foreach ($items as $item) {
			$itemCategories = $item->getCategories();
			foreach ($itemCategories as $key => $itemCategory) {
				$id = $itemCategory->getUid();
				$categories[$id]['title'] = $itemCategory->getTitle();
				$categories[$id]['description'] = $itemCategory->getTitle();
				$categories[$id]['usage']++;
			}
		}
		return $categories;
	}

	/**
	 * action promotion
	 *
	 * @return void
	 */
	public function promotionAction() {
		$items = $this->itemRepository->getLatest(1,0);
		$this->view->assign('items', $items);
	}

}
