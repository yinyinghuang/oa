<?php
namespace App\Controller;

use App\Controller\AppController;

class DashboardController extends AppController
{
    public function index()
    {
        $this->loadModel('Tasks');
        $this->loadModel('Notices');
        $this->loadModel('Customers');
        $this->loadModel('Projects');
        $this->loadModel('Finances');
        $_user = $this->request->session()->read('Auth')['User'];

        $this->loadModel('UserDepartmentRoles');
        $_positions = $this->UserDepartmentRoles->find('all',[
            'conditions' => ['user_id' => $_user['id']]
        ])->combine('department_id','role_id')->toArray();

        //最近任务
        $tasks = $this->Tasks->find('all',[
        	'conditions'=>['user_id' => $_user['id'],'state in' => [0,1]],
        	'order' => ['modified DESC'],
        	'limit' => 5
        ]);
        $countTasks = $this->Tasks->find('all',['conditions'=>['user_id' => $_user['id']]])->count();
        $taskModelArr = ['Projects' => '项目审核', 'ProjectSchedules' => '项目计划', 'FinanceApplies' => '经费审核', 'CustomerBusinesses' => '客户交易'];
        foreach ($tasks as $task) {
            switch ($task->controller) {
                case 'Projects':
                    $query = $this->Tasks->Projects->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['Projects.title','Projects.id','Users.username','Users.id']
                    ]);
                    $task->item = $query->title;
                    $task->operator = $query->user;
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
                    $task->item = '申请原因：' . $query->content . ',申请金额：' . $query->amount;
                    $task->operator = $this->Users->get($query->user_id,['fields' => ['Users.id','Users.username']]);
                    $data = [];
                    $data['url'] = ['controller' => 'Finances', 'action' => 'add',$task->id];
                    $data['label'] = '拨款';
                    $task->deal = $data;
                break;
            }
        }
        //最新消息
        $notices = $this->Notices->find('all',[
        	'conditions'=>['user_id' => $_user['id'], 'state' => 0],
        	'order' => ['created DESC'],
        	'limit' => 5
        ]);
        $noticeModelArr = ['Projects' => '项目更新', 'ProjectSchedules' => '进度更新', 'Finances' => '经费入账', 'CustomerBusinesses' => '客户交易'];
        $projectStateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起', '重启'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        foreach ($notices as $notice) {
            switch ($notice->controller) {
                case 'Projects':
                    $query = $this->Projects->get($notice->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['Projects.title','Users.username','Users.id','Projects.state']
                    ]);
                    $notice->item = $query->title . '状态更新：' . $projectStateArr['label'][$notice->remark];
                    $notice->operator = $query->user;
                    $data = [];
                    $data['url'] = ['controller' => 'Projects', 'action' => 'view',$notice->itemid];
                    $data['label'] = '查看';
                    $notice->deal = $data;
                break;

                case 'ProjectSchedules':
                    $query = $this->Projects->ProjectSchedules->get($notice->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['ProjectSchedules.title','ProjectSchedules.progress','ProjectSchedules.project_id','Users.username','Users.id']
                    ]);
                    $notice->item = $query->title . '进度更新：' . $query->progress . '%';
                    $notice->operator = $query->user;
                    $data = [];
                    $data['url'] = ['controller' => 'Projects', 'action' => 'view',$query->project_id];
                    $data['label'] = '查看';
                    $notice->deal = $data;
                break;

                case 'CustomerBusinesses':
                    $this->loadModel('CustomerBusinesses');
                    $query = $this->CustomerBusinesses->get($notice->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['CustomerBusinesses.content','CustomerBusinesses.id','Users.username','Users.id']
                    ]);
                    $notice->item = $query->content;
                    $notice->operator = $query->user;
                    $data = [];
                    $data['url'] = ['controller' => 'CustomerBusinesses', 'action' => 'view',$query->id];
                    $data['label'] = '查看';
                    $notice->deal = $data;
                break;

                case 'Finances':
                    $this->loadModel('Users');
                    $query = $this->Finances->get($notice->itemid,[
                        'fields' => ['Finances.amount','Finances.payee_id']
                    ]);
                    $notice->item = '入账金额：' . $query->amount . '，目前账户余额为' . $query->finance_balance['balance'] . '元';
                    $notice->operator = $this->Users->get($query->payee_id,['fields' => ['Users.id','Users.username']]);
                    $data = [];
                    $data['url'] = ['controller' => 'Finances', 'action' => 'index'];
                    $data['label'] = '查看';
                    $notice->deal = $data;
                break;
            }
        }
        $countNotices = $this->Notices->find('all',['conditions'=>['user_id' => $_user['id']]])->count();
        //参与项目
        $conditions = null;

        if (!in_array(3, $_positions) && !in_array(4, $_positions)) {//若职位中无总监或者老板
            foreach ($_positions as $department => $role) {
                //发起人
                if ($role == 2) {//职位为主管，则项目发起人为部门下属或自己
                    $query = $this->UserDepartmentRoles->Departments->get($department);
                    //获取当前部门及子部门下的员工数组
                    $departmentsArr = $this->UserDepartmentRoles->Departments->find()
                        ->where(['lft >= ' => $query->lft, 'lft <= ' => $query->rght])
                        ->extract('id')
                        ->toArray();
                    $usersArr = $this->UserDepartmentRoles->find()
                        ->where(['department_id in ' => $departmentsArr, 'role_id <= ' => 2])
                        ->extract('user_id')
                        ->toArray();
                }else {//职位为职员，项目发起人为自己
                    $usersArr = [$_user['id']];
                }
                $where = 'Projects.user_id in (' . implode(',', $usersArr) . ')';
                //或参与人为自己
                $where .= ' OR Projects.participantIds LIKE "%,' . $_user['id'] . ',%"';
                $or[] = $where;
            }
            $conditions['OR'] = $or;
        }
        $conditions['Projects.state'] = 2;
        $query = $this->Projects->ProjectSchedules->find('all',[
        	'contain' => ['Projects' => function($q){
        		return $q->contain(['Users'])->select(['Projects.title','Projects.id','Projects.participants','Projects.end_time','Projects.modified','Projects.state','Projects.progress','Users.id','Users.username']);
        	}],
        	'conditions' => $conditions,
        	'group' => ['Projects.id'],
        	'order' => ['Projects.modified DESC']
        ]);
        $projectSchedules = $query->limit(5);
        $countProjects = $query->count();

        //最新财务

        $query = $this->Finances->find('all',[
        	'contain' => ['Users', 'FinanceTypes'],
            'conditions' => ['OR' => [['alia is null'],['alia is not null','user_id' => $_user['id']]]],
            'order' => ['Finances.id DESC']
        ]);        
        $finances = $query->limit(5);
        $countFinances = $query->count();

        $this->set(compact('tasks', 'taskModelArr', 'countTasks', 'notices', 'noticeModelArr', 'countNotices', 'projectSchedules', 'countProjects', 'projectStateArr', 'finances', 'countFinances'));
    }

    public function getTask()
    {
        // $this->request->allowMethod(['post']);
        // $start = date('Y-m-d h:i:s', ($_GET['start'] / 1000));
        // $end = date('Y-m-d h:i:s', ($_GET['start'] / 1000));
        $this->loadModel('Tasks');
        $this->loadModel('Customers');
        $this->loadModel('Projects');
        $this->loadModel('Finances');
        $this->loadModel('Notes');
        $_user = $this->request->session()->read('Auth')['User'];

        $this->loadModel('UserDepartmentRoles');
        $_positions = $this->UserDepartmentRoles->find('all',[
            'conditions' => ['user_id' => $_user['id']]
        ])->combine('department_id','role_id')->toArray();

        //最近任务
        $tasks = $this->Tasks->find('all',[
            'conditions'=>['user_id' => $_user['id'],'state in' => [0,1]],
            'order' => ['modified DESC'],
            'limit' => 5
        ]);
        $countTasks = $this->Tasks->find('all',['conditions'=>['user_id' => $_user['id']]])->count();
        $taskModelArr = ['Projects' => '项目审核', 'ProjectSchedules' => '项目计划', 'FinanceApplies' => '经费审核', 'CustomerBusinesses' => '客户交易'];
        $respArr = [];
        foreach ($tasks as $task) {
            switch ($task->controller) {
                case 'Projects':
                    $query = $this->Tasks->Projects->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['Projects.title','Projects.id','Projects.start_time','Projects.end_time','Users.username','Users.id']
                    ]);
                    $resp = [];
                    $resp['id'] = $task->id;
                    $resp['title'] = $query->title;
                    $resp['url'] = '/projects/check/'. $task->itemid;
                    $resp['class'] = 'event-warning';
                    $resp['start'] = $query->start_time->toUnixString() . '000';
                    $resp['end'] = $query->end_time->toUnixString() . '000';
                    $respArr['result'][] = $resp;
                break;

                case 'ProjectSchedules':
                    $query = $this->Tasks->ProjectSchedules->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['ProjectSchedules.title','ProjectSchedules.start_time','ProjectSchedules.end_time','ProjectSchedules.id','Users.username','Users.id']
                    ]);

                    $resp = [];
                    $resp['id'] = $task->id;
                    $resp['title'] = $query->title;
                    $resp['url'] = 'project-schedules/view/' . $task->itemid;
                    $resp['class'] = 'event-success';
                    $resp['start'] = $query->start_time->toUnixString() . '000';
                    $resp['end'] = $query->end_time->toUnixString() . '000';
                    $respArr['result'][] = $resp;
                break;

                case 'CustomerBusinesses':
                    $this->loadModel('CustomerBusinesses');
                    $query = $this->CustomerBusinesses->get($task->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['CustomerBusinesses.content','CustomerBusinesses.customer_id','CustomerBusinesses.start_time','CustomerBusinesses.end_time','Users.username','Users.id']
                    ]);

                    $resp = [];
                    $resp['id'] = $task->id;
                    $resp['title'] = $query->content;
                    $resp['url'] = '/customers/view/' . $query->customer_id;
                    $resp['class'] = 'event-special';
                    $resp['start'] = $query->start_time->toUnixString() . '000';
                    $resp['end'] = $query->end_time->toUnixString() . '000';
                    $respArr['result'][] = $resp;
                break;

                case 'FinanceApplies':
                    $this->loadModel('Users');
                    $query = $this->Tasks->FinanceApplies->get($task->itemid,[
                        'fields' => ['FinanceApplies.amount','FinanceApplies.content','FinanceApplies.id','FinanceApplies.user_id']
                    ]);

                    $resp = [];
                    $resp['id'] = $task->id;
                    $resp['title'] = '申请原因：' . $query->content . '，申请金额：' . $query->amount;
                    $resp['url'] = '/finances/add/' . $task->id;
                    $resp['class'] = 'event-important';
                    $resp['start'] = time() . '000';
                    $resp['end'] = time() . '000';
                    $respArr['result'][] = $resp;
                break;

                case 'Notes':
                    $this->loadModel('Users');
                    $query = $this->Notes->get($task->itemid,[
                        'fields' => ['Notes.name','Notes.start_time','Notes.end_time']
                    ]);

                    $resp = [];
                    $resp['id'] = $task->id;
                    $resp['title'] = $query->name;
                    $resp['url'] = '/note/view/' . $query->id;
                    $resp['class'] = 'event-info';
                    $resp['start'] =$query->start_time->toUnixString() . '000';
                    $resp['end'] = $query->end_time->toUnixString() . '000';
                    $respArr['result'][] = $resp;
                break;
            }
        }
        $respArr['success'] = 1;
        $this->response->body(json_encode($respArr));
        return $this->response;
    }
}