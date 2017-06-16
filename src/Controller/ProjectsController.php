<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 *
 * @method \App\Model\Entity\Project[] paginate($object = null, array $settings = [])
 */
class ProjectsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($state = -1, $reset = null)
    {
        $_user = $this->request->session()->read('Auth')['User'];

        $conditions = null;
        $this->loadModel('UserDepartmentRoles');
        $_positions = $this->UserDepartmentRoles->find('all',[
            'conditions' => ['user_id' => $_user['id']]
        ])->combine('department_id','role_id')->toArray();

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
                $where .= ' OR Projects.participantIds LIKE "%,' . $_user['id'] . ',%" OR  Projects.whitelist LIKE "%,' . $_user['id'] . ',%"';
                $or[] = $where;
            }
            $conditions['OR'] = $or;
        }
        if ($state != -1)  $conditions['Projects.state'] = $state;
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => $conditions,
            'order' => ['Projects.modified DESC']
        ];
        $projects = $this->paginate($this->Projects);


        //更新通知中的项目审核结果，将此前项目审核结果消息标记为已读
        $this->loadModel('Notices');
        $where = ['user_id' => $_user['id'], 'controller' => 'Projects', 'state' => 0];
        $state == -1 ? '' : ($where['remark'] = $state == 2 ? 'in (2,6)' : $state);
        $this->Notices->query()
            ->update()
            ->set(['state' => 1])
            ->where($where)
            ->execute();
        $search = $reset ? 1 : 0;
        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        $this->set(compact('projects','stateArr','state', 'search'));
        $this->set('_serialize', ['projects']);
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Users', 'ProjectSchedules' => function($q){
                return $q->limit(5)->contain(['Users']);
            }]
        ]);
        if ($project->attachment != '') {
            $ext = explode('.', $project->attachment);
        
            $filename = explode('/', $project->attachment);
            $project->attachment = '<a href="/' . $project->attachment . '">' . $filename[count($filename)-1] . '</a>';
            
        }
        $project->auditorInput = $this->Projects->Users->get($project->auditor)->username;
        $project->whitelist = $project->whitelist ? explode(',', $project->whitelist) : [];
        $project->whitelistArr = [];
        foreach ($project->whitelist as $list) {
            $project->whitelistArr[$list] = $this->Projects->Users->get($list);
        }

        // $countSchedules = $this->Projects->ProjectSchedules->find('all')->where(['project_id' => $id])->count();
        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        $this->set(compact('project', 'stateArr','countSchedules'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $project = $this->Projects->newEntity();
        if ($this->request->is('post')) {
            $data = [
                'title' => $this->request->getData('title'),
                'user_id' => $this->request->getData('user_id'),
                'auditor' => $this->request->getData('auditor'),
                'brief' => $this->request->getData('brief'),
                'attachment' => $this->request->getData('attachment'),
                'state' => 1,
                'start_time' => $this->request->getData('start_time') . ' 00:00:00',
                'end_time' => $this->request->getData('end_time') . ' 23:59:59',
            ];
            for ($i=1; $i <= $this->request->getData('num') ; $i++) {
                $schedules['title'] = $this->request->getData('title_' . $i);
                $schedules['brief'] = $this->request->getData('brief_' . $i);
                $schedules['user_id'] = $this->request->getData('participant_id_' . $i);
                $schedules['state'] = 1;
                $schedules['start_time'] = $this->request->getData('start_time_' . $i) . ' 00:00:00';
                $schedules['end_time'] = $this->request->getData('end_time_' . $i) . ' 23:59:59';
                $data['project_schedules'][] = $schedules;
                $participants[$this->request->getData('participant_' . $i)] = 1;
                $participantIds[$this->request->getData('participant_id_' . $i)] = 1;
            }

            $data['participants'] = implode(',', array_keys($participants));
            $data['participantIds'] = ',' . implode(',', array_keys($participantIds)) . ',';
            $project = $this->Projects->patchEntity($project, $data, ['associated' => 'ProjectSchedules']);

            if ($this->Projects->save($project)) {
                $task = $this->Projects->Tasks->newEntity([
                    'user_id' => $project->auditor,
                    'controller' => 'Projects',
                    'itemid' => $project->id,
                    'state' => 0
                ]);
                $this->Projects->Tasks->save($task);
                $project->task_id = $task->id;
                $this->Projects->save($project);
                $this->Flash->success(__('The project has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {

        $project = $this->Projects->get($id, [
            'contain' => ['ProjectSchedules' => function($q){
                return $q->contain(['Users']);
            }]
        ]);
        $auditor = $project->auditor;
        $_user = $this->request->session()->read('Auth')['User'];
        if (!($project->user_id == $_user['id'] || $auditor == $_user['id'])) {
            $this->Flash->error(__('无权编辑此项目'));
            $this->redirect($this->referer());
        }
        if ($project->state != 1) {
            $this->Flash->error(__('当前项目审核已完成，项目内容及计划无法改动'));
            $this->redirect($this->referer());
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = [
                'id' => $id,
                'title' => $this->request->getData('title'),
                'brief' => $this->request->getData('brief'),
                'auditor' => $this->request->getData('auditor'),
                'attachment' => $this->request->getData('attachment'),
                'state' => 1,
                'start_time' => $this->request->getData('start_time') . ' 00:00:00',
                'end_time' => $this->request->getData('end_time') . ' 23:59:59',
            ];
            for ($i=1; $i <= $this->request->getData('num') ; $i++) {
                if (!isset($_POST['title_' . $i])) continue;
                $schedules['id'] = $this->request->getData('schedule_id_' . $i);
                $schedules['title'] = $this->request->getData('title_' . $i);
                $schedules['brief'] = $this->request->getData('brief_' . $i);
                $schedules['user_id'] = $this->request->getData('participant_id_' . $i);
                $schedules['state'] = 1;
                $schedules['start_time'] = $this->request->getData('start_time_' . $i) . ' 00:00:00';
                $schedules['end_time'] = $this->request->getData('end_time_' . $i) . ' 23:59:59';
                $data['project_schedules'][] = $schedules;
                $participants[$this->request->getData('participant_' . $i)] = 1;
                $participantIds[$this->request->getData('participant_id_' . $i)] = 1;
            }
            $data['participants'] = implode(',', array_keys($participants));
            $data['participantIds'] = implode(',', array_keys($participantIds));
            $project = $this->Projects->patchEntity($project, $data, ['associated' => 'ProjectSchedules']);

            if ($this->Projects->save($project)) {
                
                if ($auditor != $project->auditor) {//如果审核人有变动，刷新任务列表
                    $this->Projects->Tasks->query()
                        ->update()
                        ->set(['user_id' => $project->auditor])
                        ->where(['id' => $project->task_id])
                        ->execute();
                }
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $project->auditorInput = $this->Projects->Users->get($auditor)->username;
        $project->start_time = date_format($project->start_time, 'Y-m-d H:i');
        $project->end_time = date_format($project->end_time, 'Y-m-d H:i');

        foreach ($project->project_schedules as $schedule) {
            $schedule->start_time = date_format($schedule->start_time, 'Y-m-d H:i');
            $schedule->end_time = date_format($schedule->end_time, 'Y-m-d H:i');
        }
        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    public function whitelist($id = null){
        $_user = $this->request->session()->read('Auth')['User'];
        $project = $this->Projects->get($id);
        if ($project->auditor == $_user['id'] || $project->user_id == $_user['id'] || in_array($_user['id'], [3, 4])) {
            if($this->request->is(['post'])) {
                $whitelist = $project->whitelist ? explode(',', $project->whitelist) : [];
                $whitelist[] = $this->request->getData('view');
                $whitelist = array_unique($whitelist);
                $project->whitelist = implode(',', $whitelist);
                $this->Projects->save($project);
                $this->Flash->success(__('添加成功'));
                $this->redirect(['controller' => 'Projects', 'action' => 'view', $project->id]);
            }
        } else{
            $this->Flash->error(__('无权操作此项目可见人'));
            $this->redirect($this->referer());
        }
        $this->set(compact('project'));
    }

    public function deleteWhitelist($id = null, $user_id = null){
        $_user = $this->request->session()->read('Auth')['User'];
        $project = $this->Projects->get($id);
        if ($project->auditor == $_user['id'] || $project->user_id == $_user['id'] || in_array($_user['id'], [3, 4])) {
             $this->request->allowMethod(['post', 'delete']);
             $whitelist = explode(',', $project->whitelist);
             $key = array_search($user_id, $whitelist);
             if ($key !== false) array_splice($whitelist, $key, 1);
             $project->whitelist = $whitelist ? implode(',', $whitelist) : '';
             $this->Projects->save($project);
             $this->Flash->success(__('操作成功'));
             $this->redirect(['controller' => 'Projects', 'action' => 'view', $project->id]);
        } else{
            $this->Flash->error(__('无权操作此项目可见人'));
            $this->redirect($this->referer());
        }
    }

    public function check($id = null)
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $project = $this->Projects->get($id, [
            'contain' => ['Users', 'ProjectSchedules' => function($q){
                return $q->contain(['Users']);
            }]
        ]);
        if ($project->auditor != $_user['id']) {
            $this->Flash->error(__('无权审核此项目'));
            $this->redirect($this->referer()); 
        }
        if ($project->state != 1) {
            $this->Flash->error(__('当前项目审核已完成，请勿重复操作'));
            $this->redirect($this->referer());
        }
        $task_id = $project->task_id;
        if ($this->request->is(['post'])) {
            $project->state = $this->request->getData('state');
            $project->task_id = null;
            if ($this->Projects->save($project)) {

                // 项目审核完成后，删除在任务中的记录。通知项目负责人审核结果
                $task = $this->Projects->Tasks->get($task_id);
                $this->Projects->Tasks->delete($task);
                $this->loadModel('Notices');
                $entity = [
                    'controller' => 'Projects',
                    'itemid' => $project->id,
                    'user_id' => $project->user_id,
                    'remark' => $project->state,
                    'state' => 0
                ];
                $notice = $this->Notices->newEntity($entity);
                $this->Notices->save($notice);
                //项目状态日志
                $query = $this->Projects->ProjectLogs->newEntity([
                    'project_id' => $project->id,
                    'state' => $project->state,
                    'reason' => $this->request->getData('reason')
                ]);
                $this->Projects->ProjectLogs->save($query);
                //更新项目计划状态                
                $query = $this->Projects->ProjectSchedules->query();
                $query->update()
                    ->set(['state' => $project->state])
                    ->where(['project_id' => $project->id])
                    ->execute();               

                //若审核通过，则为参与人添加项目计划任务
                if($project->state == 2){
                    foreach ($project->project_schedules as $schedule) {
                        $entity = [
                            'controller' => 'ProjectSchedules',
                            'itemid' => $schedule->id,
                            'user_id' => $schedule->user_id,
                            'state' => 0
                        ];
                        $task = $this->Projects->Tasks->newEntity($entity);
                        $this->Projects->Tasks->save($task);
                        $schedule->task_id = $task->id;
                        $this->Projects->ProjectSchedules->save($schedule);
                    }
                }

                $this->Flash->success(__('项目审核完成.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('项目未审核成功，请重试.'));
        }

        if ($project->task_id) {
            //标记任务为已读
            $task = $this->Projects->Tasks->get($project->task_id);
            $task->state = 1;
            $this->Tasks->save($task);
        }
       

        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        $this->set(compact('project', 'stateArr'));
        $this->set('_serialize', ['project']);
    }

    public function hangup($id = null)
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $project = $this->Projects->get($id, [
            'contain' => ['ProjectSchedules']
        ]);
        if (!($project->user_id == $_user['id'] || $project->auditor == $_user['id'])) {
            $this->Flash->error(__('无权挂起此项目'));
            $this->redirect($this->referer()); 
        }
        if ($this->request->is(['post'])) {
            $project->state = 5;
            if ($this->Projects->save($project)) {
                //项目状态日志插入
                $query = $this->Projects->ProjectLogs->newEntity([
                    'project_id' => $project->id,
                    'state' => 5,
                    'reason' => $this->request->getData('reason')
                ]);
                $this->Projects->ProjectLogs->save($query);

                // 通知参与人项目状态 
                $entities = $participants = $taskIds = [];
                foreach ($project->project_schedules as $value) {
                    $participants[] = $value->user_id;
                    $taskIds[] =  $value->task_id;
                }
                $participants[] = $project->user_id;
                $participants[] = $project->auditor;
                $participants = array_unique($participants);
                
                foreach ($participants as $value) {
                    $entities[] =[
                        'controller' => 'Projects',
                        'itemid' => $project->id,
                        'user_id' => $value,
                        'remark' => $project->state,
                        'state' => 0
                    ];
                }
                $notice = $this->Notices->newEntities($entities);
                $this->Notices->saveMany($notice);

                //更新项目计划任务、项目计划的状态为挂起   
                if ($taskIds) {
                    $this->Tasks->query() 
                    ->update()
                    ->set(['state' => 5])
                    ->where(['id in ' => $taskIds])
                    ->execute();
                }                    
                $this->Projects->ProjectSchedules->query() 
                    ->update()
                    ->set(['state' => 5])
                    ->where(['project_id' => $project->id])
                    ->execute();

                $this->Flash->success(__('项目挂起完成.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('项目未审核成功，请重试.'));
        }

        $this->set(compact('project'));
        $this->set('_serialize', ['project']);
    }

    public function continued($id = null)
    {
        $this->request->allowMethod(['post']);
        $_user = $this->request->session()->read('Auth')['User'];
        $project = $this->Projects->get($id, [
            'contain' => ['ProjectSchedules']
        ]);
        if (!($project->user_id == $_user['id'] || $project->auditor == $_user['id'])) {
            $this->Flash->error(__('无权重启此项目'));
            $this->redirect($this->referer()); 
        }
        $this->request->allowMethod(['post']);
        $project->state = 2;

        //更新项目的结束时间
        $end_time = date_format($project->end_time, 'Ymd');

        $hangup_time = $this->Projects->ProjectLogs->find()
            ->where(['project_id' => $id])
            ->order(['created DESC'])
            ->first()->created;
        $hangup_time = date_format($hangup_time, 'Ymd');
        $now = date('Ymd', time())-1;

        $this->loadModel('Holidays');
        $this->loadModel('Configs');
        $weekdays = $this->Configs->findByName('weekdays')->first()->content;
        $weekdays = explode(',', $weekdays);
        $holidays = $this->Holidays->find()//结束日期后的假期
            ->where(['type' => 0, 'end_date >= ' => $end_time]);
        $workdays = $this->Holidays->find()//结束日期后的补假
            ->where(['type' => 1, 'end_date >= ' => $end_time]);

        $hangupSpan = $this->getSpan($hangup_time, $now);//挂起的时间
        print_r($hangupSpan);
        //项目计划中的结束时间，若结束时间晚于挂起时间，则需更新
        foreach ($project->project_schedules as $value) {
            $participants[] = $value->user_id;
            $taskIds[] =  $value->task_id;
            if($value->end_time >= $hangup_time) {
                $value->end_time = date_format($value->end_time, 'Ymd');
                $updateScheduleArr[] = $value;
            }
        }
        for ($i=0; $i < $hangupSpan; $i++) { 
            $end_time ++;
            while(!$this->getDateType($end_time, $weekdays, $holidays, $workdays)) {//后一天是假期，则继续顺延
                $end_time ++;
            }//后一天上班，则进入下一个循环
            foreach ($updateScheduleArr as $value) {
                $value->end_time ++;
                while (!$this->getDateType($value->end_time, $weekdays, $holidays, $workdays)) {
                    $value->end_time ++ ;
                }
            }
        }
        foreach ($updateScheduleArr as $value) {
            $split = str_split($value->end_time);
            $value->end_time = $split[0] . $split[1]. $split[2]. $split[3]. '-' . $split[4]. $split[5]. '-' . $split[6]. $split[7] . ' 23:59:59';
        }

        $split = str_split($end_time);
        $project->end_time = $split[0] . $split[1]. $split[2]. $split[3]. '-' . $split[4]. $split[5]. '-' . $split[6]. $split[7] . ' 23:59:59';
        
        if ($this->Projects->save($project)) {
            //项目状态日志插入
            $query = $this->Projects->ProjectLogs->newEntity([
                'project_id' => $project->id,
                'state' => 2
            ]);
            $this->Projects->ProjectLogs->save($query);

            // 通知项目参与人项目状态更新
            $entities = $participants = $taskIds = [];
            
            $participants[] = $project->user_id;
            $participants[] = $project->auditor;
            $participants = array_unique($participants);
            
            foreach ($participants as $value) {
                $entities[] =[
                    'controller' => 'Projects',
                    'itemid' => $project->id,
                    'user_id' => $value,
                    'remark' => 2,
                    'state' => 0
                ];
            }

           
            $notice = $this->Notices->newEntities($entities);
            $this->Notices->saveMany($notice);

            //更新项目计划任务、项目计划的状态为进行中   
            $this->Projects->ProjectSchedules->saveMany($updateScheduleArr);
            if ($taskIds) {
                $this->Tasks->query() 
                ->update()
                ->set(['state' => 0])
                ->where(['id in ' => $taskIds])
                ->execute();
            }                    
            $this->Projects->ProjectSchedules->query() 
                ->update()
                ->set(['state' => 2])
                ->where(['project_id' => $project->id])
                ->execute();        

            $this->Flash->success(__('项目重启完成.'));

            return $this->redirect(['action' => 'view', $project->id]);
        }
        $this->Flash->error(__('项目未重启成功，请重试.'));

    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() 
    {
        $sWhere = null;

        if ( isset($_GET['title']) && $_GET['title'] != '' )
        {   
            $title = $_GET['title'];
            $sWhere['Projects.title LIKE'] = "%".$title."%";
        }
        $state = -1;
        if ( isset($_GET['state']) && $_GET['state'] != -1 )
        {   
            $state = $_GET['state'];
            $sWhere['Projects.state ='] = $state;
        }
        if ( isset($_GET['username']) && $_GET['username'] != '' )
        {   
            $username = $_GET['username'];
            $sWhere['Users.username LIKE'] = "%".$username."%";
        }
        if ( isset($_GET['start_time']) && $_GET['start_time'] != '' )
        {
            $start_time = $_GET['start_time'];
            $sWhere['Projects.start_time >='] = $start_time;
        }
        if ( isset($_GET['end_time']) && $_GET['end_time'] != '' )
        {
            $end_time = $_GET['end_time'];
            $sWhere['Projects.end_time <='] = $end_time;
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['Projects.modified >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['Projects.modified <='] = $end_modified;
        }



        $this->paginate = [
            'contain' => ['Users' => function($q){
                return $q->select(['Users.username']);
            }],
            'order' => ['Projects.modified Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $projects = $this->paginate($this->Projects);
        $search = 1;
        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        $this->set(compact('projects','title','state','username','start_time','end_time','start_modified','end_modified','search','stateArr'));
        $this->set('_serialize', ['projects']);
        $this->render('index');
    }

    public function getUsers(){
        $userArr = $data = [];
        
        $username = $this->request->query('query');
        $conditions = [
            'Users.username LIKE ' => '%' . $username . '%'
        ];
        

        $this->loadModel('UserDepartmentRoles');
        if (isset($_GET['type']) && $_GET['type'] == 'auditor') {//若请求为获取审核人
            //获取发起人的部门列表
            $_user = $this->request->session()->read('Auth')['User'];
            $_positions = $this->UserDepartmentRoles->find('all',[
                'conditions' => ['user_id' => $_user['id']],
                'fields' => ['department_id','role_id']
            ]);

            $or = [];
            foreach ($_positions as $position) {           
                if ($position['role_id'] == 1) {//职位为职员，每个部门的上级
                    $or[] = 'UserDepartmentRoles.department_id = ' . $position['department_id'] . ' AND UserDepartmentRoles.role_id = 2';
                }else {//职位为主管级以上，选择总监或者老板
                    $or[] = 'UserDepartmentRoles.role_id >' . $position['role_id'];
                }                
            }
            $conditions['UserDepartmentRoles.user_id != '] = $_user['id'];
            $conditions['or'] = $or;            
        }

        $query = $this->UserDepartmentRoles->find('all',[
            'contain' => ['Users'],
            'conditions' => $conditions,
            'fields' => ['Users.id','Users.username'],
            'group' => ['Users.id']
        ]);
        foreach ($query as $position) {
            $dataArr = [];
            $dataArr['value'] = $position->Users['username'];
            $dataArr['data'] = $position->Users['id'];
            $userArr[] = $dataArr;
        }
        $data = [
            "query" => "Unit",
            "suggestions" => $userArr,
        ];
        $this->response->body(json_encode($data));
        return $this->response;

    }
    public function deleteSchedule()
    {
        $this->request->allowMethod(['post']);
        $data = null;
        $id = $this->request->getData('id');
        
        $schedule = $this->Projects->ProjectSchedules->get($id); 
        $this->Projects->ProjectSchedules->delete($schedule);
        $data = 1;
        $this->response->body($data);       

        return $this->response;
    }

    private function getDateType($date, $weekdays, $holidays, $workdays){
        
        $w = date('N',strtotime($date));
        if (in_array($w, $weekdays)) {//是周内。
            $flag = 1; 
            foreach ($holidays as $holiday) {
                if($date >= $holiday->start_date && $date <= $holiday->end_date) {//法定节假日
                    $flag = 0;
                    continue;
                }
            }
        } else {//周末
            $flag = 0;
            foreach ($holidays as $holiday) {
                if($date >= $holiday->start_date && $date <= $holiday->end_date) {//补假
                    $flag = 1;
                    continue;
                }
            }
        }
        return $flag;
    }

    private function getSpan($start_time, $end_time){

        $span = 0;

        $this->loadModel('Holidays');
        $this->loadModel('Configs');
        $weekdays = $this->Configs->findByName('weekdays')->first()->content;
        $weekdays = explode(',', $weekdays);
        $holidays = $this->Holidays->find()
            ->where(['type' => 0, 'OR' => ['start_date <= ' => $start_time, 'end_date >= ' => $end_time]]);
        $workdays = $this->Holidays->find()
            ->where(['type' => 1, 'OR' => ['start_date <= ' => $start_time, 'end_date >= ' => $start_time]]);

        while ($start_time <= $end_time) {
            $dateType = $this->getDateType($start_time, $weekdays, $holidays, $workdays);
            $span += $dateType;

            $start_time ++ ;
        }
        return $span;
    }
}
