<?php
namespace Pixelant\PxaRecipeDb\Domain\Repository;

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
 * The repository for Recipes
 */
class RecipeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	// Order by BE sorting
	protected $defaultOrderings = array(
		'date' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
	);

	public function getLatest($limit = 3, $offset = 1) {
		$query = $this->createQuery();
		$query->setLimit($limit);
		$query->setOffset($offset);
		return $query->execute();
	}
}