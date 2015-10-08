<?php
namespace BlueAcorn\Training\Model\Attribute\Multiselect;
use Magento\Eav\Model\Entity\Attribute\Frontend\AbstractFrontend;
use Magento\Framework\DataObject;

class FrontendModel extends AbstractFrontend
{
    public function getValue(DataObject $object)
    {
        if ($this->getConfigField('input') != 'multiselect') {
            return parent::getValue($object);
        }
        $values = $object->getData($this->getAttribute()->getAttributeCode());
        $labels = $this->getOption($values) ?: array();
        $itemsHtml = '';
        foreach($labels as $label) {
            $itemsHtml .= "<li>$label</li>";
        }
        return "<ul>$itemsHtml</ul>";
    }
}