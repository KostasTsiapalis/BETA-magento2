<?php
namespace BlueAcorn\Repository\Model;
use Magento\Framework\Api\SearchCriteriaInterface;
use BlueAcorn\Repository\Api\Data\ExampleInterface;
use BlueAcorn\Repository\Api\Data\ExampleInterfaceFactory as ExampleDataFactory;
use BlueAcorn\Repository\Api\Data\ExampleSearchResultsInterface;
use BlueAcorn\Repository\Api\Data\ExampleSearchResultsInterfaceFactory;
use BlueAcorn\Repository\Api\ExampleRepositoryInterface;
use BlueAcorn\Repository\Model\Example as ExampleModel;
use BlueAcorn\Repository\Model\Resource\Example\Collection as ExampleCollection;

class ExampleRepository implements ExampleRepositoryInterface
{
    /**
     * @var ExampleSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;
    /**
     * @var ExampleFactory
     */
    private $exampleFactory;
    /**
     * @var ExampleDataFactory
     */
    private $exampleDataFactory;

    public function __construct(
        ExampleSearchResultsInterfaceFactory $searchResultsFactory,
        ExampleFactory $exampleFactory,
        ExampleDataFactory $exampleDataFactory
    ) {
        foreach(['searchResultsFactory', 'exampleFactory', 'exampleDataFactory'] as $objectName) {
            $this->$objectName = $$objectName;
        }
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var ExampleCollection $collection */
        $collection = $this->exampleFactory->create()->getCollection();
        /** @var ExampleSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $this->applyCriteriaToCollection($searchCriteria, $collection);
        $examples = $this->convertCollectionToArray($collection);

        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($examples);

        return $searchResults;
    }

    protected function applyCriteriaToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        foreach(['Filters', 'SortOrders', 'Paging'] as $criteria) {
            $applyCriteria = '_applySearchCriteria' . $criteria . 'ToCollection';
            $this->$applyCriteria($searchCriteria, $collection);
        }
    }

    protected function convertCollectionToArray(ExampleCollection $collection)
    {
        $examples = array_map(function (ExampleModel $example) {
            /** @var ExampleInterface $dataObject */
            $dataObject = $this->exampleDataFactory->create();
            $dataObject->setId($example->getId());
            $dataObject->setName($example->getName());
            $dataObject->setCreatedAt($example->getCreatedAt());
            $dataObject->setModifiedAt($example->getModifiedAt());
            return $dataObject;
        }, $collection->getItems());
        return $examples;
    }

    private function _applySearchCriteriaFiltersToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        foreach($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = [];
            $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $fields[] = $filter->getField();
                $conditions[] = [$condition => $filter->getValue()];
            }
            if ($fields) {
                $collection->addFieldToFilter($fields, $conditions);
            }
        }
    }

    private function _applySearchCriteriaSortOrdersToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        $sortOrders = $searchCriteria->getSortOrders() ?: [];
        foreach ($sortOrders as $sortOrder) {
            $collection->addOrder(
                $sortOrder->getField(),
                $sortOrder->getDirection()
            );
        }
    }

    private function _applySearchCriteriaPagingToCollection(
        SearchCriteriaInterface $searchCriteria,
        ExampleCollection $collection
    ) {
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }
}






