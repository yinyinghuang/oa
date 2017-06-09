<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SmsDetails Controller
 *
 * @property \App\Model\Table\SmsDetailsTable $SmsDetails
 *
 * @method \App\Model\Entity\SmsDetail[] paginate($object = null, array $settings = [])
 */
class SmsDetailsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($reset = null)
    {
        $this->loadModel('CustomerCategories');
        $this->paginate = [
            'contain' => ['Users'],
            'order' => ['SmsDetails.created DESC'],
            'limit' => 10
        ];
        $smsDetails = $this->paginate($this->SmsDetails);

        $search = $reset ? 1 : 0;
        $customer_category_id = 0;

        $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
        $arr = array();
        foreach ($list as $k => $v) {
            $arr[$k] = $v;
        }
        $options = new \StdClass();
        $options->id = 0;
        $options->options = $arr; 
        $customerCategories[] = $options;

        $this->set(compact('smsDetails', 'search', 'customerCategories','customer_category_id'));
        $this->set('_serialize', ['smsDetails']);
    }

    /**
     * View method
     *
     * @param string|null $id Sms Detail id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $smsDetail = $this->SmsDetails->get($id, [
            'contain' => ['Users', 'SmsRecords' => function($q){
                return $q->contain(['Customers'])->where(['result != ' => 'ok']);
            }]
        ]);

        $this->set('smsDetail', $smsDetail);
        $this->set('_serialize', ['smsDetail']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sms Detail id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $smsDetail = $this->SmsDetails->get($id);
        if ($this->SmsDetails->delete($smsDetail)) {
            $this->Flash->success(__('The sms detail has been deleted.'));
        } else {
            $this->Flash->error(__('The sms detail could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() 
    {
        $this->loadModel('CustomerCategories');
        $sWhere = [];

        if ( isset($_GET['content']) && $_GET['content'] != '' )
        {   
            $content = $_GET['content'];
            $sWhere['SmsDetails.content LIKE'] = "%".$content."%";
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['SmsDetails.created >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['SmsDetails.created <='] = $end_modified;
        }
        $customerCategories = [];
        if ( isset($_GET['customer_category_id']))
        {
            $customer_category_id = intval($_GET['customer_category_id']);
            if (intval($customer_category_id) != 0) {
                $results = $this->CustomerCategories->find('path', ['for' => $customer_category_id]);            

                foreach ($results as $value) {            
                    $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
                    $arr = array();
                    foreach ($list as $k => $v) {
                        $arr[$k] = $v;
                    }
                    $value->options = $arr; 
                    $customerCategories[] = $value;                         
                }
                $children = $this->CustomerCategories->find('children', [
                    'for' => $customer_category_id,
                    'fields' => 'id'
                ]);
                $childrenArr = [$customer_category_id];
                foreach ($children as $value) {
                    $childrenArr[] = $value->id;
                }
                $sWhere['customer_category_id in '] = $childrenArr;
            } else {
                $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $options = new \StdClass();
                $options->id = 0;
                $options->options = $arr; 
                $customerCategories[] = $options;
                if(array_key_exists('customer_category_id', $sWhere)) unset($sWhere['customer_category_id']);
            }
        }



        $this->paginate = [
            'contain' => ['Users' => function($q){
                return $q->select(['Users.username']);
            }],
            'order' => ['SmsDetails.created Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $smsDetails = $this->paginate($this->SmsDetails);
        $search = 1;
        $this->set(compact('smsDetails','content','username','start_modified','end_modified','customer_category_id','search','customerCategories'));
        $this->set('_serialize', ['customers']);
        $this->render('index');
    }
}
