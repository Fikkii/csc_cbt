<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    </head>
    <body style='height: 100vh;'>
        <div style='background-color: #c3a75e' class="text-white h-50 d-flex justify-content-center align-items-center gap-2 flex-column text-center p-3"> 
            <a href="./admin" class="align-self-end btn btn-secondary">
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
            <b class="mt-4">DOWNLOAD PDF REQUIRED FOR COMPUTER SCIENCE STUDENTS...</b>
            <button class="btn dropdown-toggle" data-bs-toggle='collapse' data-bs-target='#announcement'>Learn More</button>
            <div id="announcement" class="collapse">
                <p class='px-5'>Note that this is still a work in progress, A lot needs to be done and you can be a part of it. Contact us @<a href="wa.me/+2348132332408" target="_blank">whatsapp</a>to be a comtributor</p>
            </div>
        </div>
        <div class="button-group d-flex mt-2 gap-2 justify-content-center">
            <a href="./" class="btn btn-secondary d-block w-25"><i class="me-3" data-feather='monitor'></i>CBT</a>
            <a href="./ebook.php" class="btn btn-secondary d-block w-25 active"><i class="me-3" data-feather='book'></i>EBOOKs</a>
        </div>
        <div class="container">
            <div class="row p-4 g-5">
<?php
include 'db.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$conn = connect();

$limit = 24;
$offset = ($limit * $page) - $limit;

$result = $conn->query("SELECT link,thumbnail FROM pdf LIMIT $limit OFFSET $offset");

if($result->num_rows > 0){
    pagination();
    while($row = $result->fetch_assoc()){
        $link = $row['link'];
        $thumbnail = $row['thumbnail'];
        $title = substr($link, 6);

        $template = <<<HTML
            <div class="col col-sm-6">
                <div class="card">
                    <img src="$thumbnail" height=200 alt='image' class="card-img-top object-fit-cover">
                    <div class="card-header">
                        <div>$title</div>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <a class="btn btn-light border"><i data-feather="star"></i></i></a>
                        <a href='$link' class="btn btn-light border"><i data-feather="download"></i></i></a>
                    </div>
                </div>
            </div>
HTML;

        echo $template;
    }
    pagination();

}

function pagination(){
    global $page;
    $nextPage = $page+1;
    $prevPage = $page-1;

    //Pagination logic goes here...
    $pagination = <<<HTML
        <ul class='pagination d-flex justify-content-between pagination-lg'>
            <li class='page-item'>
                <a class='page-link' href='?page=$prevPage'>Prev Page</a>
            </li>
            <li class='page-item'>
                <a class='page-link' href='?page=$nextPage'>Next Page</a>
            </li>
        </ul>
HTML;

    echo $pagination;
}

?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
feather.replace()
    </script>
    </body>
</html>
