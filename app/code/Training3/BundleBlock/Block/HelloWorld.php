<?php
/**
 * @package     Training3\BundleBlock
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training3\BundleBlock\Block;

class HelloWorld extends \Magento\Framework\View\Element\Template {
    public function sayHello() {
        return "Hello World";
    }
}
