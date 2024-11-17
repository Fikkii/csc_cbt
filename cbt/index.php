<?php
include $_SERVER['DOCUMENT_ROOT'].'/function.php';

$category = isset($_GET['category']) ? $_GET['category'] : '';
$time = isset($_GET['time']) ? $_GET['time'] : '';
$total = isset($_GET['total']) ? $_GET['total'] : '';

if($category && $time && $total){
    session_start();
    $_SESSION['category'] = $category;
    $_SESSION['time'] = $time;
    $_SESSION['total'] = $total;

    header('location: ./jamb');
}

$conn = connect();

$category = $conn->query("SELECT id, course FROM category");

html_header("CBT");
?>
    <body>
        <form class='d-flex flex-column gap-2' method='GET' action=<?php echo $_SERVER['PHP_SELF'] ?>>
            <div class='card m-sm-auto p-3 d-flex flex-column gap-3'>
                <div class='input-group'>
                    <label class='input-group-text'>COURSE</label>
                    <select class='form-select' name="category" id="category">
                    <?php
                    while(list($id, $course) = $category->fetch_array()){
                        echo "<option value='$id'>$course</option>";
                    }

                    ?>
                    </select>
                </div>
                <div class='input-group'>
                    <label class='input-group-text' id='total'>Total Questions</label>
                        <select class='form-select' name="total" id="total">
                            <option value="20">20</option>
                            <option value="40">40</option>
                            <option value="60">60</option>
                        </select>
                </div>
                <div class='input-group'>
                    <label  class='input-group-text' id='total'>Time(Minutes)</label>
                        <input class='form-control' type="number" value='20' name="time" id="time" min=1 max='50'/>
                </div>
            </div>
            <div class='card m-sm-auto p-3 d-flex flex-column gap-3'>
                <div class='input-group'>
                    <label class='input-group-text' id='mode'>Mode</label>
                    <select class='form-select' name="mode" id="mode" size="1">
                        <option value="practice">practice</option>
                        <option value="study">study</option>
                        </option>
                    </select>
                    <input class='btn btn-primary btn-lg' type="submit" value="Start Quiz" />
                </div>
            </div>
        </form>
    </body>
</html>
