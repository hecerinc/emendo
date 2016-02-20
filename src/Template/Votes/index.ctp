<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Vote'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Issues'), ['controller' => 'Issues', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Issue'), ['controller' => 'Issues', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Comments'), ['controller' => 'Comments', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Comment'), ['controller' => 'Comments', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="votes index large-9 medium-8 columns content">
    <h3><?= __('Votes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('vote') ?></th>
                <th><?= $this->Paginator->sort('user_id') ?></th>
                <th><?= $this->Paginator->sort('issue_id') ?></th>
                <th><?= $this->Paginator->sort('comment_id') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th><?= $this->Paginator->sort('modified') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($votes as $vote): ?>
            <tr>
                <td><?= $this->Number->format($vote->id) ?></td>
                <td><?= h($vote->vote) ?></td>
                <td><?= $vote->has('user') ? $this->Html->link($vote->user->name, ['controller' => 'Users', 'action' => 'view', $vote->user->id]) : '' ?></td>
                <td><?= $vote->has('issue') ? $this->Html->link($vote->issue->title, ['controller' => 'Issues', 'action' => 'view', $vote->issue->id]) : '' ?></td>
                <td><?= $vote->has('comment') ? $this->Html->link($vote->comment->id, ['controller' => 'Comments', 'action' => 'view', $vote->comment->id]) : '' ?></td>
                <td><?= h($vote->created) ?></td>
                <td><?= h($vote->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $vote->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $vote->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $vote->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vote->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
