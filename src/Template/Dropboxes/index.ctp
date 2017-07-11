<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="folders index content">
    <nav class="nav">
        <div class="text-center pull-right">
            <a href="" class="btn btn-primary">
                <i class="fa fa-plus"></i><span class="hidden-xs">新建文件夹</span>
            </a>            
        </div>
        <div class="text-center pull-right">
            <a href="" class="btn btn-danger">
               <i class="fa fa-cloud-upload"></i><span class="hidden-xs">上传文件</span>
            </a>            
        </div>
        <div class="pull-left col-md-6 col-sm-6 col-xs-12">
            <ol class="breadcrumb" style="margin-left:0;padding: 0">
                <?php if ($parent_id == 0): ?>
                    <li class="active">根目录</li>
                <?php else: ?>
                    <li><a href="<?= $this->Url->build(['action' => 'index'])?>">根目录</a></li>
                <?php endif ?>
                <?php if (isset($crumbs)): ?>
                    <?php foreach ($crumbs as $crumb): ?>
                    <?php if ($parent_id == $crumb->id): ?><li class="active"><?= $crumb->origin_name?></li>
                    <?php else: ?>
                    <li><a href="<?= $this->Url->build(['action' => 'index', $crumb->id])?>"><?= $crumb->origin_name?></a></li>
                    <?php endif ?>    
                    <?php endforeach ?>
                <?php endif ?>
            </ol>
        </div>
    </nav>
    <div class="clearfix"></div>
    <table cellpadding="0" cellspacing="0" id="datatable">
        <thead>
            <tr>                
                <th scope="col" width="40">id</th>
                <th scope="col">文件名</th>
                <th scope="col"></th>
                <th scope="col">大小</th>
                <th scope="col">修改时间</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class="hidden">
        <?php foreach ($folders as $folder): ?>
        <div class="text-center col-md-3 col-sm-4 col-xs-6">
            <a class="block" href="<?= $this->Url->build(['action' => 'index', $folder->id])?>">
                <div><i class="fa fa-folder-open-o fa-4x"></i></div>
                <div><?= h($folder->origin_name) ?></div>
            </a>                        
        </div>
        <?php endforeach ?>
    </div>
    <div class="clearfix"></div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js" ></script>

<script type="text/javascript">
    $(function(){
       
    });
</script>
<?= $this->end() ?>