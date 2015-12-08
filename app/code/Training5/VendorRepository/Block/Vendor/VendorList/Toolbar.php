<?php
/**
 * @package     Training5\VendorRepository
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training5\VendorRepository\Block\Vendor\VendorList;

use Magento\Framework\App\Request\Http as Request;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Data\Collection;

class Toolbar extends Template
{
    /**
     * GET parameter sort mode name
     */
    const SORT_MODE_PARAM = 'sort_mode';

    /**
     * GET parameter sort direction name
     */
    const SORT_DIR_PARAM = 'sort_dir';

    /**
     * GET parameter filter like name
     */
    const FILTER_LIKE_PARAM = 'filter_like';

    /**
     * @var Request
     */
    protected $_request;

    /**
     * Sort by mode options
     * @var array
     */
    protected $_sortModeOptions = [
        'name' => 'Name',
        'vendor_id' => 'ID'
    ];

    /**
     * Sort direction options
     * @var array
     */
    protected $_sortDirOptions = [
        Collection::SORT_ORDER_ASC => 'Ascending',
        Collection::SORT_ORDER_DESC => 'Descending'
    ];

    /**
     * Default sorting options
     * @var array
     */
    protected $_defaults = [
        self::SORT_DIR_PARAM => Collection::SORT_ORDER_ASC,
        self::SORT_MODE_PARAM => 'name'
    ];

    /**
     * Initialize block with context and registry access
     *
     * @param Request $request
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Request $request,
        Context $context,
        array $data = []
    ) {
        $this->_request = $request;
        parent::__construct($context, $data);
    }

    /**
     * Get current requested sort mode
     *
     * @return string|null
     */
    public function getSortMode()
    {
        return $this->_request->getParam(self::SORT_MODE_PARAM)
            ?: $this->_defaults[self::SORT_MODE_PARAM];
    }

    /**
     * Get current requested sort direction
     *
     * @return string|null
     */
    public function getSortDir()
    {
        return $this->_request->getParam(self::SORT_DIR_PARAM)
            ?: $this->_defaults[self::SORT_DIR_PARAM];
    }

    /**
     * Get current requested like filter
     *
     * @return string|null
     */
    public function getFilterLike()
    {
        return $this->_request->getParam(self::FILTER_LIKE_PARAM, '');
    }

    /**
     * Get sort by options
     *
     * @return array
     */
    public function getSortModeOptions()
    {
        return $this->_sortModeOptions;
    }

    /**
     * Get sort direction options
     *
     * @return array
     */
    public function getSortDirOptions()
    {
        return $this->_sortDirOptions;
    }
}
