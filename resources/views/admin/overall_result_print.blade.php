  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
       <div class="card">
        <div class="card-header">
           <h3 class="card-title">Name : {{ $student_name }}</h3>
           <h3 class="card-title">NIM : {{ $student_nim }}</h3>
           <h3 class="card-title">Class : {{ $student_class }}</h3>
        </div>
         <!-- /.card-header -->
        <div class="card-body">
           <div class="container">
               @isset($lessons_completed)

               <div class="row mt-5">
                <div class="col">
                  <h5 class="ml-5"># {{ $selected_course->course_name }}</h5>
                </div>
                <div class="col">
                  @if ($avg_speed >= $selected_course->min_speed_a && $avg_accuracy >= $selected_course->min_accuracy_a)
                    <h5 class="ml-5">Score : A</h5>
                  @elseif($avg_speed >= $selected_course->min_speed_b && $avg_accuracy >= $selected_course->min_accuracy_b)
                    <h5 class="ml-5">Score : B</h5>
                  @elseif($avg_speed >= $selected_course->min_speed_c && $avg_accuracy >= $selected_course->min_accuracy_c)
                    <h5 class="ml-5">Score : C</h5>
                  @else
                    <h5 class="ml-5">Score : N/A</h5>
                  @endif
                </div>
               </div>

               <table style="width:100%">
                 <tr>
                   <th>Lesson</th>
                   <th>Speed</th>
                   <th>Accuracy</th>
                   <th>Slowdown</th>
                   <th>Time</th>
                   <th>Duration</th>
                   <th>Date</th>
                  </tr>
                  @foreach ($all_lesson_result as $lesson)
                      <tr>
                        <td>{{ App\Models\Lesson::where('lesson_id', $lesson->lesson_id)->first()->lesson_name }}</td>
                        <td>{{ $lesson->wpm }} WPM</td>
                        <td>{{ $lesson->accuracy }} %</td>
                        <td>{{ $lesson->slowdown }} %</td>
                        <td>{{ $lesson->minutes }} Minutes</td>
                        <td>{{ $lesson->duration }} Minutes</td>
                        <td>{{ $lesson->updated_at }}</td>
                      </tr>
                  @endforeach
                  </table>
                  <br>
                  <br>

                <div class="row-result row mt-4">
                  <div class="col">
                  <label for="">Total</label>
                    <ul>
                        <li>Speed : {{ $avg_speed }} WPM</li>
                        <li>Accuracy : {{ $avg_accuracy }}%</li>
                        <li>Slowdown : {{ $avg_slowdown }}%</li>
                        <li>Error Words : {{ $error_words }} Words</li>
                    </ul>
                </div>
                <div class="col">
                  <ul>
                    <li>Lesson Completed : {{ $lessons_completed }}</li>
                    <li>Time Spend : {{ $time_spend }} Minutes</li>
                    <li>Words Typed : {{ $words_typed }} Words</li>
                  </ul>
                </div>
              </div>
              @endisset
           </div>
        </div>
         <!-- /.card-body -->
       <!-- /.card -->
      </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  </div>
<!-- /.content -->

<style>
  table, th, td {
    border:1px solid black;
  }
</style>


