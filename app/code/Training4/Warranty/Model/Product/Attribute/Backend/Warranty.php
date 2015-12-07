<?php
/**
 * @package     Training4\Warranty
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training4\Warranty\Model\Product\Attribute\Backend;

class Warranty extends \Magento\Eav\Model\Entity\Attribute\Backend\AbstractBackend {
    /**
     * Before save method
     *
     * @param \Magento\Framework\DataObject $object
     * @return $this
     */
    public function beforeSave($object)
    {
        $attrCode = $this->getAttribute()->getAttributeCode();
        if ($object->hasData($attrCode)) {
            $value = $object->getData($attrCode);
            if (strpos($value, 'year') === false) {
                $object->setData($attrCode, trim($value) . ' year(s)');
            }
        }

        return $this;
    }
}
