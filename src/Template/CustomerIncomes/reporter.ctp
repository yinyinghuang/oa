<?php
/**
  * @var \App\View\AppView $this
  */
?>
<div class="customerIncomes index large-12 medium-12 columns content">
    <div class="header">
        <h3 class="header inline"><?= __('财务报表') ?></h3>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>支付次数最多 <small></small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <table class="" style="width:100%">
              <tr>
                <th style="width:37%;">
                  <p>Top 10</p>
                </th>
                <th>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <p class="">姓名</p>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <p class="">次数</p>
                  </div>
                </th>
              </tr>
              <tr>
                <td>
                  <canvas id="topTenTimesCustomersCanvas" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                </td>
                <td>
                  <?php 
                    foreach ($topTenTimesCustomers as $customer){ ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view', $customer->customer_id]) ?>">
                    <?= $customer->customer['name']?>
                    </a>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $customer->total?>
                  </div>
                  <?php 
                    } ?>
                </td>
              </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>支付金额最多 <small></small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <table class="" style="width:100%">
              <tr>
                <th style="width:37%;">
                  <p>Top 10</p>
                </th>
                <th>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <p class="">姓名</p>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <p class="">总额</p>
                  </div>
                </th>
              </tr>
              <tr>
                <td>
                  <canvas id="topTenConsumptionCustomersCanvas" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                </td>
                <td>
                  <?php 
                    foreach ($topTenConsumptionCustomers as $customer){ ?>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <a href="<?= $this->Url->build(['controller' => 'Customers', 'action' => 'view', $customer->customer_id]) ?>">
                    <?= $customer->customer['name']?>
                    </a>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?php setlocale(LC_MONETARY, 'zh_HK');?>
                    <?=  $customer->total?>
                  </div>
                  <?php 
                    } ?>
                </td>
              </tr>
            </table>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>客户分类分布<small style="margin-left: 10px;"></small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
            <div id="topTenTimesCustomersCanvas" style='height:300px;'></div>
            </div> 
          </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<?= $this->start('script') ?>
<script type="text/javascript">
     $(document).ready(function() {
        var options = {
          legend: false,
          responsive: false
        };
        new Chart(document.getElementById("topTenTimesCustomersCanvas"), {
          type: 'doughnut',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: {
            labels: [
            <?php foreach ($topTenTimesCustomers as $customer){ ?>
              <?php echo '"'.$customer->customer['name'].'",'; ?>
            <?php } ?>
            ],
            datasets: [{
              data: [
              <?php foreach ($topTenTimesCustomers as $customer){ ?>
                <?php echo $customer->total.','; ?>
              <?php } ?>
              ],
              backgroundColor: [
                "#D462FF",
                "#C12869",
                "#E42217",
                "#FF8040",
                "#FBB917",
                "#6AFB92",
                "#50EBEC",
                "#82CAFA",
                "#0041C2",
                "#736F6E"
              ],
              hoverBackgroundColor: [
                "#E238EC",
                "#C12267",
                "#F62817",
                "#F88017",
                "#FBB117",
                "#98FF98",
                "#4EE2EC",
                "#82CAFF",
                "#0020C2",
                "#837E7C"
              ]
            }]
          },
          options: options
        });

        new Chart(document.getElementById("topTenConsumptionCustomersCanvas"), {
          type: 'doughnut',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: {
            labels: [
            <?php foreach ($topTenConsumptionCustomers as $customer){ ?>
              <?php echo '"'.$customer->customer['name'].'",'; ?>
            <?php } ?>
            ],
            datasets: [{
              data: [
              <?php foreach ($topTenConsumptionCustomers as $customer){ ?>
                <?php echo $customer->total.','; ?>
              <?php } ?>
              ],
              backgroundColor: [
                "#D462FF",
                "#C12869",
                "#E42217",
                "#FF8040",
                "#FBB917",
                "#6AFB92",
                "#50EBEC",
                "#82CAFA",
                "#0041C2",
                "#736F6E"
              ],
              hoverBackgroundColor: [
                "#E238EC",
                "#C12267",
                "#F62817",
                "#F88017",
                "#FBB117",
                "#98FF98",
                "#4EE2EC",
                "#82CAFF",
                "#0020C2",
                "#837E7C"
              ]
            }]
          },
          options: options
        });
    })
</script>
<?= $this->end() ?>
