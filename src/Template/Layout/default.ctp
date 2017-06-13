<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$title = 'Market Hotpot';
?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
        <title>
            OA
        </title>
        <?= $this->Html->meta('appicon.png', '/img/appicon.png', ['type' => 'icon']); ?>
        <?= $this->Html->meta('icon') ?>

        <!-- BEGIN STYLESHEETS -->
        <?= $this->Html->css('bootstrap.min.css') ?>
        <?= $this->Html->css('base.css') ?>
        <?= $this->Html->css('cake.css') ?>
        <?= $this->Html->css('font-awesome.min.css') ?>
        <?= $this->Html->css('nprogress.css') ?>
        <?= $this->Html->css('animate.min.css') ?>
        <?= $this->Html->css('custom.css') ?>
        <!-- <!-- PNotify -->
        <?= $this->Html->css('../js/vendors/pnotify/dist/pnotify.css') ?>
        <?= $this->Html->css('../js/vendors/pnotify/dist/pnotify.buttons.css') ?>
        <?= $this->Html->css('../js/vendors/pnotify/dist/pnotify.nonblock.css') ?>
        <?= $this->Html->css('../js/vendors/iCheck/skins/flat/green.css') ?>
        <!-- END STYLESHEETS --> 

        <?= $this->fetch('meta') ?>
        <?= $this->fetch('css') ?>
    </head>
    <body class="nav-sm">
        <div class="container body">
          <div class="main_container">
            <div class="col-md-3 left_col">
              <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                </div>
                <div class="clearfix"></div>
                <br />
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                  <div class="menu_section">
                    <h3>General</h3>
                    <ul class="nav side-menu">
                      <li>
                        <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>">
                          <i class="fa fa-home"></i> 首頁
                        </a>
                      </li>
                      <li><a><i class="fa fa-tasks"></i> 任务<?php if ($backlogCount): ?><span class="badge badge-danger"><?= $backlogCount?></span><?php endif ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'index']) ?>">待办任务<?php if ($backlogCount): ?><span class="badge badge-danger"><?= $backlogCount?></span><?php endif ?></a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'add']) ?>">新增任务</a></li>
                        </ul>
                      </li>
                      <li><a><i class="fa fa-users"></i> 客户 <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'index']) ?>">客户</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'customerIncomes', 'action' => 'index']) ?>">客户收益</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'import']) ?>">批量导入</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'CustomerCategories', 'action' => 'index']) ?>">客户分类</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'CustomerCategories', 'action' => 'sms']) ?>">短信推广</a></li>                        
                        </ul>
                      </li>
                      <li><a><i class="fa fa-file-text-o"></i> 财务 <?php if (count($financeInArr)): ?><span class="badge badge-danger"><?= count($financeInArr)?></span><?php endif ?> <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?= $this->Url->build(['controller' => 'Finances', 'action' => 'index']) ?>">流水<?php if (count($financeInArr)): ?><span class="badge badge-danger"><?= count($financeInArr)?></span><?php endif ?> </a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Finances', 'action' => 'add']) ?>">记账</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Finances', 'action' => 'apply']) ?>">申请经费</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'FinanceTypes', 'action' => 'index']) ?>">交易方式</a></li>
                        </ul>
                      </li>
                      <li><a><i class="fa fa-th-large"></i> 项目 <?php if ($projectRespCount): ?><span class="badge badge-danger"><?= $projectRespCount ?></span><?php endif ?>  <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index']) ?>">全部项目</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index', 1]) ?>">待审核</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index', 2]) ?>">进行中
                            <?php if (isset($projectRespArr['2']) && count($projectRespArr['2'])): ?>
                              <span class="badge badge-danger"><?= count($projectRespArr['2']) ?></span>
                            <?php endif ?>
                          </a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index', 4]) ?>">已完成
                            <?php if (isset($projectRespArr['4']) && count($projectRespArr['4'])): ?>
                              <span class="badge badge-danger"><?= count($projectRespArr['4']) ?></span>
                            <?php endif ?>
                          </a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index', 5]) ?>">挂起
                            <?php if (isset($projectRespArr['5']) && count($projectRespArr['5'])): ?>
                              <span class="badge badge-danger"><?= count($projectRespArr['5']) ?></span>
                            <?php endif ?>
                          </a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Projects', 'action' => 'index', 0]) ?>">审核不过
                            <?php if (isset($projectRespArr['0']) && count($projectRespArr['0'])): ?>
                              <span class="badge badge-danger"><?= count($projectRespArr['0']) ?></span>
                            <?php endif ?>
                          </a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'ProjectSchedules', 'action' => 'mySchedules']) ?>">我的计划</a></li>
                        </ul>
                      </li>
                       <li><a><i class="fa fa-dropbox"></i> 网盘 <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'index']) ?>">客户</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'customerIncomes', 'action' => 'index']) ?>">客户收益</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'import']) ?>">批量导入</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'CustomerCategories', 'action' => 'index']) ?>">客户分类</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'CustomerCategories', 'action' => 'sms']) ?>">短信推广</a></li>
                        </ul>
                      </li>
                      <li><a><i class="fa fa-user"></i> 员工 <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>">员工</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Departments', 'action' => 'index']) ?>">部门</a></li>
                          <li><a href="<?= $this->Url->build(['controller' => 'Privileges', 'action' => 'index']) ?>">权限</a></li>
                          <li class="visible-md visible-lg"><a href="<?= $this->Url->build(['controller' => 'Configs', 'action' => 'index']) ?>">节假日</a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                  <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
                    <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                  </a>
                </div>
                <!-- /menu footer buttons -->
              </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
              <div class="nav_menu">
                <nav>
                  <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                  </div>

                  <ul class="nav navbar-nav navbar-right">
                    <li class="">
                      <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <?= $this->request->session()->read('Auth')['User']['username'] ?>
                        <span class=" fa fa-angle-down"></span>
                      </a>
                      <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>"><i class="fa fa-sign-out pull-right"></i> 登出</a></li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <?= $this->fetch('content') ?>
            </div>
            <!-- /page content -->

            <!-- footer content -->
            <footer>
              <div class="pull-right">
                ©2016 All Rights Reserved. INFINITY
              </div>
              <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
          </div>
        </div>

        <!-- BEGIN JAVASCRIPT -->
        <?= $this->Html->script('jquery.min.js') ?>
        <?= $this->Html->script('bootstrap.min.js') ?>
        <?= $this->Html->script('fastclick.js') ?>
        <?= $this->Html->script('nprogress.js') ?>
        <?= $this->Html->script('jquery.autocomplete.js') ?>
        <?= $this->Html->script('moment/moment.min.js') ?>
        <?= $this->Html->script('datepicker/daterangepicker.js') ?>
        <!-- bootstrap-progressbar -->
        <?= $this->Html->script('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>

        <?= $this->Html->script('custom.js') ?>
        <!-- Chart.js -->
        <?= $this->Html->script('vendors/Chart.js/dist/Chart.min.js') ?>

        <!-- jQuery Sparklines -->
        <?= $this->Html->script('vendors/jquery-sparkline/dist/jquery.sparkline.min.js') ?>
        <!-- morris.js -->
        <?= $this->Html->script('vendors/raphael/raphael.min.js') ?>
        <?= $this->Html->script('vendors/morris.js/morris.min.js') ?>

        <!-- gauge.js -->
        <?= $this->Html->script('vendors/gauge.js/dist/gauge.min.js') ?>

        
        <!-- Skycons -->
        <?= $this->Html->script('vendors/skycons/skycons.js') ?>

        <!-- Flot -->
        <?= $this->Html->script('vendors/Flot/jquery.flot.js') ?>
        <?= $this->Html->script('vendors/Flot/jquery.flot.pie.js') ?>
        <?= $this->Html->script('vendors/Flot/jquery.flot.time.js') ?>
        <?= $this->Html->script('vendors/Flot/jquery.flot.stack.js') ?>
        <?= $this->Html->script('vendors/Flot/jquery.flot.resize.js') ?>

        <!-- Flot plugins -->
        <?= $this->Html->script('vendors/flot.orderbars/js/jquery.flot.orderBars.js') ?>
        <?= $this->Html->script('vendors/flot-spline/js/jquery.flot.spline.min.js') ?>
        <?= $this->Html->script('vendors/flot.curvedlines/curvedLines.js') ?>

        <!-- DateJS -->
        <?= $this->Html->script('vendors/DateJS/build/date.js') ?>
        <!-- PNotify -->
        <?= $this->Html->script('vendors/pnotify/dist/pnotify.js') ?>
        <?= $this->Html->script('vendors/pnotify/dist/pnotify.buttons.js') ?>
        <?= $this->Html->script('vendors/pnotify/dist/pnotify.nonblock.js') ?>
        <!-- iCheck -->
        <?= $this->Html->script('vendors/iCheck/icheck.min.js') ?>
        <!-- Switchery -->
        <?= $this->Html->script('vendors/switchery/dist/switchery.min.js') ?>

        <?= $this->fetch('script') ?>
        <script type="text/javascript">var toggle;
        $(document).on('visibilitychange', function () {
            
            if(!document.hidden) {//页面切换为可见时，获取最新消息及任务
              if ((new Date() - toggle)/1000 > 60) {
                $.ajax({
                  type : 'post',
                  url : '/tasks/get-new',
                  data : {
                    time : toggle
                  },
                  success: function(data){
                    data = JSON.parse(data);

                    for(var i in data.notices) {
                      var cur = data.notices[i]; 
                      new PNotify({
                          title: '通知<small class="pull-right" style="color:#fff">' + cur.model + '<small>',
                          text: '<a href="' + cur.deal.url + '" style="color:#fff">' + cur.item + '</a>',
                          icon: 'glyphicon glyphicon-envelope',
                          type: 'info',
                          styling: 'bootstrap3',
                          delay: 3000,
                          width:'280px'
                      });
                    }
                    for(var i in data.tasks) {
                      var cur = data.tasks[i]; 
                      new PNotify({
                          title: '任务<small class="pull-right" style="color:#fff">' + cur.model + '<small>',
                          text: '<a href="' + cur.deal.url + '" style="color:#fff">' + cur.item + '</a>',
                          icon: 'glyphicon glyphicon-tasks',
                          type: 'notice',
                          styling: 'bootstrap3',
                          delay: 3000,
                          width:'280px'
                      });
                    }
                  },
                  error : function(){

                  }
                });
              }
            } else {//记录窗口不可见时间
              toggle = new Date();
            }
        });
        <!-- END JAVASCRIPT -->
        <?= $this->Flash->render() ?>
  
        </script>
        


    </body>
</html>
