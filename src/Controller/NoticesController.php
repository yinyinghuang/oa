<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Notices Controller
 *
 * @property \App\Model\Table\NoticesTable $Notices
 *
 * @method \App\Model\Entity\Notice[] paginate($object = null, array $settings = [])
 */
class NoticesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->loadModel('Customers');
        $this->loadModel('Projects');
        $this->loadModel('Finances');
        $this->loadModel('Dropboxes');
        $_user = $this->request->session()->read('Auth')['User'];
        $this->paginate = [
            'conditions'=>['user_id' => $_user['id']],
            'order' => ['created DESC'],
            'limit' => 10
        ];
        $notices = $this->paginate($this->Notices);
        $noticeModelArr = ['Projects' => '项目更新', 'ProjectSchedules' => '进度更新', 'Finances' => '经费入账', 'CustomerBusinesses' => '客户交易'];
        $projectStateArr = [
            'label' => ['不通过', '待审核', '进行中', '已延期', '已完成', '挂起'],
            'style' => ['alert', 'info', '', 'warning', 'success', 'secondary']
        ];
        foreach ($notices as $notice) {
            switch ($notice->controller) {
                case 'Projects':
                    $query = $this->Projects->get($notice->itemid,[
                        'contain' => ['Users'],
                        'fields' => ['Projects.title','Users.username','Users.id','Projects.state']
                    ]);
                    $notice->item = $query->title . '状态更新：' . $projectStateArr['label'][$query->state];
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
                    $notice->operator = $this->Users->get($query->user_id,['fields' => ['Users.id','Users.username']]);
                    $data = [];
                    $data['url'] = ['controller' => 'Finances', 'action' => 'index'];
                    $data['label'] = '查看';
                    $notice->deal = $data;
                break;
            }
        }

        $this->set(compact('notices', 'noticeModelArr', 'projectStateArr'));
        $this->set('_serialize', ['notices']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Notice id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $notice = $this->Notices->get($id);
        if ($this->Notices->delete($notice)) {
            $this->Flash->success(__('The notice has been deleted.'));
        } else {
            $this->Flash->error(__('The notice could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
