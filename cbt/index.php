<?php
include '../db.php';

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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="./assets/jquery.min.js"></script>
        <script src="./assets/js.cookie.min.js"></script>
        <script src="./assets/script.js"></script>
        <link rel="stylesheet" href="/assets/simple.css">
        <link rel="stylesheet" href="/assets/style.css">
        <title>CBT Quiz</title>
    </head>
    <body>
        <div class='grid-container'>
        <form method='GET' action=<?php echo $_SERVER['PHP_SELF'] ?>>
                <select name="category" id="category" size="1">
<?php
while(list($id, $course) = $category->fetch_array()){
    echo "<option value='$id'>$course</option>";
}

?>
</select>
                <label id='total'>
                    <span>Total Questions:</span>
                    <select name="total" id="total" size="1">
                        <option value="20">20</option>
                        <option value="40">40</option>
                        <option value="60">60</option>
                    </select>
                </label>
                <label id='total'>
                    <span>Time(Minutes):</span>
                    <input type="number" value='20' name="time" id="time" min=1 max='50'/>
                </label>
                </label>
                <label id='mode'>
                    <span>Mode</span>
                    <select name="mode" id="mode" size="1">
                        <option value="practice">practice</option>
                        <option value="study">study</option>
                        </option>
                    </select>
                </label>
                <input type="submit" value="Start Quiz" />
            </form>
        </div>
    </body>
</html>
