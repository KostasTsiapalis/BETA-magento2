<?php

namespace BlueAcorn\Repository\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ExampleRepositoryInterface
{
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return Data\ExampleSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param int $id
     * @return \BlueAcorn\Repository\Api\Data\ExampleInterface
     */
    public function get($id);
}