<script src="{{ asset('admin_lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin_lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
<script src="{{ asset('admin_lte/plugins/chart.js/Chart.min.js') }} "></script>
<script>
    $(function() {
  'use strict';
  var data = {
    labels: ['All Lessons', 'Lessons Completed', 'Speed Average', 'Accuracy Average', 'Error Words', 'Time Spend', 'Words Typed'],
    datasets: [{
      label: '# <?= isset($selected_course) ? $selected_course->course_name : ''; ?>',
      data: [
        <?= isset($lessons_count) ? $lessons_count : 0; ?>, 
        <?= isset($lessons_completed) ? $lessons_completed : 0; ?>, 
        <?= isset($avg_speed) ? $avg_speed : 0; ?>, 
        <?= isset($avg_accuracy) ? $avg_accuracy : 0; ?>, 
        <?= isset($error_words) ? $error_words : 0; ?>, 
        <?= isset($time_spend) ? $time_spend : 0; ?>, 
        <?= isset($words_typed) ? $words_typed : 0; ?>
      ],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      // borderWidth: 1,
      fill: false,
      borderColor: 'rgb(75, 192, 192)',
      tension: 0.1,
      // showLine: true
    }]
  };
  var multiLineData = {
    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    datasets: [{
        label: 'Dataset 1',
        data: [12, 19, 3, 5, 2, 3],
        borderColor: [
          '#587ce4'
        ],
        borderWidth: 2,
        fill: false
      },
      {
        label: 'Dataset 2',
        data: [5, 23, 7, 12, 42, 23],
        borderColor: [
          '#ede190'
        ],
        borderWidth: 2,
        fill: false
      },
      {
        label: 'Dataset 3',
        data: [15, 10, 21, 32, 12, 33],
        borderColor: [
          '#f44252'
        ],
        borderWidth: 2,
        fill: false
      }
    ]
  };
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };
  var doughnutPieData = {
    datasets: [{
      data: [45, 100],
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
      'Accuracy',
      'Percent',
    ]
  };
  var doughnutPieOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };
  var areaData = {
    labels: ['All Lessons', 'Lessons Completed', 'Speed Average', 'Accuracy Average', 'Error Words', 'Time Spend', 'Words Typed'],
    datasets: [{
      label: '# <?= isset($selected_course) ? $selected_course->course_name : '' ?>',
      data: [
        <?= isset($lessons_count) ? $lessons_count : 0; ?>, 
        <?= isset($lessons_completed) ? $lessons_completed : 0; ?>, 
        <?= isset($avg_speed) ? $avg_speed : 0; ?>, 
        <?= isset($avg_accuracy) ? $avg_accuracy : 0; ?>, 
        <?= isset($error_words) ? $error_words : 0; ?>, 
        <?= isset($time_spend) ? $time_spend : 0; ?>, 
        <?= isset($words_typed) ? $words_typed : 0; ?>
      ],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: true, // 3: no fill
    }]
  };

  var areaOptions = {
    plugins: {
      filler: {
        propagate: true
      }
    }
  }

  var multiAreaData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
        label: 'Facebook',
        data: [8, 11, 13, 15, 12, 13, 16, 15, 13, 19, 11, 14],
        borderColor: ['rgba(255, 99, 132, 0.5)'],
        backgroundColor: ['rgba(255, 99, 132, 0.5)'],
        borderWidth: 1,
        fill: true
      },
      {
        label: 'Twitter',
        data: [7, 17, 12, 16, 14, 18, 16, 12, 15, 11, 13, 9],
        borderColor: ['rgba(54, 162, 235, 0.5)'],
        backgroundColor: ['rgba(54, 162, 235, 0.5)'],
        borderWidth: 1,
        fill: true
      },
      {
        label: 'Linkedin',
        data: [6, 14, 16, 20, 12, 18, 15, 12, 17, 19, 15, 11],
        borderColor: ['rgba(255, 206, 86, 0.5)'],
        backgroundColor: ['rgba(255, 206, 86, 0.5)'],
        borderWidth: 1,
        fill: true
      }
    ]
  };

  var multiAreaOptions = {
    plugins: {
      filler: {
        propagate: true
      }
    },
    elements: {
      point: {
        radius: 0
      }
    },
    scales: {
      xAxes: [{
        gridLines: {
          display: false
        }
      }],
      yAxes: [{
        gridLines: {
          display: false
        }
      }]
    }
  }

  var scatterChartData = {
    datasets: [{
        label: 'First Dataset',
        data: [{
            x: -10,
            y: 0
          },
          {
            x: 0,
            y: 3
          },
          {
            x: -25,
            y: 5
          },
          {
            x: 40,
            y: 5
          }
        ],
        backgroundColor: [
          'rgba(255, 99, 132, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)'
        ],
        borderWidth: 1
      },
      {
        label: 'Second Dataset',
        data: [{
            x: 10,
            y: 5
          },
          {
            x: 20,
            y: -30
          },
          {
            x: -25,
            y: 15
          },
          {
            x: -10,
            y: 5
          }
        ],
        backgroundColor: [
          'rgba(54, 162, 235, 0.2)',
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
        ],
        borderWidth: 1
      }
    ]
  }

  var scatterChartOptions = {
    scales: {
      xAxes: [{
        type: 'linear',
        position: 'bottom'
      }]
    }
  }
  // Get context with jQuery - using jQuery's .get() method.
  if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
  }

  if ($("#lineChart").length) {
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: data,
      options: options
    });
  }

  if ($("#linechart-multi").length) {
    var multiLineCanvas = $("#linechart-multi").get(0).getContext("2d");
    var lineChart = new Chart(multiLineCanvas, {
      type: 'line',
      data: multiLineData,
      options: options
    });
  }

  if ($("#areachart-multi").length) {
    var multiAreaCanvas = $("#areachart-multi").get(0).getContext("2d");
    var multiAreaChart = new Chart(multiAreaCanvas, {
      type: 'line',
      data: multiAreaData,
      options: multiAreaOptions
    });
  }

  if ($("#doughnutChart").length) {
    var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }

  if ($("#pieChart").length) {
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }

  if ($("#areaChart").length) {
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    var areaChart = new Chart(areaChartCanvas, {
      type: 'line',
      data: areaData,
      options: areaOptions
    });
  }

  if ($("#scatterChart").length) {
    var scatterChartCanvas = $("#scatterChart").get(0).getContext("2d");
    var scatterChart = new Chart(scatterChartCanvas, {
      type: 'scatter',
      data: scatterChartData,
      options: scatterChartOptions
    });
  }

  if ($("#browserTrafficChart").length) {
    var doughnutChartCanvas = $("#browserTrafficChart").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: browserTrafficData,
      options: doughnutPieOptions
    });
  }
})
</script>