<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="documents index content">
    <nav class="nav">
        <?php if ($parent_id): ?>
            <div class="text-center pull-right">
                <a href="" class="btn btn-primary"  data-toggle="modal" data-target="#newModal">
                    <i class="fa fa-plus"></i><span class="hidden-xs">新建文件夹</span>
                </a>            
            </div>
            <div class="text-center pull-right">
                <a href="" class="btn btn-danger"  data-toggle="modal" data-target="#uploadModal">
                   <i class="fa fa-cloud-upload"></i><span class="hidden-xs">上传文件</span>
                </a>            
            </div>
        <?php endif ?>
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
                <th scope="col" width="40"><input type="checkbox" id="selectAll"></th>
                <th scope="col">文件名</th>
                <th scope="col">大小</th>
                <th scope="col">修改时间</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($documents as $document): ?>
            <tr>
                <td><input type="checkbox" name="itemid[]" value="<?= h($document->id) ?>"></td>
                <td><a href="<?= $this->Url->build(['action' => 'index', $document->id])?>"><i class="fa fa-<?php if ($document->is_dir): ?>folder-o<?php else: ?><?= $iconArr[$document->ext]?><?php endif ?>" style="padding-right:4px;"></i><?= h($document->origin_name) ?></a></td>
                <td><?= h($document->size) ?></td>
                <td><?= h($document->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('查看'), ['action' => 'index', $document->id]) ?>
                    <?php if ($document->is_dir): ?>
                    <?= $this->Html->link(__('新建'), ['action' => 'addFolder', $document->id]) ?>
                    <?= $this->Html->link(__('上传'), ['action' => 'upload', $document->id]) ?>
                    <?php else: ?>
                    <?= $this->Html->link(__('下载'), ['action' => 'download', $document->id]) ?>
                    <?php endif ?>
                    <?= $this->Form->postLink(__('删除'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete {0}?', $document->name)]) ?>
                </td>
            </tr>  
            <?php endforeach ?>
        </tbody>
    </table>
    
    <div class="hidden">
        <?php foreach ($documents as $document): ?>
        <div class="text-center col-md-3 col-sm-4 col-xs-6">
            <a class="block" href="<?= $this->Url->build(['action' => 'index', $document->id])?>">
                <div><i class="fa fa-document-open-o fa-4x"></i></div>
                <div><?= h($document->origin_name) ?></div>
            </a>                        
        </div>
        <?php endforeach ?>
    </div>
   
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
    <div class="clearfix"></div>
    
</div>
<div class="clearfix"></div>
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="uploadModalLabel">上传文件</h4>
            </div>            
            <div class="modal-body">
                <input type="file" id="file" multiple>               
                <div id="uploadSuccess"></div>
                <div id="uploadError"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="upload">上传</button>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="newModalLabel">新建文件夹</h4>
            </div>            
            <div class="modal-body">
                <input type="file" id="file">               
                <div id="newSuccess"></div>
                <div id="newError"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="new">确定</button>
            </div>
            
        </div>
    </div>
</div>
<?= $this->start('script') ?>

<script type="text/javascript">
    $(function(){
        var tbody = $('#datatable tbody');        
        tbody.on( 'mouseover', 'tr', function () {
            $(this).hasClass('highlight') ? '' : $(this).addClass( 'highlight' );
        } )
        .on( 'mouseleave', 'tr', function () {
            $(this).hasClass('highlight') ? $(this).removeClass( 'highlight' ) : '';
        });
        $('#upload').on('click', function(){               
            var formData = new FormData(),
                success  = $('#uploadSuccess'),
                error = $('#uploadError'),
                filelists = $('#file')[0].files;
            for (var i in filelists) {
                formData.append('attachment[]', filelists[i]);
            }
            formData.append('path', "<?= $path ?>");            
            formData.append('parent_id', "<?= $parent_id ?>");            
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build([ 'action' => 'upload']) ?>',
                data : formData,
                cache: false,
                processData: false,
                contentType: false,
                success : function(data){
                    data = JSON.parse(data);
                    if(data.result){
                        $('#attachment').val(data.url);
                        success.html(data.html);
                        $('#upload').attr('disabled', true);
                        error.html('');
                        setTimeout(function(){
                            $('#close').click();

                        },1000);
                    }else{
                        success.html('');
                        error.html(data.error);
                    }
                },
                error : function(data){
                    alert(data.responseText);
                }
            });
        });

    });
</script>
<?= $this->end() ?>