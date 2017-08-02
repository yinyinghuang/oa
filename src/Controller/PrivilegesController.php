<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Privileges Controller
 *
 * @property \App\Model\Table\PrivilegesTable $Privileges
 *
 * @method \App\Model\Entity\Privilege[] paginate($object = null, array $settings = [])
 */
class PrivilegesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->loadModel('Departments');
        $query = $this->Privileges->find();
        $departments = $this->Departments->find()
            ->where(['parent_id' => 0])
            ->combine('id', 'name')
            ->toArray();

        $privileges = [];
        foreach ($query as $value) {
            $privileges[$value->department_id][$value->role_id][$value->what] = '';
        }
        $this->set(compact('privileges', 'departments'));
        $this->set('_serialize', ['privileges']);
    }

    /**
     * View method
     *
     * @param string|null $id Privilege id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $privilege = $this->Privileges->get($id, [
            'contain' => []
        ]);

        $this->set('privilege', $privilege);
        $this->set('_serialize', ['privilege']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $privilege = $this->Privileges->newEntity();
        if ($this->request->is('post')) {
            $privilege->who = $this->request->getData('who');
            $privilege->what = $this->request->getData('what');
            $privilege->how = implode('',$this->request->getData('how'));
            
            if ($this->Privileges->save($privilege)) {
                $this->Flash->success(__('The privilege has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The privilege could not be saved. Please, try again.'));
        }
        $this->loadModel('Departments');
        $this->loadModel('Roles');
        $this->loadModel('Users');
        $departments = $this->Departments->find('list');
        $roles = $this->Roles->find('list');
        $users = $this->Users->find('list');
        $this->set(compact('privilege', 'departments', 'roles', 'users'));
        $this->set('_serialize', ['privilege']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Privilege id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit()
    {
        $this->loadModel('CustomerCategories');
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $department_id = $this->request->getData('did') ? $this->request->getData('did') : 0;
            $role_id = $this->request->getData('rid') ? $this->request->getData('rid') : 0;
            $user_id = $this->request->getData('uid');
            $privilege = $this->Privileges->find()
                ->where(['department_id' => $department_id, 'role_id' => $role_id])
                ->combine('what', 'how')
                ->toArray();
            $data = [];
            $auth = $this->request->getData('auth');

            $this->Privileges->deleteAll(['department_id' => $department_id, 'role_id' => $role_id]);
            if ($auth) {
                foreach ($auth as $key => $value) {
                    foreach ($value as $v) {
                        isset($queryInsert) ? $queryInsert->insert(['department_id', 'role_id', 'what', 'how'])
                            ->values(['department_id' => $department_id, 'role_id' => $role_id, 'what' => $key, 'how' => $v])
                             : 
                            $queryInsert = $this->Privileges->query()
                            ->insert(['department_id', 'role_id', 'what', 'how'])
                            ->values(['department_id' => $department_id, 'role_id' => $role_id, 'what' => $key, 'how' => $v]);
                    }                   
                    
                }
                if (isset($queryInsert)) {
                    $queryInsert->execute();
                }
            }
            $this->Flash->success(__('The privilege has been saved.'));

            return $this->redirect(['action' => 'index']);
            
            $this->Flash->error(__('The privilege could not be saved. Please, try again.'));
        } else {
            $department_id = $this->request->query('did') ? $this->request->query('did') : 0;
            $role_id = $this->request->query('rid') ? $this->request->query('rid') : 0;
            $user_id = $this->request->query('uid');
            $query = $this->Privileges->find()
                ->where(['department_id' => $department_id, 'role_id' => $role_id])
                ->select(['what', 'how']);
            foreach ($query as $value) {
                $privilege[$value->what][] = $value->how;
            }
        }
        $customerCate = $this->CustomerCategories->find()
            ->where(['parent_id' => 0]);
        $customerCateCount = $customerCate->count();
        $this->set(compact('privilege', 'customerCate', 'customerCateCount', 'department_id', 'role_id', 'user_id'));
        $this->set('_serialize', ['privilege']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Privilege id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $privilege = $this->Privileges->get($id);
        if ($this->Privileges->delete($privilege)) {
            $this->Flash->success(__('The privilege has been deleted.'));
        } else {
            $this->Flash->error(__('The privilege could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
