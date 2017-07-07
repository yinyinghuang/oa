<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="documents index content">

    <nav class="nav">
        <?php if ($parent_id): ?>
            <div class="text-center pull-right">
                <button class="btn btn-default"  data-toggle="modal" data-target="#moveModal" id="move">
                    <i class="fa fa-arrows"></i><span class="hidden-xs">移动到</span>
                </button>            
            </div>
            <div class="text-center pull-right">
                <button class="btn btn-default"  data-toggle="modal" data-target="#copyModal" id="copy">
                    <i class="fa fa-clone"></i><span class="hidden-xs">复制到</span>
                </button>            
            </div>
            <div class="text-center pull-right">
                <button class="btn btn-default"  data-toggle="modal" data-target="#renameModal" id="rename">
                   <i class="fa fa-edit"></i><span class="hidden-xs">重命名</span>
                </button>            
            </div>
            <div class="text-center pull-right">
                <button class="btn btn-default" id="delete">
                    <i class="fa fa-trash"></i><span class="hidden-xs">删除</span>
                </button>            
            </div>
            <div class="text-center pull-right">
                <button class="btn btn-default" id="download">
                   <i class="fa fa-cloud-download"></i><span class="hidden-xs">下载</span>
                </button>            
            </div>
            <div class="text-center pull-right">
                <button class="btn btn-default"  data-toggle="modal" data-target="#newModal" id="newFolder">
                    <i class="fa fa-plus"></i><span class="hidden-xs">新建文件夹</span>
                </button>            
            </div>
            <div class="text-center pull-right">
                <button class="btn btn-primary"  data-toggle="modal" data-target="#uploadModal">
                   <i class="fa fa-cloud-upload"></i><span class="hidden-xs">上传文件</span>
                </button>            
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
                    <li><a href="<?= $this->Url->build(['action' => 'index', 'pid' => $crumb->id])?>"><?= $crumb->origin_name?></a></li>
                    <?php endif ?>    
                    <?php endforeach ?>
                <?php endif ?>
            </ol>
        </div>
    </nav>
    <div class="clearfix"></div>
    <table cellpadding="0" cellspacing="0">
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
                <td><input type="checkbox" name="itemid[]" value="<?= h($document->id) ?>" class="itemid" data-sys="<?= $document->is_sys ?>"></td>
                <td><a href="<?= $this->Url->build(['action' => 'index', 'pid' => $document->id])?>"><i class="fa fa-<?php if ($document->is_dir): ?>folder-o<?php else: ?><?= $iconArr[$document->ext]?><?php endif ?>" style="padding-right:4px;color: #000;"></i><?= h($document->origin_name) ?></a></td>
                <td><?= h($document->size) ?></td>
                <td><?= h($document->modified) ?></td>
                <td class="actions">
                    <?php if ($document->is_dir): ?>
                        <a data-toggle="modal" data-target="#newModal" class="new_btn" data-id="<?= $document->id ?>">新建</a>
                        <a data-toggle="modal" data-target="#uploadModal" class="upload_btn" data-path="<?= $document->name?>" data-id="<?= $document->id ?>">上传</a>
                    <?php else: ?>
                        <?= $this->Form->postLink(__('下载'), ['action' => 'download', $document->id]) ?>
                    <?php endif ?>

                    <?php if (!$document->is_sys): ?>
                    <a data-toggle="modal" data-target="#renameModal" class="rename_btn" data-pid="<?= $document->parent_id ?>" data-id="<?= $document->id ?>" data-name="<?= $document->origin_name ?>">重命名</a>
                    <a data-toggle="modal" data-target="#copyModal" class="copy_btn" data-pid="<?= $document->parent_id ?>" data-id="<?= $document->id ?>" data-name="<?= $document->origin_name ?>">复制到</a>
                    <a data-toggle="modal" data-target="#moveModal" class="move_btn" data-id="<?= $document->id ?>">移动到</a>
                     <?= $this->Form->postLink(__('删除'), ['action' => 'delete'], ['confirm' => __('Are you sure you want to delete {0}?', $document->name),'data' => ['itemid' => $document->id]]) ?>
                    <?php endif ?>
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
                <input type="hidden" id="path">
                <input type="hidden" id="parent_id">
                <input type="file" id="file" multiple required>               
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
                <input type="hidden" class="exisit">
                <label for="filename" class="control-label">文件名</label>
                <input type="text" class="filename" required id="filename">
                <div id="newSuccess"></div>
                <div class="error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="new">确定</button>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="renameModal" tabindex="-1" role="dialog" aria-labelledby="renameModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="renameModalLabel">重命名</h4>
            </div>            
            <div class="modal-body">
                <input type="hidden" id="docu_id">
                <input type="hidden" class="exisit">
                <input type="text" class="filename" required id="rewrite">
                <div id="renameSuccess"></div>
                <div class="error"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="renameConfirm">确定</button>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="moveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="moveModalLabel">移动至</h4>
            </div>            
            <div class="modal-body">
                <?= $html ?>
                <div id="moveSuccess"></div>
                <div id="moveError"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="moveConfirm">确定</button>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="copyModal" tabindex="-1" role="dialog" aria-labelledby="copyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="copyModalLabel">复制至</h4>
            </div>            
            <div class="modal-body">
                <?= $html ?>
                <div id="copySuccess"></div>
                <div id="copyError"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="close">关闭</button>
                <button type="button" class="btn btn-primary" id="copyConfirm">确定</button>
            </div>
            
        </div>
    </div>
