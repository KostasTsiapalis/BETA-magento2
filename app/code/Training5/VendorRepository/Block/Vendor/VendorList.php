<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Block\Vendor;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Training5\VendorRepository\Api\VendorRepositoryInterface;

class VendorList extends Template
{
    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;

    /**
     * @var \Training5\VendorRepository\Api\VendorRepositoryInterface
     */
    protected $_vendorRepository;

    /**
     * @var \Magento\Framework\Api\SortOrderBuilder
     */
    protected $_sortOrderBuilder;

    /**
     * Initialize block with context and registry access
     *
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param VendorRepositoryInterface $vendorRepository
     * @param SortOrderBuilder $sortOrderBuilder
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        VendorRepositoryInterface $vendorRepository,
        SortOrderBuilder $sortOrderBuilder,
        Context $context,
        array $data = []
    ) {
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_vendorRepository = $vendorRepository;
        $this->_sortOrderBuilder = $sortOrderBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Get vendors filtered and sorted by user input or defaults
     *
     * @return \Training5\VendorRepository\Api\Data\VendorInterface[]
     */
    public function getVendors()
    {
        /** @var \Training5\VendorRepository\Block\Vendor\VendorList\Toolbar $toolbar */
        $toolbar = $this->getChildBlock('vendor.list.toolbar');

        /** @var \Magento\Framework\Api\SortOrder $sortOrder */
        $sortOrder = $this->_sortOrderBuilder->setField($toolbar->getSortMode())
            ->setDirection($toolbar->getSortDir())
            ->create();
        $this->_searchCriteriaBuilder->addSortOrder($sortOrder);
        if ($searchQuery = $toolbar->getFilterLike()) {
            $this->_searchCriteriaBuilder->addFilter(
                'name',
                '%' . $searchQuery . '%',
                'like'
            );
        }

        return $this->_vendorRepository->getList($this->_searchCriteriaBuilder->create())->getItems();
    }

    /**
     * Get URL for vendor given vendor_id
     *
     * @param string $id
     * @return string
     */
    public function getVendorUrl($id = '')
    {
        return $this->getUrl('*/*/view', ['id' => $id]);
    }

    /**
     * Get child toolbar block html
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('vendor.list.toolbar');
    }
}
