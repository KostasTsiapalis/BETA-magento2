<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Api\Data;

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
    public function getName();

    /**
     * Set vendor name
     *
     * @param string $vendorName
     * @return $this
     */
    public function setName($vendorName);

    /**
     * Get associated products
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]
     */
    public function getProducts();

    /**
     * Set associated products
     *
     * @param \Magento\Catalog\Api\Data\ProductInterface[]
     * @return $this
     */
    public function setProducts(array $products);

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Training5\VendorRepository\Api\Data\VendorExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * Set an extension attributes object.
     *
     * @param \Training5\VendorRepository\Api\Data\VendorExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Training5\VendorRepository\Api\Data\VendorExtensionInterface $extensionAttributes
    );
}
