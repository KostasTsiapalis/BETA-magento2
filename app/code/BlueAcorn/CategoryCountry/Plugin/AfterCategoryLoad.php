<?php

namespace BlueAcorn\CategoryCountry\Plugin;

use Magento\Catalog\Api\Data\CategoryExtensionFactory;
use Magento\Catalog\Model\Category;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class AfterCategoryLoad
{
    /**
     * @var CategoryExtensionFactory
     */
    protected $categoryExtensionFactory;
    protected $setup;

    /**
     * @param CategoryExtensionFactory $categoryExtensionFactory
     * @param ModuleDataSetupInterface $setup
     */
    public function __construct(
        CategoryExtensionFactory $categoryExtensionFactory,
        ModuleDataSetupInterface $setup
    ) {
        $this->categoryExtensionFactory = $categoryExtensionFactory;
        $this->setup = $setup;
    }

    /**
     * Add countries information to the categorie's extension attributes
     *
     * @param Category $category
     * @return Category
     */
    public function afterLoad(Category $category)
    {
        $categoryExtension = $category->getExtensionAttributes();
        if ($categoryExtension === null) {
            $categoryExtension = $this->categoryExtensionFactory->create();
        }

        $select = $this->setup->getConnection()->select()
            ->from('category_countries')
            ->where('category_id=?', $category->getId());
        $data = $this->setup->getConnection()->fetchAll($select);
        $countries = array();
        if (is_array($data)) {
            foreach ($data as $country) {
                $countries[] = $country['country'];
            }
        }

        $categoryExtension->setCountries($countries);
        $category->setExtensionAttributes($categoryExtension);
        return $category;
    }
}
