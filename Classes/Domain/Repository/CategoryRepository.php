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
        $defaultQuerySettings->setRespectStoragePage(true);
        $defaultQuerySettings->setStoragePageIds([136]);
        \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
            array(
                'details' => array('@' => date('Y-m-d H:i:s'), 'class' => __class__, 'function' => __FUNCTION__, 'file' => __FILE__, 'line' => __LINE__),
                'defaultQuerySettings' => $defaultQuerySettings,
            ),
            date('Y-m-d H:i:s') . ' : ' . __METHOD__ . ' : ' . __LINE__
        );
    }
}
