<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Departments'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="departments form large-9 medium-8 columns content">
    <?= $this->Form->create($department) ?>
    <fieldset>
        <legend><?= __('Add Department') ?></legend>
        <?php
            echo $this->Form->control('parent_id', ['type' => 'hidden', 'value' => $parent_id]);
            echo $this->Form->control('name');
            if ($parent_id === null) {
                echo $this->Form->control('parent', ['options' => $parentDepartments, 'empty' => '请选择', 'class' => 'parent_id']);
            }
            
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit'),['class' => ['btn', 'btn-primary', 'pull-right']]) ?>
    <?= $this->Form->end() ?>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        $('.parent_id').on('change', function(){
            loadChilds(this);
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
