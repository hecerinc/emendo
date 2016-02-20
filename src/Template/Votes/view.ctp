<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Vote'), ['action' => 'edit', $vote->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Vote'), ['action' => 'delete', $vote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vote->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Votes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Vote'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Issues'), ['controller' => 'Issues', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Issue'), ['controller' => 'Issues', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="votes view large-9 medium-8 columns content">
    <h3><?= h($vote->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $vote->has('user') ? $this->Html->link($vote->user->name, ['controller' => 'Users', 'action' => 'view', $vote->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Issue') ?></th>
            <td><?= $vote->has('issue') ? $this->Html->link($vote->issue->title, ['controller' => 'Issues', 'action' => 'view', $vote->issue->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Comment') ?></th>
            <td><?= $vote->has('comment') ? $this->Html->link($vote->comment->id, ['controller' => 'Comments', 'action' => 'view', $vote->comment->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($vote->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($vote->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($vote->modified) ?></td>
        </tr>
        <tr>
            <th><?= __('Vote') ?></th>
            <td><?= $vote->vote ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>
