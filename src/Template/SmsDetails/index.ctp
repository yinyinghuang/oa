<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('发送短信'), ['controller' => 'CustomerCategories', 'action' => 'sms']) ?></li>
        <li><?= $this->Html->link(__('短信模板'), ['controller' => 'SmsTemplates', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('客户分类列表'), ['controller' => 'CustomerCategories', 'action' => 'index']) ?></li>
    </ul>
</nav>
<div class="smsDetails index large-10 medium-9 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('发送记录') ?></h3>
        <i class="fa fa-search pull-right" id="show-search"></i>
    </div>
    <div class="search_box" <?php if ($search==1): ?>style="display:block"<?php endif ?>>
        <form action="<?= $this->Url->build(['action' => 'search'])?>" role="form">
        <input type="hidden" name="customer_category_id" id="parent-id" value='<?= $customer_category_id?>'>
        <div class="row form-group">
            <label class="col-md-2 col-xs-4">短信内容</label>
            <div class="col-md-3 col-xs-8">
                <input type="text" name="content" value="<?= h(isset($content) ? $content : '') ?>" class="form-control">
            </div>
            <label class="col-md-2 col-xs-4">发送人</label>
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
            <label class="col-md-2 col-xs-12">发送日期</label>
            <div class="col-md-6 col-xs-12">
                <div class="input-group">
                    <input type="text" name="start_modified" value="<?= h(isset($start_modified) ? $start_modified : '') ?>" class="form-control datetimepicker" readonly="readonly">
                    <span class="input-group-addon">至</span>
                    <input type="text" name="end_modified" value="<?= h(isset($end_modified) ? $end_modified : '') ?>" class="form-control datetimepicker" readonly="readonly">
                </div>
            </div>           
        </div>
        <div class="row form-group">
            
            <div class="col-md-2">
                <button class="btn btn-primary">搜索</button>
            </div>
            <div class="col-md-2">
                <a class="btn btn-default" href="<?= $this->Url->build(['action' => 'index',1]) ?>">重置</a>
            </div>
        </div>
        </form>
    </div>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" width="40"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('content',['内容']) ?></th>
                <th scope="col" class="visible-lg" width="40"><?= $this->Paginator->sort('fail',['失败']) ?></th>
                <th scope="col" width="40"><?= $this->Paginator->sort('total',['总共']) ?></th>
                <th scope="col" class="visible-lg" width="120"><?= $this->Paginator->sort('created',['发送时间']) ?></th>
                <th scope="col" class="actions" width="80"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($smsDetails as $smsDetail): ?>
            <tr>
                <td><?= $this->Number->format($smsDetail->id) ?></td>
                <td style="width: 50%"><?= h($smsDetail->content) ?></td>
                <td class="visible-lg"><?= $this->Number->format($smsDetail->fail) ?></td>
                <td style="width: 10%"><?= $this->Number->format($smsDetail->total) ?></td>
                <td class="visible-lg"><?= h($smsDetail->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $smsDetail->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $smsDetail->id], ['confirm' => __('Are you sure you want to delete # {0}?', $smsDetail->id)]) ?>
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
                type : 'get',
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
                        html.on('change', loadCatogeries);
                        $(that).after(html);                            
                    }
                }
            });
        }
    }
</script>
<?= $this->end() ?>