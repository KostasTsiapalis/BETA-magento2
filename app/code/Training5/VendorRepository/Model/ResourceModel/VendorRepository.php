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
use Training5\VendorRepository\Api\Data\VendorSearchResultsInterface;
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
        return $this->_getDataObject($vendorModel);
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
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var VendorSearchResultsInterface $searchResults */
        $searchResults = $this->_searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        /** @var VendorCollection $collection */
        $collection = $this->_vendorFactory->create()->getCollection();
        $this->_applyCriteriaToCollection($searchCriteria, $collection);

        /** @var VendorInterface[] $vendors */
        $vendors = $this->_convertCollectionToArray($collection);

        $searchResults->setItems($vendors);
        $searchResults->setTotalCount(count($vendors));

        return $searchResults;
    }

    /**
     * Retrieve product ids associated to a specific vendor
     * Easier than intended because I already have products living on VendorInterface implementation
     *
     * @api
     * @param VendorInterface $vendor
     * @return int[]
     */
    public function getAssociatedProductIds(VendorInterface $vendor)
    {
        return array_map(function($product) {
            return $product->getId();
        }, $vendor->getProducts());
    }

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

    /**
     * Create data object (preferred VendorInterface implementation) from vendor model
     *
     * @param VendorModel $vendorModel
     * @return mixed
     */
    private function _getDataObject(VendorModel $vendorModel)
    {
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
     * Apply all search criteria items to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param VendorCollection $collection
     */
    private function _applyCriteriaToCollection(
        SearchCriteriaInterface $searchCriteria,
        VendorCollection $collection
    ) {
        foreach(['Filters', 'SortOrders', 'Paging'] as $criteria) {
            $applyCriteria = '_applySearchCriteria' . $criteria . 'ToCollection';
            $this->$applyCriteria($searchCriteria, $collection);
        }
    }

    /**
     * Convert collection into array of data objects
     *
     * @param VendorCollection $collection
     * @return array
     */
    private function _convertCollectionToArray(VendorCollection $collection)
    {
        return array_map(array($this, '_getDataObject'), $collection->getItems());
    }

    /**
     * Apply all filter groups to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param VendorCollection $collection
     */
    private function _applySearchCriteriaFiltersToCollection(
        SearchCriteriaInterface $searchCriteria,
        VendorCollection $collection
    ) {
        foreach($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() == 'product_id') {
                    $collection->addProductFilter($filter->getValue());
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $fields[] = ['attribute' => $filter->getField(), $condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields);
            }
        }
    }

    /**
     * Apply all sorting options to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param VendorCollection $collection
     */
    private function _applySearchCriteriaSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        VendorCollection $collection
    ) {
        $sortOrders = $searchCriteria->getSortOrders() ?: [];
        foreach ($sortOrders as $sortOrder) {
            $collection->addOrder(
                $sortOrder->getField(),
                $sortOrder->getDirection()
            );
        }
    }

    /**
     * Apply all paging options to collection
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param ExampleCollection $collection
     */
    private function _applySearchCriteriaPagingToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }
}
