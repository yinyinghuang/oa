<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
    }

    public function beforeFilter(Event $event)
    {
        if (isset($this->request->session()->read('Auth')['User'])) {
            $_user = $this->request->session()->read('Auth')['User'];
            //初始化任务个数
            $this->loadModel('Tasks');            
            $backlogCount = $this->Tasks->find('all',['conditions'=>['user_id' => $_user['id'],'state in' => [0,1]]])->count();

            //初始化通知个数
            $this->loadModel('Notices');
            //入账通知
            $financeInArr = $this->Notices->find('all',[
                'conditions'=>['user_id' => $_user['id'], 'controller' => 'Finances','state' => 0],
                'fields' => ['itemid']
            ])->extract('itemid')->toArray();

            //项目审核结果通知
            $query = $this->Notices->find('all',[
                'conditions'=>['user_id' => $_user['id'], 'controller' => 'Projects','state' => 0],
                'fields' => ['itemid','remark']
            ]);
            $projectRespArr = [];
            $projectRespCount = $query->count();
            foreach ($query as $project) {
                $projectRespArr[$project->remark][] = $project->itemid;
            }

            $this->set(compact('backlogCount','financeInArr','projectRespArr','projectRespCount'));
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }
    protected function uploadFiles($folder, $formdata, $itemId = null) {
        // setup dir names absolute and relative
        $folder_url = WWW_ROOT . $folder;
        $rel_url = $folder;

        // create the folder if it does not exist
        if (!is_dir($folder_url)) {
            mkdir($folder_url);
        }

        // if itemId is set create an item folder
        if ($itemId) {
            // set new absolute folder
            $folder_url = WWW_ROOT . $folder . '/' . $itemId;
            // set new relative folder
            $rel_url = $folder . '/' . $itemId;
            // create directory
            if (!is_dir($folder_url)) {
                mkdir($folder_url);
            }
        }

        // list of permitted file types, this is only images but documents can be added
        $permitted = array('xls','xlsx', 'png', 'jpg', 'gif','doc','docx','pdf','ppt','zip','txt');

        // loop through and deal with the files
        foreach ($formdata as $file) {
            $filename = str_replace(' ', '_', $file['name']);
            $fileInfo = explode(".", $filename);
            $fileExtension = end($fileInfo);
            $typeOK = false;
            // check filetype is ok
//            debug ($file['type']);
            foreach ($permitted as $type) {
                if ($type == $fileExtension) {
                    $typeOK = true;
                    break;
                }
            }

            // if file type ok upload the file
            if ($typeOK) {
                // switch based on error code
                $filename = iconv('utf-8','gb2312',$filename);
                switch ($file['error']) {
                    case 0:
                        // check filename already exists
                        if (!file_exists($folder_url . '/' . $filename)) {
                            // create full filename
                            $full_url = $folder_url . '/' . $filename;
                            $url = $rel_url . '/' . $filename;
                            // upload the file
                            $success = move_uploaded_file($file['tmp_name'], $full_url);
                        } else {
                            // create unique filename and upload file
                            ini_set('date.timezone', 'Europe/London');
                            $now = date('Y-m-d-His');
                            $full_url = $folder_url . '/' . $now . $filename;
                            $url = $rel_url . '/' . $now . $filename;
                            $success = move_uploaded_file($file['tmp_name'], $full_url);
                        }
                        // if upload was successful
                        if ($success) {
                            // save the url of the file
                            $result['urls'][] = $url;
                        } else {
                            $result['errors'][] = "Error uploaded $filename. Please try again.";
                        }
                        break;
                    case 3:
                        // an error occured
                        $result['errors'][] = "Error uploading $filename. Please try again.";
                        break;
                    default:
                        // an error occured
                        $result['errors'][] = "System error uploading $filename. Contact webmaster.";
                        break;
                }
            } elseif ($file['error'] == 4) {
                // no file was selected for upload
                $result['nofiles'][] = "No file Selected";
            } else {
                // unacceptable file type
                $result['errors'][] = "$filename cannot be uploaded.";
            }
        }
        return $result;
    }

    public function saveAttachment()
    {   
        $this->request->allowMethod(['post']);
        $data = [];
        $fileOK = $this->uploadFiles('files/' . $this->request->data['path'], [$this->request->data['attachment']], date('Ymd',time()));
        if(array_key_exists('urls', $fileOK)){

            $data['result'] = 1;
            $data['url'] = $fileOK['urls'][0];

            
            $ext = explode('.', $data['url']);
            if (in_array($ext[count($ext)-1], array('png', 'gif', 'jpg'))) {
                $data['html'] = '<img src="/' . $data['url'] . '" style="border:1px solid #ccc">';
            }else{
                $filename = explode('/', $data['url']);
                $data['html'] = '<a src="/' . $data['url'] . '">' . $filename[count($filename)-1] . '</a>';
            }
            $data['html'] .= '<div class="alert alert-success">上传成功</div>';
            
        }else if(array_key_exists('nofiles', $fileOK)){
            $data['result'] = 0;
            $data['error'] = '<div class="alert alert-danger">' . $fileOK['nofiles'][0] . '</div>';
        }else{
            $data['result'] = 0;
            $data['error'] = '<div class="alert alert-danger">' . $fileOK['errors'][0] . '</div>';
        }
        $this->response->body(json_encode($data));
        return $this->response;
    }
}
