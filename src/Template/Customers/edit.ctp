<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('删除'),
                ['action' => 'delete', $customer->id],
                ['confirm' => __('Are you sure you want to delete {0}?', $customer->name)]
            )
        ?></li>
        <li><?= $this->Html->link(__('客户列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customers form large-10 medium-9 columns content">
    <?= $this->Form->create($customer) ?>
    <fieldset>
        <legend><?= __('编辑客户') ?></legend>
        <?php
            echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => $this->request->session()->read('Auth')['User']['id']]);
            echo $this->Form->control('customer_category_id', ['type' => 'hidden', 'id' => 'parent-id']);

            echo '<div class="input select required"><label for="parent">客户分类</label>';
            foreach ($customerCategories as $value) {
                echo $this->Form->select('customer_category', $value->options , ['empty' => '请选择', 'class' => 'parent_id','default' => $value->id]);
            }
            echo'</div>';
            echo $this->Form->control('name',['label' => '姓名']);
            echo $this->Form->control('company',['label' => '公司']);
            echo $this->Form->control('country_code',['label' => '国际区号']);
            echo $this->Form->control('mobile',['label' => '电话']);
            echo $this->Form->control('email',['label' => '电邮']);
            echo $this->Form->control('position',['label' => '职位']);
            echo '<div id="opiton-fields">';

            foreach ($customer->customer_category_options as $value) {
                if($value->extra_value_id) echo '<input type="hidden" name="value_' . $value->extra_value_id . '_id" value="' . $value->extra_value_id . '">';
                switch ($value['type']) {
                    case 'text':
                    case 'textarea':
                        echo $this->Form->control('value_' . $value->id, [
                            'type' => $value['type'],
                            'value' => $value['extra_value'] ? $value['extra_value'] : $value['value'],
                            'required' => $value['required'],
                            'label' => $value['name']
                        ]);
                        break;
                    case 'select':
                        $options = explode('|', $value['value']);
                        $required = $value['required'] ? ' required' : '';
                        echo '<div class="input select' . $required . '"><label for="value-' . $value->id . '">' . $value['name'] . '</label><select id="value-' . $value->id . '" name="value_' . $value->id . '"' . $required . '><option value="">请选择</option>';
                        foreach ($options as $option) {
                            echo '<option value="' . $option . '"';
                            if($value['extra_value'] == $option) echo ' selected';
                            echo '>' . $option . '</option>';
                        }
                        echo '</select></div>';
                        break;
                    case 'checkbox':
                        $options = explode('|', $value['value']);
                        $values = explode('|', $value['extra_value']);
                        $required = $value['required'] ? ' required' : '';
                        echo '<div class="input' . $required . ' check" data-id="' . $value->id . '"><label class="checkbox_label">' . $value['name'] . '</label>';
                        foreach ($options as $option) {
                            echo '<label><input type="checkbox" name="value_' . $value->id . '[]"';
                            if(in_array($option, $values)) echo ' checked';
                            echo ' value=' . $option . '>' . $option . '</label>';
                        }
                        echo '</div>';
                        break;
                }
            }
            echo '</div>';
        ?>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary','pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change', function(){
            if(confirm('修改分类将删除客户在当前分类下的专属字段，是否确定删除？')){
                loadCatogeries(this);
            }
        }); 
        $('#submit').on('click',function(){
            var checkboxs = $('.check.required');
               
            if (checkboxs.length > 0) {
                var flag = true;                
                checkboxs.each(function(){
                    var id = $(this).data('id'),
                        input = $('input[name="value_' + id + '[]"]:checked');
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
                                    html += '<div class="input ' + required + '"><label>' + value.name + '</label>';
                                    content.forEach(function(v){
                                        html += '<label for="option-' + value.id + '"><input type="checkbox" name="option_' + value.id + '[]" id=option-"' + value.id + '"' + required + ' value="' + v + '"/>' + v + '</label>';
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