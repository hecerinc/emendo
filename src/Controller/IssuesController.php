<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Issues Controller
 *
 * @property \App\Model\Table\IssuesTable $Issues
 */
class IssuesController extends AppController
{

	/**
	 * Index method
	 *
	 * @return \Cake\Network\Response|null
	 */
	public function index()
	{
		$this->paginate = [
			'contain' => ['Users']
		];
		$issues = $this->paginate($this->Issues);

		$this->set(compact('issues'));
		$this->set('_serialize', ['issues']);
	}

	/**
	 * View method
	 *
	 * @param string|null $id Issue id.
	 * @return \Cake\Network\Response|null
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$this->viewBuilder()->layout('user');
		$issue = $this->Issues->get($id, [
			'contain' => ['Users', 'Tags', 'Comments', 'Comments.Users', 'Photos', 'Votes']
		]);
		$vote_count = $this->Issues->Votes->updatedCount('issue_id', $id);
		$this->set('issue', $issue->toArray());
		$this->set(compact('vote_count'));
		$this->set('_serialize', ['issue']);
	}

	/**
	 * Add method
	 *
	 * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$issue = $this->Issues->newEntity();
		
		// When user passes data

		if ($this->request->is('post')) {

			//$uid = $this->Auth->user('id');
			$uid = 1;
			// $user_id = $this->Issues->Users->find('all', ['conditions'=>['id'=>$uid]]);
			$this->request->data['user_id'] = $uid;

			$tag_ids = array();
			foreach($this->request->data["tags"] as $tag){

				// If tag already exists
				if (is_numeric($tag)){
					$tagquery = $this->Issues->Tags->find('all', ['conditions'=>['id'=> $tag]]);
					if(!$tagquery->isEmpty()){
						$tag = $tagquery->first();
						$tag_ids[] = $tag;
					}
				}
				else{
					// Else if tag is new
					// Create tag
					$newTag = $this->Issues->Tags->newEntity();
					$newTag->name = $tag;
					$tag_ids[] = $newTag;
				}
			}
			$issue = $this->Issues->patchEntity($issue, $this->request->data);
			$issue->tags = $tag_ids;
			if ($this->Issues->save($issue)) {
				$this->Flash->success(__('The issue has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The issue could not be saved. Please, try again.'));
			}
		}
		$tags = $this->Issues->Tags->find('list', ['limit' => 200]);
		$this->set(compact('issue', 'tags', "user_id"));
		$this->set('_serialize', ['issue']);


	}
	public function testtags(){
		$this->autoRender = false;
		$result = $this->Issues->searchByTag('pene');
		echo "<pre>";
		var_dump($result);
		echo "</pre>";
		exit();
	}
	/**
	 * Edit method
	 *
	 * @param string|null $id Issue id.
	 * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$issue = $this->Issues->get($id, [
			'contain' => ['Tags']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$issue = $this->Issues->patchEntity($issue, $this->request->data);
			if ($this->Issues->save($issue)) {
				$this->Flash->success(__('The issue has been saved.'));
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The issue could not be saved. Please, try again.'));
			}
		}
		$users = $this->Issues->Users->find('list', ['limit' => 200]);
		$tags = $this->Issues->Tags->find('list', ['limit' => 200]);
		$this->set(compact('issue', 'users', 'tags'));
		$this->set('_serialize', ['issue']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Issue id.
	 * @return \Cake\Network\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$issue = $this->Issues->get($id);
		if ($this->Issues->delete($issue)) {
			$this->Flash->success(__('The issue has been deleted.'));
		} else {
			$this->Flash->error(__('The issue could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}
