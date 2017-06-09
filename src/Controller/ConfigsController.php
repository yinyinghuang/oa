<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Configs Controller
 *
 * @property \App\Model\Table\ConfigsTable $Configs
 *
 * @method \App\Model\Entity\Config[] paginate($object = null, array $settings = [])
 */
class ConfigsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $configs = $this->paginate($this->Configs);

        $this->set(compact('configs'));
        $this->set('_serialize', ['configs']);
    }

    /**
     * View method
     *
     * @param string|null $id Config id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $config = $this->Configs->get($id, [
            'contain' => []
        ]);

        $this->set('config', $config);
        $this->set('_serialize', ['config']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $config = $this->Configs->newEntity();
        if ($this->request->is('post')) {
            $config = $this->Configs->patchEntity($config, $this->request->getData());
            if ($this->Configs->save($config)) {
                $this->Flash->success(__('The config has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The config could not be saved. Please, try again.'));
        }
        $this->set(compact('config'));
        $this->set('_serialize', ['config']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Config id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $config = $this->Configs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $config = $this->Configs->patchEntity($config, $this->request->getData());
            if ($this->Configs->save($config)) {
                $this->Flash->success(__('The config has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The config could not be saved. Please, try again.'));
        }
        $this->set(compact('config'));
        $this->set('_serialize', ['config']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Config id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $config = $this->Configs->get($id);
        if ($this->Configs->delete($config)) {
            $this->Flash->success(__('The config has been deleted.'));
        } else {
            $this->Flash->error(__('The config could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
