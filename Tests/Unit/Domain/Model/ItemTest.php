<?php

namespace Pixelant\PxaItemList\Tests\Unit\Domain\Model;

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
 * Test case for class \Pixelant\PxaItemList\Domain\Model\Item.
 *
 * @copyright Copyright belongs to the respective authors
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Pixelant <info@pixelant.se>
 */
class ItemTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
    /**
     * @var \Pixelant\PxaItemList\Domain\Model\Item
     */
    protected $subject = null;

    public function setUp()
    {
        $this->subject = new \Pixelant\PxaItemList\Domain\Model\Item();
    }

    public function tearDown()
    {
        unset($this->subject);
    }

    /**
     * @test
     */
    public function getNameReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getName()
        );
    }

    /**
     * @test
     */
    public function setNameForStringSetsName()
    {
        $this->subject->setName('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'name',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getYearReturnsInitialValueForInt()
    {
        $this->assertSame(
            null,
            $this->subject->getYear()
        );
    }

    /**
     * @test
     */
    public function setYearForIntSetsYear()
    {
        $this->subject->setYear(1999);

        $this->assertAttributeEquals(
            1999,
            'year',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getCustomerReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getCustomer()
        );
    }

    /**
     * @test
     */
    public function setCustomerForStringSetsCustomer()
    {
        $this->subject->setCustomer('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'customer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getProductChoiceReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getProductChoice()
        );
    }

    /**
     * @test
     */
    public function setProductChoiceForStringSetsProductChoice()
    {
        $this->subject->setProductChoice('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'productChoice',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getArchitectReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getArchitect()
        );
    }

    /**
     * @test
     */
    public function setArchitectForStringSetsArchitect()
    {
        $this->subject->setArchitect('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'architect',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getConsultantReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getConsultant()
        );
    }

    /**
     * @test
     */
    public function setConsultantForStringSetsConsultant()
    {
        $this->subject->setConsultant('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'consultant',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getInstallerReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getInstaller()
        );
    }

    /**
     * @test
     */
    public function setInstallerForStringSetsInstaller()
    {
        $this->subject->setInstaller('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'installer',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDescriptionReturnsInitialValueForString()
    {
        $this->assertSame(
            '',
            $this->subject->getDescription()
        );
    }

    /**
     * @test
     */
    public function setDescriptionForStringSetsDescription()
    {
        $this->subject->setDescription('Conceived at T3CON10');

        $this->assertAttributeEquals(
            'Conceived at T3CON10',
            'description',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        $this->assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setImage($fileReferenceFixture);

        $this->assertAttributeEquals(
            $fileReferenceFixture,
            'image',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getPdfReturnsInitialValueForFileReference()
    {
        $this->assertEquals(
            null,
            $this->subject->getPdf()
        );
    }

    /**
     * @test
     */
    public function setPdfForFileReferenceSetsPdf()
    {
        $fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
        $this->subject->setPdf($fileReferenceFixture);

        $this->assertAttributeEquals(
            $fileReferenceFixture,
            'pdf',
            $this->subject
        );
    }

    /**
     * @test
     */
    public function getDateReturnsInitialValueForDateTime()
    {
        $this->assertEquals(
            null,
            $this->subject->getDate()
        );
    }

    /**
     * @test
     */
    public function setDateForDateTimeSetsDate()
    {
        $dateTimeFixture = new \DateTime();
        $this->subject->setDate($dateTimeFixture);

        $this->assertAttributeEquals(
            $dateTimeFixture,
            'date',
            $this->subject
        );
    }
}
