<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectIssueSolutions Controller
 *
 * @property \App\Model\Table\ProjectIssueSolutionsTable $ProjectIssueSolutions
 *
 * @method \App\Model\Entity\ProjectIssueSolution[] paginate($object = null, array $settings = [])
 */
class ProjectIssueSolutionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tasks', 'Users']
        ];
        $projectIssueSolutions = $this->paginate($this->ProjectIssueSolutions);

        $this->set(compact('projectIssueSolutions'));
        $this->set('_serialize', ['projectIssueSolutions']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Issue Solution id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectIssueSolution = $this->ProjectIssueSolutions->get($id, [
            'contain' => ['Tasks', 'Users', 'ProjectIssues']
        ]);

        $this->set('projectIssueSolution', $projectIssueSolution);
        $this->set('_serialize', ['projectIssueSolution']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $projectIssueSolution = $this->ProjectIssueSolutions->newEntity();
        if ($this->request->is('post')) {
            $projectIssueSolution = $this->ProjectIssueSolutions->patchEntity($projectIssueSolution, $this->request->getData());
            if ($this->ProjectIssueSolutions->save($projectIssueSolution)) {
                $this->Flash->success(__('The project issue solution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project issue solution could not be saved. Please, try again.'));
        }
        $tasks = $this->ProjectIssueSolutions->Tasks->find('list', ['limit' => 200]);
        $users = $this->ProjectIssueSolutions->Users->find('list', ['limit' => 200]);
        $this->set(compact('projectIssueSolution', 'tasks', 'users'));
        $this->set('_serialize', ['projectIssueSolution']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Issue Solution id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectIssueSolution = $this->ProjectIssueSolutions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectIssueSolution = $this->ProjectIssueSolutions->patchEntity($projectIssueSolution, $this->request->getData());
            if ($this->ProjectIssueSolutions->save($projectIssueSolution)) {
                $this->Flash->success(__('The project issue solution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project issue solution could not be saved. Please, try again.'));
        }
        $tasks = $this->ProjectIssueSolutions->Tasks->find('list', ['limit' => 200]);
        $users = $this->ProjectIssueSolutions->Users->find('list', ['limit' => 200]);
        $this->set(compact('projectIssueSolution', 'tasks', 'users'));
        $this->set('_serialize', ['projectIssueSolution']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Issue Solution id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectIssueSolution = $this->ProjectIssueSolutions->get($id);
        if ($this->ProjectIssueSolutions->delete($projectIssueSolution)) {
            $this->Flash->success(__('The project issue solution has been deleted.'));
        } else {
            $this->Flash->error(__('The project issue solution could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
