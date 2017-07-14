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
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="v"<?php if (isset($privilege['CustomerCategories']) && strpos($privilege['CustomerCategories'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="a"<?php if (isset($privilege['CustomerCategories']) && strpos($privilege['CustomerCategories'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="e"<?php if (isset($privilege['CustomerCategories']) && strpos($privilege['CustomerCategories'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[CustomerCategories][]" value="d"<?php if (isset($privilege['CustomerCategories']) && strpos($privilege['CustomerCategories'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>            
            <tr>           
                <td>短信模板</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="v"<?php if (isset($privilege['SmsTemplates']) && strpos($privilege['SmsTemplates'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="a"<?php if (isset($privilege['SmsTemplates']) && strpos($privilege['SmsTemplates'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="e"<?php if (isset($privilege['SmsTemplates']) && strpos($privilege['SmsTemplates'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="d"<?php if (isset($privilege['SmsTemplates']) && strpos($privilege['SmsTemplates'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                            <label><input class="option" type="checkbox" name="auth[SmsTemplates][]" value="s"<?php if (isset($privilege['SmsTemplates']) && strpos($privilege['SmsTemplates'], 's') !== false): ?> checked<?php endif ?>>发送</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>           
                <td>客户收益</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[CustomerIncomes][]" value="v"<?php if (isset($privilege['CustomerIncomes']) && strpos($privilege['CustomerIncomes'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
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
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="v"<?php if (isset($privilege['Customers_' . $value->id]) && strpos($privilege['Customers_' . $value->id], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="a"<?php if (isset($privilege['Customers_' . $value->id]) && strpos($privilege['Customers_' . $value->id], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="i"<?php if (isset($privilege['Customers_' . $value->id]) && strpos($privilege['Customers_' . $value->id], 'i') !== false): ?> checked<?php endif ?>>导入</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="e"<?php if (isset($privilege['Customers_' . $value->id]) && strpos($privilege['Customers_' . $value->id], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                                <label><input class="option" type="checkbox" name="auth[Customers_<?= $value->id ?>][]" value="d"<?php if (isset($privilege['Customers_' . $value->id]) && strpos($privilege['Customers_' . $value->id], 'd') !== false): ?> checked<?php endif ?>>删除</label>
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
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="v"<?php if (isset($privilege['FinancesTypes']) && strpos($privilege['FinancesTypes'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="a"<?php if (isset($privilege['FinancesTypes']) && strpos($privilege['FinancesTypes'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="e"<?php if (isset($privilege['FinancesTypes']) && strpos($privilege['FinancesTypes'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[FinancesTypes][]" value="d"<?php if (isset($privilege['FinancesTypes']) && strpos($privilege['FinancesTypes'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr> 
            <tr>          
                <td>流水</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="v"<?php if (isset($privilege['Finances']) && strpos($privilege['Finances'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="a"<?php if (isset($privilege['Finances']) && strpos($privilege['Finances'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="e"<?php if (isset($privilege['Finances']) && strpos($privilege['Finances'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="d"<?php if (isset($privilege['Finances']) && strpos($privilege['Finances'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                            <label><input class="option" type="checkbox" name="auth[Finances][]" value="p"<?php if (isset($privilege['Finances']) && strpos($privilege['Finances'], 'p') !== false): ?> checked<?php endif ?>>申请</label>
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
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="v"<?php if (isset($privilege['Projects']) && strpos($privilege['Projects'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="a"<?php if (isset($privilege['Projects']) && strpos($privilege['Projects'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="e"<?php if (isset($privilege['Projects']) && strpos($privilege['Projects'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Projects][]" value="d"<?php if (isset($privilege['Projects']) && strpos($privilege['Projects'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr> 
            <tr>          
                <td>计划管理</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="v"<?php if (isset($privilege['ProjectSchedules']) && strpos($privilege['ProjectSchedules'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="a"<?php if (isset($privilege['ProjectSchedules']) && strpos($privilege['ProjectSchedules'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="e"<?php if (isset($privilege['ProjectSchedules']) && strpos($privilege['ProjectSchedules'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="d"<?php if (isset($privilege['ProjectSchedules']) && strpos($privilege['ProjectSchedules'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                            <label><input class="option" type="checkbox" name="auth[ProjectSchedules][]" value="p"<?php if (isset($privilege['ProjectSchedules']) && strpos($privilege['ProjectSchedules'], 'p') !== false): ?> checked<?php endif ?>>申请</label>
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
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="v"<?php if (isset($privilege['Dropboxes']) && strpos($privilege['Dropboxes'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="a"<?php if (isset($privilege['Dropboxes']) && strpos($privilege['Dropboxes'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="e"<?php if (isset($privilege['Dropboxes']) && strpos($privilege['Dropboxes'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Dropboxes][]" value="d"<?php if (isset($privilege['Dropboxes']) && strpos($privilege['Dropboxes'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
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
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="v"<?php if (isset($privilege['Departments']) && strpos($privilege['Departments'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="a"<?php if (isset($privilege['Departments']) && strpos($privilege['Departments'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="e"<?php if (isset($privilege['Departments']) && strpos($privilege['Departments'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Departments][]" value="d"<?php if (isset($privilege['Departments']) && strpos($privilege['Departments'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>             
                <td>员工</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="v"<?php if (isset($privilege['Users']) && strpos($privilege['Users'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="a"<?php if (isset($privilege['Users']) && strpos($privilege['Users'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="e"<?php if (isset($privilege['Users']) && strpos($privilege['Users'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Users][]" value="d"<?php if (isset($privilege['Users']) && strpos($privilege['Users'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>权限</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="v"<?php if (isset($privilege['Privileges']) && strpos($privilege['Privileges'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="a"<?php if (isset($privilege['Privileges']) && strpos($privilege['Privileges'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="e"<?php if (isset($privilege['Privileges']) && strpos($privilege['Privileges'], 'd') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Privileges][]" value="d"<?php if (isset($privilege['Privileges']) && strpos($privilege['Privileges'], 'e') !== false): ?> checked<?php endif ?>>删除</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>假期</td>
                <td>
                    <div class="row">
                        <div class="col-xs-12">
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="v"<?php if (isset($privilege['Holidays']) && strpos($privilege['Holidays'], 'v') !== false): ?> checked<?php endif ?>>浏览</label>
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="a"<?php if (isset($privilege['Holidays']) && strpos($privilege['Holidays'], 'a') !== false): ?> checked<?php endif ?>>新增</label>
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="e"<?php if (isset($privilege['Holidays']) && strpos($privilege['Holidays'], 'e') !== false): ?> checked<?php endif ?>>编辑</label>
                            <label><input class="option" type="checkbox" name="auth[Holidays][]" value="d"<?php if (isset($privilege['Holidays']) && strpos($privilege['Holidays'], 'd') !== false): ?> checked<?php endif ?>>删除</label>
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