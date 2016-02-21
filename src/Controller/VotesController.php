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
        if($this->request->is('post')){


        extract($this->request->data);
        // If the vote was made to an issue
        if(isset($issue_id)){
            // Check if vote already exists
            $req_vote = $this->Votes->find('all', [
                'conditions'=>['issue_id'=>$issue_id, 'user_id'=>$user_id]
                ]);

            if($req_vote->isEmpty()){
                // No vote exists yet, then create vote
                $newVote = $this->Votes->newEntity();
                // Uncomment this later
                // $this->request->data['user_id'] = $this->Auth->user('id');
                $this->request->data['user_id'] = 1;
                $newVote = $this->Votes->patchEntity($newVote, 
                                                    $this->request->data);
                // try to save
                echo ("<pre>");
                var_dump($newVote);
                echo ("</pre>");

                if($this->Votes->save($newVote)){
                    echo("aksjdfaoisdjfoiasdjfio");
                    // Vote was successfull
                    exit();
                    // Update vote count
                    //updateCount($issue_id, true);
                }
            }
            else{
                // There are 3 operations for a vote update:
                // Change vote from positive to negative
                // Change vote from negative to positive
                // Delete vote (When both are positive or both are negative)
                $result = $req_vote->first();
                $result = $result->toArray();
                echo ("<pre>");
                var_dump($result);
                echo ("</pre>");

                if($vote && $result['vote'] || !$vote && !$result['vote']){
                    $voteEntity = $this->Votes->get($result['id']);
                    $result = $this->Votes->delete($voteEntity);
                }
                else{
                    $newVote = $this->Votes->newEntity();
                    $newVote = $this->Votes->patchEntity($newVote, $this->request->data);
                    $newVote["id"] = $result['id'];
                    if($this->Votes->save($newVote)){
                        //updateCount($issue_id, true);
                    }
                }
            }
        
        }
        // If it's not an issue, it's a comment
        else{

        }
        }
        $users = $this->Votes->Users->find('list', ['limit' => 200]);
        $issues = $this->Votes->Issues->find('list', ['limit' => 200]);
        $comments = $this->Votes->Comments->find('list', ['limit' => 200]);
        $this->set(compact('vote', 'users', 'issues', 'comments'));
        $this->set('_serialize', ['vote']);
        /*
        elseif ($a == $b) {
        $vote = $this->Votes->newEntity();
        $vote = $this->Votes->patchEntity($vote, $this->request->data);


        if ($this->Votes->save($vote)) {
            $this->Flash->success(__('The vote has been saved.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The vote could not be saved. Please, try again.'));
        }
        
        */
    }

     /**
     * Update vote count method
     *
     * 
     */
    public function updateCount($id, $isIssue)
    {
        if($isIssue){
            $query = $this->Vote->findAllByIssueId($id);
            $allVotes = $query->count();
            $query2 = $this->Vote->find('all', [
                'conditions'=>[
                    'vote'=>false,
                    'issue_id'=>$id
                ]
            ]);
            $falseVotes = $query2->count();
            $totalCount = $allVotes - $falseVotes;
            // Return some json with new vote count
            echo json_encode(['totalVotes'=>$totalCount]);
        }
        else{
            $query = $this->Vote->findAllByCommentId($id);
            $allVotes = $query->count();
            $query2 = $this->Vote->find('all', [
                'conditions'=>[
                    'vote'=>false,
                    'issue_id'=>$id
                ]
            ]);
            $falseVotes = $query2->count();
            $totalCount = $allVotes - $falseVotes;
            echo json_encode(['totalVotes'=>$totalCount]);
        }
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
