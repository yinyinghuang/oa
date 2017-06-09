<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $department->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $department->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Departments'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="departments form large-9 medium-8 columns content">
    <?= $this->Form->create($department) ?>
    <fieldset>
        <legend><?= __('Edit Department') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['type' => 'hidden']);
            echo $this->Form->control('name');
            echo '<div class="input select"><label for="parent">Parent</label>';
            foreach ($parentDepartments as $value) {
                echo $this->Form->select('parent', $value->options , ['empty' => '请选择', 'class' => 'parent_id','default' => $value->id]);
            }
            echo'</div>';
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change', function(){
            loadChilds(this);
        }); 
        $('#submit').on('click', function(){
            if($('#parent-id').val() == '<?= $department->id ?>'){
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
                    if (data.length != 0) { 
                        var html = '<select class="parent_id" onChange="loadChilds(this)"><option value="">请选择</option>';
                        for (var i in data) {
                            html += '<option value="' + i + '">' + data[i] + '</option>';
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