<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
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
        $_user = $this->request->session()->read('Auth')['User'];
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
                $crumbs = $this->Departments->find('path',['for' => $department->id])
                        ->select(['name']);
                $path = DB_ROOT;
                foreach ($crumbs as $value) {
                    $path .= $value->name . DS;
                }
                $path = iconv('utf-8', 'gbk', $path);
                if(!is_dir($path)) mkdir($path);
                $department->parent_id && $parentDepartment = $this->Departments->get($department->parent_id);
                //新建部门文件夹及其下公共文件夹，level公司级别文件夹-1,部门级别文件夹0，个人级别文件夹1
                $this->loadModel('Documents');
                $folder = $this->Documents->newEntity([
                    'user_id' =>$_user['id'],
                    'department_id' => $department->id,
                    'spell' => $this->getALLPY($department->name),
                    'name' => $department->name,
                    'origin_name' => $department->name,
                    'size' => 0,
                    'ext' => '',
                    'is_dir' => 1,
                    'is_sys' => 1,
                    'parent_id' => $department->parent_id ? $this->Documents->get($parentDepartment->document_id)->id : 0,
                    'level' => 0,
                    'deleted' => 0
                ]); 
                $this->Documents->save($folder);
                $folder->ord = $this->Documents->find()->where(['is_dir' => 1])->order(['ord' => 'DESC'])->first();
                $folder->ord = $folder->ord ? $folder->ord->ord ++ : 1;
                $this->Documents->save($folder);
                $department->document_id = $folder->id; 
                $this->Departments->save($department);

                if(!is_dir($path . DS . 'common')) mkdir($path . DS . 'common');
                $folder = $this->Documents->newEntity([
                    'user_id' =>$_user['id'],
                    'department_id' => $department->id,
                    'spell' => 'bumengonggongwenjianjia',
                    'name' => 'common',
                    'origin_name' => '部门公共文件夹',
                    'size' => 0,
                    'ext' => '',
                    'is_dir' => 1,
                    'is_sys' => 1,
                    'parent_id' => $folder->id,
                    'level' => 0,//若有上级文件，则为0
                    'deleted' => 0
                ]); 
                $this->Documents->save($folder);
                $folder->ord = $this->Documents->find()->where(['is_dir' => 1])->order(['ord' => 'DESC'])->first();
                $folder->ord = $folder->ord ? $folder->ord->ord ++ : 1;

                
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
            if ($this->request->getData('parent_id') != 0) {
                $parent = $this->Departments->get($this->request->getData('parent_id'));
                if ($parent->lft > $department->lft && $parent->lft < $department->rght) {
                    $this->Flash->error(__('不可选择下级分类作为上级分类'));

                    return $this->redirect(['action' => 'edit', $id]);
                }
            }
            $origin_name = $department->name;
            $origin_pid = $department->parent_id;
            $department = $this->Departments->patchEntity($department, $this->request->getData());
            if ($this->Departments->save($department)) {

                //部门文件夹及其下公共文件夹
                $this->loadModel('Documents');
                $folder = $this->Documents->get($department->document_id);
                if ($folder->origin_name != $department->name) {
                    !isset($dirtyName) && $dirtyName = 1;
                    $folder->origin_name = $folder->name = $department->name;
                    $folder->spell = $this->getALLPY($department->name);                    
                }
                if ($origin_pid != $department->parent_id) {
                    !isset($dirtyPid) && $dirtyPid = 1;
                    $newParentDepartment = $this->Departments->get($department->parent_id);//新上级部门
                    $folder->parent_id = $newparentDepartment->document_id;//文档上级文档为新上级部门的文档
                }

                if (isset($ditryPid) || isset($ditryName)) {
                    if (isset($dirtyPid)) {
                        $query = $this->Documents->query()
                            ->update()
                            ->where(['lft < ' => $folder->lft, 'rght > ' => $folder->rght, 'is_dir' => 1])
                            ->set(['modified' => date('Y-m-d H:i:s'),'size=size-$folder->size'])
                            ->execute();//更新原始上级文档
                        $newParentFolders = $this->Documents->get($folder->parent_id);
                        $query = $this->Documents->query()
                            ->update()
                            ->where(['lft <= ' => $newParentFolders->lft, 'rght >= ' => $newParentFolders->rght, 'is_dir' => 1])
                            ->set(['modified' => date('Y-m-d H:i:s'),'size=size+$folder->size'])
                            ->execute();//更新新上级文档
                    } else {
                        $query = $this->Documents->query()
                            ->update()
                            ->where(['lft < ' => $folder->lft, 'rght > ' => $folder->rght, 'is_dir' => 1])
                            ->set(['modified' => date('Y-m-d H:i:s')])
                            ->execute();
                    }
                    $this->Documents->save($folder);
                }

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
        $this->loadModel('Documents');
        $this->Documents->deleteAll(['id' => $department->document_id]);
        $parentDepartments = $this->Departments->find('path',['for' => $id])
            ->order(['level' => 'ASC']);
        $path = DB_ROOT;
        foreach ($parentDepartments as $value) {
            $path .= $value->name . DS;
        }
        $path = iconv('utf-8', 'gbk', $path);
        $folder = new Folder($path);

        $delete = $folder->delete();
        if ($delete) {
            if ($this->Departments->delete($department)) {

                $this->Flash->success(__('The department has been deleted.'));
            } else {
                $this->Flash->error(__('The department could not be deleted. Please, try again.'));
            }
        }else {
            $this->Flash->error(__('部门文件删除失败'));
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
