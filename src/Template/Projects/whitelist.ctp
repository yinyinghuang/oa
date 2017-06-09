<?php
/**
  * @var \App\View\AppView $this
  */
?>
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__($project->title), ['action' => 'view', $project->id]) ?></li>
    </ul>
</nav>
<div class="projects form large-10 medium-9 columns content">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>添加可见人<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox"></ul>
                    <div class="clearfix"></div>
                </div>          
                <div class="x_content">
                    
                    <form action="<?= $this->Url->build(['action' => 'whitelist', $project->id])?>" class="form-horizontal" role="form" method="post">
                        <input type="hidden" id="view" name="view">
                        <div class="required form-group">
                            <label for="viewInput" class="control-label  col-md-3 col-sm-3 col-xs-12">可见人</label>
                            <div class="col-md-6 col-sm-6 col-xs-12"><input type="text" id="viewInput" class="form-control"></div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3"><button class="btn btn-primary pull-right" id="submit">提交</button></div>                          
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
     $(document).ready(function() {     

        var url = window.location.origin + '/projects/get-users/';

        $('#viewInput').autocomplete({
          serviceUrl: url + '/projects/get-users/',
          onSelect: function(suggestion) {
              $('#view').val(suggestion.data);
          },
          onInvalidateSelection: function() {
              $(this).val('');
              $('#view').val('');
          }
        });
        $('#submit').on('click', function(){
            var num = $('#num').val(),
                flag = false;
            if ($('#view').val() == '') {
                new PNotify({
                    title: '錯誤',
                    text: '审核人填写不正确',
                    type: 'error',
                    styling: 'bootstrap3',
                    delay: 3000,
                    width:'280px'
                });
                $('#participant-' + i).focus();
                flag = true;      
            }
            if (flag) return false;

        });
    })
</script>
<?= $this->end() ?>