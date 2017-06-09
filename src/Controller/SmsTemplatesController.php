<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SmsTemplates Controller
 *
 * @property \App\Model\Table\SmsTemplatesTable $SmsTemplates
 *
 * @method \App\Model\Entity\SmsTemplate[] paginate($object = null, array $settings = [])
 */
class SmsTemplatesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {   
        $this->paginate = [
            'order' => ['modified DESC']
        ];
        $smsTemplates = $this->paginate($this->SmsTemplates);

        $this->set(compact('smsTemplates'));
        $this->set('_serialize', ['smsTemplates']);
    }

    /**
     * View method
     *
     * @param string|null $id Sms Template id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $smsTemplate = $this->SmsTemplates->get($id);

        $this->set('smsTemplate', $smsTemplate);
        $this->set('_serialize', ['smsTemplate']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $smsTemplate = $this->SmsTemplates->newEntity();
        if ($this->request->is('post')) {
            $smsTemplate = $this->SmsTemplates->patchEntity($smsTemplate, $this->request->getData());
            $smsTemplate->variables = '';

            $pattern = '/(\$\{)(\w+)(\})/';
            preg_match_all($pattern, $smsTemplate->content, $smsTemplate->variables);
            $smsTemplate->variables = $smsTemplate->variables[2];
            $smsTemplate->variables = implode(',', $smsTemplate->variables);

            if ($this->SmsTemplates->save($smsTemplate)) {
                $this->Flash->success(__('The sms template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sms template could not be saved. Please, try again.'));
        }
        $this->set(compact('smsTemplate'));
        $this->set('_serialize', ['smsTemplate']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Sms Template id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $smsTemplate = $this->SmsTemplates->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $smsTemplate = $this->SmsTemplates->patchEntity($smsTemplate, $this->request->getData());
            $smsTemplate->variables = '';

            $pattern = '/(\$\{)(\w+)(\})/';
            preg_match_all($pattern, $smsTemplate->content, $smsTemplate->variables);
            $smsTemplate->variables = $smsTemplate->variables[2];
            $smsTemplate->variables = implode(',', $smsTemplate->variables);

            if ($this->SmsTemplates->save($smsTemplate)) {
                $this->Flash->success(__('The sms template has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sms template could not be saved. Please, try again.'));
        }
        $this->set(compact('smsTemplate'));
        $this->set('_serialize', ['smsTemplate']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Sms Template id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $smsTemplate = $this->SmsTemplates->get($id);
        if ($this->SmsTemplates->delete($smsTemplate)) {
            $this->Flash->success(__('The sms template has been deleted.'));
        } else {
            $this->Flash->error(__('The sms template could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function getTemplates(){
        $templateArr = $data = [];
        
        $name = $this->request->query('query');
        $conditions = [
            'name LIKE ' => '%' . $name . '%'
        ];
        $query = $this->SmsTemplates->find('all',[
            'conditions' => $conditions,
            'fields' => ['id','name','variables','content','sign']
        ]);
        foreach ($query as $template) {
            $dataArr = [];
            $dataArr['value'] = $template->name;
            $dataArr['data'] = $template->id;
            $pattern = '/(\$\{)(\w+)(\})/';
            $replacement = '<span id="variable-$2">$1$2$3</span>';
            $dataArr['content'] = '【' . $template->sign . '】' . preg_replace($pattern, $replacement, $template->content);
            $dataArr['variables'] = explode(',', $template->variables);
            $templateArr[] = $dataArr;
        }
        $data = [
            "query" => "Unit",
            "suggestions" => $templateArr,
        ];
        $this->response->body(json_encode($data));
        return $this->response;
    }

}
