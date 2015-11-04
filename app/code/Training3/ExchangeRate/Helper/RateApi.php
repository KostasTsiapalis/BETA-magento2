<?php
/**
 * @package     ${MAGENTO_MODULE_NAMESPACE}\\${MAGENTO_MODULE}
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training3\ExchangeRate\Helper;

class RateApi extends \Magento\Framework\App\Helper\AbstractHelper {
    const URL = 'api.fixer.io/latest';
    const BASE_USD = 'USD';

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    protected $_curl;

    /**
     * @var \Magento\Framework\Json\Decoder
     */
    protected $_decoder;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\Json\Decoder $decoder
    ) {
        parent::__construct($context);
        $this->_curl = $curl;
        $this->_decoder = $decoder;
    }

    public function getExchangeRates($base, $target) {
        $this->_curl->get(static::URL . '?base=' . $base);

        // Decode result
        if ($body = $this->_curl->getBody()) {
            $result = $this->_decoder->decode($body);
        } else {
            $result = false;
        }

        // Extract rate from result
        if (!$result || !is_array($result)) {
            return false;
        } else {
            return (isset($result['rates'][$target])) ? $result['rates'][$target] : false;
        }
    }
}