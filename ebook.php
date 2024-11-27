<?php
include 'function.php';

html_header('E-Book');

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$conn = connect();

$limit = 24;
$offset = ($limit * $page) - $limit;

$result = $conn->query("SELECT link,thumbnail FROM pdf LIMIT $limit OFFSET $offset");

if($result->num_rows > 0){
    pagination();
    $template = "<h2>Download Necessary PDFs</h2>";
    $template .= "<div class='fluid-container row g-3'>";
    while($row = $result->fetch_assoc()){
        $link = $row['link'];
        $thumbnail = $row['thumbnail'];
        $title = substr($link, 6);

        $template .= <<<HTML
            <div class="col col-sm-6 col-md-4">
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

    }
    $template .= "</div>";
    echo $template;
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
html_footer();
?>
