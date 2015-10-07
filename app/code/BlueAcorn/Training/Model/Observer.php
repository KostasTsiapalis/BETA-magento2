<?php

namespace BlueAcorn\Training\Model;

use Magento\Framework\Event\Observer as FrameworkObserver;
use Psr\Log\LoggerInterface;

class Observer
{
    protected $_logger = null;

    /**
     * Pass logger to observer
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function logChangedData(FrameworkObserver $observer)
    {
        $product = $observer->getProduct();
        $message = "Product {$product->getId()} - data changes: ";
        if (!$product->hasDataChanges()) {
            $message .= 'none.';
        } else {
            $keys = array_keys($product->getData());
            foreach($keys as $key) {
                if ($product->dataHasChangedFor($key)) {
                    $message .= "\n\t$key";
                }
            }
        }
        $this->_logger->debug($message);
    }
}