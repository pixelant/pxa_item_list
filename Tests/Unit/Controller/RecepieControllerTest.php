<?php
namespace Pixelant\PxaRecipeDb\Tests\Unit\Controller;
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
 * Test case for class Pixelant\PxaRecipeDb\Controller\RecepieController.
 *
 * @author Pixelant <info@pixelant.se>
 */
class RecepieControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase {

	/**
	 * @var \Pixelant\PxaRecipeDb\Controller\RecepieController
	 */
	protected $subject = NULL;

	public function setUp() {
		$this->subject = $this->getMock('Pixelant\\PxaRecipeDb\\Controller\\RecepieController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllRecepiesFromRepositoryAndAssignsThemToView() {

		$allRecepies = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$recepieRepository = $this->getMock('Pixelant\\PxaRecipeDb\\Domain\\Repository\\RecepieRepository', array('findAll'), array(), '', FALSE);
		$recepieRepository->expects($this->once())->method('findAll')->will($this->returnValue($allRecepies));
		$this->inject($this->subject, 'recepieRepository', $recepieRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('recepies', $allRecepies);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenRecepieToView() {
		$recepie = new \Pixelant\PxaRecipeDb\Domain\Model\Recepie();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('recepie', $recepie);

		$this->subject->showAction($recepie);
	}
}
