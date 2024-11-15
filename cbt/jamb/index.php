<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="../assets/jquery.min.js"></script>
        <script src="../assets/js.cookie.min.js"></script>
        <script src="../assets/script.js"></script>
        <link rel="stylesheet" href="/assets/simple.css">
        <link rel="stylesheet" href="/assets/style.css">
        <title>CBT Quiz</title>
    </head>
    <body>
        <div class='grid-container'>
            <div>
                <span class='timer-group'>
                    Time-Remaining
                    <span id="timer">00:00</span>
                </span>
                <button  class="right" onclick='showResult()'>Submit</button>
            </div>
            <div id="question"></div>
            <div id="option"></div>
            <div id="controls">
                <button id='prev' onclick='prev()'>Prev</button>
                <button  id='next' onclick='next()'>Next</button>
            </div>
            <div id="pagination"></div>
        </div>
<?php
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
    </body>
</html>
