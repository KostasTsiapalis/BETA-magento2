<?php
namespace BlueAcorn\Training\Controller\Enumerate;

use Magento\Framework\App\Action\Action;

class Stores extends Action
{
    public function execute()
    {
        $stores = $this->_objectManager->get('Magento\Store\Model\Store')->getCollection();
        $categoryIds = array();
        foreach($stores as $store) {
            $categoryIds[] = $store->getRootCategoryId();
        }
        $categories = $this->_objectManager->get('Magento\Catalog\Model\Category')->getCollection()
            ->addIdFilter($categoryIds)
            ->addAttributeToSelect('name');
        $response = "Store Root Category List:<br>";
        foreach($categories as $category) {
            $response .= $category->getName() . "<br>";
        }

        $this->getResponse()->appendBody($response);
    }
}
