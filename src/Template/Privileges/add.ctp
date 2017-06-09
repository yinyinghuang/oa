<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Privileges'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="privileges form large-9 medium-8 columns content">
    <?= $this->Form->create($privilege) ?>
    <fieldset>
        <legend><?= __('Add Privilege') ?></legend>
        <?php
            echo $this->Form->control('who', ['type' => 'hidden']);
            echo $this->Form->control('type', ['type' => 'radio', 'options' => [0 => '部门/角色', 2 => '用户']]);
            echo "<div id='who-fields' style='display:none;'>";
            echo $this->Form->control('department_id', ['options' => $departments, 'empty' => '请选择',]);
            echo $this->Form->control('role_id', ['options' => $roles, 'empty' => '请选择']);
            echo $this->Form->control('user_id', ['options' => $users, 'empty' => '请选择']);
            echo "</div>";
            echo $this->Form->control('what', ['options' => ['accounts' => '微信运营', 'customers' => '客户关系管理', 'dropboxes' => '网盘', 'finances' => '财务报表', 'projects' => '项目管理', 'users' => '用户', 'privileges' => '权限设置', 'departments' => '部门设置', 'roles' => '角色设置']]);
        ?>
            <div class="input">
                <label for="view"><input type="checkbox" name="how[]" value="v" id="view">浏览</label>
                <label for="add"><input type="checkbox" name="how[]" value="a" id="add">增加</label>
                <label for="edit"><input type="checkbox" name="how[]" value="e" id="edit">修改</label>
                <label for="delete"><input type="checkbox" name="how[]" value="d" id="delete">删除</label>
            </div>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function () {
        var checked = $('input:radio[name="type"]:checked').val();
        var fields = $('#who-fields'),
            department = $('#department-id').parent('.input.select'),
            role = $('#role-id').parent('.input.select'),
            user = $('#user-id').parent('.input.select');
        if (checked !== undefined) {
            switch (checked){
                case '0':
                    department.show();
                    role.show();
                    user.hide();
                break;
                case '2':
                    department.show();
                    role.hide();
                    user.show();
                break;
            } 
            fields.show();             
        }
        $('input:radio[name="type"]') .on('click', function(){
            switch (this.value){
                case '0':
                    fields.is('hidden') ? '' : fields.hide(); 
                    department.show();
                    role.show();
                    user.hide();
                break;
                case '2':
                    fields.is('hidden') ? '' : fields.hide(); 
                    department.show();
                    role.hide();
                    user.show();
                break;
            }
            fields.slideDown();  
        });

        $('#submit').on('click', function(){
            var checked = $('input:radio[name="type"]:checked').val(),
                who = document.getElementById('who');
            switch (checked){
                case '0':
                    var department = $('#department-id');
                    if(department.val() === ''){
                        if (document.getElementById('department-error')) {
                            $('#department-error').show();
                        } else {                            
                            department.after($('<div id="department-error" class="error">请选择部门</div>'))
                        }
                        department.focus();
                        return false;
                    }
                    who.value = department.val();
                break;
                case '2':
                    var department = $('#department-id'),
                        el;
                    if(department.val() === ''){
                        if (document.getElementById('department-error')) {
                            $('#department-error').fadeIn();
                        } else {
                            el = $('<div id="department-error" class="error">请选择部门</div>');
                            department.after(el);
                            el.fadeOut();
                        }
                        department.focus();
                        return false;
                    }
                    var user = $('#user-id');
                    if(user.val() === ''){
                        if (document.getElementById('user-error')) {
                            $('#user-error').show();
                        } else {                            
                            user.after($('<div id="user-error" class="error">请选择用户</div>'))
                        }
                        user.focus();
                        return false;
                    }
                    who.value = user.val();
                break;
            }
        });
    });
</script>
<?= $this->end() ?>
