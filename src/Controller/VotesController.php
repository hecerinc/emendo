<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Network\Exception\NotAcceptableException;
/**
 * Votes Controller
 *
 * @property \App\Model\Table\VotesTable $Votes
 */
class VotesController extends AppController
{

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Users', 'Issues', 'Comments']
		];
		$votes = $this->paginate($this->Votes);

		$this->set(compact('votes'));
		$this->set('_serialize', ['votes']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Vote id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$vote = $this->Votes->get($id, [
			'contain' => ['Users', 'Issues', 'Comments']
		]);

		$this->set('vote', $vote);
		$this->set('_serialize', ['vote']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function updatevote(){
		// Always false to allow testing
		$this->autoRender = false;
		if(!$this->request->is('ajax'))
			throw new ForbiddenException('You can\'t access that');

		// Extract variables from data
		$data = $this->request->input();
		$data = json_decode($data, true);
		extract($data);
		
		if(!isset($issue_id) && !isset($comment_id))
			throw new NotAcceptableException('No comment or issue passed');

		// Check if vote already exists
		$user_id = 1; // UNCOMMENT
		$field = isset($issue_id)?'issue_id':'comment_id';
		$value = isset($issue_id)?$issue_id:$comment_id;
		$req_vote = $this->Votes->find('all', [
			'conditions' => [$field => $value, 'user_id'=>$user_id]
		]);
	

		if($req_vote->isEmpty()){
			// No vote exists yet, then create vote and save it

			$voteObj = $this->createVote($field, $value, $vote);
		
			if($this->Votes->save($voteObj)){
				// Success!
				$count = $this->Votes->updatedCount($field, $value);
				echo json_encode(['new_count'=>$count, 'msg'=>'success', 'code'=>200]);
			}
			else{
				var_dump("Failed!");
				exit();
			}
		}
		else{
			// Delete vote (When both are positive or both are negative)
			// When user clicked on the same vote that he had already clicked on before,
			// assume he wants to delete his vote
			$result = $req_vote->first();
			if($vote && $result->vote || !$vote && !$result->vote){
				$voteEntity = $this->Votes->get($result['id']);
				$result = $this->Votes->delete($voteEntity);
				$count = $this->Votes->updatedCount($field, $value);
				echo json_encode(['new_count'=>$count, 'msg'=>'success', 'code'=>200]);
			}
			else{
				// Invert vote (from positive to negative && viceversa)
				$result->vote = $vote;
				if($this->Votes->save($result)){
					// Success!
					$count = $this->Votes->updatedCount($field, $value);
					echo json_encode(['new_count'=>$count, 'msg'=>'success', 'code'=>200]);
				}
				else{
					// Fail :(
					echo json_encode(['code'=>150, 'msg'=>'Could not save your vote right now :(']);
				}
			}
		}
			// exit();
		// $users = $this->Votes->Users->find('list', ['limit' => 200]);
		// $issues = $this->Votes->Issues->find('list', ['limit' => 200]);
		// $comments = $this->Votes->Comments->find('list', ['limit' => 200]);
		// $vote = $this->Votes->newEntity();
		// $this->set(compact('vote', 'users', 'issues', 'comments'));
		// $this->set('_serialize', ['vote']);
	
	}
	private function createVote($type, $id, $vote){
		$voteObj = $this->Votes->newEntity();
		if($type == 'issue_id')
			$voteObj->issue_id = $id;
		elseif($type == 'comment_id')
			$voteObj->comment_id = $id;
		$voteObj->vote = $vote;
		$voteObj->user_id = 1;
		return $voteObj;
	}



	
	/**
	 * Edit method
	 *
	 * @param string|null $id Vote id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$vote = $this->Votes->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$vote = $this->Votes->patchEntity($vote, $this->request->data);
			if ($this->Votes->save($vote)) {
				$this->Flash->success(__('The vote has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The vote could not be saved. Please, try again.'));
			}
		}
		$users = $this->Votes->Users->find('list', ['limit' => 200]);
		$issues = $this->Votes->Issues->find('list', ['limit' => 200]);
		$comments = $this->Votes->Comments->find('list', ['limit' => 200]);
		$this->set(compact('vote', 'users', 'issues', 'comments'));
		$this->set('_serialize', ['vote']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Vote id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$vote = $this->Votes->get($id);
		if ($this->Votes->delete($vote)) {
			$this->Flash->success(__('The vote has been deleted.'));
		} else {
			$this->Flash->error(__('The vote could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}
