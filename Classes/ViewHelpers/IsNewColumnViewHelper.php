<?php
namespace Pixelant\PxaItemList\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

/**
 * Class IsNewColumnViewHelper
 * @package Pixelant\PxaItemList\ViewHelpers
 */
class IsNewColumnViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * Initalize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('index', 'int', 'Loop index', true);
        $this->registerArgument('maxColumnItem', 'int', 'Max items in column', true);
        $this->registerArgument('defaultColumnItem', 'int', 'Max items in column default value', false, 5);
    }

    /**
     * Check fi new column
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return bool|mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $index = (int)$arguments['index'];
        $maxColumnItem = (int)$arguments['maxColumnItem'] ?: (int)$arguments['defaultColumnItem'];

        return $index > 0 && is_int($index / $maxColumnItem);
    }
}
