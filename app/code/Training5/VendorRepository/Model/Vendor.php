<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Training5\VendorRepository\Api\Data\VendorInterface;

class Vendor extends AbstractExtensibleModel implements VendorInterface
{
    protected function _construct()
    {
        $this->_init('\Training5\VendorRepository\Model\ResourceModel\Vendor');
    }

    /**
     * Set an extension attributes object.
     *
     * @param \Training5\VendorRepository\Api\Data\VendorExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Training5\VendorRepository\Api\Data\VendorExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Training5\VendorRepository\Api\Data\VendorExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Retrieve vendor identifier
     *
     * @return int
     */
    public function getVendorId()
    {
        return $this->getData(VendorInterface::VENDOR_ID);
    }

    /**
     * Set vendor identifier
     *
     * @param int $vendorId
     * @return $this
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(VendorInterface::VENDOR_ID, $vendorId);
    }

    /**
     * Retrieve vendor name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getData(VendorInterface::VENDOR_NAME);
    }

    /**
     * Set vendor name
     *
     * @param string $vendorName
     * @return $this
     */
    public function setName($vendorName)
    {
        return $this->setData(VendorInterface::VENDOR_NAME, $vendorName);
    }

    /**
     * Get associated products
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getProducts()
    {
        return $this->getExtensionAttributes()
            ? $this->getExtensionAttributes()->getProducts()
            : [];
    }

    /**
     * Set associated products
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface[] $products
     * @return $this
     */
    public function setProducts(array $products)
    {
        ($this->getExtensionAttributes())
            ? $this->getExtensionAttributes()->setProducts($products)
            : $this->setExtensionAttributes();
        return $this;
    }
}