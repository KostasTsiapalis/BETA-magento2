<?php
/**
 * @package     ${MAGENTO_MODULE_NAMESPACE}\\${MAGENTO_MODULE}
 * @version
 * @author      Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */

namespace Training1\Review\Model\Plugin\Review;

use Magento\Review\Model\Review;

class ValidatePlugin {
    public function afterValidate(Review $review, $result) {
        if (strpos($review->getNickname(), '-') !== false) {
            $message = __('Name cannot include dashes.');
            if (is_array($result)) {
                $result[] = $message;
            } else {
                $result = array($message);
            }
        }

        return $result;
    }
}