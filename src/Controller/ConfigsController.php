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
        $this->loadModel('Holidays');
        $holidays = $this->Holidays->find()
            ->where(['OR' => ['start_date LIKE' => date('Y') . '%', 'end_date LIKE' => date('Y') . '%']])
            ->map(function($row){
                $row->start_month = substr($row->start_date, 4, 2)-1;
                $row->start_day = substr($row->start_date, 6, 2);
                $row->end_month = substr($row->end_date, 4, 2)-1;
                $row->end_day = substr($row->end_date, 6, 2);
                $row->type = intval($row->type);
                return $row;
            });
        $weekdays = $this->Configs->findByName('weekdays')->first()->content;
        $weekdays = explode(',', $weekdays);
        $this->set(compact('holidays','weekdays'));
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
            $config->name = 'weekdays';
            $config->content = implode(',', $this->request->getData('weekdays'));
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

    public function saveHoliday()
    {
        $this->request->allowMethod(['post']);
        $this->loadModel('Holidays');
        $entity = $this->Holidays->newEntity();
        $entity->id = $this->request->getData('id');
        $entity->name = $this->request->getData('name');
        $entity->type = $this->request->getData('type');
        $entity->start_date = date('Ymd', strtotime(substr($this->request->getData('startDate'), 0, 15)));
        $entity->end_date = date('Ymd', strtotime(substr($this->request->getData('endDate'), 0, 15)));
        
        if ($this->Holidays->save($entity)) {
            $data = 1;
        }else{
            $data = $entity;
        }
        $this->response->body($data);
        return $this->response;
    }
    public function deleteHoliday()
    {
        $this->request->allowMethod(['post']);
        $this->loadModel('Holidays');
        
        $entity = $this->Holidays->get($this->request->getData('id'));
        if ($this->Holidays->delete($entity)) {
            $data = 1;
        }else{
            $data = $entity;
        }
        $this->response->body($data);
        return $this->response;
    }

}
