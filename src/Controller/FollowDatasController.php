<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * FollowDatas Controller
 *
 * @property \App\Model\Table\FollowDatasTable $FollowDatas
 *
 * @method \App\Model\Entity\FollowData[] paginate($object = null, array $settings = [])
 */
class FollowDatasController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Accounts']
        ];
        $followDatas = $this->paginate($this->FollowDatas);

        $this->set(compact('followDatas'));
        $this->set('_serialize', ['followDatas']);
    }

    /**
     * View method
     *
     * @param string|null $id Follow Data id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $followData = $this->FollowDatas->get($id, [
            'contain' => ['Accounts']
        ]);

        $this->set('followData', $followData);
        $this->set('_serialize', ['followData']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $followData = $this->FollowDatas->newEntity();
        if ($this->request->is('post')) {
            $followData = $this->FollowDatas->patchEntity($followData, $this->request->getData());
            if ($this->FollowDatas->save($followData)) {
                $this->Flash->success(__('The follow data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The follow data could not be saved. Please, try again.'));
        }
        $accounts = $this->FollowDatas->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('followData', 'accounts'));
        $this->set('_serialize', ['followData']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Follow Data id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $followData = $this->FollowDatas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $followData = $this->FollowDatas->patchEntity($followData, $this->request->getData());
            if ($this->FollowDatas->save($followData)) {
                $this->Flash->success(__('The follow data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The follow data could not be saved. Please, try again.'));
        }
        $accounts = $this->FollowDatas->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('followData', 'accounts'));
        $this->set('_serialize', ['followData']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Follow Data id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $followData = $this->FollowDatas->get($id);
        if ($this->FollowDatas->delete($followData)) {
            $this->Flash->success(__('The follow data has been deleted.'));
        } else {
            $this->Flash->error(__('The follow data could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
