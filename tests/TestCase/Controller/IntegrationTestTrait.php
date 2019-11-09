<?php
namespace App\Test\TestCase;

use Cake\ORM\TableRegistry;

trait IntegrationTestHelperTrait
{
    protected function login(?string $username)
    {
        $users = TableRegistry::getTableLocator()->get('Users');
        $user = $users->findByUsername($username)->firstOrFail();

        $this->session([
            'Auth' => $user,
        ]);
    }
}
