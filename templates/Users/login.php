<div class="users index content">
    <h3><?= __('Login') ?></h3>
    <?= $this->Form->create() ?>
    <?= $this->Form->control('username') ?>
    <?= $this->Form->control('password') ?>
    <?= $this->Form->button('Login') ?>
    <?= $this->Form->end() ?>
</div>
