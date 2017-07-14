<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Privilege'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="privileges index large-10 medium-9 columns content">
    <h3><?= __('Privileges') ?></h3>
    <table>
        <tr>
            <th>
                <div>
                    <b>部门</b><em>角色</em>
                </div>
            </th>
            <th>董事长</th>
            <th>总监</th>
            <th>主管</th>
            <th>职员</th>
        </tr>
        <?php foreach ($departments as $key => $value): ?>
            
            <tr>
                <th><?= $value?></th>
                <?php for($i = 4; $i >= 1; $i --) { ?>
                <td>
                    <?php if (isset($privileges[$key][$i])): ?>
                        <?php foreach ($privileges[$key][$i] as $module): ?>
                            <div class="visible-lg visible-md"><?= $module ?></div>
                        <?php endforeach ?>
                    <?php endif ?>
                    <?php if (isset($privileges[$key][$i])): ?>
                        <div><a data-toggle="modal" data-target="#viewModal" data-did="<?= $key?>" data="<?= $i?>">查看</a></div>
                    <?php endif ?>
                    <div><a href="/privileges/edit?did=<?= $key?>&rid=<?= $i?>">编辑</a></div>
                </td>
                <?php } ?>
            </tr>
            
        <?php endforeach ?>
        
    </table>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewModalLabel">相关权限</h4>
            </div>            
            <div class="modal-body">
                <div id="viewSuccess"></div>
                <div id="viewError"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="viewConfirm">确定</button>
            </div>
            
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        
    });
</script>
<?= $this->end() ?>