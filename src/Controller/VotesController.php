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
                    createIssueVote($this->request->data, $issue_id);
                }
                else{
                    // Delete vote (When both are positive or both are negative)
                    $result = $req_vote->first()->toArray();
                    if($vote && $result['vote'] || !$vote && !$result['vote']){
                        $voteEntity = $this->Votes->get($result['id']);
                        $result = $this->Votes->delete($voteEntity);
                        $this->updateCount($comment_id, true);
                    }
                    // Invert vote (from positive to negative && viceversa)
                    else{
                        $newVote = $this->Votes->newEntity();
                        $newVote = $this->Votes->patchEntity($newVote, $this->request->data);
                        $newVote["id"] = $result['id'];
                        if($this->Votes->save($newVote)){
                            $this->updateCount($issue_id, "issue");
                        }
                    }
                }
            }
            // If it's not an issue, it should be a comment
            // Test anyways to avoid user havoc
            elseif(isset($comment_id)){
                // Check if vote already exists
                $req_vote = $this->Votes->find('all', [
                    'conditions'=>['comment_id'=>$comment_id, 'user_id'=>$user_id]
                    ]);

                if($req_vote->isEmpty()){
                    createCommentVote($this->request->data, $issue_id);
                }
                else{
                    $result = $req_vote->first()->toArray();
                    if($vote && $result['vote'] || !$vote && !$result['vote']){
                        $voteEntity = $this->Votes->get($result['id']);
                        $result = $this->Votes->delete($voteEntity);
                        $this->updateCount($comment_id, "comment");
                    }
                    else{
                        $newVote = $this->Votes->newEntity();
                        $newVote = $this->Votes->patchEntity($newVote, $this->request->data);
                        $newVote["id"] = $result['id'];
                        if($this->Votes->save($newVote)){
                            $this->updateCount($comment_id, "comment");
                        }
                    }
                }

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
     * Method to create a vote to a specific issue by a particular user
     */
    private function createIssueVote($issueData, $id)
    {
        $newVote = $this->Votes->newEntity();
        // Uncomment this later
        // $this->request->data['user_id'] = $this->Auth->user('id');
        $newVote = $this->Votes->patchEntity($newVote, $issueData);
        if($this->Votes->save($newVote)){
            // Update vote count
            $this->updateCount($issue_id, "comment");
        }
    }


    /**
     * Method to create a vote to a specific comment by a particular user
     */
    private function createCommentVote($commentData, $id)
    {
        $newVote = $this->Votes->newEntity();
        // Uncomment this later
        // $this->request->data['user_id'] = $this->Auth->user('id');
        $newVote = $this->Votes->patchEntity($newVote, $commentData);
        if($this->Votes->save($newVote)){
            // Update vote count
            $this->updateCount($issue_id, "issue");
        }
    }


     /**
     * Update vote count method
     */
    private function updateCount($id, $category)
    {
        if($category == "issue"){
            $query = $this->Votes->findAllByIssueId($id);
            $allVotes = $query->count();
            $query2 = $this->Votes->find('all', [
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
        elseif($category == "comment"){
            $query = $this->Votes->findAllByCommentId($id);
            $allVotes = $query->count();
            $query2 = $this->Votes->find('all', [
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
