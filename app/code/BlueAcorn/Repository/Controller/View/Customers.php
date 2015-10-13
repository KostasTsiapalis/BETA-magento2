<?php
namespace BlueAcorn\Repository\Controller\View;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable as ConfigurableType;

class Customers extends Action
{
    private $customerRepository;
    private $searchCriteriaBuilder;
    private $filterBuilder;
    private $filterGroupBuilder;

    public function __construct(
        Context $context,
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        FilterGroupBuilder $filterGroupBuilder
    ) {
        parent::__construct($context);
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
    }

    public function execute()
    {
        $customers = $this->getCustomersList();
        $list = array();

        foreach ($customers as $customer) {
            $list[] = $customer->getFirstname() . ' ' . $customer->getLastname();
        }

        $html = '<h1>Customer Repository</h1>'
            . 'Repository Object Type:' . get_class($this->customerRepository) . '<br>';
        if (count($customers)) {
            $html .= 'Repository - Item Object Type:' . get_class($customers[0]) . '<br>'
                . '<ul><li>' . implode($list, '</li><li>') . '</li></ul>';
        }
        $this->getResponse()->appendBody($html);
    }

    protected function getCustomersList()
    {
        /*
        // Add filters
        foreach (array('firstname', 'lastname') as $nameField) {
            $this->filterGroupBuilder->addFilter(
                $this->filterBuilder->setField($nameField)->setConditionType('like')->setValue('%S')->create()
            );
        }
        $this->searchCriteriaBuilder->setFilterGroups($this->filterGroupBuilder->create());
        // Note - the above works as expected, but below is a bit cleaner, allowing us to add the OR condition without
        // manually '_set'-ing filter groups and thus overriding any existing filters. Leaving both as reference points
        */
        $filters = [];
        foreach (array('firstname', 'lastname') as $nameField) {
            $filters[] = $this->filterBuilder->setField($nameField)->setConditionType('like')->setValue('S%')->create();
        }
        $this->searchCriteriaBuilder->addFilters($filters);

        $criteria = $this->searchCriteriaBuilder->create();
        $customers = $this->customerRepository->getList($criteria);
        return $customers->getItems();
    }
}
