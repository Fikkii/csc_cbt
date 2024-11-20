<?php
session_start();
include '../../function.php';

html_header('Result...', true);

$category = $_SESSION['category'];
$time = $_SESSION['time'];
$total = $_SESSION['total'];

$score = $_GET['score'];
$answered = $_GET['answered'];

$incorrect = ($total - $score);

?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          var correct = parseInt('<?php echo $score ?>');
        var incorrect = parseInt('<?php echo $incorrect ?>');

        var data = google.visualization.arrayToDataTable([
          ['aggregate', 'result'],
          ['correct', correct],
          ['incorrect', incorrect],
        ]);

        var options = {
          title: 'Result'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" class='fluid-container'></div>
<?php
    $unanswered = $total - $answered;
    $progress = <<< HTML
        <div class='fluid-container card'>
            <div class='card-body d-flex flex-column gap-2'>
                <label>
                    Total Questions: <progress max=$total value=$total></progress>
                </label>
                <label>
                    Total Answered: <progress max=$total value=$answered></progress>
                </label>
                <label>
                    Total Unanswered: <progress max=$total value=$unanswered></progress>
                </label>
                <label>
                    Total correct: <progress max=$total value=$score></progress>
                </label>
                <label>
                    Total Incorrect: <progress max=$total value=$incorrect></progress>
                </label>
            </div>
        </div>
    HTML;

    echo $progress;

?>
<div>
  </body>
</html>
<?php
    html_footer();
?>
