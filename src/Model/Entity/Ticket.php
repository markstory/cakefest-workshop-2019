<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $user_id
 * @property string $subject
 * @property string|null $body
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Email[] $emails
 */
class Ticket extends Entity
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
        'customer_id' => true,
        'user_id' => true,
        'subject' => true,
        'body' => true,
        'customer' => true,
        'user' => true,
        'emails' => true,
    ];
}
