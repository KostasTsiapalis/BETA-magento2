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
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $config
     */
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $config)
    {
        $this->_config = $config;
    }

    /**
     * Check and process no route request
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @return bool
     */
    public function process(\Magento\Framework\App\RequestInterface $request) {
        $noRoutePath = $this->_config->getValue('web/default/training2_no_route', 'default');

        if ($noRoutePath) {
            $noRoute = explode('/', $noRoutePath);
        } else {
            $noRoute = [];
        }

        $moduleName = isset($noRoute[0]) ? $noRoute[0] : 'core';
        $actionPath = isset($noRoute[1]) ? $noRoute[1] : 'index';
        $actionName = isset($noRoute[2]) ? $noRoute[2] : 'index';

        $requestPath = $request->getOriginalPathInfo();
        if (strpos($requestPath, 'catalog/product/view/id') !== false
            || strpos($requestPath, 'catalog/category/view/id') !== false
            || strpos($requestPath, 'sales/order/view/order_id') !== false
        ) {
            $request->setModuleName($moduleName)->setControllerName($actionPath)->setActionName($actionName);
            return true;
        } else {
            return false;
        }
    }
}