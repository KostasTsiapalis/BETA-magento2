<?php

namespace Training1\FreeGeoIp\Model;

use Magento\Framework\Event\Observer as FrameworkObserver;
use Psr\Log\LoggerInterface;
use Magento\Framework\Event\ObserverInterface;

class Observer implements ObserverInterface
{
    const FREE_GEO_IP_URL = 'freegeoip.net/json/';

    protected $_logger = null;
    protected $_curl = null;
    protected $_context = null;
    protected $_decoder = null;

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
        $ip = $observer->getRequest();
        $countryName = $this->_getAddressData();
        $this->_logger->debug($countryName);
    }

    protected function _getAddressData()
    {
        $url = self::FREE_GEO_IP_URL . $this->_context->getRemoteAddress()->getRemoteAddress();
        $this->_curl->get($url);
        $result = $this->_decoder->decode($this->_curl->getBody());

        return $result['country_name'];


    }

}