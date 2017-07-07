<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
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
            $parentDepartments = $this->Departments->find('path',['for' => $value->department_id])
              ->extract('id')
              ->toArray();
            $conditions['OR'][] = ['Documents.level <' => 2, 'Documents.department_id in' => $parentDepartments];
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
      
      $this->set(compact('documents','parent_id','crumbs', 'path', 'iconArr', 'threads', 'html'));
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
        $this->request->allowMethod(['post', 'delete']);
        $itemid = $this->request->getData('itemid');
        !is_array($itemid) && $itemid = [$itemid];
        foreach ($itemid as $id) {
          $document = $this->Documents->get($id);
          $path = $this->Documents->find('path',['for' => $id])->extract('name')->toArray();
          $path = DB_ROOT . implode('\\', $path);
          if (is_file($path)) {
            unlink($path);
          } else {
            $this->deleteDir($path);
          }
        }
        $this->Documents->deleteAll(['id in ' => $itemid]);    
        
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
        foreach ($attachments as $file) {
            $resp = $this->uploadFiles('files' . $path, [$file]);
            if (array_key_exists('urls', $resp)) {//上传成功
                $newContent += $file['size'];
                $fileInfo = explode(".", $file['name']);
                $fileExtension = end($fileInfo);
                $file = $this->Documents->newEntity([
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
                    'deleted' => 0
                ]); 
                $this->Documents->save($file);
                $file->ord = $this->Documents->find()->where(['is_dir' => 0])->order(['ord' => 'DESC'])->first();
                $file->ord = $file->ord ? $file->ord->ord ++ : 1;
                $this->Documents->save($file);
                // $data['success']['num'] ++;
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
        $this->response->body(json_encode($result));
        return $this->response;
    }

    public function newFolder(){
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $data;
      $path = $this->request->data['path'];
      $filename = $this->request->data['filename'];
      if ($filename == '') {
        $data = -1;
        $this->response->body($data);
        return $this->response;
      }
      $parent_id = $this->request->getData('parent_id');
      $parentFolder = $this->Documents->get($parent_id);

      $spell = $this->getALLPY($filename);
      $folder = $this->Documents->newEntity([
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
      if ($name != $document->name) {
        $crumbs = $this->Documents->find('path',['for' => $document->parent_id])->combine('id','name')->toArray();
        $path = DB_ROOT .implode(DS, $crumbs);
        $oldname = $path . DS . $document->name;
        $newname = $path . DS . $name . DS . ($document->ext ? '.' . $document->ext : '');
        if(!rename($oldname, $newname)) {
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
      if(!rename($originPath, $newPath. DS . $document->name)) {
        $this->response->body(-1);//重名失败
        return $this->response;
      }

      $document->parent_id = $parent_id;
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
      return $this->response;
    }

    public function copy()
    {
      $_user = $this->request->session()->read('Auth')['User'];
      $this->request->allowMethod(['post']);
      $id = $this->request->data['id'];
      $parent_id = $this->request->data['parent_id'];
      

      $document = $this->Documents->get($id);
      
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
      $newDocument = $this->Documents->newEntity([
        'user_id' =>$_user['id'],
        'spell' => $document->spell,
        'name' => $document->name,
        'origin_name' => $document->origin_name,
        'size' => $document->size,
        'ext' => $document->ext,
        'is_dir' => $document->is_dir,
        'is_sys' => $document->is_sys,
        'parent_id' => $document->parent_id,
        'level' => $document->level,
        'deleted' => $document->deleted
      ]);

      $this->Documents->save($newDocument);
      $newDocument->ord = $this->Documents->find()->where(['is_dir' => $document->is_dir])->order(['ord' => 'DESC'])->first();
      $newDocument->ord = $newDocument->ord ? $newDocument->ord->ord ++ : 1;
      $this->Documents->save($newDocument);

       $this->Documents->query()
      ->update()
      ->set(['modified' => date('Y-m-d H:i:s'),"size=size + $document->size"])
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
            fclose ( $file ); 
            $this->Flash->success('下载成功');   
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
