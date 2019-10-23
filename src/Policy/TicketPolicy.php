<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Ticket;
use Authorization\IdentityInterface;

/**
 * Ticket policy
 */
class TicketPolicy
{
    /**
     * Check if $user can create Ticket
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Ticket $ticket
     * @return bool
     */
    public function canCreate(IdentityInterface $user, Ticket $ticket)
    {
        return true;
    }

    /**
     * Check if $user can update Ticket
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Ticket $ticket
     * @return bool
     */
    public function canUpdate(IdentityInterface $user, Ticket $ticket)
    {
        if ($user->id !== $ticket->user_id) {
            return false;
        }
        return true;
    }

    /**
     * Check if $user can delete Ticket
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Ticket $ticket
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Ticket $ticket)
    {
    }

    /**
     * Check if $user can view Ticket
     *
     * @param Authorization\IdentityInterface $user The user.
     * @param App\Model\Entity\Ticket $ticket
     * @return bool
     */
    public function canView(IdentityInterface $user, Ticket $ticket)
    {
    }
}
