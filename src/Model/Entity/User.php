<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authorization\IdentityInterface as AuthorizationIdentity;
use Authentication\IdentityInterface as AuthenticationIdentity;
use Authorization\AuthorizationServiceInterface;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property \Cake\I18n\FrozenTime|null $activation_date
 * @property bool $active
 * @property string $role
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Ticket[] $tickets
 * @property \App\Model\Entity\Customer[] $customers
 */
class User extends Entity
    implements AuthorizationIdentity, AuthenticationIdentity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'email' => true,
        'password' => true,
        'first_name' => true,
        'last_name' => true,
        'activation_date' => true,
        'active' => true,
        'role' => true,
        'created' => true,
        'modified' => true,
        'tickets' => true,
        'customers' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];


    public function can(string $action, $resource): bool
    {
        return $this->authorization->can($this, $action, $resource);
    }

    public function canResult(string $action, $resource): \Authorization\Policy\ResultInterface
    {
        return $this->authorization->canResult($this, $action, $resource);
    }

    public function applyScope(string $action, $resource)
    {
        return $this->authorization->applyScope($this, $action, $resource);
    }

    public function getIdentifier()
    {
        return $this->id;
    }

    public function getOriginalData()
    {
        return $this;
    }

    public function setAuthorization(AuthorizationServiceInterface $service)
    {
        $this->authorization = $service;
    }
}
