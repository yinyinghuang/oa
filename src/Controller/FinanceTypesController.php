<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FinanceTypes Controller
 *
 * @property \App\Model\Table\FinanceTypesTable $FinanceTypes
 *
 * @method \App\Model\Entity\FinanceType[] paginate($object = null, array $settings = [])
 */
class FinanceTypesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $financeTypes = $this->paginate($this->FinanceTypes);

        $this->set(compact('financeTypes'));
        $this->set('_serialize', ['financeTypes']);
    }

    /**
     * View method
     *
     * @param string|null $id Finance Type id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $financeType = $this->FinanceTypes->get($id, [
            'contain' => []
        ]);

        $this->set('financeType', $financeType);
        $this->set('_serialize', ['financeType']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $financeType = $this->FinanceTypes->newEntity();
        if ($this->request->is('post')) {
            $financeType = $this->FinanceTypes->patchEntity($financeType, $this->request->getData());
            if ($this->FinanceTypes->save($financeType)) {
                $this->Flash->success(__('The finance type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finance type could not be saved. Please, try again.'));
        }
        $this->set(compact('financeType'));
        $this->set('_serialize', ['financeType']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Finance Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $financeType = $this->FinanceTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $financeType = $this->FinanceTypes->patchEntity($financeType, $this->request->getData());
            if ($this->FinanceTypes->save($financeType)) {
                $this->Flash->success(__('The finance type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The finance type could not be saved. Please, try again.'));
        }
        $this->set(compact('financeType'));
        $this->set('_serialize', ['financeType']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Finance Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $financeType = $this->FinanceTypes->get($id);
        if ($this->FinanceTypes->delete($financeType)) {
            $this->Flash->success(__('The finance type has been deleted.'));
        } else {
            $this->Flash->error(__('The finance type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
