<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email[]|\Cake\Collection\CollectionInterface $emails
 */
?>
<div class="emails index content">
    <?= $this->Html->link(__('New Email'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Emails') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('from_email') ?></th>
                    <th><?= $this->Paginator->sort('to_email') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('ticket_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($emails as $email): ?>
                <tr>
                    <td><?= $this->Number->format($email->id) ?></td>
                    <td><?= h($email->from_email) ?></td>
                    <td><?= h($email->to_email) ?></td>
                    <td><?= h($email->subject) ?></td>
                    <td><?= $email->has('ticket') ? $this->Html->link($email->ticket->id, ['controller' => 'Tickets', 'action' => 'view', $email->ticket->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $email->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $email->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
