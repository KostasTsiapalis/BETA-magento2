<?php
/**
 * @package     Training4\VendorList
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\VendorList\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface VendorInterface extends ExtensibleDataInterface
{
    const VENDOR_ID = 'vendor_id';

    const VENDOR_NAME = 'name';

    /**
     * Retrieve vendor identifier
     *
     * @return int
     */
    public function getVendorId();

    /**
     * Set vendor identifier
     *
     * @param int $vendorId
     * @return $this
     */
    public function setVendorId($vendorId);

    /**
     * Retrieve vendor name
     *
     * @return string
     */
    public function getVendorName();

    /**
     * Set vendor name
     *
     * @param string $vendorName
     * @return $this
     */
    public function setVendorName($vendorName);

    /**
     * Get associated products
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]|null
     */
    public function getProducts();

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Training4\VendorList\Api\Data\VendorExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Training4\VendorList\Api\Data\VendorExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Training4\VendorList\Api\Data\VendorExtensionInterface $extensionAttributes
    );
}
