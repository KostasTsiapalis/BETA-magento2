<?php
namespace BlueAcorn\Repository\Controller\View;

use BlueAcorn\Repository\Api\ExampleRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Custom extends Action
{
	private $exampleRepository;
	private $searchCriteriaBuilder;
	private $filterBuilder;

	public function __construct(
		Context $context,
		ExampleRepositoryInterface $exampleRepository,
		SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder
	) {
		parent::__construct($context);
		$this->exampleRepository = $exampleRepository;
		$this->searchCriteriaBuilder = $searchCriteriaBuilder;
		$this->filterBuilder = $filterBuilder;
	}

	public function execute()
	{
		$filters = array_map(function ($name) {
			return $this->filterBuilder
				->setConditionType('eq')
				->setField('name')
				->setValue($name)
				->create();
		}, ['Foo', 'Bar', 'Baz', 'Qux']);

		$this->searchCriteriaBuilder->addFilters($filters);
		$examples = $this->exampleRepository->getList(
			$this->searchCriteriaBuilder->create()
		)->getItems();

        foreach($examples as $example) {
            $list[] = $example->getId() . ': ' . $example->getName();
        }

		$html = '<h1>Custom Repository Whaddup</h1><ul><li>' . implode($list, '</li><li>') . '</li></ul>';
		$this->getResponse()->appendBody($html);
	}
}






