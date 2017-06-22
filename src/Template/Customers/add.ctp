<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('客户列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customers form large-10 medium-9 columns content">
    <?= $this->Form->create($customer) ?>
    <fieldset>
        <legend><?= __('新增客户') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('customer_category_id', ['type' => 'hidden', 'id' => 'parent-id']);
            echo $this->Form->control('customer_category', ['options' => $customerCategories, 'empty' => '请选择', 'class' => 'parent_id', 'required' => true, 'label' => '客户分类']);
            echo $this->Form->control('name',['label' => '姓名']);
            echo $this->Form->control('company',['label' => '公司']);
            echo $this->Form->control('country_code',['label' => '国际区号','maxlength' => 5,'type' => 'text']);
            echo $this->Form->control('mobile',['label' => '电话']);
            echo $this->Form->control('email',['label' => '电邮']);
            echo $this->Form->control('position',['label' => '职位']);
        ?>
        <div id="opiton-fields"></div>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary','pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change', function(){
            loadCatogeries(this);
        });
        $('#submit').on('click',function(){
            var checkboxs = $('.check.required');
               
            if (checkboxs.length > 0) {
                var flag = true;                
                checkboxs.each(function(){
                    var id = $(this).data('id'),
                        input = $('input[name="option_' + id + '[]"]:checked');
                    if(input.length == 0) {
                        var checkbox_label = $(this).children('.checkbox_label')[0];
                        flag = false;
                        new PNotify({
                            title: '錯誤',
                            text: checkbox_label.innerHTML + '中至少选中一项',
                            type: 'error',
                            styling: 'bootstrap3',
                            delay: 3000,
                            width:'280px'
                        });
                    }
                });
                return flag;
            } 
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
                    parent_id : node.value,
                    option : 1
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
                    if (data.options.length != 0) {
                        var html = '';
                        data.options.forEach(function(value,index){
                            var required = value.required ? ' required' : '';
                            switch (value.type){
                                case 'text':
                                    html += '<div class="input text' + required + '"><label for="option-' + value.id + '">' + value.name + '</label><input type="text" name="option_' + value.id + '" id=option-"' + value.id + '"' + required + ' value="' + value.value + '"/></div>';
                                    break;
                                case 'textarea':
                                    html += '<div class="input textarea' + required + '"><label for="option-' + value.id + '">' + value.name + '</label><textarea rows= "5"name="option_' + value.id + '" id=option-"' + value.id + '"' + required + '/>' + value.value + '</textarea></div>';
                                    break;
                                case 'select':
                                    var content = value.value.split('|');
                                    html += '<div class="input select' + required + '"><label for="option-' + value.id + '">' + value.name + '</label><select name="option_' + value.id + '" id=option-' + value.id + '"' + required + '><option value="">请选择</option>';
                                    content.forEach(function(v){
                                        html += '<option value="' + v + '">' + v + '</option>';
                                    });
                                    html += '</select></div>';
                                    break;
                                case 'checkbox':
                                    var content = value.value.split('|');
                                    html += '<div class="input ' + required + ' check" data-id="' + value.id + '"><label class="checkbox_label">' + value.name + '</label>';
                                    content.forEach(function(v){
                                        html += '<label for="option-' + value.id + '"><input type="checkbox" name="option_' + value.id + '[]" id=option-"' + value.id + '" value="' + v + '"/>' + v + '</label>';
                                    });
                                    html += '</div>';
                                    break;
                            }
                        });
                        $('#opiton-fields').html(html);
                    }
                }
            });
        }
    }
</script>
<?= $this->end() ?>