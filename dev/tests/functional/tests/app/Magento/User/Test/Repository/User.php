<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\User\Test\Repository;

use Mtf\ObjectManager;
use Mtf\Repository\AbstractRepository;

/**
 * Class User
 * User Repository
 */
class User extends AbstractRepository
{
    /**
     * @constructor
     * @param array $defaultConfig
     * @param array $defaultData
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(array $defaultConfig = [], array $defaultData = [])
    {
        $this->_data['default'] = [
            'username' => 'admin',
            'firstname' => 'FirstName%isolation%',
            'lastname' => 'LastName%isolation%',
            'email' => 'email%isolation%@example.com',
            'password' => '123123q',
            'password_confirmation' => '123123q',
            'user_id' => 1,
            'current_password' => '%current_password%',
        ];

        $this->_data['custom_admin'] = [
            'username' => 'AdminUser%isolation%',
            'firstname' => 'FirstName%isolation%',
            'lastname' => 'LastName%isolation%',
            'email' => 'email%isolation%@example.com',
            'password' => '123123q',
            'password_confirmation' => '123123q',
            'current_password' => '%current_password%',
        ];

        $this->_data['custom_admin_with_default_role'] = [
            'username' => 'AdminUser%isolation%',
            'firstname' => 'FirstName%isolation%',
            'lastname' => 'LastName%isolation%',
            'email' => 'email%isolation%@example.com',
            'password' => '123123q',
            'password_confirmation' => '123123q',
            'role_id' => ['dataSet' => 'default'],
            'current_password' => '%current_password%',
            'is_active' => 'Active',
        ];
    }
}
