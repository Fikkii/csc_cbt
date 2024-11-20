var currentIndex = 0;
var questions = [];

function getQuestions(total, time){
    timer(time)
    $.ajax({
        url: `/api.php?total=${total}&category=${category}`,
        success: function(res){
            questions = res;
            renderQuestions(currentIndex);
        },
        error: function(){
            console.log('server could not be acessed at the moment, Try again later')
        }
    })
}

function timer(minutes){
    var minutes = minutes;
    var seconds = 0;

    interval = setInterval(() => {
        if(seconds == 0){
            --minutes;
            seconds = 59;
        }

        $el = $('#timer'); $el.empty()

        $el.append(`${minutes < 10 ? '0'+minutes : minutes}:${seconds < 10 ? '0'+seconds : seconds}`);

        --seconds;
        if(seconds == 0 & minutes == 0){
            showResult();
            clearInterval(interval)
        }
    }, 1000)

    }


function renderQuestions(index){
    //slicing off question and getting element placement node
    if(index >= questions.length){
        index=0;
    }

    if(index <= 0){
        $('#prev').attr('disabled', 'true')
    }else{
        $('#prev').removeAttr('disabled')
    }

    ques = questions[index];
    qElement = $('#question'); qElement.empty();
    optElement = $('#option'); optElement.empty();

    currentIndex = index;

    //rendering questions with options on screen
    qElement.append(`<div class='mt-3'><b>Question ${++index}(<small>Read The questions carefully and select your question</small>)</b><div class='my-2'>${ques.question}</div></div>`);
    optElement.append(`<div class='row g-2 ms-3'>
        <label><input class='form-radio me-2' type='radio' name='option' id='A' ${ques['selected'] == 'A' ? 'checked' : ''} onclick=selectOpt(this)>${ques.option.A}</label>
        <label><input class='form-radio me-2' type='radio' name='option' id='B' ${ques['selected'] == 'B' ? 'checked' : ''} onclick=selectOpt(this)>${ques.option.B}</label>
        <label><input class='form-radio me-2' type='radio' name='option' id='C' ${ques['selected'] == 'C' ? 'checked' : ''} onclick=selectOpt(this)>${ques.option.C}</label>
        <label><input class='form-radio me-2' type='radio' name='option' id='D' ${ques['selected'] == 'D' ? 'checked' : ''} onclick=selectOpt(this)>${ques.option.D}</label>
    </div>`);

    pagination()
}

function selectOpt(e){
    selected = e.id;

    ques = questions[currentIndex];
    ques['selected'] = selected;
    console.log(ques)
}

function pagination(){
    el = $('#pagination'); el.empty();

    $.each(questions, (index, value)=>{
        el.append(`<button class='btn m-1 ${value.selected ? 'btn-success' : 'btn-light'}'  onclick='renderQuestions(${index})'>${++index}</button>`)
    })
}

function next(){
    renderQuestions(++currentIndex)
}

function prev(){
    renderQuestions(--currentIndex)
}

function showResult(){
    var score = 0;
    var attempt = 0;
    $.each(questions, (index, value) => {
        if(value.selected == value.correct){
            ++score
        }
        if(value.correct){
            ++attempt
        }
    })

    total = questions.length;
    console.log(question)
    console.log(score)
    window.location.href = './result.php?score='+score+'&answered='+attempt;
};
