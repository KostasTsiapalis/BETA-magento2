<?php
/**
 * @package     Training2\OrderController
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training2\OrderController\Controller\Order;

class Json extends \Magento\Framework\App\Action\Action {
    /**
     * @var \Magento\Framework\App\Action\Context
     */
    protected $_context;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_pageFactory;

    /**
     * @var \Training2\OrderController\Helper\Training2
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\Json\EncoderInterface
     */
    protected $_jsonEncoder;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Training2\OrderController\Helper\Training2 $helper
     * @param \Magento\Framework\Json\EncoderInterface $encoder
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Training2\OrderController\Helper\Training2 $helper,
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
        $orderId = $this->getRequest()->getParam('orderId');

        /**
         * @var array
         */
        $orderData = array('response'=>null);

        // Load order data associated to the incrementid
        if ($orderId) {
            $orderData['response'] = $this->_helper->getOrderData($orderId);
        } else {
            $orderData = array('response' => 'error');
        }

        // Set response to with JSON string
        $this->getResponse()->representJson($this->_jsonEncoder->encode($orderData));

        return;
    }
}