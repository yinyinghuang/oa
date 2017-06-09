<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Departments Controller
 *
 * @property \App\Model\Table\DepartmentsTable $Departments
 *
 * @method \App\Model\Entity\Department[] paginate($object = null, array $settings = [])
 */
class DepartmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($parent_id = 0)
    {
        $this->paginate = [
            'contain' => ['ChildDepartments' => function($q){
                return $q->select(['ChildDepartments.parent_id']);
            }],
            'conditions' => ['Departments.parent_id' => $parent_id]
        ];
        $departments = $this->paginate($this->Departments);
        foreach ($departments as $department) {
            $department->childCount = $this->Departments->childCount($department);
        }

         $crumbs = null;
        if ($parent_id != 0) {
            $crumbs = $this->Departments->find('path', ['for' => $parent_id]);
            $uplevel = $this->Departments->get($parent_id);
        }

        $this->set(compact('departments', 'crumbs', 'uplevel'));
        $this->set('_serialize', ['departments']);
    }

    /**
     * View method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $department = $this->Departments->get($id, [
            'contain' => ['ParentDepartments', 'UserDepartmentRoles' => function($q){
                return $q->contain(['Users', 'Roles'])->select(['Users.username','Roles.name','UserDepartmentRoles.user_id','UserDepartmentRoles.role_id', 'UserDepartmentRoles.department_id', 'Users.id']);
            }]
        ]);

        $this->set('department', $department);
        $this->set('_serialize', ['department']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($parent_id = null)
    {   
        $department = $this->Departments->newEntity();
        if ($this->request->is('post')) {
            if ($this->request->getData('parent_id') !== '0') {
                $count = $this->Departments->find('all',['conditions' =>['id' => $this->request->getData('parent_id')]])->count();
                if ($count === 0) {
                    $this->Flash->error(__('上级分类不存在'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));

                return $this->redirect(['action' => 'index'], $this->request->getData('parent_id'));
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }
        $parentDepartments = $this->Departments->ParentDepartments->find('list', [
            'conditions' => ['parent_id' => 0],
            'limit' => 200
        ]);
        $this->set(compact('department', 'parentDepartments', 'parent_id'));
        $this->set('_serialize', ['department']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $department = $this->Departments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('parent_id') != null) {
                $parent = $this->Departments->get($this->request->getData('parent_id'));
                if ($parent->lft > $department->lft && $parent->lft < $department->rght) {
                    $this->Flash->error(__('不可选择下级分类作为上级分类'));

                    return $this->redirect(['action' => 'edit', $id]);
                }
            }
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The department could not be saved. Please, try again.'));
        }

        $results = $this->Departments->find('path', ['for' => $id]);
        $parentDepartments = [];

        foreach ($results as $value) {         
            if ($value->id != $id) {
                $list = $this->Departments->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $value->options = $arr; 
                $parentDepartments[] = $value;
            }            
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

        $this->set(compact('department', 'parentDepartments'));
        $this->set('_serialize', ['department']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Department id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $department = $this->Departments->get($id,[
            'contain' => ['UserDepartmentRoles','ChildDepartments']
        ]);
        if ($department->child_departments || $department->user_department_roles) {
            $this->Flash->error(__('当前部门下存在子部门或者用户，请清空子部门及用户后再操作.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->Departments->delete($department)) {
            $this->Flash->success(__('The department has been deleted.'));
        } else {
            $this->Flash->error(__('The department could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function loadChilds()
    {
        $data = array();
        $this->request->allowMethod(['post']);
        if ($this->request->getData('parent_id') !== '') {
            $data = $this->Departments->ParentDepartments->find('list', ['limit' => 200])->where(['parent_id' => $this->request->getData('parent_id')]);
        }
        $this->response->body(json_encode($data));
        return $this->response;
    }
}
