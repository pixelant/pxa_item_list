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
class ItemControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

    /**
     * @var \Pixelant\PxaItemList\Controller\ItemController
     */
    protected $subject = null;

    public function setUp()
    {
        $this->subject = $this->getMockBuilder(\Pixelant\PxaItemList\Controller\ItemController::class)
            ->setMethods(['redirect', 'forward', 'addFlashMessage'])
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function listActionFetchesAllItemsFromRepositoryAndAssignsThemToView()
    {
        // Typescript settings
        $typoscriptSettings = [
            'filterCategory1' => '13',
            'filterCategory2' => '134',
        ];

        $expectedFilterCategories = [
            [
                'category' => null,
                'subCategories' => [],
            ],
            [
                'category' => null,
                'subCategories' => []
            ],
        ];

        $this->inject($this->subject, 'settings', $typoscriptSettings);
        $allItems = $this->getMockBuilder(\TYPO3\CMS\Extbase\Persistence\Generic\QueryResult::class)
            ->disableOriginalConstructor()
            ->getMock();

        $itemRepository = $this->getMockBuilder(\Pixelant\PxaItemList\Domain\Repository\ItemRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock();
        $itemRepository->expects(self::once())->method('findAll')->will(self::returnValue($allItems));
        $this->inject($this->subject, 'itemRepository', $itemRepository);

        $categoryRepository = $this->getMockBuilder(\TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository::class)
            ->setMethods([])
            ->disableOriginalConstructor()
            ->getMock();
        $this->inject($this->subject, 'categoryRepository', $categoryRepository);


        $subject = $this->getMockBuilder(\Pixelant\PxaItemList\Controller\ItemController::class)
            ->setMethods(['getFilterCategories'])
            ->disableOriginalConstructor()
            ->getMock();
        $subject->expects(self::any())->method('getFilterCategories')->with('items', $allItems);

        $view = $this->getMockBuilder(\TYPO3\CMS\Extbase\Mvc\View\ViewInterface::class)->getMock();
        $this->inject($this->subject, 'view', $view);
        $view->expects($this->at(0))->method('assign')->with('items', $allItems);
        $view->expects($this->at(1))->method('assign')->with('filterCategories', $expectedFilterCategories);


        $this->subject->listAction();
    }
}
