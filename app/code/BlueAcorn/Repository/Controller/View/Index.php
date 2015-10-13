<?php
namespace BlueAcorn\Repository\Controller\View;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;

class Index extends Action
{
	private $productRepository;
	private $searchCriteriaBuilder;
    private $sortOrderBuilder;

	public function __construct(
		Context $context,
		ProductRepositoryInterface $productRepository,
		SearchCriteriaBuilder $searchCriteriaBuilder,
		SortOrderBuilder $sortOrderBuilder
	) {
		parent::__construct($context);
		$this->productRepository = $productRepository;
		$this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
	}

	public function execute()
	{
		$products = $this->getProductsFromRepository();
        $list = array();

        foreach($products as $product)
        {
            $list[] = $product->getName() . ': ' . $product->getSku();
        }

		$html = '<h1>Repository Whaddup</h1><ul><li>' . implode($list, '</li><li>') . '</li></ul>';
		$this->getResponse()->appendBody($html);
	}

	protected function getProductsFromRepository()
	{
        // Set filters
		$this->searchCriteriaBuilder->addFilter('type_id', ConfigurableType::TYPE_CODE);
		$this->searchCriteriaBuilder->addFilter('name', '%Yoga%', 'like');
        // Set sort
		$this->searchCriteriaBuilder->addSortOrder(
			$this->sortOrderBuilder->setField('name')->setAscendingDirection()->create()
		);
        // Set paging limit
        $page = $this->getRequest()->getParam('p') ?: 1;
        $this->searchCriteriaBuilder->setPageSize(6);
        $this->searchCriteriaBuilder->setCurrentPage($page);

        // Get list with search criteria
		$criteria = $this->searchCriteriaBuilder->create();
		$products = $this->productRepository->getList($criteria);

		return $products->getItems();
	}
}






