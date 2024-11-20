<?php
include '../../function.php';

html_header('Text in Progress');
session_start();

$category = $_SESSION['category'];
$time = $_SESSION['time'];
$total = $_SESSION['total'];

if ($category && $time && $total) {
    $init_script = <<< script
            <script defer>
                var total = $total;
                var time = $time;
                var category = $category;

                console.log(category);
                if (total && time){
                    getQuestions(total, time)
                }
            </script>
         script; 
        echo $init_script;
    }else{
        header('location: ./cbt');
    }
?>
    <body>
        <div class='grid-container'>
            <div class='d-flex justify-content-between'>
                <span class='h5'>
                    Time-Remaining:
                    <span id="timer">00:00</span>
                </span>
                <button  class="btn btn-danger" onclick='showResult()'>Submit</button>
            </div>
            <div id="question"></div>
            <div class='d-flex flex-column gap-2' id="option"></div>
            <div class='d-flex mt-2 justify-content-between' id="controls">
                <button class='btn btn-primary' id='prev' onclick='prev()'>Prev</button>
                <button class='btn btn-primary'  id='next' onclick='next()'>Next</button>
            </div>
            <div class='m-3' id="pagination"></div>
        </div>
    </body>
<?php
html_footer();
?>
