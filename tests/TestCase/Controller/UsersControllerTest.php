<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Test\TestCase\IntegrationTestHelperTrait;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;
    use IntegrationTestHelperTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Users',
        'app.Tickets',
        'app.Customers',
    ];

    public function testLogin()
    {
        $this->enableCsrfToken();
        $this->post('/users/login', [
            'username' => 'admin',
            'password' => 'hunter12'
        ]);
        $this->assertRedirect('/tickets');
        $this->assertSession('admin', 'Auth.username');
    }

    public function testLogout()
    {
        $this->enableCsrfToken();
        $this->login('admin');
        $this->post('/users/logout');

        $this->assertRedirect('/users/login');
        $session = $this->_requestSession;
        $this->assertNull($session->read('Auth.username'));
    }
}
