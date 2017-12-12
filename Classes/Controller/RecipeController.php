<?php
namespace Pixelant\PxaRecipeDb\Controller;

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
 * RecipeController
 */
class RecipeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * recipeRepository
	 *
	 * @var \Pixelant\PxaRecipeDb\Domain\Repository\RecipeRepository
	 * @inject
	 */
	protected $recipeRepository = NULL;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		if ($this->settings['js']['dontInlcudeInController'] != 1) {
			$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
			$pageRenderer->addJsFooterFile('typo3conf/ext/pxa_recipe_db/Resources/Public/Js/pxa_recipe_db.js');
		}
		$recipes = $this->recipeRepository->findAll();
		$this->view->assign('recipes', $recipes);
		$this->view->assign('filterCategories', $this->getRecipeCategories($recipes));
	}


	/**
	 * action simple list
	 *
	 * @return void
	 */
	public function simpleAction() {
		if ($this->settings['js']['dontInlcudeInController'] != 1) {
			$pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Page\PageRenderer::class);
			$pageRenderer->addJsFooterFile('typo3conf/ext/pxa_recipe_db/Resources/Public/Js/pxa_recipe_db.js');
		}
		$recipes = $this->recipeRepository->findAll();
		$this->view->assign('recipes', $recipes);
		$this->view->assign('filterCategories', $this->getRecipeCategories($recipes));
	}

	/**
	 * action show
	 *
	 * @param \Pixelant\PxaRecipeDb\Domain\Model\Recipe $recipe
	 * @return void
	 */
	public function showAction(\Pixelant\PxaRecipeDb\Domain\Model\Recipe $recipe) {
		$this->view->assign('recipe', $recipe);
	}

	/**
	 * action latest
	 *
	 * @return void
	 */
	public function latestAction() {
		$recipes = $this->recipeRepository->getLatest(3,1);
		$this->view->assign('recipes', $recipes);
	}

	/**
	 * getRecipeCategories Loops through all recipes and collects categories
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult $recipes Recipes to collect used categories from
	 * @return array           An array of used categories
	 */
	private function getRecipeCategories($recipes) {
		$categories = array();
		foreach ($recipes as $recipe) {
			$recipeCategories = $recipe->getCategories();
			foreach ($recipeCategories as $key => $recipeCategory) {
				$id = $recipeCategory->getUid();
				$categories[$id]['title'] = $recipeCategory->getTitle();
				$categories[$id]['description'] = $recipeCategory->getTitle();
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
		$recipes = $this->recipeRepository->getLatest(1,0);
		$this->view->assign('recipes', $recipes);
	}

}
