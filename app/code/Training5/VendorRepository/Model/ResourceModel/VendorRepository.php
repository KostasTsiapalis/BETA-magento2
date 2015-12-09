<?php
/**
 * @package     Training5\VendorRepository
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training5\VendorRepository\Model\ResourceModel;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Webapi\Exception;
use Training5\VendorRepository\Api\Data\VendorInterface;
use Training5\VendorRepository\Api\Data\VendorInterfaceFactory;
use Training5\VendorRepository\Api\Data\VendorSearchResultsInterfaceFactory;
use Training5\VendorRepository\Model\ResourceModel\Vendor as VendorResource;
use Training5\VendorRepository\Model\ResourceModel\Vendor\Collection as VendorCollection;
use Training5\VendorRepository\Model\Vendor as VendorModel;
use Training5\VendorRepository\Model\VendorFactory;

class VendorRepository implements VendorRepositoryInterface
{
    /**
     * @var VendorFactory
     */
    private $_vendorFactory;

    /**
     * @var VendorInterfaceFactory
     */
    private $_vendoryInterfaceFactory;

    /**
     * @var VendorSearchResultsInterfaceFactory
     */
    private $_searchResultsFactory;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $_extensibleDataObjectConverter;

    /**
     * @var VendorResource
     */
    private $_vendorResource;

    /**
     * @var DataObjectHelper
     */
    private $_dataObjectHelper;

    /**
     * @param VendorFactory $vendorFactory
     * @param VendorResource $vendorResource
     * @param VendorInterfaceFactory $vendorInterfaceFactory
     * @param VendorSearchResultsInterfaceFactory $searchResultsFactory
     * @param ExtensibleDataObjectConverter $extensibleDataObjectConverter
     * @param DataObjectHelper $dataObjectHelper
     */
    public function __construct(
        VendorFactory $vendorFactory,
        VendorResource $vendorResource,
        VendorInterfaceFactory $vendorInterfaceFactory,
        VendorSearchResultsInterfaceFactory $searchResultsFactory,
        ExtensibleDataObjectConverter $extensibleDataObjectConverter,
        DataObjectHelper $dataObjectHelper
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
     * @return VendorInterface
     * @throws NoSuchEntityException
     */
    public function load($id)
    {
        /** @var VendorModel $vendorModel */
        $vendorModel = $this->_vendorFactory->create()->load($id);
        if (!$vendorModel->getId()) {
            throw new NoSuchEntityException(__('Vendor with id "%1" does not exist.', $id));
        }
        $vendorData = $vendorModel->getData();
        $products = $vendorModel->getProducts();

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
     * @param VendorInterface $vendor
     * @return VendorInterface
     */
    public function save(VendorInterface $vendor)
    {
        $this->_validate($vendor);

        // Get vendor data from $vendor
        $products = $vendor->getProducts();
        $vendor->setProducts([]);
        $vendorData = $this->_extensibleDataObjectConverter->toNestedArray(
            $vendor,
            [],
            '\Training5\VendorRepository\Api\Data\VendorInterface'
        );
        $vendor->setProducts($products);

        /** @var VendorModel $vendorModel */
        $vendorModel = $this->_vendorFactory->create(['data' => $vendorData])
            ->setProducts($products)
            ->setId($vendor->getVendorId())
            ->save();

        return $vendor->setVendorId($vendorModel->getId());
    }

    /**
     * Retrieve vendors which match a specified criteria.
     *
     * @api
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Training5\VendorRepository\Api\Data\VendorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria) {}

    /**
     * Retrieve products associated to a specific vendor
     *
     * @api
     * @param VendorInterface $vendor
     * @return int[]
     */
    public function getAssociatedProductIds(\Training5\VendorRepository\Api\Data\VendorInterface $vendor) {}

    /**
     * Validate data on $vendor object before saving
     *
     * @param VendorInterface $vendor
     * @throws InputException
     * @throws \Exception
     * @throws \Zend_Validate_Exception
     */
    private function _validate(VendorInterface $vendor)
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
