<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 *
 * @method \App\Model\Entity\Task[] paginate($object = null, array $settings = [])
 */
class TasksController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $this->paginate = [
            'contain' => [],
            'conditions' => ['Tasks.user_id' => $_user['id']],
            'order' => ['Tasks.modified DESC']
        ];
        $tasks = $this->paginate($this->Tasks);
        foreach ($tasks as $task) {
            switch ($task->controller) {
                case 'Projects':
                    $query = $this->Tasks->Projects->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['Projects.title','Projects.id','Users.username','Users.id']
                    ]);
                    $task->item = $query->title;
                    $task->operator = $query->user;
                    $task->status = '待审核';
                    $data = [];
                    $data['url'] = ['controller' => 'Projects', 'action' => 'check',$task->itemid];
                    $data['label'] = '审核';
                    $task->deal = $data;
                break;

                case 'ProjectSchedules':
                    $query = $this->Tasks->ProjectSchedules->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['ProjectSchedules.title','ProjectSchedules.end_time','ProjectSchedules.id','Users.username','Users.id']
                    ]);
                    $task->item = $query->title;
                    $task->operator = $query->user;
                    $task->status = date_format($query->end_time, 'Y-m-d H:i') >= date('Y-m-d H:i') ? '进行中' : '已延期';
                    $data = [];
                    $data['url'] = ['controller' => 'ProjectSchedules', 'action' => 'view',$task->itemid];
                    $data['label'] = '查看';
                    $task->deal = $data;
                break;

                case 'CustomerBusinesses':
                    $this->loadModel('CustomerBusinesses');
                    $query = $this->CustomerBusinesses->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['CustomerBusinesses.content','CustomerBusinesses.id','Users.username','Users.id']
                    ]);
                    $task->item = $query->content;
                    $task->operator = $query->user;
                    $task->status = '进行中';
                    $data = [];
                    $data['url'] = ['controller' => 'CustomerBusinesses', 'action' => 'view',$query->id];
                    $data['label'] = '查看';
                    $task->deal = $data;
                break;

                case 'FinanceApplies':
                    $this->loadModel('Users');
                    $query = $this->Tasks->FinanceApplies->get($task->itemid,[
                        'fields' => ['FinanceApplies.amount','FinanceApplies.content','FinanceApplies.id','FinanceApplies.user_id']
                    ]);
                    $task->item = '申请原因：' . $query->content . '</br>申请金额：' . $query->amount;
                    $task->operator = $this->Users->get($query->user_id,['fields' => ['Users.id','Users.username']]);
                    $task->status = '待审核';
                    $data = [];
                    $data['url'] = ['controller' => 'Finances', 'action' => 'add',$task->id];
                    $data['label'] = '拨款';
                    $task->deal = $data;
                break;
                    
                default:
                    
                break;
            }
        }

        $modelArr = ['Projects' => '项目审核', 'ProjectSchedules' => '项目计划', 'FinanceApplies' => '经费审核', 'CustomerBusinesses' => '客户交易'];
        $this->set(compact('tasks','modelArr'));
        $this->set('_serialize', ['tasks']);
    }

    /**
     * View method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => ['Users', 'FinanceApplies', 'ProjectIssueSolutions', 'ProjectIssues', 'ProjectProgresses', 'ProjectSchedules', 'Projects']
        ]);

        $this->set('task', $task);
        $this->set('_serialize', ['task']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $task = $this->Tasks->newEntity();
        if ($this->request->is('post')) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }
        $users = $this->Tasks->Users->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $task = $this->Tasks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $task = $this->Tasks->patchEntity($task, $this->request->getData());
            if ($this->Tasks->save($task)) {
                $this->Flash->success(__('The task has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The task could not be saved. Please, try again.'));
        }
        $users = $this->Tasks->Users->find('list', ['limit' => 200]);
        $this->set(compact('task', 'users'));
        $this->set('_serialize', ['task']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Task id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $task = $this->Tasks->get($id);
        if ($this->Tasks->delete($task)) {
            $this->Flash->success(__('The task has been deleted.'));
        } else {
            $this->Flash->error(__('The task could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function remind($id = null)
    {
        $this->request->allowMethod(['post']);
        $task = $this->Tasks->get($id);
        $task->state = 0;
        $this->Tasks->save($task);

        return $this->redirect($this->referer());
    }
}
