<?php
namespace BlueAcorn\Training\Setup;


use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\ObjectManagerInterface as ObjectManager;
use Magento\Framework\Setup\ModuleContextInterface as ModuleContext;
use Magento\Framework\Setup\ModuleDataSetupInterface as ModuleDataSetup;

class UpgradeData implements UpgradeDataInterface
{
    private $_objectManager;
    private $_eavSetupFactory;

    public function __construct(ObjectManager $manager, EavSetupFactory $eavSetupFactory)
    {
        $this->_objectManager = $manager;
        $this->_eavSetupFactory = $eavSetupFactory;
    }
    public function upgrade(ModuleDataSetup $setup, ModuleContext $moduleContext)
    {
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);
        if (version_compare($moduleContext->getVersion(), '1.1.1.', '<')) {
            $this->_objectManager->create('\BlueAcorn\Training\Model\Test')
                ->setTitle('Test title')
                ->setType('2')
                ->save();
        }
        if (version_compare($moduleContext->getVersion(), '1.2.0', '<')) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'test_text_attr',
                [
                    'type' => 'text',
                    'label' => 'Text Input Attribute',
                    'input' => 'text',
                    'visible' => true,
                    'user_defined' => true,
                    'visible_on_front' => true,
                ]
            );
        }
        if (version_compare($moduleContext->getVersion(), '1.3.0', '<')) {
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'test_multiselect_attr',
                [
                    'type' => 'text',
                    'label' => 'Multiselect Attribute',
                    'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                    'source' => '',
                    'input' => 'multiselect',
                    'visible' => true,
                    'user_defined' => true,
                    'visible_on_front' => true,
                    'option' => array(
                        'value' => array(
                            '1' => array('fuck'),
                            '2' => array('shit'),
                            '3' => array('penis')
                        )
                    )
                ]
            );
        }

        if (version_compare($moduleContext->getVersion(), '1.3.1') < 0) {
            $eavSetup->updateAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'test_multiselect_attr',
                'frontend_model',
                'BlueAcorn\\Model\Attribute\Multiselect\FrontendModel'
            );
        }

        if (version_compare($moduleContext->getVersion(), '1.3.2') < 0) {
            $eavSetup->updateAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'test_multiselect_attr',
                'is_html_allowed_on_front',
                true
            );
        }

        if (version_compare($moduleContext->getVersion(), '1.3.3') < 0) {
            $eavSetup->updateAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'test_multiselect_attr',
                'frontend_model',
                'BlueAcorn\Training\Model\Attribute\Multiselect\FrontendModel'
            );
        }
    }
}