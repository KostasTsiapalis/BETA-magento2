<?php
/**
 * @package     Training3\OrderInfo
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training3\OrderInfo\Block;

class OrderInfo extends \Magento\Framework\View\Element\Template {
    /**
     * @var array
     */
    protected $_orderData;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     * @param \Training3\OrderInfo\Helper\Training3 $helper
     * @param \Magento\Framework\App\Request\Http $request
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = [],
        \Training3\OrderInfo\Helper\Training3 $helper,
        \Magento\Framework\App\Request\Http $request
    )
    {
        if ($request->getParam('orderId')) {
            $this->_orderData = $helper->getOrderData($request->getParam('orderId'));
        } else {
            $this->_orderData = null;
        }

        parent::__construct($context, $data);
    }

    /**
     * @return array|null
     */
    public function getOrderInfo()
    {
        return $this->_orderData;
    }

}