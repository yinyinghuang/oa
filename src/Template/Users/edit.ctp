<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users form large-10 medium-9 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
             echo $this->Form->control('num', ['type' => 'hidden', 'value' => count($user->user_department_roles),'id' => 'num']);
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            foreach ($user->user_department_roles as $key => $position) {
                $k = $key + 1;
                echo '<div id="add-' . $k . '">';
                echo $this->Form->control('position_id_' . $k, ['type' => 'hidden', 'value' => $position->id, 'class' => 'position_id']);
                echo '<div class="input select required">';
                echo '<input type="hidden" name="department_' . $k . '" class="department" value="'. $position->department_id .'">';
                echo '<label for="department-id-' . $k . '">部门' . $k . '</label>';
                foreach ($position->departmentList as $department) {
                    echo $this->Form->select('department_id_' . $k . '', $department->options, ['required' => true, 'empty' => '请选择', 'class' => 'parent_id','value' => $department->id]);
                }
                echo '</div>';
                echo $this->Form->control('role_id_' . $k, ['value' => $position->role_id, 'label' => '职位' . $k, 'required' => true, 'options' => $roles]);
                if($key) echo '<a class="btn btn-danger del">删除</a>';
                echo '</div>';

            }
            echo '<a class="btn btn-warning" id="add">新增部门职位</a>';
            echo $this->Form->control('gender');
            echo $this->Form->control('telephone');
            echo $this->Form->control('email');
            echo $this->Form->control('state');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class' => ['btn', 'btn-primary', 'pull-right']]) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        var add = $('#add');
        add.on('click', function(){
            var num = $('#num'),
                i = num.val() * 1 + 1,
                html = '<div id="add-' + i + '"><input type="hidden" class="position_id"><div class="input select required"><input type="hidden" name="department_' + i + '" class="department"><label for="department-id-' + i + '">部门  ' + i + '</label><select name="department_id_' + i + '" id="department-id-' + i + '" required onChange="loadChilds(this)"><option value="">请选择</option><?php foreach ($departments as $key => $value): ?><option value="<?= $key ?>"><?= $value ?></option><?php endforeach ?></select></div><div class="input select required"><label for="role-id-' + i + '">Role Id  ' + i + '</label><select name="role_id_' + i + '" id="role-id-' + i + '" required><option value="">请选择</option><?php foreach ($roles as $key => $value): ?><option value="<?= $key ?>"><?= $value ?></option><?php endforeach ?></select></div><a class="btn btn-danger del" onClick="deletePosition(this);">删除</a></div>';
            add.before(html);
            num.val(i);
        });
        $('.del').on('click', function(){
            deletePosition(this);
        });
        $('.parent_id').on('change', function(){
            loadChilds(this);
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


    function deletePosition(node){
        var num = $('#num'),
            i = num.val() * 1,
            id = $(node).siblings('.position_id')[0].value,
            parent =  $(node).parent('div');
        if(confirm('确定要删除此部门职位？')){
            if (id !== '') {
                $.ajax({
                    type : 'post',
                    url : '<?= $this->Url->build(['action' => 'deletePosition'])?>',
                    data : {
                        id : id
                    },
                    success : function(data){
                        if(data == 1){
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