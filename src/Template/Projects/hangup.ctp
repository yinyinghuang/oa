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
                    <h2>挂起项目<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox"></ul>
                    <div class="clearfix"></div>
                </div>          
                <div class="x_content">
                    <form action="<?= $this->Url->build(['action' => 'hangup', $project->id])?>" class="form-horizontal" role="form" method="post">
                        <div class="required form-group">
                            <label for="reason" class="control-label  col-md-3 col-sm-3 col-xs-12">原因</label>
                            <div class="col-md-6 col-sm-6 col-xs-12"><textarea type="text" id="reason" class="form-control" required name="reason" rows="5"></textarea></div>
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