<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('新增客户'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('导入客户'), ['action' => 'import']) ?></li>
    </ul>
</nav>
<div class="customers index large-10 medium-9 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('客戶') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <input type="hidden" name="customer_category_id" id="parent-id" value='<?= $customer_category_id?>'>
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">客戶名稱</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="name" value="<?= h(isset($name) ? $name : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">业务员</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="username" value="<?= h(isset($username) ? $username : '') ?>" class="form-control">
            </div>
        </div>
        <div class="row form-group">            
            <label class="col-md-2 col-xs-4">客户分类</label>
            <div class="col-md-3 col-xs-8">
                <?php foreach ($customerCategories as $category): ?>
                <select class="form-control parent_id">
                    <option value="">請選擇</option>
                    <?php foreach ($category->options as $key => $value): ?>
                        <option value="<?= $key ?>" <?php if ($category->id == $key): ?>selected<?php endif ?>><?= $value ?></option>
                    <?php endforeach ?>
                </select>
                <?php endforeach ?>
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">電話</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="mobile" value="<?= h(isset($mobile) ? $mobile : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">電郵</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="email" value="<?= h(isset($email) ? $email : '') ?>" class="form-control">
            </div>
        </div>
        <div class="row form-group">
            <label class="col-md-2 col-xs-12">更新日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_modified" value="<?= h(isset($start_modified) ? $start_modified : '') ?>" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_modified" value="<?= h(isset($end_modified) ? $end_modified : '') ?>" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div>           
        </div>
        <?php if (isset($extraSearch)): ?>
            <?php foreach ($extraSearch as $key => $value): ?>
                <div class="row form-group">
                    <label class="col-md-2 col-xs-4"><?= $value['name'] ?></label>
                    <div class="col-md-3 col-xs-8">
                        <?php 
                            switch ($value['control']) {
                                case 'radio':
                                    echo $this->Form->radio($key, $value['options'], ['value' => isset($$key) ? $$key : '']);
                                break;
                                case 'select':
                                    echo $this->Form->select($key, $value['options'], ['value' => isset($$key) ? $$key : '', 'empty' => '请选择']);
                                break;
                                default:
                                    echo $this->Form->control($key,['label' => false, 'div' => false, 'type' => $value['control'], 'value' => isset($$key) ? $$key : '']);
                                break;
                            }
                             
                        ?>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
        <div class="row form-group">
            
            <div class="col-md-2">
                <button class="btn btn-primary">搜索</button>
            </div>
            <div class="col-md-2">
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'index','reset' => 1]) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width="40"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('customer_category_id', ['分类']) ?></th>
                <th scope="col"><?= $this->Paginator->sort('name', ['姓名']) ?></th>
                <th scope="col" class="hidden-xs"><?= $this->Paginator->sort('mobile', ['手机']) ?></th>
                <th scope="col" class="hidden-xs"><?= $this->Paginator->sort('email', ['电邮']) ?></th>
                <?php if (isset($extraFonts)): ?>
                    <?php foreach ($extraFonts as $font): ?>
                    <th scope="col"><?= __($font) ?></th>   
                    <?php endforeach ?>   
                <?php endif ?>                
                <th scope="col"><?= __('备注') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= $this->Number->format($customer->id) ?></td>
                <td><?= $customer->has('customer_category') ? $this->Html->link($customer->customer_category->name, ['controller' => 'CustomerCategories', 'action' => 'view', $customer->customer_category_id]) : '' ?></td>
                <td><?= h($customer->name) ?></td>
                <td class="hidden-xs"><a href="tel:<?= '+' . $customer->country_code . '-' . $customer->mobile?>"><?= '+' . $customer->country_code . '-' . $customer->mobile?></a></td>
                <td class="hidden-xs"><?= $customer->email ?></td>
                <?php if (isset($extraFonts)): ?>
                    <?php foreach ($extraFonts as $key => $font): ?>
                    <td scope="col"><?= __($customer->customer_category_values[$key]) ?></td>   
                    <?php endforeach ?>    
                <?php endif ?>
                
                <td><?= $customer->remark ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $customer->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customer->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change',function () {
            loadCatogeries(this);
        }); 
        $('.datetimepicker').daterangepicker({
            "calender_style": "picker_3",
            "singleDatePicker": true,
            "format" : "YYYY-MM-DD",
          }, function(start, end, label) {
        });      
    });
    function loadCatogeries(node){
        var parent_id = $('#parent-id');
        if (node.value == 0 && $(node).prev('select').length > 0) {
            parent_id.val($(node).prev('select').val());
        } else {
             parent_id.val(node.value);
        }
        $(node).nextAll('select').remove();
        if(node.value !== ''){
            var that = node;
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build(['controller' => 'CustomerCategories', 'action' => 'loadChilds'])?>',
                data : {
                    parent_id : node.value
                },
                success : function(data){  
                    data = JSON.parse(data);
                    if (data.child.length != 0) { 
                        var html = '<select class="parent_id" onChange="loadCatogeries(this)"><option value="">请选择</option>';
                        for (var i in data.child) {
                            html += '<option value="' + i + '">' + data.child[i] + '</option>';
                        }
                        html += '</select>';
                        html = $(html);
                        $(that).after(html);                            
                    }
                }
            });
        }
    }
</script>
<?= $this->end() ?>