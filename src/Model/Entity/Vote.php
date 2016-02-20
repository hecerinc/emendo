<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vote Entity.
 *
 * @property int $id
 * @property bool $vote
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $issue_id
 * @property \App\Model\Entity\Issue $issue
 * @property int $comment_id
 * @property \App\Model\Entity\Comment $comment
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Vote extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
