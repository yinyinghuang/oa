<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('分类列表'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="customerCategories form large-10 medium-9 columns content">
    <?= $this->Form->create($customerCategory) ?>
    <fieldset>
        <legend><?= __('新增分类') ?></legend>
        <?php
            echo $this->Form->control('num', ['type' => 'hidden', 'value' => 0,'id' => 'num']);
            echo $this->Form->control('parent_id', ['type' => 'hidden', 'value' => $parent_id]);
            echo $this->Form->control('name',['label' => '名称']);
            if ($parent_id === null) {
                echo $this->Form->control('parent', ['options' => $parentCustomerCategories, 'empty' => '请选择', 'class' => 'parent_id', 'label' => '上级分类']);
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
            loadChilds(this);
        });  
        var add = $('#add');
        add.on('click', function(){
            var num = $('#num'),
                i = num.val() * 1 + 1,
                html = '<div id="add-' + i + '"><div class="input text required"><label for="name-' + i + '">字段' + i + '名称</label><input type="text" name="name_' + i + '" id="name-' + i + '" required /></div><div class="input select required"><label for="type-' + i + '">字段' + i + '类型</label><select name="type_' + i + '" id="type-' + i + '" required><option value="">请选择</option><option value="text">单行文本</option><option value="textarea">多行文本</option><option value="select">下拉列表</option><option value="checkbox">复选框</option></select></div><div class="input textarea"><label for="value-' + i + '">字段' + i + '内容</label><textarea name="value_' + i + '" id="value-' + i + '" placeholder="单行文本、多行文本默认值；下拉列表、复选框选项值，请用英文|竖线隔开" rows="5"/></div><div class="input radio required"><label>必填</label><input type="hidden" name="required_' + i + '" value=""><label for="required-' + i + '-1"><input type="radio" name="required_' + i + '" value="1" id="required-' + i + '-1" class="parent_id" required>是</label><label for="required-' + i + '-2"><input type="radio" name="required_' + i + '" value="0" id="required-' + i + '-2" class="parent_id" required>否</label></div></div></div>',
                del = '<a class="btn btn-danger" id="del">删除</a>';
            add.before(html);
            if (!document.getElementById('del')) {
                add.after(del);
                $('#del').on('click', function(e){
                    e.preventDefault();
                    var num = $('#num'),
                        i = num.val() * 1;
                    if(i - 1 == 0){$(this).remove();}
                    $('#add-' + i).remove();
                    num.val(i - 1);
                });
            }
            num.val(i);
        });
        $('#submit').on('click', function(){
            var num = $('#num').val();
            for (var i = 1; i <= num; i++) {
                var type = $('#type-' + i).val(),
                    value = $('#value-' + i);
                if((type == 'select' || type == 'checkbox') && value.val() == ''){
                    new PNotify({
                        title: '錯誤',
                        text: '字段' + i + '为下拉选项或复选框，请填写字段选项值',
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000,
                        width:'280px'
                    });
                    value.focus();
                    return false;                    
                }
            }
        });     
    });
    function loadChilds(node){
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
</script>
<?= $this->end() ?>
