<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Plugin;

class VendorExtension
{
    /**
     * @var \Training5\VendorRepository\Api\Data\VendorExtensionFactory
     */
    protected $_vendorExtensionFactory;

    /**
     * @var \Training5\VendorRepository\Model\ResourceModel\Vendor
     */
    protected $_vendorResource;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @param \Training5\VendorRepository\Api\Data\VendorExtensionFactory $vendorExtensionFactory
     * @param \Training5\VendorRepository\Model\ResourceModel\Vendor $vendorResource
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Training5\VendorRepository\Api\Data\VendorExtensionFactory $vendorExtensionFactory,
        \Training5\VendorRepository\Model\ResourceModel\Vendor $vendorResource,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->_vendorExtensionFactory = $vendorExtensionFactory;
        $this->_vendorResource = $vendorResource;
        $this->_productRepository = $productRepository;
    }

    /**
     * Saves associated products via resource model
     *
     * @param \Training5\VendorRepository\Model\Vendor $vendor
     * @return \Training5\VendorRepository\Model\Vendor
     */
    public function afterSave(\Training5\VendorRepository\Model\Vendor $vendor)
    {
        $productIds = array_map(function($product) {
            return $product->getId();
        }, $vendor->getProducts());
        $this->_vendorResource->saveAssociatedProductIds($vendor, $productIds);

        return $vendor;
    }

    /**
     * Loads associated products onto vendor model
     *
     * @param \Training5\VendorRepository\Model\Vendor $vendor
     * @return \Training5\VendorRepository\Model\Vendor
     */
    public function afterLoad(\Training5\VendorRepository\Model\Vendor $vendor)
    {
        // Get extension object
        $vendorExtension = $vendor->getExtensionAttributes();
        if ($vendorExtension === null) {
            $vendorExtension = $this->_vendorExtensionFactory->create();
        }

        // Gather associated products
        $productIds = $this->_vendorResource->getAssociatedProductIds($vendor);
        $products = [];
        foreach($productIds as $id) {
            $products[$id] = $this->_productRepository->getById($id);
        }

        // Set products on extension object
        $vendorExtension->setProducts($products);
        $vendor->setExtensionAttributes($vendorExtension);
        return $vendor;
    }
}