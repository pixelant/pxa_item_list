<?php
namespace Pixelant\PxaItemList\Domain\Repository;

class CategoryRepository extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
{
    /**
     * CategoryRepository
     *
     * @var \Pixelant\PxaItemList\Domain\Repository\CategoryRepository
     * @inject
     */
    protected $categoryRepository = null;

    public function initializeObject()
    {
        /** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings */
        $defaultQuerySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // add the pid constraint
        $defaultQuerySettings->setStoragePageIds([136]);
        $defaultQuerySettings->setRespectStoragePage(false);
    }


    /**
     * Find categories by parent category
     * This is mostly used for navigation, so we need possibility to set direction
     *
     * @param mixed $parentCategory
     * @param array $ordering
     * @return QueryResultInterface
     */
    public function findByParent($parentCategory, array $ordering = [])
    {
        $query = $this->createQuery();

        $query->matching($query->equals('parent', $parentCategory));
        if (!empty($ordering)) {
            $query->setOrderings($ordering);
        }

        return $query->execute();
    }
}
