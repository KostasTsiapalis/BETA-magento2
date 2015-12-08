<?php
/**
 * @package     Training5\VendorRepository
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training5\VendorRepository\Model\ResourceModel;

class VendorRepository implements VendorRepositoryInterface
{
    /**
     * @var \Training5\VendorRepository\Model\VendorFactory
     */
    private $_vendorFactory;

    /**
     * @var \Training5\VendorRepository\Api\Data\VendorInterfaceFactory
     */
    private $_vendoryInterfaceFactory;

    /**
     * @var \Training5\VendorRepository\Api\Data\VendorSearchResultsInterfaceFactory
     */
    private $_searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    private $_extensibleDataObjectConverter;

    /**
     * @param \Training5\VendorRepository\Model\VendorFactory $vendorFactory
     * @param \Training5\VendorRepository\Api\Data\VendorInterfaceFactory $vendorInterfaceFactory
     * @param \Training5\VendorRepository\Api\Data\VendorSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        \Training5\VendorRepository\Model\VendorFactory $vendorFactory,
        \Training5\VendorRepository\Api\Data\VendorInterfaceFactory $vendorInterfaceFactory,
        \Training5\VendorRepository\Api\Data\VendorSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->_vendorFactory = $vendorFactory;
        $this->_vendoryInterfaceFactory = $vendorInterfaceFactory;
        $this->_searchResultsFactory = $searchResultsFactory;
        $this->_extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }
    /**
     * Retrieve vendor.
     *
     * @api
     * @param int $id
     * @return \Training5\VendorRepository\Api\Data\VendorInterface
     */
    public function load($id) {
        return $this->_vendorFactory->create()->load($id);
    }

    /**
     * Create vendor.
     *
     * @api
     * @param \Training5\VendorRepository\Api\Data\VendorInterface $vendor
     * @return \Training5\VendorRepository\Api\Data\VendorInterface
     */
    public function save(\Training5\VendorRepository\Api\Data\VendorInterface $vendor) {
        $vendorData = $this->_extensibleDataObjectConverter->toNestedArray(
            $vendor,
            [],
            '\Training5\VendorRepository\Api\Data\VendorInterface'
        )
    }

    /**
     * Retrieve vendors which match a specified criteria.
     *
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training5\VendorRepository\Api\Data\VendorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria) {}

    /**
     * Retrieve products associated to a specific vendor
     *
     * @api
     * @param \Training5\VendorRepository\Api\Data\VendorInterface $vendor
     * @return int[]
     */
    public function getAssociatedProductIds(\Training5\VendorRepository\Api\Data\VendorInterface $vendor) {}
}
