<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {   
        $this->paginate = [
            'contain' => ['UserDepartmentRoles' => function($q){
                return $q->contain(['Departments', 'Roles'])
                    ->select(['Departments.name', 'Roles.name', 'UserDepartmentRoles.user_id'])
                    ->order(['UserDepartmentRoles.id ASC']);
            }]
        ];
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Customers', 'Dropboxes', 'Finances', 'ProjectIssueSolutions', 'ProjectIssues', 'ProjectSchedules', 'Projects', 'Tasks', 'UserDepartmentRoles' => function($q){
                return $q->contain(['Departments', 'Roles'])->select(['UserDepartmentRoles.user_id', 'Departments.name', 'Roles.name']);
            }]
        ]);


        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->loadModel('UserDepartmentRoles');

                for ($i=1; $i <= $this->request->getData('num') ; $i++) { 
                    $position = $this->UserDepartmentRoles->newEntity();
                    $position->user_id = $user->id;
                    $position->department_id = $this->request->getData('department_' . $i);
                    $position->role_id = $this->request->getData('role_id_' . $i);
                    $this->UserDepartmentRoles->save($position);
                }

                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->loadModel('Departments');
        $this->loadModel('Roles');
        $departments = $this->Departments->find('list');
        $roles = $this->Roles->find('list');
        $this->set(compact('user', 'departments', 'roles'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['UserDepartmentRoles']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                for ($i=1; $i <= $this->request->getData('num') ; $i++) { 
                    if (isset($_POST['position_id_' . $i])) {
                        $position = $this->Users->UserDepartmentRoles->newEntity();
                        $position->id = $this->request->getData('position_id_' . $i);
                        $position->user_id = $user->id;
                        $position->department_id = $this->request->getData('department_id_' . $i);
                        $position->role_id = $this->request->getData('role_id_' . $i);
                        $this->Users->UserDepartmentRoles->save($position);
                    }
                }
               
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->loadModel('Departments');
        $this->loadModel('Roles');

        foreach ($user->user_department_roles as &$position) {

            $query = $this->Departments->find('path', ['for' => $position->department_id]);
            $parentDepartments = [];

            foreach ($query as $value) { 

                $list = $this->Departments->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $value->options = $arr; 
                $parentDepartments[] = $value;
                            
            }

            if ($parentDepartments == []) {
                $list = $this->Departments->find('list', ['conditions' => ['parent_id' => 0]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $options = new \StdClass();
                $options->id = 0;
                $options->options = $arr; 
                $parentDepartments[] = $options;
            }
            $position->departmentList = $parentDepartments;
        }
        $roles = $this->Roles->find('list');
        $departments = $this->Departments->find('list')->where(['parent_id' => 0]);
        $this->set(compact('user', 'roles','departments'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('用户名或密码错误，请重试!'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

    public function deletePosition()
    {
        $this->request->allowMethod(['post']);
        $this->loadModel('UserDepartmentRoles');
        $data = null;

        $position =  $this->UserDepartmentRoles->get($this->request->getData('id'));

        if ($this->UserDepartmentRoles->delete($position)) {
            $data = 1;
        }else{
            $data = 0;
        }
            
        $this->response->body($data);       

        return $this->response;
    }
}
