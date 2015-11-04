<?php
/**
 * @package     Training2\OrderController
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training2\OrderController\Helper;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

class Training2 extends \Magento\Framework\App\Helper\AbstractHelper {
    /**
     * @var \Magento\Sales\Api\Data\OrderInterface
     */
    protected $_order;

    /**
     * Fields to control data structure of getOrderData return
     * @var array
     */
    protected $_orderFields = array(OrderInterface::STATUS,OrderInterface::GRAND_TOTAL,OrderInterface::TOTAL_INVOICED);
    protected $_itemFields = array(OrderItemInterface::SKU,OrderItemInterface::ITEM_ID,OrderItemInterface::PRICE);

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     */
    public function __construct(\Magento\Sales\Api\Data\OrderInterface $order) {

        $this->_order = $order;
    }

    /**
     * Gather order and order item data
     *
     * @param $orderId
     * @return array
     */
    public function getOrderData($orderId) {
        $data = array();

        // Load order by increment id
        $this->_order->loadByIncrementId($orderId);

        // Check existence of order loaded
        if ($this->_order->getId()) {
            // Gather order fields
            foreach($this->_orderFields as $field) {
                $data[$field] = $this->_order->getData($field);
            }

            // Gather order item fields for each item in order
            foreach($this->_order->getItemsCollection() as $item) {
                foreach($this->_itemFields as $field) {
                    $data['items'][$item->getItemId()][] = $item->getData($field);
                }
            }
        }

        return $data;
    }
}
