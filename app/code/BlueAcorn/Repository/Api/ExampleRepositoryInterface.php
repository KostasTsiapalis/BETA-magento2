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
}