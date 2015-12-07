<?php
/**
 * @package     Training4\Warranty
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training4\Warranty\Model\Product\Attribute\Frontend;

class Warranty extends \Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend {

    /**
     * Retrieve attribute value
     *
     * @param \Magento\Framework\DataObject $object
     * @return mixed
     */
    public function getValue(\Magento\Framework\DataObject $object)
    {
        return '<strong>' . parent::getValue($object) . '</strong>';
    }
}