<?php
/**
 * @package     Training2\\Specific404Page
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training2\Specific404Page\App\Router;

class Specific404Handler implements \Magento\Framework\App\Router\NoRouteHandlerInterface {
    /**
     * @param \Magento\Backend\Helper\Data $helper
     * @param \Magento\Framework\App\Route\ConfigInterface $routeConfig
     */
    public function __construct(
        \Magento\Framework\App\Route\ConfigInterface $routeConfig
    ) {
        $this->routeConfig = $routeConfig;
    }

    /**
     * Check and process no route request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function process(\Magento\Framework\App\RequestInterface $request) {
        $actionName = $request->getOriginalPathInfo();
        if (strpos($actionName, 'catalog/product/view/id') !== false
            || strpos($actionName, 'catalog/category/view/id') !== false
            || strpos($actionName, 'sales/order/view/order_id') !== false
        ) {
            $request->setModuleName('training2')->setControllerName('default')->setActionName('no_route');
            return true;
        }
    }
}