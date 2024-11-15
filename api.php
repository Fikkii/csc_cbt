<?php
include './db.php';

header('content-type: text/json');

$total = isset($_GET['total']) ? $_GET['total'] : 20;
$category = isset($_GET['category']) ? $_GET['category'] : 20;
$total = intval($total);

$conn = connect();
$offset = 10;

$questions = $conn->query("select id, question from questions where category_id=$category limit $total");
$datastructstruct = [];
$data = [];
$answers = [];
while($question = $questions->fetch_assoc()){
    $datastruct['question'] = $question['question'];
    $answersql = $conn->query("select * from answers where id='".$question['id']."'");
    while($answer = $answersql->fetch_assoc()){
        array_push($answers, $answer);
        switch ($answer['keyword']){
        case 'A':
            $datastruct['option']['A'] = $answer['answer'];
            break;
        case 'B':
            $datastruct['option']['B'] = $answer['answer'];
            break;
        case 'C':
            $datastruct['option']['C'] = $answer['answer'];
            break;
        case 'D';
            $datastruct['option']['D'] = $answer['answer'];
            break;
        }

        if($answer['correct']){
            $datastruct['correct'] = $answer['keyword'];
        }
    }
    array_push($data, $datastruct);
}
echo json_encode($data);
