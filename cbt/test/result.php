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

        var result = localStorage.getItem('result');
        console.log(JSON.parse(result))
    </script>
  </head>
  <body>
    <a class='btn btn-primary' href='/cbt'>Take New Test</a>
    <div id="piechart" class='fluid-container'></div>
<?php
$total_percentage = 100;

$unanswered_percentage = function(){
    global $total;
    global $answered;

    $unanswered = $total - $answered;
    return $unanswered / $total * 100;
};

$score_percentage = function(){
    global $total;
    global $score;

    return $score / $total * 100;
};

$incorrect_percentage = function(){
    global $total;
    global $incorrect;

    return $incorrect / $total * 100;
};

    $progress = <<< HTML
        <div class='fluid-container card'>
            <div class='card-body d-flex flex-column gap-2'>
                <label>
                    T. Questions: <progress max=$total value=$total></progress> $total
                </label>
                <label>
                    T. Unanswered: <progress max=$total_percentage value={$unanswered_percentage()}></progress> {$unanswered_percentage()}%
                </label>
                <label>
                    T. correct: <progress max=$total_percentage value={$score_percentage()}></progress> {$score_percentage()}%
                </label>
                <label>
                    Total Incorrect: <progress max=$total_percentage value={$incorrect_percentage()}></progress> {$incorrect_percentage()}%
                </label>
            </div>
        </div>
    HTML;

    echo $progress;

?>
<div>
<div class='bg-body-tertiary p-3'>
    <h3>Quiz Overview</h3>
    <b>Scroll or click on the buttons to see corrections to the questions</b>
    <br>
    <em>Remember that failure is not fatal, Success is not final. It is the courage to continue that counts...</em>
    <div class='m-3' id="pagination"></div>
    <div id="question" class='card card-body'></div>
    <div class='d-flex flex-column gap-2' id="option"></div>
</div>
<script>
function pagination(questions){
    el = $('#pagination'); el.empty();

    $.each(questions, (index, value)=>{
        el.append(`<a href='#${++index}' class='btn m-1 ${value.selected != value.correct ? 'btn-danger' : 'btn-success'}'>${index}</a>`)
    })
}

function renderQuestionsComplete(){
    //slicing off question and getting element placement node
    var questions = localStorage.getItem('result');
    var questions = JSON.parse(questions)
    console.log(questions);

    qElement = $('#question'); qElement.empty();
    optElement = $('#option'); optElement.empty();
    pagination(questions);

    $.each(questions, (index, ques) => {
        qElement.append(`<div id='${++index}' class='mt-3 danger'><b>Question ${index}(<small>Read The questions carefully and select your answer</small>)</b><div class='my-2'>${ques.question}</div></div>`);
        qElement.append(`<div class='row g-2 ms-3'>
            <label style="color: ${ques['correct'] == 'A' ? 'green' : (ques['selected'] != ques['correct']) && (ques['selected'] == 'A') ? 'red' : 'black'}"><input class='form-radio me-2' type='radio' name='option' id='A' ${ques['selected'] == 'A' ? 'checked' : ''} disabled>A. ${ques.option.A}</label>
            <label style="color: ${ques['correct'] == 'B' ? 'green' : (ques['selected'] != ques['correct']) && (ques['selected'] == 'B') ? 'red' : 'black'}"><input class='form-radio me-2' type='radio' name='option' id='B' ${ques['selected'] == 'B' ? 'checked' : ''} disabled>B. ${ques.option.B}</label>
            <label style="color: ${ques['correct'] == 'C' ? 'green' : (ques['selected'] != ques['correct']) && (ques['selected'] == 'C') ? 'red' : 'black'}"><input class='form-radio me-2' type='radio' name='option' id='C' ${ques['selected'] == 'C' ? 'checked' : ''} disabled>C. ${ques.option.C}</label>
            <label style="color: ${ques['correct'] == 'D' ? 'green' : (ques['selected'] != ques['correct']) && (ques['selected'] == 'D') ? 'red' : 'black'}"><input class='form-radio me-2' type='radio' name='option' id='D' ${ques['selected'] == 'D' ? 'checked=checked' : ''} disabled>D. ${ques.option.D}</label>
        </div>
        <div>Selected Option: ${ques['selected']}</div><div>Correct Option: ${ques['correct']}</div>`);

    })
}

renderQuestionsComplete();

</script>
  </body>
</html>
<?php
    html_footer();
?>
