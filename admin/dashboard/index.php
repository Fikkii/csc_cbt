<?php
include '../../db.php';
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    header('location: ../index.php');
}

$conn = connect();

$category = $conn->query("SELECT id, course FROM category");
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body style='height: 100vh; background-color: #c3a75e' class="d-flex flex-column gap-3 p-5">
        <header class='navbar'>
            <h3>200LVL CSC</h3>
            <button class='navbar-toggler border-0'>
                <span class='navbar-toggler-icon' data-bs-toggle='offcanvas' data-bs-target='#offnav'></span>
            </button>
            <div id='offnav' class='offcanvas offcanvas-end'>
                <div class='offcanvas-header p-4 text-bg-warning'>
                    <h2>ADMIN DASHBOARD</h2>
                    <button class='btn-close' data-bs-dismiss='offcanvas'></button>
                </div>
                <div class='offcanvas-body' tabindex='-1'>
                    <ul class='navbar-nav px-2'>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='index.php'>Home</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='question.php'>questions</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='category.php'>category</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='pdf.php'>pdf</a></li>
                        <li class='nav-item border border-3 px-3'><a class='nav-link' href='user.php'>user</a></li>
                    </ul>
                </div>
                <div class='mb-5 d-flex justify-content-between'>
                    <a class='btn btn-secondary'>Change Password</a>
                    <a class='btn btn-secondary'>Password</a>
                </div>
            </div>
        </header>
        <form>
            <label>Fetch Questions</label>
            <div class="input-group">
            <div class="input-group-text">Course</div>
                <select class="form-select" name='course'>
                    <option value=''>course</option>
                </select>
                <input name='filterQuestion' class="form-control btn btn-success" type="submit">
            </div>
        </form>
        <table class="table table-hover">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Question</td>
                    <td>A</td>
                    <td>B</td>
                    <td>C</td>
                    <td>D</td>
                    <td>correct</td>
                </tr>
            </thead>
        </table>
        <ul class="pagination">
            <li class="page-item"><a class="page-link">a</a></li>
            <li class="page-item"><a class="page-link">a</a></li>
            <li class="page-item"><a class="page-link">a</a></li>
            <li class="page-item"><a class="page-link">a</a></li>
        </ul>
        <form>
            <div class="form-floating">
                <input type="text" id='question' class="form-control">
                <label for='question'>Question</label>
            </div>
            <h6 class="pt-4">Answers</h6>

            <div class="d-flex flex-column gap-2">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="A">
                    <label class="form-check-label">A.</label>
                    <input type="text" name="A" class="form-control w-50"></input>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="B">
                    <label class="form-check-label">B.</label>
                    <input type="text" name="B" class="form-control w-50"></input>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="C">
                    <label class="form-check-label">C.</label>
                    <input type="text" name="C" class="form-control w-50"></input>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct" value="D">
                    <label class="form-check-label">D.</label>
                    <input type="text" name="D" class="form-control w-50"></input>
                </div>
            </div>
            <div class='d-flex justify-content-between gap-3 mt-3'>
                <div class='input-group w-50'>
                    <label class='input-group-text'>Select Course</label>
                    <select class='form-select w-25' name="category">
                    <?php
                    while(list($id, $course) = $category->fetch_array()){
                        echo "<option value='$id'>$course</option>";
                    }
                    ?>
                    </select>
                </div>
                <input type="submit" name="addQuestion" class="btn mt-2 btn-primary d-block" value="Add Question">

            </div>
        </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>

