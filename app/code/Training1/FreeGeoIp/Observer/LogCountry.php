<?php

namespace Training1\FreeGeoIp\Observer;

use Magento\Framework\Event\Observer as FrameworkObserver;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\ObserverInterface;

class LogCountry implements ObserverInterface
{
    protected $_logger = null;
    protected $_curl = null;
    protected $_context = null;
    protected $_decoder = null;
    const URL = 'freegeoip.net/json/';

    /**
     * Pass logger to observer
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Json\Decoder $decoder
    )
    {
        $this->_logger = $logger;
        $this->_curl = $curl;
        $this->_context = $context;
        $this->_decoder = $decoder;
    }

    public function execute(FrameworkObserver $observer)
    {
        if ($ip = $this->_context->getRemoteAddress()->getRemoteAddress()) {
            if ($country = $this->_getCountry($ip)) {
                $this->_logger->debug($country);
            }
        }
    }

    protected function _getCountry($ip)
    {
        // Make GET request to freegeoip
        $this->_curl->get(static::URL . $this->_context->getRemoteAddress()->getRemoteAddress());

        // Decode result
        if ($body = $this->_curl->getBody()) {
            $result = $this->_decoder->decode($body);
        } else {
            $result = false;
        }

        // Extract country from result
        if (!$result || !is_array($result)) {
            return false;
        } else {
            return (isset($result['country_name'])) ? $result['country_name'] : false;
        }
    }

}