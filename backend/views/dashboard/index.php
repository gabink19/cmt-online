<?php

use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DashboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dashboard-index">
    <?php $form = ActiveForm::begin([
        'action' => '#' ,
        'method' => 'get',
    ]); ?>

  <div class="col-md-12 col-xs-12">
    <div class="col-md-6 col-xs-6">    
      <?= $form->field($searchModel, 'start')->widget(DatePicker::classname(), [
                          'options' => ['placeholder' => 'Start Date','onchange'=>'filter();'],
                          'pluginOptions' => [
                              'autoclose'=>true,
                              'format' => 'yyyy-mm-01',
                              'startView'=>'month',
                              'minViewMode'=>'months'
                          ]
                      ]); ?>
    </div>                    
    <div class="col-md-6 col-xs-6">                    
      <?= $form->field($searchModel, 'stop')->widget(DatePicker::classname(), [
                          'options' => ['placeholder' => 'Start Date', 'onchange'=>'filter();'],
                          'pluginOptions' => [
                              'autoclose'=>true,
                              'format' => 'yyyy-mm-31',
                              'startView'=>'month',
                              'minViewMode'=>'months'
                          ]
                      ]); ?>
    </div>

      <!-- <div class="form-group"> -->
          <?php //echo  Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>        
      <!-- </div> -->
  </div>
  <?php ActiveForm::end(); ?>    
  <div class="col-md-12 col-xs-12">
    <div class="col-md-12 col-xs-12"> 
    <?= Highcharts::widget([
              'id'=>'my-chart2',
              'scripts' => [
                  // 'highcharts-more', 
                  'modules/exporting', 
                  // 'themes/grid'
                  ],
             'options' => [
                  'credits' => 'false',
                'chart'=> ['defaultSeriesType'=>'column',
                  ],
                // 'title' => ['text' => 'Transaction Campaign'],
                // 'xAxis' => [
                   // 'categories' => ['Campaign']
                  // 'title'=>array('text'=>''),
                  // 'labels'=>array('rotation'=>-45),
                  // 'style'=>array('fontSize'=>'14px','fontFamily'=>'Verdana, sans-serif'),
                // ],
                'yAxis' => [
                   'title' => ['text' => '']
                ],
                'credits'=>array('enabled'=>false),
                // 'series' => [
                //    ['name' => 'success', 'data' => [18]],
                //    ['name' => 'failed', 'data' => [1]],
                // ],
                // 'colors'=>['#7cb5ec','#f45b5b'],
             ]
          ]);
              ?>
      </div>
              <br><br>
      <div class="col-md-12 col-xs-12"> 
    <?= Highcharts::widget([
            'id'=>'my-chart3',
            'scripts' => [
                // 'highcharts-more', 
                'modules/exporting', 
                // 'themes/grid'
                ],
           'options' => [
                'credits' => 'false',
              'chart'=> ['defaultSeriesType'=>'column',
                ],
              // 'title' => ['text' => 'Transaction Campaign'],
              // 'xAxis' => [
                 // 'categories' => ['Campaign']
                // 'title'=>array('text'=>''),
                // 'labels'=>array('rotation'=>-45),
                // 'style'=>array('fontSize'=>'14px','fontFamily'=>'Verdana, sans-serif'),
              // ],
              'yAxis' => [
                 'title' => ['text' => '']
              ],
              'credits'=>array('enabled'=>false),
              // 'series' => [
              //    ['name' => 'success', 'data' => [18]],
              //    ['name' => 'failed', 'data' => [1]],
              // ],
              // 'colors'=>['#7cb5ec','#f45b5b'],
           ]
        ]);
            ?>
      </div>
      <div class="col-md-6 col-xs-6"> 
    <?= Highcharts::widget([
            'id'=>'my-chart4',
            'scripts' => [
                // 'highcharts-more', 
                'modules/exporting', 
                // 'themes/grid'
                ],
           'options' => [
                'credits' => 'false',
                'plotOptions' => [
                    'pie' => [
                        'cursor' => 'pointer',
                    ],
                ],
              'yAxis' => [
                 'title' => ['text' => '']
              ],
              'credits'=>array('enabled'=>false),
              // 'colors'=>['#7cb5ec','#f45b5b'],
           ]
        ]);
            ?>
      </div>
      <div class="col-md-6 col-xs-6"> 
    <?= Highcharts::widget([
            'id'=>'my-chart5',
            'scripts' => [
                // 'highcharts-more', 
                'modules/exporting', 
                // 'themes/grid'
                ],
           'options' => [
                'credits' => 'false',
                'plotOptions' => [
                    'pie' => [
                        'cursor' => 'pointer',
                    ],
                ],
              'yAxis' => [
                 'title' => ['text' => '']
              ],
              'credits'=>array('enabled'=>false),
              // 'colors'=>['#7cb5ec','#f45b5b'],
           ]
        ]);
            ?>
      </div>
  </div>      

