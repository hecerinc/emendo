<?php
namespace App\Model\Table;

use App\Model\Entity\Vote;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Votes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\BelongsTo $Issues
 * @property \Cake\ORM\Association\BelongsTo $Comments
 */
class VotesTable extends Table
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

		$this->table('votes');
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
		$this->belongsTo('Comments', [
			'foreignKey' => 'comment_id',
			'joinType' => 'INNER'
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
			->boolean('vote')
			->allowEmpty('vote');

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
		$rules->add($rules->existsIn(['comment_id'], 'Comments'));
		return $rules;
	}
	/**
	 * Update vote count method
	 */
	public function updatedCount($category, $id){
		$query = $this->findAllByIssueId($id);
		// Find all votes
		$allVotes = $query->count();
		// Find downvotes
		$query2 = $this->find('all', [
			'conditions'=>[
				'vote' => false,
				$category => $id
			]
		]);
		$falseVotes = $query2->count();

		// Positive votes
		$totalCount = $allVotes - $falseVotes;
		
		if($totalCount == 0 && $falseVotes != 0)
			$totalCount = 0-$falseVotes;

		// Return some json with new vote count
		return $totalCount;
	}

}
