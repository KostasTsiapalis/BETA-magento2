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
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteriaBuilder
     */
    protected $_searchCriteriaBuilder;


    /**
     * Fields to control data structure of getOrderData return
     * @var array
     */
    protected $_orderFields = array(OrderInterface::STATUS,OrderInterface::GRAND_TOTAL,OrderInterface::TOTAL_INVOICED);
    protected $_itemFields = array(OrderItemInterface::SKU,OrderItemInterface::ITEM_ID,OrderItemInterface::PRICE);

    /**
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(\Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder,
        \Magento\Framework\App\Helper\Context $context
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context);
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
        $this->_searchCriteriaBuilder->addFilter('increment_id', $orderId);
        $orders = $this->_orderRepository->getList(
            $this->_searchCriteriaBuilder->create()
        )->getItems();

        // Check existence of order loaded
        if (count($orders)) {
            $order = reset($orders);
            // Gather order fields
            foreach($this->_orderFields as $field) {
                $getter = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
                $data[$field] = $order->$getter();
            }

            // Gather order item fields for each item in order
            foreach($order->getItems() as $item) {
                foreach($this->_itemFields as $field) {
                    $getter = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $field)));
                    $data['items'][$item->getItemId()][$field] = $item->$getter();
                }
            }
        }

        return $data;
    }
}
