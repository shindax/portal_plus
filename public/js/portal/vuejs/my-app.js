/*
 * author: vvdanilevskiy@vn.rosneft.ru
 * date: 27.09.2018
 * Vue.js часть скрипта для викторины дня кодекса НК «Роснефть»
 */


window.onbeforeunload = function() {
    return "Did you save your stuff?"
}

var questions = [];
$.getJSON('/data/json/quizData.json', function (data) {
    $.each(data.questions, function (key, val) {
        val.userAnswerId = 0;
        questions.push(val);
    });
});

var userData = {
    quizQuestions: questions,
    activeQuestion: 1,
    finished: false,
    started: false,
    userTimer: 0,
    quizResult: null,
    userOk: false,

    counter: 0,
    timer: null,

    rightCount: 0
};

function tictac(){
    counter++;
}

var myApp = new Vue({
        delimiters: ['${', '}'],
        el: '#my-app',
        data: userData,
        methods: {
            checkUser: function (username) {

                var vm = this;
                $.get("index.php", {
                        task: "corporateCode",
                        f: "checkUser",
                        login: decodeURI(username),
                        ajax: 1
                    }, function (json) {
                        data = JSON.parse(json);
                        vm.userOk = data.checkUser;
                    }
                );
                return vm.userOk;
            },
            stepNext: function (q, username) {

                $.each(q.answers, function (key, val) {
                    if ((val.answerId == q.userAnswerId) && val.right == true) {
                        q.answerRight = true;
                        return false;
                    }
                    q.answerRight = false;
                });

                $.get("index.php", {
                        task: "corporateCode",
                        f: "setAnswer",
                        answer: JSON.stringify({
                            user: decodeURI(username),
                            type: 'answer',
                            questionId: q.questionId,
                            userAnswerId: q.userAnswerId,
                            answerRight: q.answerRight,
                            date: (new Date()).getTime()
                        }),
                        ajax: 1
                    },
                    function (json) {
                        data = JSON.parse(json);
                        console.log(data);
                    }
                );

                if (this.activeQuestion <= this.quizQuestions.length) this.activeQuestion++;
                if (this.activeQuestion == this.quizQuestions.length + 1) {
                    this.finished = true;
                    this.finishQuiz(username);
                }
            },
            stepPrev: function () {
                if (this.activeQuestion > 1) this.activeQuestion--;
            },
            checkForNext: function (q) {
                return (this.activeQuestion <= this.quizQuestions.length) && (q.userAnswerId != 0);
            },
            checkEnd: function () {
                return (this.activeQuestion == this.quizQuestions.length) && (q.userAnswerId != 0);
            },
            checkForEnd: function (n) {
                if ((this.activeQuestion == this.quizQuestions.length) && (q.userAnswerId != 0)) {
                    return true;
                }
            },
            finishQuiz: function (username)  {
                var em = this;

                $.each(this.quizQuestions, function (key, val) {
                    if (val.answerRight) {
                        em.rightCount++;
                    }
                });
                console.log(em.rightCount, this.quizQuestions.length);
                this.quizResult = "Правильных ответов: " + em.rightCount + "/" + this.quizQuestions.length;

                $.get("index.php", {
                        task: "corporateCode",
                        f: "setAnswer",
                        answer: JSON.stringify({
                            user: decodeURI(username),
                            type: 'result',
                            // questionId: q.questionId,
                            // userAnswerId: q.userAnswerId,
                            // answerRight: q.answerRight,
                            rightCount: em.rightCount,
                            date: (new Date()).getTime()
                        }),
                        ajax: 1
                    },
                    function (json) {
                        console.log(json);
                        data = JSON.parse(json);
                        console.log(data);
                    }
                );

            }
        }
    })
;





