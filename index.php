<?php
$course = isset($_GET['course']) ? $_GET['course'] : '';

if ($course){
    session_start();
    $_SESSION['course'] = $course;
    header("location: ./cbt");
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    </head>
    <body style='height: 100vh'>
        <div style='background-color: #c3a75e' class="text-white h-50 d-flex justify-content-center align-items-center gap-2 flex-column text-center p-3"> 
            <a href="./admin" class="align-self-end btn border border-3">
                <i data-feather='user'></i>
            </a>
            <div class="d-flex">
                <img src="./images/logo.png" height="65" alt="">
                <div class="text-start border-bottom">
                    <h5>200LVL</h5>
                    <h5>COMPUTER SCIENCE</h5>
                </div>

            </div>
            <div class="d-flex gap-2">
                <i data-feather='facebook'></i>
                <i data-feather='instagram'></i>
                <i data-feather='twitter'></i>
                <i data-feather='youtube'></i>
                <i data-feather='whatsapp'></i>

            </div>
            <b class="mt-4">CBT IS NOT A JOKE, START PRACTISING</b><button class="btn dropdown-toggle" data-bs-toggle='collapse' data-bs-target='#announcement'>Learn More</button>
            <div id="announcement" class="collapse">
                <p class='px-5'>If you notice any incosistency in the past questions or will like to add to it, message us @<a href="wa.me/+2348132332408" target="_blank">whatsapp</a> and stand a chance to be a CONTRIBUTOR</p>
            </div>
        </div>
        <div class="button-group d-flex mt-2 gap-2 justify-content-center">
            <a href="./" class="btn btn-secondary d-block w-25 active"><i class="me-3" data-feather='monitor'></i>CBT</a>
            <a href="./ebook.php" class="btn btn-secondary d-block w-25"><i class="me-3" data-feather='book'></i>EBOOKs</a>
        </div>
        <div class="container">
            <div class="row p-4 g-2">
<?php
include 'db.php';

$conn = connect();

$result = $conn->query("SELECT course FROM category");

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $course = strtoupper($row['course']);
        $template = <<<HTML
                <div class="col-6 col-sm-4">
                    <div class="card">
                        <div style='background-color: #c3a75e; height: 10px;' ></div>
                        <div class="card-body">
                            <div class="card-title"><b>COURSE: </b>$course</div>
                            <div class="card-title"><b>TITLE: </b>---</div>
                            <a href="?course=csc211" class="btn btn-light border border-4 w-100 mt-2">Start</a>
                        </div>
                    </div>
                </div>
        HTML;
        echo $template;
    }
}

$result = $conn->query("SELECT link,thumbnail FROM pdf");

?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script>
            feather.replace()
        </script>
    </body>
</html>
