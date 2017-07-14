<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 *
 * @method \App\Model\Entity\Document[] paginate($object = null, array $settings = [])
 */

class DocumentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
      $_user = $this->request->session()->read('Auth')['User'];
      $this->loadModel('UserDepartmentRoles');
      $this->loadModel('Departments');
      $positions = $this->UserDepartmentRoles->findByUserId($_user['id']);

      $conditions = null;
      $parent_id = isset($_GET['pid']) && isset($_GET['pid']) != 0 ? $_GET['pid'] : 0;
      $conditions['Documents.parent_id'] = $parent_id;

      if ($parent_id) {//上级文件夹
        $parentDocument = $this->Documents->get($parent_id);
        $parentDepartment = $this->Departments->get($parentDocument->department_id);
        $relativeDepartments = $this->Departments->find()
          ->where(['or' => [['lft >=' => $parentDepartment->lft, 'rght <=' => $parentDepartment->rght], ['lft <' => $parentDepartment->lft, 'rght >' => $parentDepartment->rght]]])
          ->extract('id')
          ->toArray();//文件夹所属部门及下级部门 或者是上级部门

        $role = $this->UserDepartmentRoles->find()//当前员工是否属于该部门或其子部门
          ->where(['user_id' => $_user['id'], 'department_id in' => $relativeDepartments])->first();
        if (!$role) {
          $this->Flash->error(__('无权访问.'));
          return $this->redirect($this->referer());
        }
      }

      foreach ($positions as $value) {
        switch ($value->role_id) {
          case '1'://只看自己上传的，只看自己的文件夹，或者是部门共享文件，或者公司共享文件
            $parentDepartments = $this->Departments->find('path',['for' => $value->department_id])
              ->extract('id')
              ->toArray();
            $conditions['OR'][] = ['Documents.user_id' => $_user['id']];
            $conditions['OR'][] = ['Documents.name' => 'user_' . $_user['id']];
            $conditions['OR'][] = ['Documents.level' => 0, 'Documents.department_id in ' => $parentDepartments];
            $conditions['OR'][] = ['Documents.level' => -1];
          break;
          case '2'://部门文件，或者公司共享文件
            $parentDepartment = $this->Departments->get($value->department_id);
            $parentDepartments = $this->Departments->find()
              ->where(['lft < ' => $parentDepartment->lft, 'rght > ' => $parentDepartment->rght])
              ->extract('id')
              ->toArray();
            $conditions['OR'][] = ['Documents.level <' => 1, 'Documents.department_id in' => $parentDepartments];
            $conditions['OR'][] = ['Documents.level <' => 2, 'Documents.department_id' => $value->department_id];
            $conditions['OR'][] = ['Documents.level' => -1];
          break;
        }
      }
       
      $iconArr = ['png' => 'image', 'gif' => 'image', 'jpg' => 'image', 'xls' => 'file-excel-o', 'xlsx' => 'file-excel-o', 'doc' => 'file-word-o', 'docx' => 'file-word-o', 'pdf' => 'file-pdf-o', 'ppt' => 'file-powerpoint-o', 'zip' => 'file-zip-o', 'txt' => 'file-text-o' ];
      $this->paginate = [
          'conditions' => ['Documents.parent_id' => $parent_id] + $conditions,
          'order' => ['Documents.is_dir' => 'DESC','Documents.modified' => 'DESC']
      ];
      $documents = $this->paginate($this->Documents);
      foreach ($documents as $value) {
          $value->size = $this->getRealSize($value->size);
      }
      $path = '/';
      if($parent_id){
          $path .= 'dropboxes/';
          $crumbs = $this->Documents->find('path',['for' => $parent_id]);
          foreach ($crumbs as $crumb) {
              $path .= $crumb->name . '/' ;
          }
      }

      $threads = $this->Documents->find('children', ['for' => 1])
        ->find('threaded')
        ->select(['name', 'origin_name', 'id', 'parent_id'])
        ->where(['is_dir' => 1]);
      
      $html = $this->dirList($threads);
      
      $this->set(compact('documents','parent_id','crumbs', 'path', 'iconArr', 'threads', 'html','parentDocument'));
      $this->set('_serialize', ['documents']);
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['Users', 'ParentDocuments', 'ChildDocuments']
        ]);

        $this->set('document', $document);
        $this->set('_serialize', ['document']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $document = $this->Documents->newEntity();
        if ($this->request->is('post')) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $users = $this->Documents->Users->find('list', ['limit' => 200]);
        $parentDocuments = $this->Documents->ParentDocuments->find('list', ['limit' => 200]);
        $this->set(compact('document', 'users', 'parentDocuments'));
        $this->set('_serialize', ['document']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $users = $this->Documents->Users->find('list', ['limit' => 200]);
        $parentDocuments = $this->Documents->ParentDocuments->find('list', ['limit' => 200]);
        $this->set(compact('document', 'users', 'parentDocuments'));
        $this->set('_serialize', ['document']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete()
    {

      $_user = $this->request->session()->read('Auth')['User'];
      $this->loadModel('UserDepartmentRoles');
      $this->loadModel('Departments');
      $this->request->allowMethod(['post', 'delete']);
      $itemid = $this->request->getData('itemid');
      !is_array($itemid) && $itemid = [$itemid];
      foreach ($itemid as $id) { 
        
        $document = $this->Documents->get($id);
        $parentDepartments = $this->Departments->find('path', ['for' => $document->department_id])
          ->extract('id')
          ->toArray();//文件夹所属部门及下级部门 或者是上级部门
        
        $role = $this->UserDepartmentRoles->find()
          ->where(['user_id' => $_user['id'], 'department_id in' => $parentDepartments])
          ->order('role_id DESC')
          ->first();
        if(!($role->role_id > 2 || ($document->owner == $_user['id'] && $document->user_id == $_user['id']))) {
          $this->Flash->error('无权删除文件：' . $document->origin_name);
          continue;
        }
        $path = $this->Documents->find('path',['for' => $id])->extract('name')->toArray();
        $path = DB_ROOT . implode('\\', $path);
        $path = iconv('utf-8', 'gbk', $path);
        if (is_file($path)) {
          $fileIns = new File($path);
          $fileIns->delete();
          // unlink($path);
        } else {
          $folderIns = new Folder($path);
          $folderIns->delete();
          // $this->deleteDir($path);
        }
        $this->Documents->delete($document); 
      }  
      
      return $this->redirect($this->referer());
    }

    public function upload(){
        $_user = $this->request->session()->read('Auth')['User'];
        $this->request->allowMethod(['post']);
        $path = $this->request->data['path'];
        $attachments = $this->request->data['attachment'];
        $parent_id = $this->request->getData('parent_id');
        $parentFolder = $this->Documents->get($parent_id);

        $data = $result = [];
        $result['html'] = '';
        $newContent = 0;

        $this->loadModel('UserDepartmentRoles');
        $this->loadModel('Departments');
        $document = $this->Documents->get($parent_id);
        $parentDepartments = $this->Departments->find('path', ['for' => $document->department_id])
          ->extract('id')
          ->toArray();//文件夹所属部门或者是上级部门
        $role = $this->UserDepartmentRoles->find()
          ->where(['user_id' => $_user['id'], 'department_id in' => $parentDepartments])
          ->order('role_id DESC')
          ->first();
        if(($document->level == 1 && $document->owner == $_user['id'] ) || ($role && $document->level < 1 && $role->role_id > 1) || ($role && $role->role_id > 2) || ($role->role_id == 2 && $role->department_id == $document->department_id)) {//个人文件，部门文件职位在主管以上
          foreach ($attachments as $file) {
              $resp = $this->uploadFiles('files' . $path, [$file]);
              if (array_key_exists('urls', $resp)) {//上传成功
                  $newContent += $file['size'];
                  $fileInfo = explode(".", $file['name']);
                  $fileExtension = end($fileInfo);
                  $file = $this->Documents->newEntity([
                      'department_id' => $parentFolder->department_id,
                      'user_id' =>$_user['id'],
                      'spell' => $this->getALLPY($file['name']),
                      'name' => $resp['names'][0],
                      'origin_name' => $file['name'],
                      'size' => $file['size'],
                      'ext' => $fileExtension,
                      'is_dir' => 0,
                      'is_sys' => 0,
                      'parent_id' => $parent_id,
                      'level' => $parentFolder->level,
                      'owner' => $parentFolder->owner,
                      'deleted' => 0
                  ]); 
                  $this->Documents->save($file);
                  $file->ord = $this->Documents->find()->where(['is_dir' => 0])->order(['ord' => 'DESC'])->first();
                  $file->ord = $file->ord ? $file->ord->ord ++ : 1;
                  $this->Documents->save($file);
              } else{
                  $data['fail'][$file['name']] = $resp;
                  isset($data['fail']['num']) ? $data['fail']['num'] ++ : $data['fail']['num'] = 1;
                  $result['html'] .= '<li>' . $file['name'] . '： ' . $resp['errors'][0] . '</li>';
              }
          }
          if ($newContent) {
              $parentFolders = $this->Documents->find('path',['for' => $parent_id])->where(['is_dir' => 1])
                  ->extract('id')->toArray();
               $this->Documents->query()
              ->update()
              ->set(['modified' => date('Y-m-d H:i:s'),"size=size + $newContent"])
              ->where(['id in' => $parentFolders])
              ->execute();
          }
          $result['num'] = count($attachments);
          $result['flag'] = 1;
          if (array_key_exists('fail', $data)) {
            $result['flag'] --;
            $result['html'] = '<div class="alert alert-danger"><div>失败个数：' . $data['fail']['num'] . '</div><div>失败列表：</div><ul>' . $result['html'] . '</ul></div>';

          }
          $result['detail'] = $data;
        }else {
          $result['flag'] = 0;
          $result['html'] = '<div class="alert alert-danger"><div>无权上传</div></div>';
        }

        
        $this->response->body(json_encode($result));
        return $this->response;
    }

    public function newFolder(){
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $data;
      $path = $this->request->data['path'];
      $filename = $this->request->data['filename'];
      $parent_id = $this->request->getData('parent_id');
      $parentFolder = $this->Documents->get($parent_id);

      $this->loadModel('UserDepartmentRoles');
      $this->loadModel('Departments');
      $document = $this->Documents->get($parent_id);
      $parentDepartments = $this->Departments->find('path', ['for' => $document->department_id])
        ->extract('id')
        ->toArray();//文件夹所属部门及下级部门 或者是上级部门
      $role = $this->UserDepartmentRoles->find()
        ->where(['user_id' => $_user['id'], 'department_id in' => $parentDepartments])
        ->order('role_id DESC')
        ->first();
      if(($document->level == 1 && $document->owner == $_user['id'] ) || ($role && $document->level < 1 && $role->role_id > 1) || ($role && $role->role_id > 2) || ($role->role_id == 2 && $role->department_id == $document->department_id)) {//个人文件，部门文件职位在主管以上
        if ($filename == '') {
          $data = -1;
          $this->response->body($data);
          return $this->response;
        }

        $spell = $this->getALLPY($filename);
        $folder = $this->Documents->newEntity([
            'department_id' => $parentFolder->department_id,
            'user_id' =>$_user['id'],
            'spell' => $spell,
            'name' => $filename,
            'origin_name' => $filename,
            'size' => 0,
            'ext' => '',
            'is_dir' => 1,
            'is_sys' => 0,
            'parent_id' => $parent_id,
            'level' => $parentFolder->level,
            'owner' => $parentFolder->owner,
            'deleted' => 0
        ]); 
        $this->Documents->save($folder);
        $folder->ord = $this->Documents->find()->where(['is_dir' => 1])->order(['ord' => 'DESC'])->first();
        $folder->ord = $folder->ord ? $folder->ord->ord ++ : 1;
        $this->Documents->save($folder);

        $parentFolders = $this->Documents->find('path',['for' => $parent_id])->where(['is_dir' => 1])
            ->combine('id','name')->toArray();
        $path = DB_ROOT . implode('\\', $parentFolders) . '\\' . iconv('utf-8', 'gbk', $folder->origin_name);
        if(!is_dir($path)){
          if (!mkdir($path)) {
            $data = -2;
            $this->response->body($path);
            return $this->response;
          }
        }
          
         $this->Documents->query()
        ->update()
        ->set(['modified' => date('Y-m-d H:i:s')])
        ->where(['id in' => array_keys($parentFolders)])
        ->execute();
        $data = 1;
      } else {
        $data = -3;
      }
      $this->response->body($data);
      return $this->response;
    }

    public function rename()
    {
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $name = $this->request->data['name'];
      $id = $this->request->data['id'];
      

      $document = $this->Documents->get($id);
      $this->loadModel('UserDepartmentRoles');
      $this->loadModel('Departments');
      $parentDepartments = $this->Departments->find('path', ['for' => $document->department_id])
        ->extract('id')
        ->toArray();//文件夹所属部门及下级部门 或者是上级部门
      $role = $this->UserDepartmentRoles->find()
        ->where(['user_id' => $_user['id'], 'department_id in' => $parentDepartments])
        ->order('role_id DESC')
        ->first();
      if(($document->level == 1 && $document->owner == $_user['id'] ) || ($role && $document->level < 1 && $role->role_id > 1) || ($role && $role->role_id > 2) || ($role->role_id == 2 && $role->department_id == $document->department_id)) {//个人文件，部门文件职位在主管以上

        if ($name != $document->name) {
          $crumbs = $this->Documents->find('path',['for' => $document->parent_id])->combine('id','name')->toArray();
          $path = DB_ROOT .implode(DS, $crumbs);
          $oldname = $path . DS . $document->name;
          $newname = $path . DS . $name . DS . ($document->ext ? '.' . $document->ext : '');
          if(!rename(iconv('utf-8', 'gbk', $oldname), iconv('utf-8', 'gbk', $newname))) {
            $this->response->body(-1);//重名失败
            return $this->response;
          }

          $document->spell = $this->getALLPY($name);
          $document->origin_name = $document->name = $name;
          $this->Documents->save($document);

           $this->Documents->query()
          ->update()
          ->set(['modified' => date('Y-m-d H:i:s')])
          ->where(['id in' => array_keys($crumbs)])
          ->execute();
        }
        $this->response->body(1);
      } else {
        $this->response->body(-2);//无权限操作
      }
      return $this->response;
    }
    public function move()
    {
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $id = $this->request->data['id'];
      $parent_id = $this->request->data['parent_id'];
      


      $document = $this->Documents->get($id);
      if ($document->is_sys) {
        $this->response->body(-4);//系统文件无权移动
        return $this->response;
      }
      $originParentDocument = $this->Documents->get($document->parent_id);

      $this->loadModel('UserDepartmentRoles');
      $this->loadModel('Departments');
      $parentDepartments = $this->Departments->find('path', ['for' => $document->department_id])
        ->extract('id')
        ->toArray();//文件夹所属部门及下级部门 或者是上级部门
      $role = $this->UserDepartmentRoles->find()
        ->where(['user_id' => $_user['id'], 'department_id in' => $parentDepartments])
        ->order('role_id DESC')
        ->first();
      if(($document->level == 1 && $document->owner == $_user['id'] ) || ($role && $document->level < 1 && $role->role_id > 1) || ($role && $role->role_id > 2) || ($role->role_id == 2 && $role->department_id == $document->department_id)) {//个人文件，部门文件职位在主管以上

        $newParentDocument = $this->Documents->get($parent_id);
        if($newParentDocument->lft >= $originParentDocument->lft && $newParentDocument->rght <= $originParentDocument->lft ){
          $this->response->body('-2');//新上级分类为子分类
          return $this->response;
        }
        
        $originCrumbs = $this->Documents->find('path',['for' => $document->id])->combine('id','name')->toArray();
        $originPath = DB_ROOT .implode(DS, $originCrumbs);
        $newCrumbs = $this->Documents->find('path',['for' => $parent_id])->combine('id','name')->toArray();
        $newPath = DB_ROOT .implode(DS, $newCrumbs);
        if (!is_dir($newPath)) {
          $this->response->body(-3);//新文件不存在
          return $this->response;
        }
        if(!rename(iconv('utf-8', 'gbk', $originPath), iconv('utf-8', 'gbk', $newPath. DS . $document->name))) {
          $this->response->body(-1);//移动失败
          return $this->response;
        }

        $document->parent_id = $parent_id;
        $document->level = $newParentDocument->level;
        $this->Documents->save($document);

         $this->Documents->query()
        ->update()
        ->set(['modified' => date('Y-m-d H:i:s'),"size=size - $document->size"])
        ->where(['id in' => array_keys($originCrumbs)])
        ->execute();
         $this->Documents->query()
        ->update()
        ->set(['modified' => date('Y-m-d H:i:s'),"size=size + $document->size"])
        ->where(['id in' => array_keys($newCrumbs)])
        ->execute();
        
        $this->response->body(1);
      } else {
        $this->response->body(-4);//无权限操作
      }
      return $this->response;
    }

    public function copy()
    {
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $id = $this->request->data['id'];
      $parent_id = $this->request->data['parent_id'];
      

      $document = $this->Documents->get($id);
      $newParentDocument = $this->Documents->get($parent_id);
      
      $originCrumbs = $this->Documents->find('path',['for' => $document->id])->combine('id','name')->toArray();
      $originPath = DB_ROOT .implode(DS, $originCrumbs);
      $newCrumbs = $this->Documents->find('path',['for' => $parent_id])->combine('id','name')->toArray();
      $newPath = DB_ROOT .implode(DS, $newCrumbs);
      if (!is_dir($newPath)) {
        $this->response->body(-3);//新文件不存在
        return $this->response;
      }
      if (!$document->is_dir) {
        
        if(!@copy($originPath, $newPath . DS . $document->name)) {
          $this->response->body(-1);//复制失败
          return $this->response;
        }
      } else {
        if(!$this->copy_dir($originPath,  $newPath . DS . $document->name)) {
          $this->response->body(-1);//复制失败
          return $this->response;
        }
        
      }
      
      
      
      $document->parent_id = $parent_id;
      $childCount = ($document->rght - $document->lft + 1);
      $del = ($newParentDocument->lft - $document->lft + 1);
      $delDepth = ($newParentDocument->depth - $document->depth + 1);
      $modified = date('Y-m-d H:i:s');

      $this->Documents->query()
      ->update()
      ->set(["lft=lft + $childCount"])
      ->where(['lft > ' => $newParentDocument->lft])
      ->execute();
      $this->Documents->query()
      ->update()
      ->set(["rght=rght + $childCount"])
      ->where(['rght >= ' => $newParentDocument->rght])
      ->execute();

      $descendant = $this->Documents->find('children', ['for' => $document->id])
        ->where(['deleted' => 0]);
      $query = $this->Documents->query()->insert(['department_id', 'user_id', 'spell', 'name', 'origin_name', 'size', 'ext', 'is_dir', 'is_sys', 'parent_id', 'level','owner', 'deleted', 'created', 'modified']);
      $query->values([
        'department_id' => $document->department_id,
        'user_id' =>$_user['id'],
        'spell' => $document->spell,
        'name' => $document->name,
        'origin_name' => $document->origin_name,
        'size' => $document->size,
        'ext' => $document->ext,
        'is_dir' => $document->is_dir,
        'is_sys' => $document->is_sys,
        'parent_id' => $parent_id,
        'lft' => $document->lft + $del,
        'rght' => $document->rght + $del,
        'depth' => $document->depth + $delDepth,
        'level' => $newParentDocument->level,
        'owner' => $newParentDocument->owner,
        'deleted' => $document->deleted,
        'created' => $modified,
        'modified' => $modified
      ]);
      foreach ($descendant as $value) {
        $query->values([
          'department_id' => $value->department_id,
          'user_id' =>$_user['id'],
          'spell' => $value->spell,
          'name' => $value->name,
          'origin_name' => $value->origin_name,
          'size' => $value->size,
          'ext' => $value->ext,
          'is_dir' => $value->is_dir,
          'is_sys' => $value->is_sys,
          'parent_id' => $value->parent_id,
          'lft' => $value->lft + $del,
          'rght' => $value->rght + $del,
          'level' => $newParentDocument->level,
          'owner' => $newParentDocument->owner,
          'depth' => $value->depth + $delDepth,
          'deleted' => $value->deleted,
          'created' => $modified,
          'modified' => $modified
        ]);
      }
      $query->execute();

      $this->Documents->query()
      ->update()
      ->set(['modified' => $modified,"size=size + $document->size"])
      ->where(['id in' => array_keys($newCrumbs)])
      ->execute();
      
      $this->response->body(1);
      return $this->response;
    }

    public function download()
    {
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $this->request->allowMethod(['post', 'delete']);
      $itemid = $this->request->getData('itemid');
      !is_array($itemid) && $itemid = [$itemid];
      foreach ($itemid as $id) {
        $document = $this->Documents->get($id);

        $crumbs = $this->Documents->find('path',['for' => $document->id])->combine('id','name')->toArray();
        $path = DB_ROOT .implode(DS, $crumbs);

        //检查文件是否存在    
        if (! file_exists ($path)) {           
            $this->Flash->error('资源不存在');   
            return $this->redirect($this->referer());   
        } else {    
            //打开文件    
            $file = fopen ($path, "r" );    
            //输入文件标签     
            Header ( "Content-type: application/octet-stream" );    
            Header ( "Accept-Ranges: bytes" );    
            Header ( "Accept-Length: " . filesize ($path) );    
            Header ( "Content-Disposition: attachment; filename=" . $document->name );    
            //输出文件内容     
            //读取文件内容并直接输出到浏览器    
            echo fread ( $file, filesize ($path) );    
            fclose ($file); 
            return $this->redirect($this->referer());   
        }
      }
    }


    
    public function identicalName($value='')
    {
      $is_exisit = $this->Documents->find()
        ->where(['origin_name' => $this->request->query('filename'), 'parent_id' => $this->request->query('parent_id'),'is_dir' => 1])
        ->count();
      $this->response->body($is_exisit);
      return $this->response;
    }

    private function dirList($docs)
    { 
      $html = '';
      foreach ($docs as $doc) {
        $html .= '<ul class= "top"><li class="collapseItem"><div class="mouseoverItem" data-id="' . $doc->id . '">' . $doc->origin_name . '</div>';
        if(!empty($doc->children)){
          $html .= $this->dirList($doc->children); 
        }
        $html .= '</li></ul>';
      }
      return $html;
    }

    private function copy_dir($src,$dst) {
      $dir = opendir($src);
      @mkdir($dst);
      while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
          if ( is_dir($src . '/' . $file) ) {
            copy_dir($src . '/' . $file,$dst . '/' . $file);
            continue;
          }
          else {
            copy($src . '/' . $file,$dst . '/' . $file);
          }
        }
      }
      closedir($dir);
      return true;
    }

}
