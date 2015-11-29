<?php
/**
 * @package     Training3\OrderInfo
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training3\OrderInfo\Controller\Order;

class Json extends \Magento\Framework\App\Action\Action {
    const JSON_FLAG = '1';

    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $_context;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Training3\OrderInfo\Helper\Training3
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * @var string
     */
    protected $_orderId;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Training3\OrderInfo\Helper\Training3 $helper
     * @param \Magento\Framework\Json\EncoderInterface $encoder
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Training3\OrderInfo\Helper\Training3 $helper,
        \Magento\Framework\Json\EncoderInterface $encoder

    ) {
        $this->_context = $context;
        $this->_pageFactory = $pageFactory;
        $this->_helper = $helper;
        $this->_jsonEncoder = $encoder;

        parent::__construct($context);
    }

    public function execute() {
        /**
         * Load orderId from request
         * @var array
         */
        $this->_orderId = $this->getRequest()->getParam('orderId');

        /**
         * Load json flag from request
         * @var string
         */
        $json = $this->getRequest()->getParam('json');

        switch ($json) {
            case self::JSON_FLAG:
                $page = $this->renderJson();
                break;
            default:
                $page = $this->renderPage();
        }

        return $page;
    }

    /**
     * Render JSON as page result
     */
    protected function renderJson() {
        /**
         * @var array
         */
        $orderData = array('response'=>null);

        // Load order data associated to the incrementid
        if ($this->_orderId) {
            $orderData['response'] = $this->_helper->getOrderData($this->_orderId);
        } else {
            $orderData = array('response' => 'error');
        }

        // Set response to with JSON string
        $this->getResponse()->representJson($this->_jsonEncoder->encode($orderData));

        return null;
    }

    /**
     * Render page
     */
    protected function renderPage() {
        $page = $this->_pageFactory->create(false);
        return $page;
    }
}