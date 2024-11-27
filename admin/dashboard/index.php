<?php
include $_SERVER['DOCUMENT_ROOT'].'/function.php';

session_start();

if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION);
    header('location: /');
}

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    header('location: ../index.php');
}

$conn = connect();

$category = $conn->query("SELECT id, course FROM category");

html_header('Dashboard Home');
?>


<div class='row text-bg-light mx-2 p-4 border rounded'>
    <div class='d-flex col-4 flex-column align-items-center'><i data-feather='file-plus'></i><small>questions</small></div>
    <div class='d-flex col-4 flex-column align-items-center'><i data-feather='tool'></i><small>users</small></div>
    <div class='d-flex col-4 flex-column align-items-center'><i data-feather='file-text'></i><small>pdfs</small></div>
</div>

<div class='card'>
    <div class='h4 px-4 py-2'>Services</div>
    <div class='row p-3 py-1 g-2'>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Questions</b></div>
                    <a href="question.php" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Category</b></div>
                    <a href="category.php" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>PDFs</b></div>
                    <a href="pdf.php" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card">
                <div style='background-color: #c3a75e; height: 10px;' ></div>
                <div class="card-body">
                    <div class="card-title"><b>Users</b></div>
                    <a href="user.php" class="btn btn-light border border-4 w-100 mt-2">Show</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
html_footer();
?>