</div>
<?php
$urlLineCommand = $_SERVER["SCRIPT_NAME"].'?r=dashboard/diagram';
$urlLineCommand2 = $_SERVER["SCRIPT_NAME"].'?r=dashboard/diagram2';
$urlLineCommand3 = $_SERVER["SCRIPT_NAME"].'?r=dashboard/diagram3';
$urlLineCommand4 = $_SERVER["SCRIPT_NAME"].'?r=dashboard/diagram4';
?>
<script type="text/javascript">
    
    $(function(){
  addDashboard3();
  addDashboard4();
  addDashboard5();
  addDashboard6();
  y = setInterval(function(){
    addDashboard3();
    addDashboard4();
    addDashboard5();
    addDashboard6();
  },6000);
});
    function filter(){

      addDashboard3();
      addDashboard4();
      addDashboard5();
      addDashboard6();
    }

function addDashboard3(){
    var start          = $( "#dashboardsearch-start" ).val();
    var end            = $( "#dashboardsearch-stop" ).val();
  var url = '<?php echo $urlLineCommand; ?>&start='+start+'&stop='+end;
  // alert ("x");
  $.getJSON(url).done(function(data){
      var chart1 = $("#my-chart2").highcharts();
      $(chart1.series).each(function(){
          this.remove();
      });

      //add new data
      //chart1.addSeries(data);

      for (indez = 0; indez < data.data.length; ++indez) {
          console.log(data.data[indez]);
          chart1.addSeries(
              data.data[indez]
          );
      }
      console.log(data.xaxis);
      chart1.setTitle({text:data.title});
      chart1.xAxis[0].setCategories(data.xaxis);  
      chart1.yAxis[0].setTitle(data.yaxis);  
  })

  .fail(function(){
      console.log('error');
  });
}
function addDashboard4(){
    var start          = $( "#dashboardsearch-start" ).val();
    var end            = $( "#dashboardsearch-stop" ).val();
  var url = '<?php echo $urlLineCommand2; ?>&start='+start+'&stop='+end;
  // alert ("x");
  $.getJSON(url).done(function(data){
      var chart1 = $("#my-chart3").highcharts();
      $(chart1.series).each(function(){
          this.remove();
      });

      //add new data
      //chart1.addSeries(data);

      for (indez = 0; indez < data.data.length; ++indez) {
          console.log(data.data[indez]);
          chart1.addSeries(
              data.data[indez]
          );
      }
      console.log(data.xaxis);
      chart1.setTitle({text:data.title});
      chart1.xAxis[0].setCategories(data.xaxis);  
      chart1.yAxis[0].setTitle(data.yaxis);  
  })

  .fail(function(){
      console.log('error');
  });
}
function addDashboard5(){
    var start          = $( "#dashboardsearch-start" ).val();
    var end            = $( "#dashboardsearch-stop" ).val();
  var url = '<?php echo $urlLineCommand3; ?>&start='+start+'&stop='+end;
  // alert ("x");
  $.getJSON(url).done(function(data){
      var chart1 = $("#my-chart4").highcharts();
      $(chart1.series).each(function(){
          this.remove();
      });
      console.log(data.xaxis);
      chart1.addSeries(data.data);
      chart1.setTitle({text:data.title});
      // chart1.xAxis[0].setCategories(data.xaxis);  
      chart1.yAxis[0].setTitle(data.yaxis);  
  })

  .fail(function(){
      console.log('error');
  });
}
function addDashboard6(){
    var start          = $( "#dashboardsearch-start" ).val();
    var end            = $( "#dashboardsearch-stop" ).val();
  var url = '<?php echo $urlLineCommand4; ?>&start='+start+'&stop='+end;
  // alert ("x");
  $.getJSON(url).done(function(data){
      var chart1 = $("#my-chart5").highcharts();
      $(chart1.series).each(function(){
          this.remove();
      });
      console.log(data.xaxis);
      chart1.addSeries(data.data);
      chart1.setTitle({text:data.title});
      // chart1.xAxis[0].setCategories(data.xaxis);  
      chart1.yAxis[0].setTitle(data.yaxis);  
  })

  .fail(function(){
      console.log('error');
  });
}
</script>