<?php
/**
 * @package     Training5\VendorRepository
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training5\VendorRepository\Api\Data;

interface VendorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface {
    /**
     * Get items list.
     *
     * @return \Training5\VendorRepository\Api\Data\VendorInterface[]
     */
    public function getItems();

    /**
     * Set items list.
     *
     * @param \Training5\VendorRepository\Api\Data\VendorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}