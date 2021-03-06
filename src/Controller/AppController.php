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


  private $pylist = array(
      'a'=>-20319,'ai'=>-20317,'an'=>-20304,'ang'=>-20295,'ao'=>-20292,
      'ba'=>-20283,'bai'=>-20265,'ban'=>-20257,'bang'=>-20242,'bao'=>-20230,'bei'=>-20051,'ben'=>-20036,'beng'=>-20032,'bi'=>-20026,'bian'=>-20002,'biao'=>-19990,'bie'=>-19986,'bin'=>-19982,'bing'=>-19976,'bo'=>-19805,'bu'=>-19784,
      'ca'=>-19775,'cai'=>-19774,'can'=>-19763,'cang'=>-19756,'cao'=>-19751,'ce'=>-19746,'ceng'=>-19741,'cha'=>-19739,'chai'=>-19728,'chan'=>-19725,'chang'=>-19715,'chao'=>-19540,'che'=>-19531,'chen'=>-19525,'cheng'=>-19515,'chi'=>-19500,'chong'=>-19484,'chou'=>-19479,'chu'=>-19467,'chuai'=>-19289,'chuan'=>-19288,'chuang'=>-19281,'chui'=>-19275,'chun'=>-19270,'chuo'=>-19263,'ci'=>-19261,'cong'=>-19249,'cou'=>-19243,'cu'=>-19242,'cuan'=>-19238,'cui'=>-19235,'cun'=>-19227,'cuo'=>-19224,
      'da'=>-19218,'dai'=>-19212,'dan'=>-19038,'dang'=>-19023,'dao'=>-19018,'de'=>-19006,'deng'=>-19003,'di'=>-18996,'dian'=>-18977,'diao'=>-18961,'die'=>-18952,'ding'=>-18783,'diu'=>-18774,'dong'=>-18773,'dou'=>-18763,'du'=>-18756,'duan'=>-18741,'dui'=>-18735,'dun'=>-18731,'duo'=>-18722,
      'e'=>-18710,'en'=>-18697,'er'=>-18696,
      'fa'=>-18526,'fan'=>-18518,'fang'=>-18501,'fei'=>-18490,'fen'=>-18478,'feng'=>-18463,'fo'=>-18448,'fou'=>-18447,'fu'=>-18446,
      'ga'=>-18239,'gai'=>-18237,'gan'=>-18231,'gang'=>-18220,'gao'=>-18211,'ge'=>-18201,'gei'=>-18184,'gen'=>-18183,'geng'=>-18181,'gong'=>-18012,'gou'=>-17997,'gu'=>-17988,'gua'=>-17970,'guai'=>-17964,'guan'=>-17961,'guang'=>-17950,'gui'=>-17947,
      'gun'=>-17931,'guo'=>-17928,
      'ha'=>-17922,'hai'=>-17759,'han'=>-17752,'hang'=>-17733,'hao'=>-17730,'he'=>-17721,'hei'=>-17703,'hen'=>-17701,'heng'=>-17697,'hong'=>-17692,'hou'=>-17683,'hu'=>-17676,'hua'=>-17496,'huai'=>-17487,'huan'=>-17482,'huang'=>-17468,'hui'=>-17454,
      'hun'=>-17433,'huo'=>-17427,
      'ji'=>-17417,'jia'=>-17202,'jian'=>-17185,'jiang'=>-16983,'jiao'=>-16970,'jie'=>-16942,'jin'=>-16915,'jing'=>-16733,'jiong'=>-16708,'jiu'=>-16706,'ju'=>-16689,'juan'=>-16664,'jue'=>-16657,'jun'=>-16647,
      'ka'=>-16474,'kai'=>-16470,'kan'=>-16465,'kang'=>-16459,'kao'=>-16452,'ke'=>-16448,'ken'=>-16433,'keng'=>-16429,'kong'=>-16427,'kou'=>-16423,'ku'=>-16419,'kua'=>-16412,'kuai'=>-16407,'kuan'=>-16403,'kuang'=>-16401,'kui'=>-16393,'kun'=>-16220,'kuo'=>-16216,
      'la'=>-16212,'lai'=>-16205,'lan'=>-16202,'lang'=>-16187,'lao'=>-16180,'le'=>-16171,'lei'=>-16169,'leng'=>-16158,'li'=>-16155,'lia'=>-15959,'lian'=>-15958,'liang'=>-15944,'liao'=>-15933,'lie'=>-15920,'lin'=>-15915,'ling'=>-15903,'liu'=>-15889,
      'long'=>-15878,'lou'=>-15707,'lu'=>-15701,'lv'=>-15681,'luan'=>-15667,'lue'=>-15661,'lun'=>-15659,'luo'=>-15652,
      'ma'=>-15640,'mai'=>-15631,'man'=>-15625,'mang'=>-15454,'mao'=>-15448,'me'=>-15436,'mei'=>-15435,'men'=>-15419,'meng'=>-15416,'mi'=>-15408,'mian'=>-15394,'miao'=>-15385,'mie'=>-15377,'min'=>-15375,'ming'=>-15369,'miu'=>-15363,'mo'=>-15362,'mou'=>-15183,'mu'=>-15180,
      'na'=>-15165,'nai'=>-15158,'nan'=>-15153,'nang'=>-15150,'nao'=>-15149,'ne'=>-15144,'nei'=>-15143,'nen'=>-15141,'neng'=>-15140,'ni'=>-15139,'nian'=>-15128,'niang'=>-15121,'niao'=>-15119,'nie'=>-15117,'nin'=>-15110,'ning'=>-15109,'niu'=>-14941,
      'nong'=>-14937,'nu'=>-14933,'nv'=>-14930,'nuan'=>-14929,'nue'=>-14928,'nuo'=>-14926,
      'o'=>-14922,'ou'=>-14921,
      'pa'=>-14914,'pai'=>-14908,'pan'=>-14902,'pang'=>-14894,'pao'=>-14889,'pei'=>-14882,'pen'=>-14873,'peng'=>-14871,'pi'=>-14857,'pian'=>-14678,'piao'=>-14674,'pie'=>-14670,'pin'=>-14668,'ping'=>-14663,'po'=>-14654,'pu'=>-14645,
      'qi'=>-14630,'qia'=>-14594,'qian'=>-14429,'qiang'=>-14407,'qiao'=>-14399,'qie'=>-14384,'qin'=>-14379,'qing'=>-14368,'qiong'=>-14355,'qiu'=>-14353,'qu'=>-14345,'quan'=>-14170,'que'=>-14159,'qun'=>-14151,
      'ran'=>-14149,'rang'=>-14145,'rao'=>-14140,'re'=>-14137,'ren'=>-14135,'reng'=>-14125,'ri'=>-14123,'rong'=>-14122,'rou'=>-14112,'ru'=>-14109,'ruan'=>-14099,'rui'=>-14097,'run'=>-14094,'ruo'=>-14092,
      'sa'=>-14090,'sai'=>-14087,'san'=>-14083,'sang'=>-13917,'sao'=>-13914,'se'=>-13910,'sen'=>-13907,'seng'=>-13906,'sha'=>-13905,'shai'=>-13896,'shan'=>-13894,'shang'=>-13878,'shao'=>-13870,'she'=>-13859,'shen'=>-13847,'sheng'=>-13831,'shi'=>-13658,'shou'=>-13611,'shu'=>-13601,'shua'=>-13406,'shuai'=>-13404,'shuan'=>-13400,'shuang'=>-13398,'shui'=>-13395,'shun'=>-13391,'shuo'=>-13387,'si'=>-13383,'song'=>-13367,'sou'=>-13359,'su'=>-13356,'suan'=>-13343,'sui'=>-13340,'sun'=>-13329,'suo'=>-13326,
      'ta'=>-13318,'tai'=>-13147,'tan'=>-13138,'tang'=>-13120,'tao'=>-13107,'te'=>-13096,'teng'=>-13095,'ti'=>-13091,'tian'=>-13076,'tiao'=>-13068,'tie'=>-13063,'ting'=>-13060,'tong'=>-12888,'tou'=>-12875,'tu'=>-12871,'tuan'=>-12860,'tui'=>-12858,'tun'=>-12852,'tuo'=>-12849,
      'wa'=>-12838,'wai'=>-12831,'wan'=>-12829,'wang'=>-12812,'wei'=>-12802,'wen'=>-12607,'weng'=>-12597,'wo'=>-12594,'wu'=>-12585,
      'xi'=>-12556,'xia'=>-12359,'xian'=>-12346,'xiang'=>-12320,'xiao'=>-12300,'xie'=>-12120,'xin'=>-12099,'xing'=>-12089,'xiong'=>-12074,'xiu'=>-12067,'xu'=>-12058,'xuan'=>-12039,'xue'=>-11867,'xun'=>-11861,
      'ya'=>-11847,'yan'=>-11831,'yang'=>-11798,'yao'=>-11781,'ye'=>-11604,'yi'=>-11589,'yin'=>-11536,'ying'=>-11358,'yo'=>-11340,'yong'=>-11339,'you'=>-11324,'yu'=>-11303,'yuan'=>-11097,'yue'=>-11077,'yun'=>-11067,
      'za'=>-11055,'zai'=>-11052,'zan'=>-11045,'zang'=>-11041,'zao'=>-11038,'ze'=>-11024,'zei'=>-11020,'zen'=>-11019,'zeng'=>-11018,'zha'=>-11014,'zhai'=>-10838,'zhan'=>-10832,'zhang'=>-10815,'zhao'=>-10800,'zhe'=>-10790,'zhen'=>-10780,'zheng'=>-10764,'zhi'=>-10587,'zhong'=>-10544,'zhou'=>-10533,'zhu'=>-10519,'zhua'=>-10331,'zhuai'=>-10329,'zhuan'=>-10328,'zhuang'=>-10322,'zhui'=>-10315,'zhun'=>-10309,'zhuo'=>-10307,'zi'=>-10296,'zong'=>-10281,'zou'=>-10274,'zu'=>-10270,'zuan'=>-10262,
      'zui'=>-10260,'zun'=>-10256,'zuo'=>-10254
  );

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
            //查询可用模块
            $_user = $this->request->session()->read('Auth')['User'];
            $this->loadModel('Privileges');
            $this->loadModel('UserDepartmentRoles');
            $positions = $this->UserDepartmentRoles->find()
              ->where(['user_id' => $_user['id']])
              ->select(['department_id', 'role_id']);
            $_privileges = [];
            foreach ($positions as $position) {
              $privilege = $this->Privileges->find()
                ->where(['department_id' => $position->department_id, 'role_id' => $position->role_id])
                ->select(['what','how']);
              foreach ($privilege as $value) {
                if(isset($_privileges[$value->what])) {
                  !(in_array($value->how, $_privileges[$value->what])) && $_privileges[$value->what][] = $value->how;
                } else {
                  $_privileges[$value->what][] = $value->how;
                }                
              }
            }
            // $_module = array_keys($_privileges);
            // $_controller = $this->request->param('controller');
            // $_action = $this->request->param('action');

            // if(!((in_array($_controller, $_module) && ($_action === 'index' || in_array($_action, $_privileges[$_controller]))) || in_array($_action, ['login', 'logout']) || $_controller === 'Dashboard')){
            //   $this->Flash->error(__('无权访问'));
            //   return $this->redirect($this->referer());
            // }
            
            $this->set(compact('backlogCount','financeInArr','projectRespArr','projectRespCount','_privileges','_module'));
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
          $fileExtension = strtolower(end($fileInfo));
          $typeOK = false;
          // check filetype is ok
          // debug ($file['type']);
          foreach ($permitted as $type) {
              if ($type == $fileExtension) {
                  $typeOK = true;
                  break;
              }
          }

          // if file type ok upload the file
          if ($typeOK) {
            // switch based on error code
            $filename_gbk = iconv('utf-8','gb2312',$filename);
            switch ($file['error']) {
                case 0:
                    // check filename already exists
                    if (!file_exists($folder_url . '/' . $filename)) {
                        // create full filename
                        $full_url = $folder_url . '/' . $filename_gbk;
                        $url = $rel_url . '/' . $filename;
                        $name = $filename;
                        // upload the file
                        $success = move_uploaded_file($file['tmp_name'], $full_url);
                    } else {
                        // create unique filename and upload file
                        ini_set('date.timezone', 'Europe/London');
                        $now = date('Y-m-d-His');
                        $full_url = $folder_url . '/' . $now . $filename_gbk;
                        $url = $rel_url . '/' . $now . $filename;
                        $name = $now . $filename;
                        $success = move_uploaded_file($file['tmp_name'], $full_url);
                    }
                    // if upload was successful
                    if ($success) {
                        // save the url of the file
                        $result['urls'][] = $url;
                        $result['names'][] = $name;
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
              $result['nofiles'][] = "未选中文件";
          } else {
              // unacceptable file type
              $result['errors'][] = "不支持该类型文件上传";
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
    
    public function getAllPY($chinese, $delimiter = '', $length = 0,$charset='utf-8') {
        if($charset != 'gb2312') $chinese = iconv('UTF-8', 'GB2312', $chinese);
       $py = $this->zh_to_pys($chinese, $delimiter);
       if($length) {
           $py = substr($py, 0, $length);
       }
       return $py;
    }
    public function getFirstPY($chinese,$charset='utf-8'){
      if($charset != 'gb2312') $chinese = iconv('UTF-8', 'GB2312', $chinese);
       $result = '' ;
       for ($i=0; $i<strlen($chinese); $i++) {
           $p = ord(substr($chinese,$i,1));
           if ($p>160) {
              $q = ord(substr($chinese,++$i,1));
              $p = $p*256 + $q - 65536;
           }
           $result .= substr($this->zh_to_py($p),0,1);
       }
       return $result ;
    }
 
    private function zh_to_py($num, $blank = '') {
       if($num>0 && $num<160 ) {
           return chr($num);
       } elseif ($num<-20319||$num>-10247) {
           return $blank;
       } else {
           foreach ($this->pylist as $py => $code) {
              if($code > $num) break;
              $result = $py;
           }
           return $result;
       }
    }
      
    private function zh_to_pys($chinese, $delimiter = ' ', $first=0){
       $result = array();
       for($i=0; $i<strlen($chinese); $i++) {
           $p = ord(substr($chinese,$i,1));
           if($p>160) {
              $q = ord(substr($chinese,++$i,1));
              $p = $p*256 + $q - 65536;
           }
           $result[] = $this->zh_to_py($p);
           if ($first) {
              return $result[0];
           }
       }
       return implode($delimiter, $result);
    }
     // 单位自动转换函数
    public function getRealSize($size)
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
