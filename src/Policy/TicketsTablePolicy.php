<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\User;
use Cake\ORM\Query;

/**
 * Tickets policy
 */
class TicketsTablePolicy
{
    public function scopeIndex(User $user, Query $query): Query
    {
        return $query->where(['Tickets.user_id' => $user->id]);
    }
}
