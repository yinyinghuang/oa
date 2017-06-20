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
                ['action' => 'delete', $customerCategory->id],
                ['confirm' => __('Are you sure you want to delete {0}?', $customerCategory->name)]
            )
        ?></li>
        <li><?= $this->Html->link(__('分类列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customerCategories form large-10 medium-9 columns content">
    <?= $this->Form->create($customerCategory) ?>
    <fieldset>
        <legend><?= __('编辑分类') ?></legend>
        <?php
            echo $this->Form->control('num', ['type' => 'hidden', 'value' => count($customerCategory->customer_category_options),'id' => 'num']);
            echo $this->Form->control('parent_id', ['type' => 'hidden']);
            echo $this->Form->control('name',['label' => '名称']);
            echo '<div class="input select"><label for="parent">Parent</label>';
            foreach ($parentCustomerCategories as $value) {
                echo $this->Form->select('parent', $value->options , ['empty' => '请选择', 'class' => 'parent_id','default' => $value->id]);
            }
            echo'</div>';
            foreach ($customerCategory->customer_category_options as $key => $option) {
                $k = $key + 1;
                echo '<div id="add-' . $k . '">';
                echo $this->Form->control('option_id_' . $k, ['type' => 'hidden', 'value' => $option->id, 'class' => 'option_id']);
                echo $this->Form->control('name_' . $k, ['value' => $option->name, 'label' => '字段' . $k . '名称', 'required' => true]);
                echo $this->Form->control('type_' . $k, ['options' => $typeArr, 'empty' => '请选择','value' => $option->type, 'label' => '字段类型', 'required' => true]);
                echo $this->Form->control('value_' . $k, ['value' => $option->value, 'type' => 'textarea', 'placeholder' => '单行文本、多行文本默认值；下拉列表、复选框选项值，请用英文|竖线隔开', 'label' => '字段选项']);
                echo $this->Form->control('required_' . $k, ['options' => [1 => '是', 0 => '否'],'value' => $option->required, 'type' => 'radio', 'label' => '必填', 'required' => true]);
                echo $this->Form->control('font_' . $k, ['options' => [1 => '是', 0 => '否'],'value' => $option->font, 'type' => 'radio', 'label' => '首页可见栏位', 'required' => true]);
                echo $this->Form->control('searchable_' . $k, ['options' => [1 => '是', 0 => '否'],'value' => $option->searchable, 'type' => 'radio', 'label' => '搜索栏中可见', 'required' => true]);
                echo '<a class="btn btn-danger del">删除</a>';
                echo '</div>';

            }
        ?>
        <a class="btn btn-warning" id="add">新增额外字段</a>
    </fieldset>
    <?= $this->Form->button(__('提交'),['class' => ['btn', 'btn-primary','pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change', function(){
            loadChilds(this)
        });
        var add = $('#add');
        add.on('click', function(){
            var num = $('#num'),
                i = num.val() * 1 + 1,
                html = '<div id="add-' + i + '"><input type="hidden" name="option_id_'+i+'" value="" class="option_id"><div class="input text required"><label for="name-' + i + '">字段' + i + '名称</label><input type="text" name="name_' + i + '" id="name-' + i + '" required /></div><div class="input select required"><label for="type-' + i + '">字段' + i + '类型</label><select name="type_' + i + '" id="type-' + i + '" required><option value="">请选择</option><option value="text">单行文本</option><option value="textarea">多行文本</option><option value="select">下拉列表</option><option value="checkbox">复选框</option></select></div><div class="input textarea"><label for="value-' + i + '">字段' + i + '内容</label><textarea name="value_' + i + '" id="value-' + i + '" placeholder="单行文本、多行文本默认值；下拉列表、复选框选项值，请用英文|竖线隔开" rows="5"/></div><div class="input radio required"><label>必填</label><input type="hidden" name="required_' + i + '" value=""><label for="required-' + i + '-1"><input type="radio" name="required_' + i + '" value="1" id="required-' + i + '-1" class="parent_id" required>是</label><label for="required-' + i + '-2"><input type="radio" name="required_' + i + '" value="0" id="required-' + i + '-2" class="parent_id" required>否</label></div><div class="input radio required"><label>首页可见栏位</label><input type="hidden" name="font_' + i + '" value=""><label for="font-' + i + '-1"><input type="radio" name="font_' + i + '" value="1" id="font-' + i + '-1" class="parent_id" required>是</label><label for="font-' + i + '-2"><input type="radio" name="font_' + i + '" value="0" id="font-' + i + '-2" class="parent_id" checked>否</label></div><div class="input radio required"><label>搜索框中可见</label><input type="hidden" name="searchable_' + i + '" value=""><label for="searchable-' + i + '-1"><input type="radio" name="searchable_' + i + '" value="1" id="searchable-' + i + '-1" class="parent_id" required>是</label><label for="searchable-' + i + '-2"><input type="radio" name="searchable_' + i + '" value="0" id="searchable-' + i + '-2" class="parent_id" checked>否</label></div><a class="btn btn-danger del" onClick="deleteOption(this)">删除</a></div><div class="ln_solid"></div>';
            add.before(html);      
            num.val(i);
        });
        $('.del').on('click', function(){
            deleteOption(this);
        }); 
        $('#submit').on('click', function(){
            if($('#parent-id').val() == '<?= $customerCategory->id ?>'){
                new PNotify({
                    title: '錯誤',
                    text: '上级分类不能与当前分类相同',
                    type: 'error',
                    styling: 'bootstrap3',
                    delay: 3000,
                    width:'280px'
                });
                return false;
            }
        });     
    });
    function loadChilds(node){
        $('#parent-id').val(node.value);
        $(node).nextAll('select').remove();
        if(node.value !== ''){
            var that = node;
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build(['action' => 'loadChilds'])?>',
                data : {
                    parent_id : node.value
                },
                success : function(data){      
                    data = JSON.parse(data);        
                    if (data.child.length != 0) { 
                        var html = '<select class="parent_id" onChange="loadChilds(this)"><option value="">请选择</option>';
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
    function deleteOption(node){
        var num = $('#num'),
            i = num.val() * 1,
            id = $(node).siblings('.option_id')[0].value,
            parent =  $(node).parent('div');
        if(confirm('确定要删除此字段？')){
            if (id !== '') {
                $.ajax({
                    type : 'post',
                    url : '<?= $this->Url->build(['action' => 'delete-option'])?>',
                    data : {
                        id : id
                    },
                    success : function(data){
                        data = JSON.parse(data);
                        if (data.ask == 1) {
                            if(confirm('该字段下存在客户数据，是否确定删除？')){
                                $.ajax({
                                    type : 'post',
                                    url : '<?= $this->Url->build(['action' => 'delete-option'])?>',
                                    data : {
                                        id : id,
                                        confirm : 1
                                    },
                                    success : function(data){
                                        data = JSON.parse(data);
                                        if (data.result == 1) {
                                           parent.remove();
                                        }else {
                                            alert('删除失败，请重试');
                                        }
                                    }
                                });
                            }
                        }else if(data.result == 1){
                            parent.remove();
                        }else {
                            alert('删除失败，请重试');
                        }
                    }
                });
            }else{
                $(node).parent('div').remove();
            }
        }                
        
    }
</script>
<?= $this->end() ?>