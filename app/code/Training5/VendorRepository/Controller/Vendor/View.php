<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Controller\Vendor;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;
use Training5\VendorRepository\Api\VendorRepositoryInterface;

class View extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Training5\VendorRepository\Api\VendorRepositoryInterface
     */
    protected $_vendorRepository;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param Registry $registry
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        Registry $registry,
        VendorRepositoryInterface $vendorRepository
    ) {
        $this->_resultPageFactory = $pageFactory;
        $this->_coreRegistry = $registry;
        $this->_vendorRepository = $vendorRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // If no id parameter, go to list view
        if (!$id = $this->getRequest()->getParam('id')) {
            return $this->resultRedirectFactory->create()->setPath('*/*/listvendor');
        }

        // Register current requested vendor
        $vendor = $this->_vendorRepository->load($id);
        $this->_coreRegistry->register('vendor', $vendor);

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($vendor->getName());
        return $resultPage;
    }
}