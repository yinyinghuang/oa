<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectSchedules Controller
 *
 * @property \App\Model\Table\ProjectSchedulesTable $ProjectSchedules
 *
 * @method \App\Model\Entity\ProjectSchedule[] paginate($object = null, array $settings = [])
 */
class ProjectSchedulesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($project_id = 0)
    {
        $exisit = $this->ProjectSchedules->Projects->find('all',['conditions' => ['id' => $project_id]])->count();
        if (!$exisit) {
            $this->Flash->error(__('项目不存在'));
            $this->redirect($this->referer());
        }
        $this->paginate = [
            'contain' => ['Users'],
            'conditions' => ['project_id' => $project_id],
            'limit' => 10
        ];
        $projectSchedules = $this->paginate($this->ProjectSchedules);
        $project = $this->ProjectSchedules->Projects->get($project_id);
        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];

        $this->set(compact('projectSchedules', 'project','stateArr'));
        $this->set('_serialize', ['projectSchedules']);
    }

    public function mySchedules($reset = null)
    {
        $_user = $this->request->session()->read('Auth')['User'];

        $this->paginate = [
            'contain' => ['Projects'],
            'conditions' => ['ProjectSchedules.user_id' => $_user['id'], 'Projects.state >=' => 2],
            'limit' => 10,
            'order' => ['ProjectSchedules.modified DESC']
        ];
        $projectSchedules = $this->paginate($this->ProjectSchedules);

        $search = $reset ? 1 : 0;
        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];

        $this->set(compact('projectSchedules', 'stateArr','search'));
        $this->set('_serialize', ['projectSchedules']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Schedule id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $projectSchedule = $this->ProjectSchedules->get($id, [
            'contain' => ['Projects', 'Users', 'ProjectIssues', 'ProjectProgresses' => function($q){
                return $q->order(['ProjectProgresses.created DESC']);
            }]
        ]);
        if ($projectSchedule->state == 2 && $projectSchedule->user_id == $_user['id'] && $projectSchedule->task_id) {//若计划状态为进行中，且查看人为负责人
            //标记任务为已读
            $task = $this->ProjectSchedules->Tasks->get($projectSchedule->task_id);
            $task->state = 1;
            $this->Tasks->save($task);
            
        }

        foreach ($projectSchedule->project_progresses as $progress) {
            if ($progress->attachment != '') {
                $ext = explode('.', $progress->attachment);
                switch ($ext[count($ext)-1]) {
                    case 'png':
                    case 'gif':
                    case 'jpg':
                        $icon = 'image';
                    break;
                    case 'xls':
                    case 'xlsx':
                        $icon = 'file-excel-o';
                    break;
                    case 'doc':
                    case 'docx':
                        $icon = 'file-word-o';
                    break;
                    case 'pdf':
                        $icon = 'file-pdf-o';
                    break;
                    case 'ppt':
                        $icon = 'file-powerpoint-o';
                    break;
                    case 'zip':
                        $icon = 'file-zip-o';
                    break;
                    case 'txt':
                        $icon = 'file-text-o';
                    break;
                }

                $filename = explode('/', $progress->attachment);
                $progress->attachment = '<a href="/' . $progress->attachment . '"><i class="fa fa-' . $icon .'"></i>下载</a>';
            }
        }        

        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        $this->set(compact('projectSchedule', 'stateArr'));
        $this->set('_serialize', ['projectSchedule']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($project_id = 0)
    {
        if (!$project_id == 0) {
            $exisit = $this->ProjectSchedules->Projects->find('all',['conditions' => ['id' => $project_id]])->count();
            if (!$exisit) {
                $this->Flash->error(__('项目不存在'));
                $this->redirect($this->referer());
            }
            $projectSchedule = $this->ProjectSchedules->newEntity();
            if ($this->request->is('post')) {
                $projectSchedule = $this->ProjectSchedules->patchEntity($projectSchedule, $this->request->getData());
                if ($this->ProjectSchedules->save($projectSchedule)) {
                    $this->Flash->success(__('The project schedule has been saved.'));

                    return $this->redirect(['action' => 'index', $projectSchedule->project_id]);
                }
                $this->Flash->error(__('The project schedule could not be saved. Please, try again.'));
            }
            $project = $this->ProjectSchedules->Projects->get($project_id);
            $this->set(compact('projectSchedule', 'project'));
            $this->set('_serialize', ['projectSchedule']);
        } else {
            $this->Flash->error(__('项目不存在'));
            $this->redirect($this->referer());
        }
        
    }

    /**
     * Edit method
     *
     * @param string|null $id Project Schedule id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $projectSchedule = $this->ProjectSchedules->get($id, [
            'contain' => ['Projects','Users']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $projectSchedule = $this->ProjectSchedules->patchEntity($projectSchedule, $this->request->getData());
            if ($this->ProjectSchedules->save($projectSchedule)) {
                $this->Flash->success(__('The project schedule has been saved.'));

                return $this->redirect(['action' => 'index', $projectSchedule->project_id]);
            }
            $this->Flash->error(__('The project schedule could not be saved. Please, try again.'));
        }
        $projectSchedule->start_time = date_format($projectSchedule->start_time, 'Y-m-d H:i');
        $projectSchedule->end_time = date_format($projectSchedule->end_time, 'Y-m-d H:i');
        $this->set(compact('projectSchedule'));
        $this->set('_serialize', ['projectSchedule']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Project Schedule id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectSchedule = $this->ProjectSchedules->get($id);
        if ($this->ProjectSchedules->delete($projectSchedule)) {
            $this->Flash->success(__('The project schedule has been deleted.'));
        } else {
            $this->Flash->error(__('The project schedule could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search() 
    {
        $_user = $this->request->session()->read('Auth')['User'];
        $sWhere = null;
        $sWhere['ProjectSchedules.user_id'] = $_user['id'];

        if ( isset($_GET['projectTitle']) && $_GET['projectTitle'] != '' )
        {   
            $projectTitle = $_GET['projectTitle'];
            $sWhere['Projects.title LIKE'] = "%".$projectTitle."%";
        }
        if ( isset($_GET['state']) && $_GET['state'] != -1 )
        {   
            $state = $_GET['state'];
            $sWhere['ProjectSchedules.state ='] = $state;
        }
        if ( isset($_GET['scheduleTitle']) && $_GET['scheduleTitle'] != '' )
        {   
            $scheduleTitle = $_GET['scheduleTitle'];
            $sWhere['ProjectSchedules.title LIKE'] = "%".$scheduleTitle."%";
        }
        if ( isset($_GET['start_time']) && $_GET['start_time'] != '' )
        {
            $start_time = $_GET['start_time'];
            $sWhere['ProjectSchedules.start_time >='] = $start_time;
        }
        if ( isset($_GET['end_time']) && $_GET['end_time'] != '' )
        {
            $end_time = $_GET['end_time'];
            $sWhere['ProjectSchedules.end_time <='] = $end_time;
        }
        if ( isset($_GET['start_modified']) && $_GET['start_modified'] != '' )
        {
            $start_modified = $_GET['start_modified'];
            $sWhere['ProjectSchedules.modified >='] = $start_modified;
        }
        if ( isset($_GET['end_modified']) && $_GET['end_modified'] != '' )
        {
            $end_modified = $_GET['end_modified'];
            $sWhere['ProjectSchedules.modified <='] = $end_modified;
        }



        $this->paginate = [
            'contain' => ['Projects'],
            'order' => ['ProjectSchedules.modified Desc'],
            'limit' => '10',
            'conditions' => $sWhere
        ];
        $projectSchedules = $this->paginate($this->ProjectSchedules);
        $search = 1;
        $stateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        $this->set(compact('projectSchedules','scheduleTitle','projectTitle','state','start_time','end_time','start_modified','end_modified','search','stateArr'));
        $this->set('_serialize', ['projectSchedules']);
        $this->render('my_schedules');
    }
}
