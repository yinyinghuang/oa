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
    public function index($parent_id = 0)
    {
        $iconArr = ['png' => 'image', 'gif' => 'image', 'jpg' => 'image', 'xls' => 'file-excel-o', 'xlsx' => 'file-excel-o', 'doc' => 'file-word-o', 'docx' => 'file-word-o', 'pdf' => 'file-pdf-o', 'ppt' => 'file-powerpoint-o', 'zip' => 'file-zip-o', 'txt' => 'file-text-o' ];
        $this->paginate = [
            'conditions' => ['Documents.parent_id' => $parent_id]
        ];
        $documents = $this->paginate($this->Documents);
        foreach ($documents as $value) {
            $value->size = $this->getRealSize($value->size);
        }
        if($parent_id){
            $path = '/dropboxes/';
            $crumbs = $this->Documents->find('path',['for' => $parent_id]);
            foreach ($crumbs as $crumb) {
                $path .= $crumb->name . '/' ;
            }
        }
        $this->set(compact('documents','parent_id','crumbs', 'path', 'iconArr'));
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
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function upload(){
        $_user = $this->request->session()->read('Auth')['User'];
        $this->request->allowMethod(['post']);
        $path = $this->request->data['path'];
        $attachments = $this->request->data['attachment'];
        $parent_id = $this->request->getData('parent_id');

        $data = [];

        foreach ($attachments as $file) {
            $resp = $this->uploadFiles('files/' . $path, [$file]);
            if (array_key_exists('urls', $resp)) {//上传成功
                !isset($success) && $success = 1;
                $fileInfo = explode(".", $file['name']);
                $fileExtension = end($fileInfo);
                $file = $this->Documents->newEntity([
                    'user_id' =>$_user['id'],
                    'spell' => $this->getALLPY($file['name']),
                    'name' => $file['name'],
                    'origin_name' => $file['name'],
                    'size' => $file['size'],
                    'ext' => $fileExtension,
                    'is_dir' => 0,
                    'parent_id' => $parent_id,
                    'level' => 1,
                    'deleted' => 0
                ]); 
                $this->Documents->save($file);
                $file->ord = $this->Documents->find()->where(['is_dir' => 0])->order(['ord' => 'DESC'])->first();
                $file->ord = $file->ord ? $file->ord->ord ++ : 1;
                $data[$file['name']]['result'] = true;
            } else{
                $data[$file['name']]['result'] = false;
                $data[$file['name']]['error'] = $resp['errors'][0];
            }
        }
        if (isset($success)) {
            $parentFolders = $this->Documents->find('path',['for' => $parent_id])->where(['is_dir' => 1])
                ->extract('id')->toArray();
             $this->Documents->query()
            ->update()
            ->set(['modified' => date('Y-m-d H:i:s')])
            ->where(['id in' => $parentFolders])
            ->execute();
        }

        $this->response->body(json_encode($data));
        return $this->response;
    }

    private function getDirSize($dir)
     { 
      $handle = opendir($dir);
      while (false!==($FolderOrFile = readdir($handle)))
      { 
       if($FolderOrFile != "." && $FolderOrFile != "..") 
       { 
        if(is_dir("$dir/$FolderOrFile"))
        { 
         $sizeResult += getDirSize("$dir/$FolderOrFile"); 
        }
        else
        { 
         $sizeResult += filesize("$dir/$FolderOrFile"); 
        }
       } 
      }
      closedir($handle);
      return $sizeResult;
    }
     // 单位自动转换函数
    private function getRealSize($size)
    { 
          $kb = 1024;   // Kilobyte
          $mb = 1024 * $kb; // Megabyte
          $gb = 1024 * $mb; // Gigabyte
          $tb = 1024 * $gb; // Terabyte
          if($size < $kb)
          { 
           return $size." B";
          }
          else if($size < $mb)
          { 
           return round($size/$kb,2)." KB";
          }
          else if($size < $gb)
          { 
           return round($size/$mb,2)." MB";
          }
          else if($size < $tb)
          { 
           return round($size/$gb,2)." GB";
          }
          else
          { 
           return round($size/$tb,2)." TB";
          }
    }
}
