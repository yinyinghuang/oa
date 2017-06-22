<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 *
 * @method \App\Model\Entity\Customer[] paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CustomerCategories' => function($q){
                return $q->select(['CustomerCategories.name']);
            }],
            'order' => ['Customers.modified' => 'Desc']
        ];
        $customers = $this->paginate($this->Customers);
        $search = $this->request->query('reset') ? 1 : 0;
        $customer_category_id = 0;

        $list = $this->Customers->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
        $arr = array();
        foreach ($list as $k => $v) {
            $arr[$k] = $v;
        }
        $options = new \StdClass();
        $options->id = 0;
        $options->options = $arr; 
        $customerCategories[] = $options;

        $this->set(compact('customers','search', 'customerCategories','customer_category_id'));
        $this->set('_serialize', ['customers']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $_user = $this->request->session()->read('Auth')['User'];
        //更新通知中的客户交易，将此前客户交易消息标记为已读
        $this->loadModel('Notices');
        $where = ['user_id' => $_user['id'], 'controller' => 'CustomerBusinesses', 'state' => 0];
        $this->Notices->query()
            ->update()
            ->set(['state' => 1])
            ->where($where)
            ->execute();
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerCategories', 'Users', 'CustomerBusinesses' => function($q){
                return $q->find('all', [
                    'contain' => ['Users'],
                    'fields' => ['CustomerBusinesses.id','CustomerBusinesses.customer_id','CustomerBusinesses.content','CustomerBusinesses.state','CustomerBusinesses.start_time','CustomerBusinesses.end_time','CustomerBusinesses.modified','Users.username'],
                    'limit' => 5,
                    'order' => ['CustomerBusinesses.modified' => 'DESC']
                ]);
            }, 'CustomerIncomes' => function($q){
                return $q->find('all', [
                    'contain' => ['Users','FinanceTypes'],
                    'fields' => ['Users.username','CustomerIncomes.id', 'CustomerIncomes.customer_id', 'CustomerIncomes.amount', 'CustomerIncomes.detail', 'CustomerIncomes.modified', 'FinanceTypes.name'],
                    'limit' => 5,
                    'order' => ['CustomerIncomes.modified' => 'DESC']
                ]);
            }, 'CustomerCategoryValues' => function($q){
                return $q->contain(['CustomerCategoryOptions'])->select(['CustomerCategoryOptions.name', 'CustomerCategoryValues.customer_id', 'CustomerCategoryValues.value']);
            }]
        ]);
        $countBusiness = $this->Customers->CustomerBusinesses->find('all')->where(['customer_id' => $id])->count();
        $countIncome = $this->Customers->CustomerIncomes->find('all')->where(['customer_id' => $id])->count();

        $this->set(compact('customer', 'countBusiness', 'countIncome'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $this->loadModel('CustomerCategoryOptions');
                $options = $this->CustomerCategoryOptions->find('list',['conditions' => ['customer_category_id' => $customer->customer_category_id]]);
                foreach ($options as $key => $option) {
                    $value = $this->Customers->CustomerCategoryValues->newEntity();
                    $value->customer_id = $customer->id;
                    $value->customer_category_option_id = $key;
                    $value->value = is_array($this->request->getData('option_' . $key)) ? implode('|', $this->request->getData('option_' . $key)) : $this->request->getData('option_' . $key);
                    $this->Customers->CustomerCategoryValues->save($value);
                }
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $customerCategories = $this->Customers->CustomerCategories->find('list', ['limit' => 200, 'conditions' => ['parent_id' => 0]]);
        $this->set(compact('customer', 'customerCategories'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['CustomerCategoryValues' => function($q){
                return $q->contain(['CustomerCategoryOptions']);
            }]
        ]);        
        $customer->customer_category_options = $this->Customers->CustomerCategories->CustomerCategoryOptions->find()
            ->where(['customer_category_id' => $customer->customer_category_id]);
        foreach ($customer->customer_category_options as $value) {
            $query_extra = $this->Customers->CustomerCategoryValues->find()
                ->where(['customer_id' =>$id, 'customer_category_option_id' => $value->id])
                ->first();
            
            $value->extra_value = $query_extra ? $query_extra->value : '';
            $value->extra_value_id = $query_extra ? $query_extra->id : '';
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());
            if ($this->Customers->save($customer)) {
                $values = [];
                foreach ($customer->customer_category_options as $option) {
                    $value = [];
                    isset($_POST['value_' . $option->extra_value_id . '_id']) && $value['id'] = $option->extra_value_id;
                    $content = $this->request->getData('value_' .$option->id);
                    $value['value'] = is_array($content) ? implode('|', $content) : $content;
                    $value['customer_id'] = $id;
                    $value['customer_category_option_id'] = $option->id;
                    $values[] = $value;
                }
                $values = $this->Customers->CustomerCategoryValues->patchEntities([], $values);
                
                $this->Customers->CustomerCategoryValues->saveMany($values);
                $this->Flash->success(__('The customer has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $results = $this->Customers->CustomerCategories->find('path', ['for' => $customer->customer_category_id]);
        $customerCategories = [];

        foreach ($results as $value) {            
            $list = $this->Customers->CustomerCategories->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
            $arr = array();
            foreach ($list as $k => $v) {
                $arr[$k] = $v;
            }
            $value->options = $arr; 
            $customerCategories[] = $value;
                 
        }
        if ($customerCategories == []) {
            $list = $this->Customers->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
            $arr = array();
            foreach ($list as $k => $v) {
                $arr[$k] = $v;
            }
            $options = new \StdClass();
            $options->id = 0;
            $options->options = $arr; 
            $customerCategories[] = $options;
        }
        $this->set(compact('customer', 'customerCategories'));
        $this->set('_serialize', ['customer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function import()
    {   
        if ($this->request->isPost() || $this->request->isPut()) {
            $fileOK = $this->uploadFiles('files/import', $this->request->data['File'], date('YmdH',time()));
            if (array_key_exists('urls', $fileOK)) {
                require_once(ROOT . DS  . 'vendor' . DS  . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel.php');
                require_once(ROOT . DS  . 'vendor' . DS  . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');

                $reader = \PHPExcel_IOFactory::load(WWW_ROOT . $fileOK['urls'][0]);
                $objWorksheet = $reader->getActiveSheet()->toArray(null,true,true,true);
                
                $countRow = 1;
                $this->loadModel('CustomerCategoryOptions');
                $user_id = $this->request->session()->read('Auth')['User']['id'];
                $category_id = $this->request->getData('customer_category_id');
                $options = $this->CustomerCategoryOptions->find('all')
                    ->where(['customer_category_id' => $category_id])
                    ->select('id')
                    ->order(['id' => 'ASC']);
                foreach ($objWorksheet as $row) {
                    if($countRow > 1){
                        $is_exisit = $this->Customers->find('all')
                            ->where(['mobile' => $row['D']])
                            ->count();
                        if ($is_exisit) continue;
                        $countCol = 71;
                        $values = array();
                        foreach ($options as $key => $option_id) {
                            $values[$key]['customer_category_option_id'] = $option_id->id;
                            $values[$key]['value'] = $row[chr($countCol)];
                            $countCol ++ ;
                        }
                        $data = [
                            'customer_category_id' => $category_id,
                            'name' => $row['A'],
                            'company' => $row['B'],
                            'country_code' => intval($row['C']),
                            'mobile' => $row['D'],
                            'email' => $row['E'],
                            'position' => $row['F'],
                            'user_id' => $user_id,
                            'customer_category_values' => $values
                        ];
                        $customer = $this->Customers->newEntity($data, [
                            'associated' => ['CustomerCategoryValues']
                        ]);
                        if (!$this->Customers->save($customer)) {
                            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
                            return $this->redirect(['action' => 'index']);
                        }
                    }
                    $countRow++;
                }
                $this->Flash->success(__('成功导入资料.'));
                return $this->redirect(['action' => 'index']);
            } 
            $this->Flash->error(__('未能成功导入资料.'));
        }
        $customerCategories = $this->Customers->CustomerCategories->find('list', ['limit' => 200, 'conditions' => ['parent_id' => 0]]);
        $this->set(compact('customerCategories'));
    }
    public function search() 
    {
        $sWhere = [];

        if ( isset($_GET['name']) && $_GET['name'] != '' )
        {   
            $name = $_GET['name'];
            $sWhere['Customers.name LIKE'] = "%".$name."%";
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
        }
        if ( isset($_GET['mobile']) && $_GET['mobile'] != '' )
        {   
            $mobile = $_GET['mobile'];
            $sWhere['Customers.mobile LIKE'] = "%".$mobile."%";
        }
        if ( isset($_GET['email']) && $_GET['email'] != '' )
        {   
            $email = $_GET['email'];
            $sWhere['Customers.email LIKE'] = "%".$email."%";
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['Customers.modified >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['Customers.modified <='] = $end_modified;
        }
        $customerCategories = [];
        if ( isset($_GET['customer_category_id']))
        {
            $customer_category_id = intval($_GET['customer_category_id']);
            if (intval($customer_category_id) != 0) {
                $results = $this->Customers->CustomerCategories->find('path', ['for' => $customer_category_id]);

                foreach ($results as $value) {            
                    $list = $this->Customers->CustomerCategories->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
                    $arr = array();
                    foreach ($list as $k => $v) {
                        $arr[$k] = $v;
                    }
                    $value->options = $arr; 
                    $customerCategories[] = $value;                         
                }
                $query = $this->Customers->CustomerCategories->get($customer_category_id);
                $childrenArr = $this->Customers->CustomerCategories->find('all')
                    ->where(['lft >= ' => $query->lft, 'lft <= ' => $query->rght])
                    ->extract('id')
                    ->toArray();

                $sWhere['customer_category_id in '] = $childrenArr;
                $category = $this->Customers->CustomerCategories->get($customer_category_id, ['contain' => 'CustomerCategoryOptions']);
                $extraFonts = $extraSearch = $extraSearchCustomerId = [];
                foreach ($category->customer_category_options as $option) {
                    $sWhereSub = [];
                    $option->font && $extraFonts[$option->id] = $option->name;
                    if ($option->searchable) {
                        $extraSearch['option' . $option->id] = [
                            'name' => $option->name,
                            'control' => in_array($option->type, ['textarea', 'text']) ? 'text' : $option->type,
                            'options' => in_array($option->type, ['textarea', 'text']) ? $option->value : explode('|', $option->value)
                        ];
                        if ( isset($_GET['option' . $option->id]) && $_GET['option' . $option->id] !== '' )
                        { 
                            if (isset($sWhere['Customers.id in ']) && empty($sWhere['Customers.id in '])) continue;
                            $optionName = 'option' . $option->id;
                            $$optionName = $_GET['option' . $option->id];
                            $sWhereSub['customer_category_option_id'] = $option->id;
                            if (in_array($option->type, ['textarea', 'text'])) {
                                $sWhereSub['value LIKE '] = '%' . $$optionName . '%';
                            } else {
                                $sWhereSub['value'] = $$optionName;
                            }
                            $query = $this->Customers->CustomerCategoryValues->find('all')
                                ->where($sWhereSub)
                                ->select(['customer_id']);
                            foreach ($query as $value) {
                                $extraSearchCustomerId[] =  $value->customer_id;
                            }
                            $sWhere['Customers.id in '] = isset($sWhere['Customers.id in ']) ?  array_intersect($sWhere['Customers.id in '],$extraSearchCustomerId) : $extraSearchCustomerId;
                           
                        }
                    }
                    
                }

            } else {
                $list = $this->Customers->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
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
        if (isset($sWhere['Customers.id in ']) && $sWhere['Customers.id in '] == []) $sWhere['Customers.id in '] = [0];

        $this->paginate = [
            'contain' => ['Users' => function($q){
                return $q->select(['Users.username']);
            },'CustomerCategories'],
            'order' => ['Customers.modified Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $customers = $this->paginate($this->Customers);
        if (isset($extraFonts) && $extraFonts && $customers) {
            $optionIds = array_keys($extraFonts);
            foreach ($customers as $customer) {
                $customer->customer_category_id == $customer_category_id && $customer->customer_category_values = $this->Customers->CustomerCategoryValues->find()
                    ->where(['customer_category_option_id in ' => $optionIds, 'customer_id' => $customer->id])
                    ->combine('customer_category_option_id', 'value')
                    ->toArray();
            }
        }
        $search = 1;
        $searchVaribles = isset($extraSearch) ? implode(',', array_keys($extraSearch)) : '';
        $this->set(compact('customers','name','username','mobile','email','start_modified','end_modified','customer_category_id','search','customerCategories','extraFonts','extraSearch'));        
        $searchVaribles && $this->set(compact($searchVaribles));

        $this->set('_serialize', ['customers']);
        $this->render('index');
    }

    public function getUsers(){
        $userArr = $data = [];
        
        $username = $this->request->query('query');
        $conditions = [
            'username LIKE ' => '%' . $username . '%',
            'id != ' => $this->request->session()->read('Auth')['User']['id']
        ];
        $query = $this->Customers->Users->find('all',[
            'conditions' => $conditions,
            'fields' => ['Users.id','Users.username']
        ]);
        foreach ($query as $user) {
            $dataArr = [];
            $dataArr['value'] = $user->username;
            $dataArr['data'] = $user->id;
            $userArr[] = $dataArr;
        }
        $data = [
            "query" => "Unit",
            "suggestions" => $userArr,
        ];
        $this->response->body(json_encode($data));
        return $this->response;
    }
}
