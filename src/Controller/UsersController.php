<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\Folder;
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
            'contain' => ['Customers', 'Documents', 'Finances', 'ProjectIssueSolutions', 'ProjectIssues', 'ProjectSchedules', 'Projects', 'Tasks', 'UserDepartmentRoles' => function($q){
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
        $_user = $this->request->session()->read('Auth')['User'];
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());

            if ($this->Users->save($user)) {
                $this->loadModel('UserDepartmentRoles');
                $this->loadModel('Departments');
                for ($i=1; $i <= $this->request->getData('num') ; $i++) { 
                    $position = $this->UserDepartmentRoles->newEntity();
                    $position->user_id = $user->id;
                    $position->department_id = $this->request->getData('department_' . $i);
                    $position->role_id = $this->request->getData('role_id_' . $i);
                    //新建个人文件夹
                    $crumbs = $this->Departments->find('path',['for' => $position->department_id])
                        ->extract('name')->toArray();
                    $path = DB_ROOT . ($crumbs ? ($crumbs ? implode(DS, $crumbs) . DS : '') : '') . $user->username;

                    $path = iconv('utf-8', 'gbk', $path);
                    if(!is_dir($path)) mkdir($path);

                    $this->loadModel('Documents');
                    $department = $this->Departments->get($position->department_id);
                    
                    $folder = $this->Documents->newEntity([
                        'user_id' =>$_user['id'],
                        'department_id' => $position->department_id,
                        'spell' => $this->getALLPY($user->username),
                        'name' => $user->username,
                        'origin_name' => $user->username,
                        'size' => 0,
                        'ext' => '',
                        'is_dir' => 1,
                        'is_sys' => 1,
                        'parent_id' => $department->document_id,
                        'level' => 1,
                        'owner' => $user->id,
                        'deleted' => 0
                    ]); 
                    $this->Documents->save($folder);
                    $folder->ord = $this->Documents->find()->where(['is_dir' => 1])->order(['ord' => 'DESC'])->first();
                    $folder->ord = $folder->ord ? $folder->ord->ord ++ : 1;
                    $position->document_id = $folder->id;
                    $this->UserDepartmentRoles->save($position);

                    $parentFolders = $this->Documents->query()->update()
                        ->where(['lft < ' => $folder->lft, 'rght > ' => $folder->rght, 'is_dir' => 1])
                        ->set(['modified' => date('Y-m-d H:i:s')])
                        ->execute();

                }

               

                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->loadModel('Departments');
        $this->loadModel('Roles');
        $departments = $this->Departments->find('list')->where(['parent_id' => 0]);
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
        $_user = $this->request->session()->read('Auth')['User'];
        $user = $this->Users->get($id, [
            'contain' => ['UserDepartmentRoles']
        ]);
        $this->loadModel('Departments');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $origin_name = $user->username;
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $dirtyName = 0;
                $this->loadModel('Documents');                
                if ($origin_name != $user->username) {
                    $dirtyName = 1;
                }
                for ($i=1; $i <= $this->request->getData('num') ; $i++) {

                    if (isset($_POST['position_id_' . $i]) && $_POST['position_id_' . $i]) {//已存在部门改变
                        $dirtyDid = 0;
                        $newDepartmentId = $this->request->getData('department_' . $i);
                        $position = $this->Users->UserDepartmentRoles->get($this->request->getData('position_id_' . $i));
                        $position->role_id = $this->request->getData('role_id_' . $i);
                        $position->department_id = $newDepartmentId;
                        $folder = $this->Documents->get($position->document_id);

                        if ($dirtyName == 1) {
                            $folder->origin_name = $folder->name = $user->username;
                            $folder->spell = $this->getALLPY($user->username);
                        }

                        if ($position->department_id != $newDepartmentId) {//部门改变
                            $dirtyDid = 1;
                            $oldpath = $newpath = DB_ROOT;
                            $track;
                            $newParentFolderId = $this->Departments->get($newDepartmentId)->document_id;
                            $newParentFolder = $this->Documents->get($newFolderId);
                            $folder->parent_id = $newParentFolderId;
                            $folder->department_id = $newDepartmentId;

                            $crumbs = $this->Documents->find()
                                ->where(['lft < ' => $folder->lft, 'rght > ' => $folder->rght, 'is_dir' => 1])
                                ->extract('name')
                                ->toArray();
                            $oldpath .= ($crumbs ? implode(DS, $crumbs) . DS : '') .$origin_name;
                            $size = (new Folder($oldpath))->dirsize();
                            $oldpath = iconv('utf-8', 'gbk', $oldpath);


                            $crumbs = $this->Documents->find()
                                ->where(['lft <= ' => $newParentFolder->lft, 'rght >= ' => $newParentFolder->rght, 'is_dir' => 1])
                                ->extract('name')
                                ->toArray();
                            $newpath .= ($crumbs ? implode(DS, $crumbs) . DS : '') . $user->username;
                            $newpath = iconv('utf-8', 'gbk', $newpath);
                            //重命名文件夹
                            if(file_exists($oldpath)) rename($oldpath, $newpath);
                            
                            $this->Documents->query()
                                ->update()
                                ->set(['modified' => date('Y-m-d H:i:s'), "size=size - $size"])
                                ->where(['lft < ' => $folder->lft, 'rght > ' => $folder->rght, 'is_dir' => 1])
                                ->execute();
                            $this->Documents->query()
                                ->update()
                                ->set(['modified' => date('Y-m-d H:i:s'), "size=size + $size"])
                                ->where(['lft <= ' => $newParentFolder->lft, 'rght >= ' => $newParentFolder->rght, 'is_dir' => 1])
                                ->execute();
                            $parentFolder = $this->Documents->find('all')
                                ->where(['name' => 'department_' . $position->department_id])
                                ->first();
                        }
                        if($dirtyName || $dirtyDid){
                            $this->Documents->save($folder);
                        }
                        $this->Users->UserDepartmentRoles->save($position);
                        
                    } elseif($this->request->getData('department_id_' . $i)) {//新增部门
                        $position = $this->Users->UserDepartmentRoles->newEntity();
                        $position->user_id = $user->id;
                        $position->department_id = $this->request->getData('department_id_' . $i);
                        $position->role_id = $this->request->getData('role_id_' . $i);
                        //新建个人文件夹
                        $parentFolderId = $this->Departments->get($position->department_id)->document_id;
                        $parentFolder = $this->Documents->get($parentFolderId);

                        $crumbs = $this->Documents->find()
                            ->where(['lft <= ' => $parentFolder->lft, 'rght >= ' => $parentFolder->rght, 'is_dir' => 1])
                            ->extract('name')
                            ->toArray();
                        $path =  DB_ROOT . ($crumbs ? implode(DS, $crumbs) . DS : '') .$user->username;print_r($path);
                        $path = iconv('utf-8', 'gbk', $path);
                        if(!is_dir($path)) mkdir($path);

                        $folder = $this->Documents->newEntity([
                            'department_id' => $position->department_id,
                            'user_id' =>$_user['id'],
                            'spell' => $this->getALLPY($user->username),
                            'name' => $user->username,
                            'origin_name' => $user->username,
                            'parent_id' => $parentFolderId,
                            'ext' => '',
                            'size' => 0,
                            'is_dir' => 1,
                            'is_sys' => 1,
                            'level' => 1,
                            'owner' => $user->id,
                            'deleted' => 0
                        ]); 
                        $this->Documents->save($folder);print_r($folder);
                        $folder->ord = $this->Documents->find()->where(['is_dir' => 1])->order(['ord' => 'DESC'])->first();
                        $folder->ord = $folder->ord ? $folder->ord->ord ++ : 1;
                        $this->Documents->save($folder);

                        $position->document_id = $folder->id;
                        $this->Users->UserDepartmentRoles->save($position);
                    }
                      
                   
                }

               
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
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

        $this->loadModel('Documents');
        $user = $this->Users->get($id,[
            'contain' => ['UserDepartmentRoles']
        ]);
        $positionArr = [];
        foreach ($user->user_department_roles as $position) {
            $path = $this->Documents->find('path',['for' => $position->document_id])->extract('name')->toArray();
            $path = DB_ROOT . implode(DS, $path) ;
            $path = iconv('utf-8', 'gbk', $path);
            $result = (new Folder($path))->delete();
            $positionArr[] = $position->document_id;
        }
        if ($this->Users->delete($user)) {
            $positionArr && $this->Documents->deleteAll(['id in '=> $positionArr]);
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
        $this->loadModel('Documents');
        $data = null;

        $position =  $this->UserDepartmentRoles->get($this->request->getData('id'));
        
        $path = $this->Documents->find('path',['for' => $position->document_id])->extract('name')->toArray();
        $path = DB_ROOT . ($path ? implode(DS, $path) . DS : '');
        $path = iconv('utf-8', 'gbk', $path);
        if ((new Folder($path))->delete()) {
            $folder = $this->Documents->get($position->document_id);
            $this->Documents->delete($folder); 
            $this->UserDepartmentRoles->delete($position);
            $data = 1;
        }
        
            
        $this->response->body($data);       

        return $this->response;
    }
}
