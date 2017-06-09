<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-10 medium-9 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('num', ['type' => 'hidden', 'value' => 1,'id' => 'num']);
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo '<div class="input select required">';
            echo '<input type="hidden" name="department_1" class="department">';
            echo '<label for="department-id-1">部门1</label>';
            echo $this->Form->select('department_id_1', $departments, ['required' => true, 'empty' => '请选择', 'class' => ['parent_id', 'department_id']]);
            echo '</div>';
            echo $this->Form->control('role_id_1', ['options' => $roles, 'required' => true, 'empty' => '请选择']);
        ?>
        <a class="btn btn-warning" id="add">新增部门职位</a>
        <?php
            echo $this->Form->control('gender', ['options' => [0 => '男', 1 => '女'], 'type' => 'radio']);
            echo $this->Form->control('telephone');
            echo $this->Form->control('email');
            echo $this->Form->control('state', ['options' => [1 => '在职', 0 => '离职'], 'default' => 1, 'type' => 'radio']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        var add = $('#add');
        add.on('click', function(){
            var num = $('#num'),
                i = num.val() * 1 + 1,
                html = '<div id="add-' + i + '"><div class="input select required"><input type="hidden" name="department_' + i + '" class="department"><label for="department-id-' + i + '">部门  ' + i + '</label><select name="department_id_' + i + '" id="department-id-' + i + '" required onChange="loadChilds(this)" class="department_id"><option value="">请选择</option><?php foreach ($departments as $key => $value): ?><option value="<?= $key ?>"><?= $value ?></option><?php endforeach ?></select></div><div class="input select required"><label for="role-id-' + i + '">Role Id  ' + i + '</label><select name="role_id_' + i + '" id="role-id-' + i + '" required><option value="">请选择</option><?php foreach ($roles as $key => $value): ?><option value="<?= $key ?>"><?= $value ?></option><?php endforeach ?></select></div></div>',
                del = '<a class="btn btn-danger" id="del">删除</a>';
            add.before(html);
            if (!document.getElementById('del')) {
                add.after(del);
                $('#del').on('click', function(e){
                    e.preventDefault();
                    var num = $('#num'),
                        i = num.val() * 1;
                    if(i - 1 == 1){$(this).remove();}
                    $('#add-' + i).remove();
                    num.val(i - 1);
                });
            }
            num.val(i);
        });
        $('.parent_id').on('change', function(){
            loadChilds(this);
        });  
        $('#submit').on('click', function(){
            var obj = {},
                flag = false;
            $('.department_id').each(function(){
                if (obj[this.value] == undefined) {
                    obj[this.value] = 1;
                } else {
                    flag = true;
                    return false;
                }
            });
            if (flag) {
                new PNotify({
                    title: '錯誤',
                    text: '部门选择请不要重复',
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
        var parent_id = $(node).siblings('.department')[0];
        if (node.value == 0 && $(node).prev('select').length > 0) {
            parent_id.value = $(node).prev('select').val();
        } else {
             parent_id.value = node.value;
        }
        $(node).nextAll('select').remove();
        if(node.value !== ''){
            var that = node;
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build(['controller' => 'Departments', 'action' => 'loadChilds'])?>',
                data : {
                    parent_id : node.value
                },
                success : function(data){      
                    data = JSON.parse(data);        
                    if (data.length != 0) { 
                        var html = '<select class="parent_id" onChange="loadChilds(this);"><option value="">请选择</option>';
                        for (var i in data) {
                            html += '<option value="' + i + '">' + data[i] + '</option>';
                        }
                        html += '</select>';
                        $(that).after($(html));                            
                    }
                }
            });
        }
    }

</script>
<?= $this->end() ?>
