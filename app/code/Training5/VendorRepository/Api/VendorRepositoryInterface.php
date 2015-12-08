<?php
/**
 * @package     Training5\VendorRepositoryInterface
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training5\VendorRepository\Api;

interface VendorRepositoryInterface {
    /**
     * Retrieve vendor.
     *
     * @api
     * @param int $id
     * @return \Training5\VendorRepository\Api\Data\VendorInterface
     */
    public function load($id);

    /**
     * Create vendor.
     *
     * @api
     * @param \Training5\VendorRepository\Api\Data\VendorInterface $vendor
     * @return \Training5\VendorRepository\Api\Data\VendorInterface
     */
    public function save(\Training5\VendorRepository\Api\Data\VendorInterface $vendor);

    /**
     * Retrieve vendors which match a specified criteria.
     *
     * @api
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Training5\VendorRepository\Api\Data\VendorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve products associated to a specific vendor
     *
     * @api
     * @param \Training5\VendorRepository\Api\Data\VendorInterface $vendor
     * @return int[]
     */
    public function getAssociatedProductIds(\Training5\VendorRepository\Api\Data\VendorInterface $vendor);
}