<?php
namespace Pixelant\PxaItemList\Tests\Unit\Controller;
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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Pixelant\PxaItemList\Controller\ItemController.
 *
 * @author Pixelant <info@pixelant.se>
 */
class ItemControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Pixelant\PxaItemList\Controller\ItemController
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = $this->getMock('Pixelant\\PxaItemList\\Controller\\ItemController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllItemsFromRepositoryAndAssignsThemToView() {

		$allItems = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$itemRepository = $this->getMock('Pixelant\\PxaItemList\\Domain\\Repository\\ItemRepository', array('findAll'), array(), '', FALSE);
		$itemRepository->expects($this->once())->method('findAll')->will($this->returnValue($allItems));
		$this->inject($this->subject, 'itemRepository', $itemRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('items', $allItems);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenItemToView() {
		$item = new \Pixelant\PxaItemList\Domain\Model\Item();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('item', $item);

		$this->subject->showAction($item);
	}
}
