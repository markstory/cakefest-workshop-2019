<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Email Entity
 *
 * @property int $id
 * @property string $from_email
 * @property string $to_email
 * @property string $subject
 * @property string|null $body
 * @property int|null $ticket_id
 *
 * @property \App\Model\Entity\Ticket $ticket
 */
class Email extends Entity
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
        'from_email' => true,
        'to_email' => true,
        'subject' => true,
        'body' => true,
        'ticket_id' => true,
        'ticket' => true,
    ];
}
