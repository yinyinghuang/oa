<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinanceBalances Controller
 *
 * @property \App\Model\Table\FinanceBalancesTable $FinanceBalances
 *
 * @method \App\Model\Entity\FinanceBalance[] paginate($object = null, array $settings = [])
 */
class FinanceBalancesController extends AppController
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
        $financeBalances = $this->paginate($this->FinanceBalances);

        $this->set(compact('financeBalances'));
        $this->set('_serialize', ['financeBalances']);
    }

    /**
     * View method
     *
     * @param string|null $id Finance Balance id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financeBalance = $this->FinanceBalances->get($id, [
            'contain' => ['Users']
        ]);

        $this->set('financeBalance', $financeBalance);
        $this->set('_serialize', ['financeBalance']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financeBalance = $this->FinanceBalances->newEntity();
        if ($this->request->is('post')) {
            $financeBalance = $this->FinanceBalances->patchEntity($financeBalance, $this->request->getData());
            if ($this->FinanceBalances->save($financeBalance)) {
                $this->Flash->success(__('The finance balance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finance balance could not be saved. Please, try again.'));
        }
        $users = $this->FinanceBalances->Users->find('list', ['limit' => 200]);
        $this->set(compact('financeBalance', 'users'));
        $this->set('_serialize', ['financeBalance']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Finance Balance id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financeBalance = $this->FinanceBalances->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $financeBalance = $this->FinanceBalances->patchEntity($financeBalance, $this->request->getData());
            if ($this->FinanceBalances->save($financeBalance)) {
                $this->Flash->success(__('The finance balance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finance balance could not be saved. Please, try again.'));
        }
        $users = $this->FinanceBalances->Users->find('list', ['limit' => 200]);
        $this->set(compact('financeBalance', 'users'));
        $this->set('_serialize', ['financeBalance']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Finance Balance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $financeBalance = $this->FinanceBalances->get($id);
        if ($this->FinanceBalances->delete($financeBalance)) {
            $this->Flash->success(__('The finance balance has been deleted.'));
        } else {
            $this->Flash->error(__('The finance balance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
