<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ProjectProgresses Controller
 *
 * @property \App\Model\Table\ProjectProgressesTable $ProjectProgresses
 *
 * @method \App\Model\Entity\ProjectProgress[] paginate($object = null, array $settings = [])
 */
class ProjectProgressesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ProjectSchedules']
        ];
        $projectProgresses = $this->paginate($this->ProjectProgresses);

        $this->set(compact('projectProgresses'));
        $this->set('_serialize', ['projectProgresses']);
    }

    /**
     * View method
     *
     * @param string|null $id Project Progress id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $projectProgress = $this->ProjectProgresses->get($id, [
            'contain' => ['ProjectSchedules']
        ]);

        $this->set('projectProgress', $projectProgress);
        $this->set('_serialize', ['projectProgress']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($project_schedule_id = null)
    {
        $projectProgress = $this->ProjectProgresses->newEntity();

        if ($this->request->is('post')) {
            $projectProgress = $this->ProjectProgresses->patchEntity($projectProgress, $this->request->getData());

            if ($this->ProjectProgresses->save($projectProgress)) {
                //更新计划进度
                $set['progress'] = $projectProgress->progress;
                if ($projectProgress->progress == 100){//若计划进度为100%，更新计划状态为完成4，并删除任务列表中的记录
                    $set['state'] = 4;
                    $set['task_id'] = null;
                    $this->loadModel('Tasks');
                    $task = $this->Tasks->find()->where(['controller' => 'ProjectSchedules', 'itemid' => $projectProgress->project_schedule_id])->first();
                    $this->Tasks->delete($task);
                }
                $query = $this->ProjectProgresses->ProjectSchedules->query();
                $query->update()
                    ->set($set)
                    ->where(['id' => $projectProgress->project_schedule_id])
                    ->execute();
                
                // 更新项目进度
                $this->loadModel('Projects');
                $project_id = $this->ProjectProgresses->ProjectSchedules->get($projectProgress->project_schedule_id)->project_id;
                $progress = $this->ProjectProgresses->ProjectSchedules->find()
                    ->where(['project_id' => $project_id])
                    ->select(['progress' => 'SUM(progress)/COUNT(id)','user_id'])
                    ->first()->progress;

                $project = $this->Projects->get($project_id);
                $project->progress = $progress;

                $paticipiants = $this->ProjectProgresses->ProjectSchedules->find()
                    ->where(['project_id' => $project_id])
                    ->group('user_id')
                    ->extract('user_id')
                    ->toArray();
                $paticipiants = array_merge($paticipiants, [$project->user_id, 1]);
                $this->loadModel('Notices');
                if ($progress == 100) {//若项目进度为100%，更新项目状态为完成4，并在给项目负责人，参与人，审核人通知项目已完成
                    $project->state = 4;                    
                    foreach ($paticipiants as $key => $paticipiant) {
                        $entities[$key]['controller'] = 'Projects';
                        $entities[$key]['itemid'] = $project_id;
                        $entities[$key]['user_id'] = $paticipiant;
                        $entities[$key]['state'] = 0;
                        $entities[$key]['remark'] = 4;
                    }
                } else {//项目进度不是100%，通知项目负责人，审核人，其他参与人项目进度
                    foreach ($paticipiants as $key => $paticipiant) {
                        if ($paticipiant != $projectProgress->user_id) {
                            $entities[$key]['controller'] = 'ProjectSchedules';
                            $entities[$key]['itemid'] = $projectProgress->project_schedule_id;
                            $entities[$key]['user_id'] = $paticipiant;
                            $entities[$key]['state'] = 0;
                        }                        
                    }
                }
                $notices = $this->Notices->newEntities($entities);
                $this->Notices->saveMany($notices);

                $this->Projects->save($project);               

                $this->Flash->success(__('The project progress has been saved.'));

                return $this->redirect(['controller' => 'ProjectSchedules','action' => 'view',$projectProgress->project_schedule_id]);
            }
            $this->Flash->error(__('The project progress could not be saved. Please, try again.'));
        }
        $projectSchedule = $this->ProjectProgresses->ProjectSchedules->get($project_schedule_id);
        
        $this->set(compact('projectProgress', 'project_schedule_id','projectSchedule'));
        $this->set('_serialize', ['projectProgress']);
    }


    /**
     * Delete method
     *
     * @param string|null $id Project Progress id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $projectProgress = $this->ProjectProgresses->get($id);
        if ($this->ProjectProgresses->delete($projectProgress)) {
            $this->Flash->success(__('The project progress has been deleted.'));
        } else {
            $this->Flash->error(__('The project progress could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
