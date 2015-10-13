<?php
namespace BlueAcorn\Repository\Api\Data;
interface ExampleSearchResultsInterface
    extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * @api
     * @return \BlueAcorn\Repository\Api\Data\ExampleInterface[]
     */
    public function getItems();

    /**
     * @api
     * @param \BlueAcorn\Repository\Api\Data\ExampleInterface[] $items
     * @return $this
     */
    public function setItems(array $items = null);

}
