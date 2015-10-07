<?php
namespace BlueAcorn\Training\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\ObjectManagerInterface as ObjectManager;
use Magento\Framework\Setup\ModuleContextInterface as ModuleContext;
use Magento\Framework\Setup\ModuleDataSetupInterface as ModuleDataSetup;

class UpgradeData implements UpgradeDataInterface
{
    protected $_objectManager;

    public function __construct(ObjectManager $manager)
    {
        $this->_objectManager = $manager;
    }
    public function upgrade(ModuleDataSetup $setup, ModuleContext $moduleContext)
    {
        if (version_compare($moduleContext->getVersion(), '1.1.1.', '<')) {
            $this->_objectManager->create('\BlueAcorn\Training\Model\Test')
                ->setTitle('Test title')
                ->setType('2')
                ->save();
        }
    }
}