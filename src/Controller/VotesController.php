<?php
namespace App\Controller;

use App\Controller\AppController;

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
    public function add()
    {
        // Always false to allow testing
        if(!$this->request->is('ajax') && false)
            throw new NotFoundException('You can\'t access that');
        // Extract variables from data
        extract($this->request->data);
        // If the vote was made to an issue
        if($issue_id != NULL){
            // Check if vote already exists
            $req_vote = $this->Votes->find('all', [
                'conditions'=>['issue_id'=>$issue_id, 'user_id'=>$user_id]
                ]);
            echo ("<pre>");
            var_dump($req_vote->toArray());
            //var_dump($req_vote->isEmpty());
            echo ("</pre>");
            if($req_vote->isEmpty()){ 
                // No vote exists yet, then create vote
                $newVote = $this->Votes->newEntity();
                // Uncomment this later
                // $this->request->data['user_id'] = $this->Auth->user('id');
                $this->request->data['user_id'] == 1;
                $newVote = $this->Votes->patchEntity($newVote, 
                                                    $this->request->data);
                // try to save
                echo ("<pre>");
                var_dump($newVote);
                echo ("</pre>");
                if($this->Votes->save($newVote)){
                    echo("aksjdfaoisdjfoiasdjfio");
                    // Vote was successfull
                    // Update vote count
                    updateCount($issue_id, true);
                }
            }
            else{
                // There are 3 operations for a vote update:
                // Change vote from positive to negative
                // Change vote form negative to positive
                // Delete vote (When both are positive or both are negative)
                //if($req_vote[]
            }
        }
        $users = $this->Votes->Users->find('list', ['limit' => 200]);
        $issues = $this->Votes->Issues->find('list', ['limit' => 200]);
        $comments = $this->Votes->Comments->find('list', ['limit' => 200]);
        $this->set(compact('vote', 'users', 'issues', 'comments'));
        $this->set('_serialize', ['vote']);
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
