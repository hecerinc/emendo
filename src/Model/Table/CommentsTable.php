<?php
namespace App\Model\Table;

use App\Model\Entity\Comment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Issues
 * @property \Cake\ORM\Association\BelongsTo $ParentComments
 * @property \Cake\ORM\Association\HasMany $ChildComments
 * @property \Cake\ORM\Association\HasMany $Photos
 * @property \Cake\ORM\Association\HasMany $Votes
 */
class CommentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('comments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Issues', [
            'foreignKey' => 'issue_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ParentComments', [
            'className' => 'Comments',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildComments', [
            'className' => 'Comments',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Photos', [
            'foreignKey' => 'comment_id'
        ]);
        $this->hasMany('Votes', [
            'foreignKey' => 'comment_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('body');

        $validator
            ->boolean('is_private')
            ->requirePresence('is_private', 'create')
            ->notEmpty('is_private');

        $validator
            ->boolean('is_latest')
            ->requirePresence('is_latest', 'create')
            ->notEmpty('is_latest');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['issue_id'], 'Issues'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentComments'));
        return $rules;
    }
}
