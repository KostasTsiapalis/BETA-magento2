<?php
/**
 * @package     ${MAGENTO_MODULE_NAMESPACE}\\${MAGENTO_MODULE}
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training3\ExchangeRate\Block;

class ExchangeRate extends \Magento\Framework\View\Element\Template {
    /**
     * @var \Training3\ExchangeRate\Helper\RateApi
     */
    protected $_api;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     * @param \Training3\ExchangeRate\Helper\RateApi $api
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = [],
        \Training3\ExchangeRate\Helper\RateApi $api
    ) {
        $this->_api = $api;
        parent::__construct($context, $data);
    }

    public function getExchangeRate($base, $target) {
        return $this->_api->getExchangeRates($base, $target);
    }
}