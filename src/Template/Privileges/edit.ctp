<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Privileges'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="privileges form large-10 medium-9 columns content">
    
<form action="/privileges/edit" method="post">
    <input type="hidden" name="did" value="<?= $department_id?>">
    <input type="hidden" name="rid" value="<?= $role_id?>">
    <fieldset>
        <legend><?= __('Edit Privilege') ?>
            <span>部门</span><span</span>
            <label ><input type="checkbox" id="selectAll">全选</label>
            <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary', 'pull-right'], 'id' => 'submit']) ?>
        </legend>
        <table>
            <tr>                
                <th rowspan="3">客户模块配置</th>                
                <td>客户分类</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="view"<?php if (isset($privilege['CustomerCategories']) && in_array('view', $privilege['CustomerCategories']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="add"<?php if (isset($privilege['CustomerCategories']) && in_array('add', $privilege['CustomerCategories']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="edit"<?php if (isset($privilege['CustomerCategories']) && in_array('edit', $privilege['CustomerCategories']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="delete"<?php if (isset($privilege['CustomerCategories']) && in_array('delete', $privilege['CustomerCategories']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>            
            <tr>           
                <td>短信模板</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="view"<?php if (isset($privilege['SmsTemplates']) && in_array('view', $privilege['SmsTemplates']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="add"<?php if (isset($privilege['SmsTemplates']) && in_array('add', $privilege['SmsTemplates']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="edit"<?php if (isset($privilege['SmsTemplates']) && in_array('edit', $privilege['SmsTemplates']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="delete"<?php if (isset($privilege['SmsTemplates']) && in_array('delete', $privilege['SmsTemplates']) !== false): ?> checked<?php endif ?>>删除</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="sms"<?php if (isset($privilege['SmsTemplates']) && in_array('sms', $privilege['SmsTemplates']) !== false): ?> checked<?php endif ?>>发送</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>           
                <td>客户收益</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[CustomerIncomes][]" value="view"<?php if (isset($privilege['CustomerIncomes']) && in_array('view', $privilege['CustomerIncomes']) !== false): ?> checked<?php endif ?>>浏览</label>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <?php foreach ($customerCate as $key => $value): ?>
                <tr>
                    <?php if ($key == 0): ?>
                        <th rowspan="<?= $customerCateCount ?>">客户</th>
                    <?php endif ?>
                    <td><?= $value->name ?></td>
                    <td>
                        <div class="row">
                            <div class="col-xs-12">
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="view"<?php if (isset($privilege['Customers_' . $value->id]) && in_array('view', $privilege['Customers_' . $value->id]) !== false): ?> checked<?php endif ?>>浏览</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="add"<?php if (isset($privilege['Customers_' . $value->id]) && in_array('add' ,$privilege['Customers_' . $value->id]) !== false): ?> checked<?php endif ?>>新增</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="import"<?php if (isset($privilege['Customers_' . $value->id]) && in_array('import' ,$privilege['Customers_' . $value->id]) !== false): ?> checked<?php endif ?>>导入</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="edit"<?php if (isset($privilege['Customers_' . $value->id]) && in_array('edit' ,$privilege['Customers_' . $value->id]) !== false): ?> checked<?php endif ?>>编辑</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="delete"<?php if (isset($privilege['Customers_' . $value->id]) && in_array('delete' ,$privilege['Customers_' . $value->id]) !== false): ?> checked<?php endif ?>>删除</label>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
        <table>
            <tr>                
                <th rowspan="2">财务</th>                
                <td>交易方式</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="view"<?php if (isset($privilege['FinancesTypes']) && in_array('view', $privilege['FinancesTypes']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="add"<?php if (isset($privilege['FinancesTypes']) && in_array('add', $privilege['FinancesTypes']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="edit"<?php if (isset($privilege['FinancesTypes']) && in_array('edit', $privilege['FinancesTypes']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="delete"<?php if (isset($privilege['FinancesTypes']) && in_array('delete', $privilege['FinancesTypes']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr> 
            <tr>          
                <td>流水</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="view"<?php if (isset($privilege['Finances']) && in_array('view', $privilege['Finances']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="add"<?php if (isset($privilege['Finances']) && in_array('add', $privilege['Finances']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="edit"<?php if (isset($privilege['Finances']) && in_array('edit', $privilege['Finances']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="delete"<?php if (isset($privilege['Finances']) && in_array('delete', $privilege['Finances']) !== false): ?> checked<?php endif ?>>删除</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="apply"<?php if (isset($privilege['Finances']) && in_array('apply', $privilege['Finances']) !== false): ?> checked<?php endif ?>>申请</label>
                        </div>
                    </div>
                </td>
            </tr> 
        </table>
        <table>
            <tr>                
                <th rowspan="2">项目</th>                
                <td>项目管理</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="view"<?php if (isset($privilege['Projects']) && in_array('view', $privilege['Projects']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="add"<?php if (isset($privilege['Projects']) && in_array('add', $privilege['Projects']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="edit"<?php if (isset($privilege['Projects']) && in_array('edit', $privilege['Projects']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="delete"<?php if (isset($privilege['Projects']) && in_array('delete', $privilege['Projects']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr> 
            <tr>          
                <td>计划管理</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="view"<?php if (isset($privilege['ProjectSchedules']) && in_array('view', $privilege['ProjectSchedules']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="add"<?php if (isset($privilege['ProjectSchedules']) && in_array('add', $privilege['ProjectSchedules']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="edit"<?php if (isset($privilege['ProjectSchedules']) && in_array('edit', $privilege['ProjectSchedules']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="delete"<?php if (isset($privilege['ProjectSchedules']) && in_array('delete', $privilege['ProjectSchedules']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr> 
        </table>
        <table>
            <tr>                
                <th>网盘</th>                
                <td></td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="view"<?php if (isset($privilege['Dropboxes']) && in_array('view', $privilege['Dropboxes']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="add"<?php if (isset($privilege['Dropboxes']) && in_array('add', $privilege['Dropboxes']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="edit"<?php if (isset($privilege['Dropboxes']) && in_array('edit', $privilege['Dropboxes']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="delete"<?php if (isset($privilege['Dropboxes']) && in_array('delete', $privilege['Dropboxes']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr> 
        </table>
        <table>
            <tr>                
                <th rowspan="4">组织及其他</th>                
                <td>部门</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="view"<?php if (isset($privilege['Departments']) && in_array('view', $privilege['Departments']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="add"<?php if (isset($privilege['Departments']) && in_array('add', $privilege['Departments']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="edit"<?php if (isset($privilege['Departments']) && in_array('edit', $privilege['Departments']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="delete"<?php if (isset($privilege['Departments']) && in_array('delete', $privilege['Departments']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>             
                <td>员工</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="view"<?php if (isset($privilege['Users']) && in_array('view', $privilege['Users']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="add"<?php if (isset($privilege['Users']) && in_array('add', $privilege['Users']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="edit"<?php if (isset($privilege['Users']) && in_array('edit', $privilege['Users']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="delete"<?php if (isset($privilege['Users']) && in_array('delete', $privilege['Users']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>权限</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="view"<?php if (isset($privilege['Privileges']) && in_array('view', $privilege['Privileges']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="add"<?php if (isset($privilege['Privileges']) && in_array('add', $privilege['Privileges']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="edit"<?php if (isset($privilege['Privileges']) && in_array('edit', $privilege['Privileges']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="delete"<?php if (isset($privilege['Privileges']) && in_array('delete', $privilege['Privileges']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>假期</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="view"<?php if (isset($privilege['Holidays']) && in_array('view', $privilege['Holidays']) !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="add"<?php if (isset($privilege['Holidays']) && in_array('add', $privilege['Holidays']) !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="edit"<?php if (isset($privilege['Holidays']) && in_array('edit', $privilege['Holidays']) !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="delete"<?php if (isset($privilege['Holidays']) && in_array('delete', $privilege['Holidays']) !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </fieldset>
    <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'], 'id' => 'submit']) ?>
</form>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
    $(function(){
        if($('.option:checked').length == $('.option').length){
            $('#selectAll').prop('checked', true);
        }
        $('#selectAll').on('click', function(){
            $('.option').prop('checked', this.checked);
        });
    });
</script>
<?= $this->end() ?>