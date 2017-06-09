<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerIncomes Controller
 *
 * @property \App\Model\Table\CustomerIncomesTable $CustomerIncomes
 *
 * @method \App\Model\Entity\CustomerIncome[] paginate($object = null, array $settings = [])
 */
class CustomerIncomesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($customer_id = 0, $reset = null)
    {   
        $conditions = [];
        if ($customer_id != 0) {
            $conditions['customer_id'] = $customer_id;
            $customer = $this->CustomerIncomes->Customers->get($customer_id,['fields' => ['name', 'id']]);
        }
        $this->paginate = [
            'contain' => ['Users', 'Customers','FinanceTypes'],
            'conditions' => $conditions,
            'order' => ['CustomerIncomes.modified Desc'],
            'limit' => 10
        ];
        $customerIncomes = $this->paginate($this->CustomerIncomes);
        $search = $reset ? 1 : 0;
        $financeTypes = $this->CustomerIncomes->FinanceTypes->find('list', ['limit' => 200]);

        $this->set(compact('customerIncomes', 'search', 'customer', 'financeTypes', 'customer_id'));
        $this->set('_serialize', ['customerIncomes']);
    }

    public function reporter($customer_id = 0, $reset = null)
    {   
        $conditions = [];
        $this->loadModel('CustomerCategories');
        $topTenTimesCustomers = $this->CustomerIncomes
            ->find('all',[
                    'contain' => ['Customers'],
                    'fields' => ['Customers.name','total' => 'COUNT(CustomerIncomes.id)','CustomerIncomes.customer_id'],
                    'group' => ['CustomerIncomes.customer_id'],
                    'order' => ['COUNT(CustomerIncomes.id) DESC'],
                ])
            ->limit(10);

        $topTenConsumptionCustomers = $this->CustomerIncomes
            ->find('all',[
                    'contain' => ['Customers'],
                    'fields' => ['Customers.name','total' => 'SUM(CustomerIncomes.amount)','CustomerIncomes.customer_id'],
                    'group' => ['CustomerIncomes.customer_id'],
                    'order' => ['SUM(CustomerIncomes.amount) DESC'],
                ])
            ->limit(10);


        $query = $this->CustomerCategories->find('children',['for' => 1,'fields' => 'CustomerCategories.id']);
        $categoriesLevel1 = $this->CustomerIncomes
            ->find('all',[
                    'contain' => ['Customers'],
                    'group' => ['CustomerIncomes.customer_id'],
                    'fields' => ['total' => 'SUM(CustomerIncomes.amount)','Customers.customer_category_id'],
                ]);
        $this->set(compact('topTenTimesCustomers', 'search', 'topTenConsumptionCustomers','categoriesLevel1'));
        $this->set('_serialize', ['customerIncomes']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer Income id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerIncome = $this->CustomerIncomes->get($id, [
            'contain' => ['Users', 'Customers','FinanceTypes']
        ]);
        if ($customerIncome->receipt != '') {
            $ext = explode('.', $customerIncome->receipt);
            if (in_array($ext[count($ext)-1], array('png', 'gif', 'jpg'))) {
                $customerIncome->receipt = '<img src="/' . $customerIncome->receipt . '">';
            }else{
                $filename = explode('/', $customerIncome->receipt);
                $customerIncome->receipt = '<a src="/' . $customerIncome->receipt . '">' . $filename[count($filename)-1] . '</a>';
            }
        }
        $this->set(compact('customerIncome'));
        $this->set('_serialize', ['customerIncome']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($customer_id = 0)
    {
        $customerIncome = $this->CustomerIncomes->newEntity();
        if ($this->request->is('post')) {
            $customerIncome = $this->CustomerIncomes->patchEntity($customerIncome, $this->request->getData());
            
            if ($this->CustomerIncomes->save($customerIncome)) {
                if (isset($_POST['customer_id']) && $_POST['customer_id'] != 0) {
                    $customer_id = $_POST['customer_id'];
                }
                $customer = $this->CustomerIncomes->Customers->get($customer_id);
                $customer->modified = date('Y-m-d H:i:s', time());
                $this->CustomerIncomes->Customers->save($customer);
                $this->Flash->success(__('The customer income has been saved.'));

                return $this->redirect(['controller' => 'Customers', 'action' => 'view', $customer_id]);
            }
            $this->Flash->error(__('The customer income could not be saved. Please, try again.'));
            
        }
        if ($customer_id != 0) {
            $customer = $this->CustomerIncomes->Customers->get($customer_id);
        }
        $financeTypes = $this->CustomerIncomes->FinanceTypes->find('list', ['limit' => 200]);
        $this->set(compact('customerIncome', 'customer_id', 'financeTypes','customer'));
        $this->set('_serialize', ['customerIncome']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Income id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerIncome = $this->CustomerIncomes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerIncome = $this->CustomerIncomes->patchEntity($customerIncome, $this->request->getData());
            if ($this->CustomerIncomes->save($customerIncome)) {
                $customer = $this->CustomerIncomes->Customers->get($customerIncome->customer_id);
                $customer->modified = date('Y-m-d H:i:s', time());
                $this->CustomerIncomes->Customers->save($customer);
                $this->Flash->success(__('The customer income has been saved.'));

                return $this->redirect(['action' => 'index',$customerIncome->customer_id]);
            }
            $this->Flash->error(__('The customer income could not be saved. Please, try again.'));
        }
        $financeTypes = $this->CustomerIncomes->FinanceTypes->find('list', ['limit' => 200]);
        $this->set(compact('customerIncome','financeTypes'));
        $this->set('_serialize', ['customerIncome']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Income id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerIncome = $this->CustomerIncomes->get($id);
        if ($this->CustomerIncomes->delete($customerIncome)) {
            $this->Flash->success(__('The customer income has been deleted.'));
        } else {
            $this->Flash->error(__('The customer income could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() 
    {
        $sWhere = null;
        $customer_id = 0;

        if ( isset($_GET['type']) && $_GET['type'] != '-1' )
        {   
            $type = $_GET['type'];
            $sWhere['CustomerIncomes.finance_type_id'] = $type;
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['CustomerIncomes.modified >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['CustomerIncomes.modified <='] = $end_modified;
        }
        if ( isset($_GET['min']) && $_GET['min'] != '' )
        {
            $min = $_GET['min'];
            $sWhere['CustomerIncomes.amount >='] = $min;
        }
        if ( isset($_GET['max']) && $_GET['max'] != '' )
        {
            $max = $_GET['max'];
            $sWhere['CustomerIncomes.amount <='] = $max;
        }        
        if ( isset($_GET['customer_id']) && $_GET['customer_id'] != 0 )
        {   
            $customer_id = $_GET['customer_id'];
            $customer = $this->CustomerIncomes->Customers->get($customer_id,['fields' => ['name', 'id']]);
            $sWhere['CustomerIncomes.customer_id'] = $customer_id;
        }
        if ( isset($_GET['name']) && $_GET['name'] != '' )
        {   
            $name = $_GET['name'];
            $sWhere['Customers.name LIKE'] = "%".$name."%";
        }
        if ( isset($_GET['receipt']) && $_GET['receipt'] == 1 )
        {
            $receipt = $_GET['receipt'];
            $sWhere['CustomerIncomes.receipt != '] = '';
        }



        $this->paginate = [
            'contain' => ['Users' => function($q){
                return $q->select(['Users.username']);
            },'FinanceTypes'],
            'order' => ['CustomerIncomes.modified Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $customerIncomes = $this->paginate($this->CustomerIncomes);
        $search = 1;
        $financeTypes = $this->CustomerIncomes->FinanceTypes->find('list', ['limit' => 200]);

        $this->set(compact('customerIncomes','type','username','start_modified','end_modified','min','max','search','customer','financeTypes','customer_id','name','receipt'));
        $this->set('_serialize', ['customerIncomes']);
        $this->render('index');
    }

    public function getCustomers(){
        $customerArr = $data = [];
        
        $name = $this->request->query('query');
        $conditions = [
            'name LIKE ' => '%' . $name . '%'
        ];
        $query = $this->CustomerIncomes->Customers->find('all',[
            'conditions' => $conditions,
            'fields' => ['Customers.id','Customers.name']
        ]);
        foreach ($query as $customer) {
            $dataArr = [];
            $dataArr['value'] = $customer->name;
            $dataArr['data'] = $customer->id;
            $customerArr[] = $dataArr;
        }
        $data = [
            "query" => "Unit",
            "suggestions" => $customerArr,
        ];
        $this->response->body(json_encode($data));
        return $this->response;
    }
    
}
