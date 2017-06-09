<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Dropboxes Controller
 *
 * @property \App\Model\Table\DropboxesTable $Dropboxes
 *
 * @method \App\Model\Entity\Dropbox[] paginate($object = null, array $settings = [])
 */
class DropboxesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Files', 'Users']
        ];
        $dropboxes = $this->paginate($this->Dropboxes);

        $this->set(compact('dropboxes'));
        $this->set('_serialize', ['dropboxes']);
    }

    /**
     * View method
     *
     * @param string|null $id Dropbox id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $dropbox = $this->Dropboxes->get($id, [
            'contain' => ['Files', 'Users']
        ]);

        $this->set('dropbox', $dropbox);
        $this->set('_serialize', ['dropbox']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $dropbox = $this->Dropboxes->newEntity();
        if ($this->request->is('post')) {
            $dropbox = $this->Dropboxes->patchEntity($dropbox, $this->request->getData());
            if ($this->Dropboxes->save($dropbox)) {
                $this->Flash->success(__('The dropbox has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dropbox could not be saved. Please, try again.'));
        }
        $files = $this->Dropboxes->Files->find('list', ['limit' => 200]);
        $users = $this->Dropboxes->Users->find('list', ['limit' => 200]);
        $this->set(compact('dropbox', 'files', 'users'));
        $this->set('_serialize', ['dropbox']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Dropbox id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $dropbox = $this->Dropboxes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $dropbox = $this->Dropboxes->patchEntity($dropbox, $this->request->getData());
            if ($this->Dropboxes->save($dropbox)) {
                $this->Flash->success(__('The dropbox has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The dropbox could not be saved. Please, try again.'));
        }
        $files = $this->Dropboxes->Files->find('list', ['limit' => 200]);
        $users = $this->Dropboxes->Users->find('list', ['limit' => 200]);
        $this->set(compact('dropbox', 'files', 'users'));
        $this->set('_serialize', ['dropbox']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Dropbox id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $dropbox = $this->Dropboxes->get($id);
        if ($this->Dropboxes->delete($dropbox)) {
            $this->Flash->success(__('The dropbox has been deleted.'));
        } else {
            $this->Flash->error(__('The dropbox could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
