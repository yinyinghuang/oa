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
        $_user = $this->request->session()->read('Auth')['User'];

        $conditions = [];
        $conditions['OR'] = [
            ['alia is null'],['alia is not null','user_id' => $_user['id']]
        ];
        $this->paginate = [
            'contain' => ['Users', 'FinanceTypes'],
            'conditions' => $conditions,
            'order' => ['Finances.id DESC'],
            'limit' => 10
        ];
        $search = $reset ? 1 : 0;
        $finances = $this->paginate($this->Finances);

        //更新通知中的入账消息，将此前入账消息标记为已读
        $this->loadModel('Notices');
        $this->Notices->query()
            ->update()
            ->set(['state' => 1])
            ->where(['user_id' => $_user['id'], 'controller' => 'Finances','state' => 0])
            ->execute();

        $this->set(compact('finances','search'));
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
                $finance->receipt = '<a href="/' . $finance->receipt . '">' . $filename[count($filename)-1] . '</a>';
            }
        }
        $this->set(compact('finance'));
        $this->set('_serialize', ['finance']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($task_id = 0)
    {
        $this->loadModel('FinanceBalances');
        $_user = $this->request->session()->read('Auth')['User'];
        //标记任务为已读
        if ($task_id) {
            $this->loadModel('Tasks');
            $task = $this->Tasks->get($task_id);
            $task->state = 1;
            $this->Tasks->save($task);
        }
        $this->loadModel('UserDepartmentRoles');
        // $roleMax = $this->UserDepartmentRoles->findByUserId($_user['id'])->group('role_id')->max('role_id')->role_id;
        // if ($roleMax != 4) {
            $balance = $this->FinanceBalances->findByUserId($_user['id'])->first();
            if(!$balance || $balance->balance == 0) {
                $this->Flash->error(__('你的账户余额不足,请申请'));
                $this->redirect(['action' => 'apply']);
            }
        // }
        $finance = $this->Finances->newEntity();
        if ($this->request->is('post')) {
            $amount = intval($this->request->getData('amount'));

            $finance = $this->Finances->patchEntity($finance, $this->request->getData());
            $finance->payee = $this->request->getData('payee_' . $_POST['payee_type']);
            $finance->balance = $balance->balance - $amount;
            $finance->amount = 0 - $amount;
            
            //记录保存情况判断
            if ($this->Finances->save($finance)) {//成功则刷新账户余额，重定向至流水账首页                    
                
                $balance->balance = $finance->balance;
                $this->FinanceBalances->save($balance);

                //refresh the payee's balance when the payee is an employee
                if ($_POST['payee_type'] == 1) {
                    $payee_id = $this->request->getData('payee_id');
                    // 查看收款人账户余额
                    $payeeBalance = $this->FinanceBalances->findByUserId($payee_id)->first();
                    if($payeeBalance) {//若存在余额记录，刷新余额
                        $payeeBalance->balance += $amount;
                    }else{//不存在则新建记录，刷新金额
                        $payeeBalance = $this->FinanceBalances->newEntity();
                        $payeeBalance->user_id = $payee_id;
                        $payeeBalance->balance = $amount;
                    }
                    $this->FinanceBalances->save($payeeBalance);

                    //添加收款人收入流水记录
                    $payee = $this->Finances->newEntity([
                        'alia' => $finance->id,
                        'user_id' => $payee_id,
                        'amount' => $amount,
                        'detail' => $this->request->getData('detail'),
                        'finance_type_id' => $this->request->getData('finance_type_id'),
                        'receipt' => $this->request->getData('receipt'),
                        'balance' => $payeeBalance->balance,
                        'payee' => $_user['username'],
                        'payee_id' => $_user['id']
                    ]);
                    $this->Finances->save($payee);
                }
                if ($this->request->getData('task_id')) { //若此记录为经费拨款，在完成拨款后，将任务列表中的记录删除，在申请记录中删除
                    $this->loadModel('Tasks');
                    $task = $this->Tasks->get($this->request->getData('task_id'));
                    $this->Tasks->delete($task);
                }
                //通知收款人经费已到账
                $this->loadModel('Notices');
                $query = $this->Notices->newEntity([
                    'controller' => 'Finances',
                    'itemid' => $payee->id,
                    'user_id' => $finance->payee_id,
                    'state' => 0
                ]);
                $this->Notices->save($query);
                
                $this->Flash->success(__('The finance has been saved.'));

                return $this->redirect(['action' => 'index']);
            }else{//否则返回记录保存失败提示                    
                $this->Flash->error(__('The finance could not be saved. Please, try again.'));
            } 
        }
        if ($task_id) {
            $this->loadModel('Tasks');
            $task = $this->Tasks->get($task_id,[
                'contain' => ['FinanceApplies']
            ]);
            $task->payee = $this->Finances->Users->get($task->finance_apply->user_id,[
                'fields' => ['Users.id','Users.username']
            ]);
        }
        $financeTypes = $this->Finances->FinanceTypes->find('list');
        $this->set(compact('finance', 'financeTypes','balance','task','roleMax'));
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
        $this->loadModel('FinanceBalances');
        //取经办人账户余额
        $payerBalance = $this->FinanceBalances->findByUserId($finance->user_id)->first();

        if ($this->request->is(['patch', 'post', 'put'])) { 
            $amount = intval($this->request->getData('amount'));           
            $Dvalue = abs($finance->amount) - $amount;//金额修改前后差值

            $finance = $this->Finances->patchEntity($finance, $this->request->getData());
            $finance->balance = $finance->balance + $Dvalue;
            $finance->amount = - $amount;

            if ($this->Finances->save($finance)) {
                //刷新次流水记录后的全部流水余额
                $laterFinances = $this->Finances->find('all',[
                    'conditions' => ['user_id' => $finance->user_id, 'created > ' => $finance->created]
                ]);
                foreach ($laterFinances as $f) {
                    $f->balance += $Dvalue;
                    $this->Finances->save($f);
                }
                //刷新经办人账户余额
                $payerBalance->balance += $Dvalue;
                $this->FinanceBalances->save($payerBalance);

                //若收款人为内部员工，刷新收款人入账流水及账户余额
                if (isset($_POST['payee_id']) && $_POST['payee_id'] != '') {
                    $payee_id = $this->request->getData('payee_id'); 
                    $payeeFinance = $this->Finances->findByAlia($finance->id)->first();
                    $payeeFinance->amount = $amount;  
                    $payeeFinance->balance -= $Dvalue;
                    $this->Finances->save($payeeFinance);                 
                    //后续入账流水余额
                    $laterFinances = $this->Finances->find('all',[
                        'conditions' => ['user_id' => $payee_id, 'created > ' => $payeeFinance->created]
                    ]);
                    foreach ($laterFinances as $f) {
                        $f->balance -= $Dvalue;
                        $this->Finances->save($f);
                    }

                    //账户余额
                    $payeeBalance = $this->FinanceBalances->findByUserId($payee_id)->first();                    
                    $payeeBalance->balance -= $Dvalue;
                    $this->FinanceBalances->save($payeeBalance);

                }
                
                $this->Flash->success(__('The finance has been saved.'));
                return $this->redirect(['action' => 'index']);
                                
            }
            $this->Flash->error(__('The finance could not be saved. Please, try again.'));
        }
        //计算经办人账户可用余额
        $available = $payerBalance->balance - $finance->amount;
        $financeTypes = $this->Finances->FinanceTypes->find('list', ['limit' => 200]);
        $this->set(compact('finance', 'financeTypes','available'));
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
        $this->loadModel('FinanceBalances');
        $finance = $this->Finances->get($id);
        if ($this->Finances->delete($finance)) {
            //刷新次流水记录后的全部流水余额及账户余额
            $laterFinances = $this->Finances->find('all',[
                'conditions' => ['user_id' => $finance->user_id, 'created > ' => $finance->created]
            ]);
            foreach ($laterFinances as $f) {
                $f->balance -= $finance->amount;
                $this->Finances->save($f);
            }
            $payerBalance = $this->FinanceBalances->findByUserId($finance->user_id)->first();
            $payerBalance->balance -= $finance->amount;
            $this->FinanceBalances->save($payerBalance);

            if($finance->payee_id){
                $payeeFinance = $this->Finances->findByAlia($finance->id)->first();
                $this->Finances->delete($payeeFinance);

                $laterFinances = $this->Finances->find('all',[
                    'conditions' => ['user_id' => $finance->payee_id, 'created > ' => $payeeFinance->created]
                ]);
                foreach ($laterFinances as $f) {
                    $f->balance += $finance->amount;
                    $this->Finances->save($f);
                }

                //账户余额
                $payeeBalance = $this->FinanceBalances->findByUserId($finance->payee_id)->first();                    
                $payeeBalance->balance += $finance->amount;
                $this->FinanceBalances->save($payeeBalance);

            }

            $this->Flash->success(__('The finance has been deleted.'));
        } else {
            $this->Flash->error(__('The finance could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() 
    {
        $_user = $this->request->session()->read('Auth')['User'];

        $sWhere['OR'] = [
            ['Finances.alia is null'],['Finances.alia is not null','Finances.user_id' => $_user['id']]
        ];

        if ( isset($_GET['type']) && $_GET['type'] != '-1' )
        {   
            $type = $_GET['type'];
            $sWhere['Finances.finance_type_id'] = $type;
        }
        if ( isset($_GET['alia']) && $_GET['alia'] != '' )
        {   
            $alia = $_GET['alia'];
            if ($alia == 1) {
                $sWhere['Finances.alia is not'] = null;
            } else{
                $sWhere['Finances.alia is '] = null;
            }
            
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
            $sWhere['Finances.alia is '] = null;
        }
        if ( isset($_GET['payee']) && $_GET['payee'] != '' )
        {   
            $payee = $_GET['payee'];
            $sWhere['Finances.payee LIKE'] = "%".$payee."%";
            $sWhere['Finances.alia is '] = null;
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

        $this->set(compact('finances','type','username','start_modified','end_modified','min','max','search','financeTypes','payee','max','min','receipt','alia'));
        $this->set('_serialize', ['finances']);
        $this->render('index');
    }

    public function apply()
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $this->loadModel('FinanceApplies');
        $financeApplies = $this->FinanceApplies->find('all',[
            'conditions' => ['user_id' => $_user['id']],
            'contain' => ['Users']
        ]);
        $approverList = [];
        foreach ($financeApplies as $apply) {
            $approverList[] = $apply->approver;

        }
        $approverList = implode(',', $approverList);
        $this->set(compact('financeApply', 'financeApplies', 'approverList'));
        $this->set('_serialize', ['financeApply']);
    }
    public function getUsers(){
        $userArr = $data = [];
        
        $username = $this->request->query('query');
        $conditions = [
            'username LIKE ' => '%' . $username . '%',
            'id != ' => $this->request->session()->read('Auth')['User']['id']
        ];
        if (isset($_GET['list']) && $_GET['list'] != '') {
            $conditions['id not in '] = explode(',', $_GET['list']);
        }
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
}
