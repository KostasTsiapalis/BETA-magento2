<?php
/**
 * @package     Training5\VendorRepository
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training5\VendorRepository\Model\ResourceModel;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Webapi\Exception;

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
     * @var \Training5\VendorRepository\Model\ResourceModel\Vendor
     */
    private $_vendorResource;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    private $_dataObjectHelper;

    /**
     * @param \Training5\VendorRepository\Model\VendorFactory $vendorFactory
     * @param Vendor $vendorResource
     * @param \Training5\VendorRepository\Api\Data\VendorInterfaceFactory $vendorInterfaceFactory
     * @param \Training5\VendorRepository\Api\Data\VendorSearchResultsInterfaceFactory $searchResultsFactory
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        \Training5\VendorRepository\Model\VendorFactory $vendorFactory,
        \Training5\VendorRepository\Model\ResourceModel\Vendor $vendorResource,
        \Training5\VendorRepository\Api\Data\VendorInterfaceFactory $vendorInterfaceFactory,
        \Training5\VendorRepository\Api\Data\VendorSearchResultsInterfaceFactory $searchResultsFactory,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper
    ) {
        $this->_vendorFactory = $vendorFactory;
        $this->_vendorResource = $vendorResource;
        $this->_vendoryInterfaceFactory = $vendorInterfaceFactory;
        $this->_searchResultsFactory = $searchResultsFactory;
        $this->_extensibleDataObjectConverter = $extensibleDataObjectConverter;
        $this->_dataObjectHelper = $dataObjectHelper;
    }

    /**
     * Retrieve vendor.
     *
     * @api
     * @param int $id
     * @return \Training5\VendorRepository\Api\Data\VendorInterface
     * @throws NoSuchEntityException
     */
    public function load($id)
    {
        $vendorModel = $this->_vendorFactory->create()->load($id);
        if (!$vendorModel->getId()) {
            throw new NoSuchEntityException(__('Vendor with id "%1" does not exist.', $id));
        }
        $vendorData = $vendorModel->getData();
        $products = $vendorModel->getExtensionAttributes()->getProducts();

        $vendorDataObject = $this->_vendoryInterfaceFactory->create();
        $this->_dataObjectHelper->populateWithArray(
            $vendorDataObject,
            $vendorData,
            '\Magento\Customer\Api\Data\CustomerInterface'
        );
        $vendorDataObject->setProducts($products)
            ->setVendorId($vendorModel->getId());

        return $vendorDataObject;
    }

    /**
     * Create/update vendor.
     *
     * @api
     * @param \Training5\VendorRepository\Api\Data\VendorInterface $vendor
     * @return \Training5\VendorRepository\Api\Data\VendorInterface
     */
    public function save(\Training5\VendorRepository\Api\Data\VendorInterface $vendor)
    {
        $this->validate($vendor);

        // Get vendor data from $vendor
        $products = $vendor->getProducts();
        $vendor->setProducts([]);
        $vendorData = $this->_extensibleDataObjectConverter->toNestedArray(
            $vendor,
            [],
            '\Training5\VendorRepository\Api\Data\VendorInterface'
        );
        $vendor->setProducts($products);

        $vendorModel = $this->_vendorFactory->create(['data' => $vendorData])
            ->getExtensionAttributes()->setProducts($products)
            ->setId($vendor->getVendorId())
            ->save();

        return $vendor->setVendorId($vendorModel->getId());
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

    /**
     * Validate data on $vendor object before saving
     *
     * @param \Training5\VendorRepository\Api\Data\VendorInterface $vendor
     * @throws InputException
     * @throws \Exception
     * @throws \Zend_Validate_Exception
     */
    private function validate(\Training5\VendorRepository\Api\Data\VendorInterface $vendor)
    {
        $exception = new InputException();
        if (!\Zend_Validate::is(trim($vendor->getVendorName()), 'NotEmpty')) {
            $exception->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => 'name']));
        }

        if ($exception->wasErrorAdded()) {
            throw $exception;
        }
    }
}