</div>
<?= $this->start('script') ?>

<script type="text/javascript">
    $(function(){
        var tbody = $('tbody'),
            parent_id = $('#parent_id')[0],
            path = $('#path')[0],
            docu_id = $('#docu_id')[0],
            id;
        //悬停改变背景样式
        tbody.on('mouseover', 'tr', function () {
            $(this).hasClass('highlight') ? '' : $(this).addClass( 'highlight' );
        })
        .on( 'mouseleave', 'tr', function () {
            $(this).hasClass('highlight') ? $(this).removeClass( 'highlight' ) : '';
        });
        $('.mouseoverItem').on('mouseover', function () {
            $(this).hasClass('highlight') ? '' : $(this).addClass( 'highlight' );
        })
        .on( 'mouseleave', function () {
            $(this).hasClass('highlight') ? $(this).removeClass( 'highlight' ) : '';
        });
        $('.collapseItem').on('click',function(e){
            e.stopPropagation();
            div = $(this).children('div');
            if(div.hasClass('cur')){                
                var children = $(this).children('ul');
                if(children.length){
                    children.is(':hidden') ? children.show() : children.hide();
                }
            }else{
                $('.top').find('div').removeClass('cur');
                div.addClass('cur'); 
            }
            
        });
        //上传文件
        $('#file').on('click',function(){
            $('#upload').attr('disabled', false);
        });
        $('#upload').on('click', function(){
            if ($('#file')[0].files.length < 1) {
                $('#uploadError').html('<div style="color:red">未选中文件</div>');return false;
            }
            $('#upload').attr('disabled', true);               
            var formData = new FormData(),
                success  = $('#uploadSuccess'),
                error = $('#uploadError'),
                filelists = $('#file')[0].files;
            for (var i = 0; i < filelists.length; i++) {
                formData.append('attachment[]', filelists[i]);
            }
            formData.append('path', "<?= $path ?>" + path.value);            
            formData.append('parent_id', parent_id.value ? parent_id.value : "<?php if(isset($parent_id) && $parent_id):?><?= $parent_id ?><?php else: ?>0<?php endif?>");            
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build([ 'action' => 'upload']) ?>',
                data : formData,
                cache: false,
                processData: false,
                contentType: false,
                success : function(data){
                    data = JSON.parse(data);
                    if (data.flag == 1) {
                        error.html('');
                        window.location.reload();
                    } else {
                        error.html(data.html);
                    }
                },
                error : function(data){
                    console.log(data.responseText);
                }
            });
        });
        $('.upload_btn').on('click',function(){
            parent_id.value = $(this).data('id');
            path.value = $(this).data('path');
        });
        //新建文件夹
        var timer = null;
        $('.filename').on('input', function(){
            exisit = document.getElementById('exisit');
            var that = this;
            if(timer) {clearTimeout(timer)};
            timer = setTimeout(function(){
                $.ajax({
                    type : 'get',
                    url : '<?= $this->Url->build([ 'action' => 'identicalName']) ?>',
                    data : {
                        filename : that.value,
                        parent_id : parent_id.value ? parent_id.value : "<?php if(isset($parent_id) && $parent_id):?><?= $parent_id ?><?php else: ?>0<?php endif?>"
                    },
                    success : function(data){
                        if (data > 0) {
                            $(that).prev('.exisit').val(1);
                            $(that).siblings('.error').html('<div style="color:red">文件夹名已存在</div>');
                        } else {
                            $(that).siblings('.error').html('');
                            $(that).prev('.exisit').val(0);
                        }
                    },
                    error : function(data){
                        console.log(data.responseText);
                    }
                });
            },250);
        });

        $('.new_btn').on('click',function(){
            parent_id.value = $(this).data('id');
            path.value = $(this).data('path');
        });
        $('#new').on('click', function(){
            var filename = $('#filename')[0].value;
            if (filename == '') {
                $('#newError').html('<div style="color:red">请填写文件夹名</div>');return false;
            } 
            if ($('#exisit').val() == 1) {
                $('#newError').html('<div style="color:red">文件夹名已存在</div>');return false;
            }               
            $('#new').attr('disabled', true);
            var success  = $('#newSuccess'),
                error = $('#newError'),
                data = {
                    path : "<?= $path ?>" + path.value,
                    parent_id :  parent_id.value ? parent_id.value : "<?php if(isset($parent_id) && $parent_id):?><?= $parent_id ?><?php else: ?>0<?php endif?>",
                    filename : filename
                };           
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build([ 'action' => 'newFolder']) ?>',
                data : data,
                success : function(data){
                    if (data == 1) {
                        window.location.reload();
                    } else if(data == -1) {
                        error.html('文件夹名不能为空');
                    } else if(data == -1) {
                        error.html('文件夹创建失败');
                    }
                },
                error : function(data){
                    console.log(data.responseText);
                }
            });
        });
        $('.rename_btn').on('click',function(){
            parent_id.value = $(this).data('pid');
            var name = $(this).data('name').split('.').slice(0,-1).join('.'),
                rewrite = $('#rewrite')[0];
            rewrite.value = name;
            rewrite.select();

            id = $(this).data('id');
        });
        //文件夹重命名
        $('#renameConfirm').on('click', function(){
            var filename = $('#rewrite')[0].value;
            if (filename == '') {
                $('#renameError').html('<div style="color:red">请填写文件夹名</div>');return false;
            } 
            if ($('#exisit').val() == 1) {
                $('#renameError').html('<div style="color:red">文件夹名已存在</div>');return false;
            }               
            $('#rename').attr('disabled', true);
            var success  = $('#renameSuccess'),
                error = $('#renameError'),
                data = {
                    name : filename,
                    id : id
                };           
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build([ 'action' => 'rename']) ?>',
                data : data,
                success : function(data){
                    if (data == 1) {
                        window.location.reload();
                    } else {
                        error.html('重命名失败。请重试');
                    }
                },
                error : function(data){
                    console.log(data.responseText);
                }
            });
        });
        //移动文件位置
        $('.move_btn').on('click',function(){
            id = $(this).data('id');
        });
        $('#moveConfirm').on('click', function(){
            var dirname = $(this).parent('div').siblings('.modal-body').find('.top').find('.cur');
            if (!dirname.length) {
                $('#moveError').html('<div style="color:red">请选择文件夹</div>');return false;
            } 
            if (dirname.length > 1) {
                $('#moveError').html('<div style="color:red">只能选择一个文件夹，请刷新页面后重选</div>');return false;
            }               
            $('#move').attr('disabled', true);
            var success  = $('#moveSuccess'),
                error = $('#moveError'),
                data = {
                    id : id,
                    parent_id : dirname[0].dataset.id
                };           
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build([ 'action' => 'move']) ?>',
                data : data,
                success : function(data){
                    if (data == 1) {
                        window.location.reload();
                    } else if(data == -1) {
                        error.html('重命名失败。请重试');
                    } else if(data == -3){
                        error.html('指定文件不存在');
                    }
                },
                error : function(data){
                    console.log(data.responseText);
                }
            });
        });

        //复制文件
        $('.copy_btn').on('click',function(){
            id = $(this).data('id');
        });
        $('#copyConfirm').on('click', function(){
            var dirname = $(this).parent('div').siblings('.modal-body').find('.top').find('.cur');
            if (!dirname.length) {
                $('#copyError').html('<div style="color:red">请选择文件夹</div>');return false;
            } 
            if (dirname.length > 1) {
                $('#copyError').html('<div style="color:red">只能选择一个文件夹，请刷新页面后重选</div>');return false;
            }               
            $('#copy').attr('disabled', true);
            var success  = $('#copySuccess'),
                error = $('#copyError'),
                data = {
                    id : id,
                    parent_id : dirname[0].dataset.id
                };           
            $.ajax({
                type : 'post',
                url : '<?= $this->Url->build([ 'action' => 'copy']) ?>',
                data : data,
                success : function(data){
                    if (data == 1) {
                        window.location.reload();
                    } else if(data == -1) {
                        error.html('重命名失败。请重试');
                    } else if(data == -2){
                        error.html('不能选择子分类作为上级分类');
                    } else if(data == -3){
                        error.html('指定文件不存在');
                    } else if(data == -4){
                        error.html('系统文件无权移动');
                    }
                },
                error : function(data){
                    console.log(data.responseText);
                }
            });
        });
        $('#selectAll').on('click',function(){
            $('.itemid').prop('checked', this.checked);
            $('#newFolder,#rename,#move').attr('disabled', true);
        });
        $('#delete').on('click',function(){
            if (confirm('确定删除？')) {
                if(!$('.itemid:checked').length){
                    new PNotify({
                        title: '錯誤',
                        text: '至少选中一项',
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000,
                        width:'280px'
                    });
                    return false;
                }
                var itemid = [];
                $('.itemid:checked').each(function(){
                    itemid.push(this.value);
                });

                $.ajax({
                    type : 'post',
                    url : '<?= $this->Url->build([ 'action' => 'delete']) ?>',
                    data : {
                        itemid : itemid
                    },
                    success : function(data){
                        window.location.reload();
                    },
                    error : function(data){
                        console.log(data.responseText);
                    }
                })
            }
        });
        $('#download').on('click',function(){
            
                if(!$('.itemid:checked').length){
                    new PNotify({
                        title: '錯誤',
                        text: '至少选中一项',
                        type: 'error',
                        styling: 'bootstrap3',
                        delay: 3000,
                        width:'280px'
                    });
                    return false;
                }
                var itemid = [];
                $('.itemid:checked').each(function(){
                    itemid.push(this.value);
                });

                $.ajax({
                    type : 'post',
                    url : '<?= $this->Url->build([ 'action' => 'download']) ?>',
                    data : {
                        itemid : itemid
                    },
                    success : function(data){
                        
                    },
                    error : function(data){
                        console.log(data.responseText);
                    }
                })
            
        });
    });
</script>
<?= $this->end() ?>