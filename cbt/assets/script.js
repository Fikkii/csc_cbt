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
    qElement.append(`<div class='quiz-info'><b>Question ${++index}(<small>Read The questions carefully and select your question</small>)</b><div>${ques.question}</div></div>`);
    optElement.append(`<label><input type='radio' name='option' id='A' ${ques['selected'] == 'A' ? 'checked' : ''} onclick=selectOpt(this)>${ques.option.A}</input></label>`);
    optElement.append(`<label><input type='radio' name='option'  ${ques['selected'] == 'B' ? 'checked' : ''}  id='B' onclick=selectOpt(this)>${ques.option.B}</input></label>`);
    optElement.append(`<label><input type='radio'  ${ques['selected'] == 'C' ? 'checked' : ''}  name='option' id='C' onclick=selectOpt(this)>${ques.option.C}</input></label>`);
    optElement.append(`<label><input type='radio' name='option'  ${ques['selected'] == 'D' ? 'checked' : ''}  id='D' onclick=selectOpt(this)>${ques.option.D}</input></label>`);

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
        el.append(`<button ${value.selected ? 'class="selected"' : ''} onclick='renderQuestions(${index})'>${++index}</button>`)
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
    $.each(questions, (index, value) => {
        if(value.selected == value.correct){
            ++score
        }
    })

    total = questions.length;

    percentage = Math.round((score/total) * 100)
    alert(percentage)
}
