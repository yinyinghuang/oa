<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * CustomerCategories Controller
 *
 * @property \App\Model\Table\CustomerCategoriesTable $CustomerCategories
 *
 * @method \App\Model\Entity\CustomerCategory[] paginate($object = null, array $settings = [])
 */
class CustomerCategoriesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index($parent_id = 0)
    {
        $this->paginate = [
            'contain' => ['ChildCustomerCategories' => function($q){
                return $q->select(['ChildCustomerCategories.parent_id']);
            }],
            'conditions' => ['CustomerCategories.parent_id' => $parent_id]
        ];
        $customerCategories = $this->paginate($this->CustomerCategories);
        foreach ($customerCategories as $category) {
            $category->childCount = $this->CustomerCategories->childCount($category);
        }

        $crumbs = null;
        if ($parent_id != 0) {
            $crumbs = $this->CustomerCategories->find('path', ['for' => $parent_id]);
            $uplevel = $this->CustomerCategories->get($parent_id);
        }

        $this->set(compact('customerCategories', 'crumbs', 'uplevel'));
        $this->set('_serialize', ['customerCategories']);
    }

    /**
     * View method
     *
     * @param string|null $id Customer Category id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customerCategory = $this->CustomerCategories->get($id, [
            'contain' => ['ParentCustomerCategories', 'Customers', 'CustomerCategoryOptions']
        ]);
        $typeArr = ['text' => '单行文本', 'textarea' => '多行文本', 'select' => '下拉列表', 'checkbox' => '复选框'];
        $this->set(compact('customerCategory', 'typeArr'));
        $this->set('_serialize', ['customerCategory']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($parent_id = null)
    {
        $customerCategory = $this->CustomerCategories->newEntity();
        if ($this->request->is('post')) {
            if ($this->request->getData('parent_id') != '') {
                $count = $this->CustomerCategories->find('all',['conditions' =>['id' => $this->request->getData('parent_id')]])->count();
                if ($count === 0) {
                    $this->Flash->error(__('上级分类不存在'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            $customerCategory = $this->CustomerCategories->patchEntity($customerCategory, $this->request->getData());
            if ($this->CustomerCategories->save($customerCategory)) {

                for ($i=1; $i <= $this->request->getData('num') ; $i++) { 
                    $option = $this->CustomerCategories->CustomerCategoryOptions->newEntity();
                    $option->customer_category_id = $customerCategory->id;
                    $option->name = $this->request->getData('name_' . $i);
                    $option->type = $this->request->getData('type_' . $i);
                    $option->value = $this->request->getData('value_' . $i);
                    $option->required = $this->request->getData('required_' . $i);
                    $this->CustomerCategories->CustomerCategoryOptions->save($option);
                }
                $this->example($customerCategory->id);
                $this->Flash->success(__('The customer category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer category could not be saved. Please, try again.'));
        }
        $parentCustomerCategories = $this->CustomerCategories->ParentCustomerCategories->find('list', [
            'conditions' => ['parent_id' => $parent_id],
            'limit' => 200
        ]);
        $this->set(compact('customerCategory', 'parent_id','parentCustomerCategories'));
        $this->set('_serialize', ['customerCategory']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customerCategory = $this->CustomerCategories->get($id, [
            'contain' => ['CustomerCategoryOptions']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('parent_id') != null) {
                $parent = $this->CustomerCategories->get($this->request->getData('parent_id'));
                if ($parent->lft > $customerCategory->lft && $parent->lft < $customerCategory->rght) {
                    $this->Flash->error(__('不可选择下级分类作为上级分类'));

                    return $this->redirect(['action' => 'edit', $id]);
                }
            }
            $customerCategory = $this->CustomerCategories->patchEntity($customerCategory, $this->request->getData());
            if ($this->CustomerCategories->save($customerCategory)) {

                for ($i=1; $i <= $this->request->getData('num') ; $i++) {
                    if (!isset($_POST['name_' . $i])) continue;
                    $option = $this->CustomerCategories->CustomerCategoryOptions->newEntity();
                    if ($this->request->getData('option_id_' . $i) != '') {
                        $option->id = $this->request->getData('option_id_' . $i);
                    }
                    $option->customer_category_id = $customerCategory->id;
                    $option->name = $this->request->getData('name_' . $i);
                    $option->type = $this->request->getData('type_' . $i);
                    $option->value = $this->request->getData('value_' . $i);
                    $option->required = $this->request->getData('required_' . $i);
                    $this->CustomerCategories->CustomerCategoryOptions->save($option);
                }
                $this->example($id);
                $this->Flash->success(__('The customer category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer category could not be saved. Please, try again.'));
        }

        $results = $this->CustomerCategories->find('path', ['for' => $id]);
        $parentCustomerCategories = [];

        foreach ($results as $value) {         
            if ($value->id != $id) {
                $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $value->options = $arr; 
                $parentCustomerCategories[] = $value;
            }            
        }

        if ($parentCustomerCategories == []) {
            $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
            $arr = array();
            foreach ($list as $k => $v) {
                $arr[$k] = $v;
            }
            $options = new \StdClass();
            $options->id = 0;
            $options->options = $arr; 
            $parentCustomerCategories[] = $options;
        }
        $typeArr = ['text' => '单行文本', 'textarea' => '多行文本', 'select' => '下拉列表', 'checkbox' => '复选框'];
        $this->set(compact('customerCategory', 'parentCustomerCategories', 'typeArr'));
        $this->set('_serialize', ['customerCategory']);
    }

    public function sms($id = 0,$sms_template_id = 0)
    {   
        $_user = $this->request->session()->read('Auth')['User'];
        if ($this->request->is('post')) {
            if($this->request->getData('customer_category_id') == '') {
                $this->Flash(__('请选择客户类型'));
                $this->redirect($this->referer());
            }
            if($this->request->getData('sms_template_id') == '') {
                $this->Flash(__('请选择短信模板'));
                $this->redirect($this->referer());
            }

            $this->loadModel('SmsTemplates');
            $this->loadModel('SmsDetails');
            $cate_id = $this->request->getData('customer_category_id');
            $template = $this->SmsTemplates->get($this->request->getData('sms_template_id'));
            $template->variables = explode(',', $template->variables);
            foreach ($template->variables as $variable) {
                $value = $this->request->getData($variable);
                $param[$variable] = $value;
                $template->content = str_replace('${' . $variable . '}', $value, $template->content);

            }            
            $detail = $this->SmsDetails->newEntity([
                'sms_template_id' => $this->request->getData('sms_template_id'),
                'variables' => implode(',', $param),
                'user_id' => $_user['id'],
                'content' => $template->content,
                'customer_category_id' => $cate_id
            ]);
            $param = json_encode($param);
            $this->SmsDetails->save($detail);

            $query = $this->CustomerCategories->get($cate_id);
            $childrenArr = $this->CustomerCategories->find('all')
                ->where(['lft >= ' => $query->lft, 'lft <= ' => $query->rght])
                ->extract('id')
                ->toArray();
            $conditions['customer_category_id in '] = $childrenArr;
            $query = $this->CustomerCategories->Customers->find('all',[
                'fields' => ['mobile','id'],
                'conditions' => $conditions
            ]);
            foreach ($query as $customer) {//$sign, $param, $mobile, $templateid
                $resp = $this->sendSms($template->sign, $param, $customer->mobile, $template->templateid);
                
                if (isset($resp->result->success)) {
                    $result = 'ok';
                } else {
                    $result = $resp->sub_msg;
                }
                // $result = 'no';
                $record = $this->SmsDetails->SmsRecords->newEntity([
                    'sms_detail_id' => $detail->id,
                    'customer_id' => $customer->id,
                    'result' => $result
                ]);
                $this->SmsDetails->SmsRecords->save($record);
            }

            $s = $this->SmsDetails->SmsRecords->find('all')->where(['sms_detail_id' => $detail->id,'result' => 'ok'])->count();
            $f = $this->SmsDetails->SmsRecords->find('all')->where(['sms_detail_id' => $detail->id,'result != ' => 'ok'])->count();
            $detail->success = $s;
            $detail->fail = $f;
            $detail->total = $f + $s;

            $this->SmsDetails->save($detail);
            $this->Flash->success(__('成功' . $s .'条，失败' . $f .'条。'));
            $this->redirect(['controller' => 'SmsDetails', 'action' => 'view', $detail->id]);
            
        }
        $smsTemplate = null;
        if ($id != 0) {
            $results = $this->CustomerCategories->find('path', ['for' => $id]);
            $customerCategories = [];

            foreach ($results as $value) {         
                $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => $value->parent_id]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $value->options = $arr; 
                $customerCategories[] = $value;
                           
            }

            if ($customerCategories == []) {
                $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
                $arr = array();
                foreach ($list as $k => $v) {
                    $arr[$k] = $v;
                }
                $options = new \StdClass();
                $options->id = 0;
                $options->options = $arr; 
                $customerCategories[] = $options;
            }
        }else {
            $list = $this->CustomerCategories->find('list', ['conditions' => ['parent_id' => 0]]);
            $arr = array();
            foreach ($list as $k => $v) {
                $arr[$k] = $v;
            }
            $options = new \StdClass();
            $options->id = 0;
            $options->options = $arr; 
            $customerCategories[] = $options;
        }
        if ($sms_template_id != 0) {
            $this->loadModel('SmsTemplates');
            $smsTemplate = $this->SmsTemplates->get($sms_template_id);
            $pattern = '/(\$\{)(\w+)(\})/';
            $replacement = '<span id="variable-$2">$1$2$3</span>';
            $smsTemplate->text = '【' . $smsTemplate->sign . '】' . $smsTemplate->content;
            $smsTemplate->content = '【' . $smsTemplate->sign . '】' . preg_replace($pattern, $replacement, $smsTemplate->content);
            $smsTemplate->variables = explode(',', $smsTemplate->variables);
            $smsTemplate->count = mb_strlen($smsTemplate->text);
        }

        $this->set(compact('customerCategories', 'id', 'sms_template_id','smsTemplate'));
    }

    public function resend($id = 0)
    {
        $this->loadModel('SmsDetails');
        // $records = $this->SmsDetails->SmsRecords->find(['all',
        //     'contain' => ['Customers','SmsTemplates'],
        //     'conditions' => ['sms_detail_id' => $id, 'result != ' => 'ok']
        // ]);

        $records = $this->SmsDetails->SmsRecords
            ->find('all')
            ->contain(['Customers','SmsDetails' => function($q){
                return $q->contain('SmsTemplates');
            }])
            ->where(['sms_detail_id' => $id, 'result != ' => 'ok']);

        foreach ($records as $record) {
            if (!isset($param)) {
                $keyArr = explode(',', $record->sms_detail->sms_template->variables);
                $valueArr = explode(',', $record->sms_detail->variables);
                foreach ($keyArr as $i => $key) {            
                    $param[$key] = $valueArr[$i];
                } 
                $param = json_encode($param);
            }

            $resp = $this->sendSms($record->sms_detail->sms_template->sign, $param, $record->customer->mobile, $record->sms_detail->sms_template->templateid);
            
            if (isset($resp->result->success)) {
                $result = 'ok';
            } else {
                $result = $resp->sub_msg;
            }

            // $result = 'no';
            $record->result = $result;
            $this->SmsDetails->SmsRecords->save($record);
        }

        $s = $this->SmsDetails->SmsRecords->find('all')->where(['sms_detail_id' => $id,'result' => 'ok'])->count();
        $f = $this->SmsDetails->SmsRecords->find('all')->where(['sms_detail_id' => $id,'result != ' => 'ok'])->count();
        $detail = $this->SmsDetails->newEntity([
            'id' => $id,
            'success' => $s,
            'fail' => $f
        ]);

        $this->SmsDetails->save($detail);
        $this->Flash->success(__('成功' . $s .'条，失败' . $f .'条。'));
        $this->redirect(['controller' => 'SmsDetails', 'action' => 'view', $id]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customerCategory = $this->CustomerCategories->get($id,[
            'contain' => ['Customers', 'ChildCustomerCategories']
        ]);
        if ($customerCategory->child_customer_categories || $customerCategory->customers) {
            $this->Flash->error(__('当前分类下存在子分类或者客户，请清空子分类及客户后再操作.'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->CustomerCategories->delete($customerCategory)) {
            $filename = WWW_ROOT . 'files' . DS . 'customer_excels' . DS . 'import_customers_' . $id . '.xls';
            if(file_exists($filename)) unlink($filename);
            $this->Flash->success(__('The customer category has been deleted.'));
        } else {
            $this->Flash->error(__('The customer category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index', $customerCategory->parent_id]);
    }

    public function deleteOption()
    {
        $this->request->allowMethod(['post']);
        $this->loadModel('CustomerCategoryOptions');
        $data = null;
        $id = $this->request->getData('id');

        if ($this->request->getData('confirm') == '1') {
            $option = $this->CustomerCategoryOptions->get($id); 
            $this->CustomerCategoryOptions->delete($option);
            $this->example($option->customer_category_id);
            $data = ['result' => 1];
        }else {
            $option = $this->CustomerCategoryOptions->get($id,[
                'contain' => ['CustomerCategoryValues']
            ]);
            if ($option->customer_category_values) {
                $data = ['ask' => 1];
            } else {
                $this->CustomerCategoryOptions->delete($option);
                $this->example($option->customer_category_id);
                $data = ['result' => 1];
            }
        }
        $this->response->body(json_encode($data));       

        return $this->response;
    }

    public function loadChilds()
    {
        $data = array();
        if ($this->request->query('parent_id') !== '') {
            $data['child'] = $this->CustomerCategories->ParentCustomerCategories->find('list', ['limit' => 200])->where(['parent_id' => $this->request->query('parent_id')]);
            
            if (isset($_POST['option']) && $_POST['option'] == 1) {
                $data['options'] = $this->CustomerCategories->CustomerCategoryOptions->find('all')->where(['customer_category_id' => $this->request->query('parent_id')]);
            }            
        }

        $this->response->body(json_encode($data));
        return $this->response;
    }
    protected function example($id = null)
    {   
        $filename = WWW_ROOT . 'files' . DS . 'customer_excels' . DS . 'import_customers_' . $id . '.xls';
        if (file_exists($filename)) {
            unlink($filename);
        }
        $customerCategory = $this->CustomerCategories->get($id,[
            'contain' => ['CustomerCategoryOptions' => function($q){
                return $q->find('all', ['order' => ['id' => 'ASC']]);
            }]
        ]);
        if($customerCategory){
            require_once(ROOT . DS  . 'vendor' . DS  . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel.php');
            require_once(ROOT . DS  . 'vendor' . DS  . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel' . DS . 'IOFactory.php');
            $objExcel = new \PHPExcel(); 
            
            //设置表头
            $objExcel->getActiveSheet()->setCellValue('A1', "姓名*");  
            $objExcel->getActiveSheet()->setCellValue('B1', "公司");  
            $objExcel->getActiveSheet()->setCellValue('C1', "国家区号*");  
            $objExcel->getActiveSheet()->setCellValue('D1', "手机号码*");  
            $objExcel->getActiveSheet()->setCellValue('E1', "邮件*");  
            $objExcel->getActiveSheet()->setCellValue('F1', "职位");  

            $start = 71;

            foreach ($customerCategory->customer_category_options as $value) {
                $alph = chr($start);
                $objExcel->getActiveSheet()->setCellValue($alph . '1', $value->required ? $value->name . '*' : $value->name); 
                $start ++ ;
            }

            $objExcel->getActiveSheet()->setTitle('import_customers_' . $id);
            $objExcel->setActiveSheetIndex(0);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
            $objWriter->save($filename);
        }
    }

    function sendSms($sign, $param, $mobile, $templateid){
        include_once(ROOT . DS  . 'vendor' . DS  . 'dy-sdk' . DS . 'TopSdk.php'); 
          
        include_once(ROOT . DS  . 'vendor' . DS  . 'dy-sdk' . DS . 'top' . DS . 'TopClient.php'); 
        include_once(ROOT . DS  . 'vendor' . DS  . 'dy-sdk' . DS . 'top' . DS . 'ResultSet.php');
        include_once(ROOT . DS  . 'vendor' . DS  . 'dy-sdk' . DS . 'top' . DS . 'RequestCheckUtil.php'); 
        include_once(ROOT . DS  . 'vendor' . DS  . 'dy-sdk' . DS . 'top' . DS . 'TopLogger.php');  
        include_once(ROOT . DS  . 'vendor' . DS  . 'dy-sdk' . DS . 'top' . DS . 'request' . DS . 'AlibabaAliqinFcSmsNumSendRequest.php');
        $c = new \TopClient;
        $c->appkey ="23875573";  
        $c->secretKey = "5182755796db38b5fc861e73f6cd730f"; 
        $req = new \AlibabaAliqinFcSmsNumSendRequest;
        $req->setSmsType("normal");
        $req ->setSmsFreeSignName($sign);
        $req ->setSmsParam($param);
        $req ->setRecNum($mobile);
        $req ->setSmsTemplateCode($templateid);
        $resp = $c->execute($req); 
        return json_decode(json_encode($resp));
    }
    
}
