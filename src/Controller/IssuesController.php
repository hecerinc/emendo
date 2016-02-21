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
        $issue = $this->Issues->get($id, [
            'contain' => ['Users', 'Tags', 'Comments', 'Photos', 'Votes']
        ]);

        $this->set('issue', $issue);
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
        //$user_id = 1;
        // When user passes data
        $uid = 1;
        $user_id = $this->Issues->Users->find('all', ['conditions'=>['id'=>$uid]]);
        // echo "<pre>";
        // var_dump($user_id->isEmpty());
        // if(!$user_id->isEmpty()){
        //     var_dump($user_id->toArray());
        // }
        // echo "</pre>";
        // exit(); 
        if ($this->request->is('post')) {
            //$uid = $this->Auth->user('id');
            // echo "<pre>";
            // var_dump($this->request->data);
            // echo "</pre>";
            // exit();
            $this->request->data['user_id'] = $uid;
            foreach($this->request->data["tags"] as $tag){
                if (is_numeric($tag)){
                    $tagquery = $this->Issues->Tags->find('all', ['conditions'=>['id'=> $tag]]);
                    if(!$tagquery->isEmpty()){
                        $tag = $tagquery->first()->toArray()['name'];
                    }
                }
                $tagquery = $this->Issues->Tags->find('all', ['conditions'=>['name'=> $tag]]);
                //var_dump($this->request->data);
                $newObject = $this->Issues->Tags->newEntity();
                $newObject = $this->Issues->Tags->patchEntity($newObject,$this->request->data);
                $newObject['name'] = $tag;
                if ($tagquery->isEmpty()){
                    echo "<pre> Enters </pre>";
                    //$newTag = $this->Tags->newEntity();
                    if ($this->Issues->Tags->save($newObject)){
                        echo "<pre> works </pre>";
                    }
                }
            }
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
        $this->set(compact('issue', 'users', 'tags', "user_id"));
        $this->set('_serialize', ['issue']);


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
