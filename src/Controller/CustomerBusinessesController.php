<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerBusinesses Controller
 *
 * @property \App\Model\Table\CustomerBusinessesTable $CustomerBusinesses
 *
 * @method \App\Model\Entity\CustomerBusiness[] paginate($object = null, array $settings = [])
 */
class CustomerBusinessesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($customer_id = null, $reset = null)
    {   
        if ($customer_id == null) $this->redirect($this->referer());
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => ['customer_id' => $customer_id],
            'order' => ['CustomerBusinesses.modified Desc']
        ];
        $customerBusinesses = $this->paginate($this->CustomerBusinesses);
        $customer = $this->CustomerBusinesses->Customers->get($customer_id,['fields' => ['name', 'id']]);
        $search = $reset ? 1 : 0;

        $this->set(compact('customerBusinesses', 'search', 'customer'));
        $this->set('_serialize', ['customerBusinesses']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer Business id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerBusiness = $this->CustomerBusinesses->get($id, [
            'contain' => ['Customers', 'Users']
        ]);

        $this->set('customerBusiness', $customerBusiness);
        $this->set('_serialize', ['customerBusiness']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($customer_id)
    {
        $customerBusiness = $this->CustomerBusinesses->newEntity();
        if ($this->request->is('post')) {
            $customerBusiness = $this->CustomerBusinesses->patchEntity($customerBusiness, $this->request->getData());
            if ($this->CustomerBusinesses->save($customerBusiness)) {
                
                if ($this->request->getData('end_time')) {
                    $this->loadModel('Tasks');
                    $task = $this->Tasks->newEntity();
                    $task->controller = 'CustomerBusinesses';
                    $task->itemid = $customerBusiness->id;
                    $task->user_id = $customerBusiness->user_id;
                    $task->state = 0;
                    $this->Tasks->save($task);
                }
                $this->loadModel('Customers');
                $customer = $this->Customers->get($customer_id);
                $customer->modified = date('Y-m-d H:i:s', time());
                $this->Customers->save($customer);

                $this->Flash->success(__('The customer business has been saved.'));

                return $this->redirect(['controller' => 'Customers', 'action' => 'view',$customer_id]);
            }
            $this->Flash->error(__('The customer business could not be saved. Please, try again.'));
        }
        $this->set(compact('customerBusiness', 'customer_id'));
        $this->set('_serialize', ['customerBusiness']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Business id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerBusiness = $this->CustomerBusinesses->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customerBusiness = $this->CustomerBusinesses->patchEntity($customerBusiness, $this->request->getData());
            if ($this->CustomerBusinesses->save($customerBusiness)) {
                $customer = $this->CustomerIncomes->Customers->get($customer_id);
                $customer->modified = date('Y-m-d H:i:s', time());
                $this->CustomerIncomes->Customers->save($customer);
                $this->Flash->success(__('The customer business has been saved.'));

                return $this->redirect(['controller' => 'Customers', 'action' => 'view',$customerBusiness->customer_id]);
            }
            $this->Flash->error(__('The customer business could not be saved. Please, try again.'));
        }
        if($customerBusiness->start_time != null)$customerBusiness->start_time = date_format($customerBusiness->start_time, 'Y-m-d H:i');
        if($customerBusiness->end_time != null)$customerBusiness->end_time = date_format($customerBusiness->end_time, 'Y-m-d H:i');
        $customers = $this->CustomerBusinesses->Customers->find('list', ['limit' => 200]);
        $users = $this->CustomerBusinesses->Users->find('list', ['limit' => 200]);
        $this->set(compact('customerBusiness', 'customers', 'users'));
        $this->set('_serialize', ['customerBusiness']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Business id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerBusiness = $this->CustomerBusinesses->get($id);
        if ($this->CustomerBusinesses->delete($customerBusiness)) {
            $this->Flash->success(__('The customer business has been deleted.'));
        } else {
            $this->Flash->error(__('The customer business could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Customers', 'action' => 'view',$customerBusiness->customer_id]);
    }

    public function search() 
    {
        $sWhere = null;

        if ( isset($_GET['content']) && $_GET['content'] != '' )
        {   
            $content = $_GET['content'];
            $sWhere['CustomerBusinesses.content LIKE'] = "%".$content."%";
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
        }
        if ( isset($_GET['start_time']) && $_GET['start_time'] != '' )
        {
            $start_time = $_GET['start_time'];
            $sWhere['CustomerBusinesses.start_time >='] = $start_time;
        }
        if ( isset($_GET['end_time']) && $_GET['end_time'] != '' )
        {
            $end_time = $_GET['end_time'];
            $sWhere['CustomerBusinesses.end_time <='] = $end_time;
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['CustomerBusinesses.modified >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['CustomerBusinesses.modified <='] = $end_modified;
        }



        $this->paginate = [
            'contain' => ['Users' => function($q){
                return $q->select(['Users.username']);
            }],
            'order' => ['CustomerBusinesses.modified Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $customerBusinesses = $this->paginate($this->CustomerBusinesses);
        $search = 1;
        $customer = $this->CustomerBusinesses->Customers->get($this->request->query('customer_id'),['fields' => ['name', 'id']]);
        $this->set(compact('customerBusinesses','content','username','start_time','end_time','start_modified','end_modified','search','customer'));
        $this->set('_serialize', ['customerBusinesses']);
        $this->render('index');
    }
}
