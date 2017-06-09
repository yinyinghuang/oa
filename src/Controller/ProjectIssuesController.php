<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectIssues Controller
 *
 * @property \App\Model\Table\ProjectIssuesTable $ProjectIssues
 *
 * @method \App\Model\Entity\ProjectIssue[] paginate($object = null, array $settings = [])
 */
class ProjectIssuesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tasks', 'ProjectSchedules', 'Users', 'ProjectIssueSolutions']
        ];
        $projectIssues = $this->paginate($this->ProjectIssues);

        $this->set(compact('projectIssues'));
        $this->set('_serialize', ['projectIssues']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Issue id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectIssue = $this->ProjectIssues->get($id, [
            'contain' => ['Tasks', 'ProjectSchedules', 'Users', 'ProjectIssueSolutions']
        ]);

        $this->set('projectIssue', $projectIssue);
        $this->set('_serialize', ['projectIssue']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectIssue = $this->ProjectIssues->newEntity();
        if ($this->request->is('post')) {
            $projectIssue = $this->ProjectIssues->patchEntity($projectIssue, $this->request->getData());
            if ($this->ProjectIssues->save($projectIssue)) {
                $this->Flash->success(__('The project issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project issue could not be saved. Please, try again.'));
        }
        $tasks = $this->ProjectIssues->Tasks->find('list', ['limit' => 200]);
        $projectSchedules = $this->ProjectIssues->ProjectSchedules->find('list', ['limit' => 200]);
        $users = $this->ProjectIssues->Users->find('list', ['limit' => 200]);
        $projectIssueSolutions = $this->ProjectIssues->ProjectIssueSolutions->find('list', ['limit' => 200]);
        $this->set(compact('projectIssue', 'tasks', 'projectSchedules', 'users', 'projectIssueSolutions'));
        $this->set('_serialize', ['projectIssue']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Issue id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectIssue = $this->ProjectIssues->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectIssue = $this->ProjectIssues->patchEntity($projectIssue, $this->request->getData());
            if ($this->ProjectIssues->save($projectIssue)) {
                $this->Flash->success(__('The project issue has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project issue could not be saved. Please, try again.'));
        }
        $tasks = $this->ProjectIssues->Tasks->find('list', ['limit' => 200]);
        $projectSchedules = $this->ProjectIssues->ProjectSchedules->find('list', ['limit' => 200]);
        $users = $this->ProjectIssues->Users->find('list', ['limit' => 200]);
        $projectIssueSolutions = $this->ProjectIssues->ProjectIssueSolutions->find('list', ['limit' => 200]);
        $this->set(compact('projectIssue', 'tasks', 'projectSchedules', 'users', 'projectIssueSolutions'));
        $this->set('_serialize', ['projectIssue']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Issue id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectIssue = $this->ProjectIssues->get($id);
        if ($this->ProjectIssues->delete($projectIssue)) {
            $this->Flash->success(__('The project issue has been deleted.'));
        } else {
            $this->Flash->error(__('The project issue could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
