<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Finances Controller
 *
 * @property \App\Model\Table\FinancesTable $Finances
 *
 * @method \App\Model\Entity\Finance[] paginate($object = null, array $settings = [])
 */
class FinancesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($reset = null)
    {
        $this->paginate = [
            'contain' => ['Users', 'FinanceTypes'],
            'conditions' => ['Finances.customer_id is null'],
            'order' => ['Finances.modified DESC'],
            'limit' => 10
        ];
        $search = $reset ? 1 : 0;
        $finances = $this->paginate($this->Finances);

        $this->set(compact('finances','search'));
        $this->set('_serialize', ['finances']);
    }

    public function customerIncomes($customer_id = 0, $reset = null)
    {
        $conditions = $customer = null;
        $conditions[] = ['Finances.customer_id is not null'];
        if($customer_id != 0) {
            $conditions['customer_id'] =  $customer_id;
            $customer = $this->Finances->Customers->get($customer_id,['fields' => ['name', 'id']]);
        }
        $this->paginate = [
            'contain' => ['Users', 'FinanceTypes','Customers'],
            'conditions' => $conditions,
            'order' => ['Finances.modified Desc']
        ];
        $finances = $this->paginate($this->Finances);

        $search = $reset ? 1 : 0;
        $financeTypes = $this->Finances->FinanceTypes->find('list', ['limit' => 200]);

        $this->set(compact('finances', 'search', 'customer', 'financeTypes','customer_id'));
        $this->set('_serialize', ['finances']);
    }

    /**
     * View method
     *
     * @param string|null $id Finance id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $finance = $this->Finances->get($id, [
            'contain' => ['Users', 'FinanceTypes']
        ]);
        if ($finance->receipt != '') {
            $ext = explode('.', $finance->receipt);
            if (in_array($ext[count($ext)-1], array('png', 'gif', 'jpg'))) {
                $finance->receipt = '<img src="/' . $finance->receipt . '" style="border:1px solid #ccc">';
            }else{
                $filename = explode('/', $finance->receipt);
                $finance->receipt = '<a src="/' . $finance->receipt . '">' . $filename[count($filename)-1] . '</a>';
            }
        }
        $customer = null;
        if ($finance->customer_id) {
            $customer = $this->Finances->Customers->get($finance->customer_id);
        }
        $this->set(compact('finance','customer'));
        $this->set('_serialize', ['finance']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('FinanceBalances');
        $_user = $this->request->session()->read('Auth')['User'];
        $balance = $this->FinanceBalances->findByUserId($_user['id'])->first();
        if(!$balance || $balance->balance == 0) {
            $this->Flash->error(__('你的账户余额不足,请申请'));
            $this->redirect(['action' => 'apply']);
        }
            
        $finance = $this->Finances->newEntity();
        if ($this->request->is('post')) {
            $amount = intval($this->request->getData('amount'));

            $finance = $this->Finances->patchEntity($finance, $this->request->getData());
            $finance->payee = $this->request->getData('payee_' . $_POST['payee_type']);
            $finance->balance = $balance->balance - $amount;
            
            //记录保存情况判断
            if ($this->Finances->save($finance)) {//成功则刷新账户余额，重定向至流水账首页                    
                
                $balance->balance = $finance->balance;
                $this->FinanceBalances->save($balance);

                //refresh the payee's balance when the payee is employee
                if ($_POST['payee_type'] == 1) {
                    $payee_id = $this->request->getData('payee_id');
                    // 查看收款人账户余额
                    $balance = $this->FinanceBalances->findByUserId($payee_id)->first();
                    if($balance) {//若存在余额记录，刷新余额
                        $balance->balance += $finance->amount;
                    }else{//不存在则新建记录，刷新金额
                        $balance = $this->FinanceBalances->newEntity();
                        $balance->user_id = $payee_id;
                        $balance->balance = $finance->amount;
                    }
                    $this->FinanceBalances->save($balance);

                    //添加收款人收入流水记录
                    $payee = $this->Finances->newEntity([
                        'user_id' => $payee_id,
                        'amount' => (0-$amount),
                        'detail' => $this->request->getData('detail'),
                        'finance_type_id' => $this->request->getData('finance_type_id'),
                        'receipt' => $this->request->getData('receipt'),
                        'balance' => $balance->balance,
                        'payee' => $_user['username'],
                        'payee_id' => $_user['id']
                    ]);
                    $this->Finances->save($payee);
                }
               
                $this->Flash->success(__('The finance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{//否则返回记录保存失败提示                    
                $this->Flash->error(__('The finance could not be saved. Please, try again.'));
            } 
        }
        $financeTypes = $this->Finances->FinanceTypes->find('list', ['limit' => 200]);
        $this->set(compact('finance', 'financeTypes','balance'));
        $this->set('_serialize', ['finance']);
    }

    public function addCustomer($customer_id)
    {
        $finance = $this->Finances->newEntity();

        if ($this->request->is('post')) {

            $finance = $this->Finances->patchEntity($finance, $this->request->getData());
            if ($this->Finances->save($finance)) {
                $customer = $this->Finances->Customers->get($customer_id);
                $customer->modified = date('Y-m-d H:i:s', time());
                $this->Finances->Customers->save($customer);
                $redirect = ['controller' => 'Customers', 'action' => 'view', $customer_id];
                
                $this->Flash->success(__('The finance has been saved.'));

                return $this->redirect(['controller' => 'Customers', 'action' => 'view', $customer_id]);
            }else{
                $this->Flash->error(__('The finance could not be saved. Please, try again.'));
            }
        }
        $financeTypes = $this->Finances->FinanceTypes->find('list', ['limit' => 200]);
        $this->set(compact('finance', 'financeTypes','customer_id'));
        $this->set('_serialize', ['finance']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Finance id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $finance = $this->Finances->get($id, [
            'contain' => []
        ]);
        if (!$finance->customer_id) {
            $this->loadModel('FinanceBalances');
            $balance = $this->FinanceBalances->findByUserId($finance->user_id)->first();
            $balance->balance += $finance->amount;
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $Dvalue = $finance->amount - intval($this->request->getData('amount'));
            $finance = $this->Finances->patchEntity($finance, $this->request->getData());

            $finance->balance = $finance->balance + $Dvalue;
            if ($this->Finances->save($finance)) {
                $redirect = ['action' => 'index'];
                if ($finance->customer_id) {
                    $customer = $this->Finances->Customers->get($finance->customer_id);
                    $customer->modified = date('Y-m-d H:i:s', time());
                    $this->Finances->Customers->save($customer);
                    $redirect = ['controller' => 'Customers', 'action' => 'view', $finance->customer_id];
                }else{

                    $balance->balance = $balance->balance - $Dvalue;
                    $this->FinanceBalances->save($balance);

                    //refresh the payee's balance when the payee is employee
                    if ($_POST['payee_type'] == 1) {
                        $payee_id = $this->request->getData('payee_id');
                        $balance = $this->FinanceBalances->findByUserId($payee_id)->first();
                        if($balance) {
                            $balance->balance += $finance->amount;
                        }else{
                            $balance = $this->FinanceBalances->newEntity();
                            $balance->user_id = $payee_id;
                            $balance->balance = $finance->amount;
                        }
                        $this->FinanceBalances->save($balance);

                    }
                }
                
                $this->Flash->success(__('The finance has been saved.'));
                return $this->redirect($redirect);
                                
            }
            $this->Flash->error(__('The finance could not be saved. Please, try again.'));
        }
        $financeTypes = $this->Finances->FinanceTypes->find('list', ['limit' => 200]);
        $this->set(compact('finance', 'financeTypes','balance','payee'));
        $this->set('_serialize', ['finance']);

    }

    /**
     * Delete method
     *
     * @param string|null $id Finance id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $finance = $this->Finances->get($id);
        if ($this->Finances->delete($finance)) {
            $this->Flash->success(__('The finance has been deleted.'));
        } else {
            $this->Flash->error(__('The finance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() 
    {
        $sWhere = $customer = null;
        $customer_id = 0;

        if ( isset($_GET['type']) && $_GET['type'] != '-1' )
        {   
            $type = $_GET['type'];
            $sWhere['Finances.finance_type_id'] = $type;
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
        }
        if ( isset($_GET['name']) && $_GET['name'] != '' )
        {   
            $name = $_GET['name'];
            $sWhere['Customers.name LIKE'] = "%".$name."%";
        }
        if ( isset($_GET['payee']) && $_GET['payee'] != '' )
        {   
            $payee = $_GET['payee'];
            $sWhere['Finances.payee LIKE'] = "%".$payee."%";
        }
        if ( isset($_GET['customer_id']) && $_GET['customer_id'] != 0 )
        {   
            $customer_id = $_GET['customer_id'];
            $customer = $this->Finances->Customers->get($customer_id,['fields' => ['name', 'id']]);
            $sWhere['Finances.customer_id'] = $customer_id;
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['Finances.modified >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['Finances.modified <='] = $end_modified;
        }
        if ( isset($_GET['min']) && $_GET['min'] != '' )
        {
            $min = $_GET['min'];
            $sWhere['Finances.amount >='] = $min;
        }
        if ( isset($_GET['max']) && $_GET['max'] != '' )
        {
            $max = $_GET['max'];
            $sWhere['Finances.amount <='] = $max;
        }
        if ( isset($_GET['receipt']) && $_GET['receipt'] == 1 )
        {
            $receipt = $_GET['receipt'];
            $sWhere['Finances.receipt != '] = '';
        }



        $this->paginate = [
            'contain' => ['Users' => function($q){
                return $q->select(['Users.username']);
            },'FinanceTypes'],
            'order' => ['Finances.modified Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $finances = $this->paginate($this->Finances);
        $search = 1;
        
        $financeTypes = $this->Finances->FinanceTypes->find('list', ['limit' => 200]);

        $this->set(compact('finances','type','username','start_modified','end_modified','min','max','search','customer','financeTypes','customer_id','payee','max','min','receipt'));
        $this->set('_serialize', ['finances']);
        if ($customer_id == 0) {
            $this->render('index');
        } else {
            $this->render('customer_incomes');
        }
    }

    public function apply()
    {
        
    }
    public function getUsers(){
        $userArr = $data = [];
        
        $username = $this->request->query('query');
        $conditions = [
            'username LIKE ' => '%' . $username . '%',
            'id != ' => $this->request->session()->read('Auth')['User']['id']
        ];
        $query = $this->Finances->Users->find('all',[
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
    public function saveAttachment()
    {   
        $this->request->allowMethod(['post']);
        $data = [];
        $fileOK = $this->uploadFiles('files/receipts', [$this->request->data['attachment']], date('Ymd',time()));
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
