<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinanceApplies Controller
 *
 * @property \App\Model\Table\FinanceAppliesTable $FinanceApplies
 *
 * @method \App\Model\Entity\FinanceApply[] paginate($object = null, array $settings = [])
 */
class FinanceAppliesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $financeApplies = $this->paginate($this->FinanceApplies);

        $this->set(compact('financeApplies'));
        $this->set('_serialize', ['financeApplies']);
    }

    /**
     * View method
     *
     * @param string|null $id Finance Apply id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financeApply = $this->FinanceApplies->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('financeApply', $financeApply);
        $this->set('_serialize', ['financeApply']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {   

        $financeApply = $this->FinanceApplies->newEntity();
        if ($this->request->is('post')) {
            $financeApply = $this->FinanceApplies->patchEntity($financeApply, $this->request->getData());
            if ($this->FinanceApplies->save($financeApply)) {
                $task = $this->FinanceApplies->Tasks->newEntity([
                    'user_id' => $financeApply->approver,
                    'controller' => 'FinanceApplies',
                    'itemid' => $financeApply->id,
                    'state' => 0
                ]);
                $this->FinanceApplies->Tasks->save($task);
                $financeApply->task_id = $task->id;
                $this->FinanceApplies->save($financeApply);
                $this->Flash->success(__('The finance apply has been saved.'));

                return $this->redirect(['controller' => 'Finances', 'action' => 'apply']);
            }
            $this->Flash->error(__('The finance apply could not be saved. Please, try again.'));
        }
        $users = $this->FinanceApplies->Users->find('list', ['limit' => 200]);
        $this->set(compact('financeApply', 'users'));
        $this->set('_serialize', ['financeApply']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Finance Apply id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financeApply = $this->FinanceApplies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $financeApply = $this->FinanceApplies->patchEntity($financeApply, $this->request->getData());
            if ($this->FinanceApplies->save($financeApply)) {
                $this->Flash->success(__('The finance apply has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finance apply could not be saved. Please, try again.'));
        }
        $users = $this->FinanceApplies->Users->find('list', ['limit' => 200]);
        $this->set(compact('financeApply', 'users'));
        $this->set('_serialize', ['financeApply']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Finance Apply id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $financeApply = $this->FinanceApplies->get($id);
        $this->loadModel('Tasks');
        $task = $this->Tasks->find('all',[
            'conditions' => ['controller' => 'FinanceApplies','itemid' => $financeApply->id]
        ])->first();
        $this->Tasks->delete($task);
        if ($this->FinanceApplies->delete($financeApply)) {

            $this->Flash->success(__('The finance apply has been deleted.'));
        } else {
            $this->Flash->error(__('The finance apply could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Finances','action' => 'apply']);
    }
}
