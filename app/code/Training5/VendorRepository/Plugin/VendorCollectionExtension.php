<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Training5\VendorRepository\Api\Data\VendorExtensionFactory;
use Training5\VendorRepository\Model\ResourceModel\Vendor as VendorResource;
use Training5\VendorRepository\Model\ResourceModel\Vendor\Collection as VendorCollection;

class VendorCollectionExtension
{
    /**
     * @var VendorExtensionFactory
     */
    protected $_vendorExtensionFactory;

    /**
     * @var VendorResource
     */
    protected $_vendorResource;

    /**
     * @var ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @param VendorExtensionFactory $vendorExtensionFactory
     * @param VendorResource $vendorResource
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        VendorExtensionFactory $vendorExtensionFactory,
        VendorResource $vendorResource,
        ProductRepositoryInterface $productRepository
    ) {
        $this->_vendorExtensionFactory = $vendorExtensionFactory;
        $this->_vendorResource = $vendorResource;
        $this->_productRepository = $productRepository;
    }

    /**
     * Loads associated products onto vendor model
     *
     * @param VendorCollection $subject
     * @return \Training5\VendorRepository\Model\Vendor
     */
    public function aroundLoad(VendorCollection $subject, \Closure $proceed, $printQuery = false, $logQuery = false)
    {
        $skip = $subject->isLoaded() || !$subject->getFlag(VendorCollection::ADD_PRODUCTS_FLAG);
        $proceed($printQuery, $logQuery);
        if ($skip) {
            return $subject;
        }
        foreach ($subject->getItems() as $vendor) {
            // Gather products
            $productIds = $this->_vendorResource->getAssociatedProductIds($vendor);
            $products = [];
            foreach($productIds as $id) {
                $products[$id] = $this->_productRepository->getById($id);
            }
            // Set products on extension object
            $vendorExtension = $vendor->getExtensionAttributes();
            if ($vendorExtension === null) {
                $vendorExtension = $this->_vendorExtensionFactory->create();
            }
            $vendorExtension->setProducts($products);
            $vendor->setExtensionAttributes($vendorExtension);
        }
        return $subject;
    }
}
