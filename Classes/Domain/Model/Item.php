<?php
namespace Pixelant\PxaItemList\Domain\Model;

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

use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Annotation as Extbase;

/**
 * Item
 */
class Item extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * Categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category>
     */
    protected $categories = null;

    /**
     * Name
     *
     * @var      string
     * @Extbase\Validate("NotEmpty")
     */
    protected $name = '';

    /**
     * customer
     *
     * @var      string
     * @Extbase\Validate("NotEmpty")
     */
    protected $customer = '';

    /**
     * product choice
     *
     * @var      string
     * @Extbase\Validate("NotEmpty")
     */
    protected $productChoice = '';

    /**
     * architect
     *
     * @var      string
     * @Extbase\Validate("NotEmpty")
     */
    protected $architect = '';

    /**
     * consultant
     *
     * @var      string
     * @Extbase\Validate("NotEmpty")
     */
    protected $consultant = '';

    /**
     * installer
     *
     * @var      string
     * @Extbase\Validate("NotEmpty")
     */
    protected $installer = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * Image
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     */
    protected $image = null;

    /**
     * PDF file
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $pdf = null;

    /**
     * Date
     *
     * @var \DateTime
     */
    protected $date = null;

    /**
     * @var string
     */
    protected $year = '';

    /**
     * Item Construct
     *
     * @return void
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties.
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->image = new ObjectStorage();
        $this->categories = new ObjectStorage();
    }
    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the year
     *
     * @return string $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param  string $year
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Returns the customer
     *
     * @return string $customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Sets the customer
     *
     * @param  string $customer
     * @return void
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Returns the product choice
     *
     * @return string $productChoice
     */
    public function getProductChoice()
    {
        return $this->productChoice;
    }

    /**
     * Sets the product choice
     *
     * @param  string $productChoice
     * @return void
     */
    public function setProductChoice($productChoice)
    {
        $this->productChoice = $productChoice;
    }

    /**
     * Returns the architect
     *
     * @return string $architect
     */
    public function getArchitect()
    {
        return $this->architect;
    }

    /**
     * Sets the architect
     *
     * @param  string $architect
     * @return void
     */
    public function setArchitect($architect)
    {
        $this->architect = $architect;
    }

    /**
     * Returns the consultant
     *
     * @return string $consultant
     */
    public function getConsultant()
    {
        return $this->consultant;
    }

    /**
     * Sets the consultant
     *
     * @param  string $consultant
     * @return void
     */
    public function setConsultant($consultant)
    {
        $this->consultant = $consultant;
    }

    /**
     * Returns the installer
     *
     * @return string $installer
     */
    public function getInstaller()
    {
        return $this->installer;
    }

    /**
     * Sets the installer
     *
     * @param  string $installer
     * @return void
     */
    public function setInstaller($installer)
    {
        $this->installer = $installer;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param  string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $image)
    {
        $this->image = $image;
    }

    /**
     * Returns the pdf
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $pdf
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Sets the pdf
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\FileReference $pdf
     * @return void
     */
    public function setPdf(\TYPO3\CMS\Extbase\Domain\Model\FileReference $pdf)
    {
        $this->pdf = $pdf;
    }

    /**
     * Adds a Category
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\Category $category
     * @return void
     */
    public function addCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $category)
    {
        $this->categories->attach($category);
    }

    /**
     * Removes a Category
     *
     * @param  \TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove The Category to be removed
     * @return void
     */
    public function removeCategory(\TYPO3\CMS\Extbase\Domain\Model\Category $categoryToRemove)
    {
        $this->categories->detach($categoryToRemove);
    }

    /**
     * list of uids of categories
     *
     * @return string
     */
    public function getCategoriesUidList()
    {
        $categoriesUids = [];

        /** @var Category $category */
        foreach ($this->getCategories() as $category) {
            $categoriesUids[] = $category->getUid();
        }

        return implode(',', $categoriesUids);
    }

    /**
     * list of names of categories
     *
     * @return string
     */
    public function getCategoriesTitleList()
    {
        $categoriesTitles = [];

        /** @var Category $category */
        foreach ($this->getCategories() as $category) {
            $categoriesTitles[] = $category->getTitle();
        }

        return implode(', ', $categoriesTitles);
    }

    /**
     * Returns the categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Reverse order of categories
     *
     * @return array
     */
    public function getCategoriesReverse()
    {
        return array_reverse($this->categories->toArray());
    }

    /**
     * Sets the categories
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\Category> $categories
     * @return void
     */
    public function setCategories(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Returns the date
     *
     * @return \DateTime $date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Sets the date
     *
     * @param  \DateTime $date
     * @return void
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}
