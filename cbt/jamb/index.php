<?php
include '../../function.php';

html_header('Text in Progress');
session_start();

$category = $_SESSION['category'];
$time = $_SESSION['time'];
$total = $_SESSION['total'];

if ($category && $time && $total) {
    $init_script = <<< script
            <script>
                var total = $total;
                var time = $time;
                var category = $category;

                console.log(category);
                if (total && time){
                    getQuestions(total, time)
                }
            </script>
         script; 
    }else{
        header('location: ./cbt');
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="/assets/jquery.min.js"></script>
        <script src="/assets/js.cookie.min.js"></script>
        <script src="/assets/script.js"></script>
        <title>CBT Quiz</title>
    </head>
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
        <?php echo $init_script ?>
    </body>
</html>
