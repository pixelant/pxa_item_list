<?php
namespace Pixelant\PxaItemList\Domain\Model;

/**
 * Category
 */
class Category extends \TYPO3\CMS\Extbase\Domain\Model\Category
{
    function __construct()
    {
        $this->categories = new ObjectStorage();
    }
    /**
     * categories
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaItemList\Domain\Model\Category>
     * @lazy
     */
    protected $categories;

    /**
     * Get categories
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\Pixelant\PxaItemList\Domain\Model\Category>
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set categories
     *
     * @param  \TYPO3\CMS\Extbase\Persistence\ObjectStorage $categories
     * @return void
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }
}
