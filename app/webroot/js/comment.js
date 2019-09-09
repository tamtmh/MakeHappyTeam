$(document).ready(function() {
    $("#btnCmt").click(function(){
        sendComment();
    });

    // button translate report
    $(".btnEN").click(function(){
        var lang = "en";
        var tag = $(this).parent().parent();
        var text = tag.children(".viewanswer").html();
        translateReport(tag, lang, text);
    });

    $(".btnVN").click(function(){
        var lang = "vi";
        var tag = $(this).parent().parent();
        var text = tag.children(".viewanswer").html();
        translateReport(tag, lang, text);
    });

    $(".btnJP").click(function(){
        var lang = "ja";
        var tag = $(this).parent().parent();
        var text = tag.children(".viewanswer").html();
        translateReport(tag, lang, text);
    });

    // button translate comment
    $("#list-comment-box").on('click','button.cmtEN', function(){
        var lang = "en";
        var tag = $(this).parent().parent().find(".comment-content");
        var text = tag.text();
        translateComment(tag, lang, text);
    });

    $("#list-comment-box").on('click','button.cmtVN', function(){
        var lang = "vi";
        var tag = $(this).parent().parent().find(".comment-content");
        var text = tag.text();
        translateComment(tag, lang, text);
    });

    $("#list-comment-box").on('click','button.cmtJP', function(){
        var lang = "ja";
        var tag = $(this).parent().parent().find(".comment-content");
        var text = tag.text();
        translateComment(tag, lang, text);
    });

    $('.contentCmt').keypress(function(event){

        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
            sendComment();
        }
    });

    // $('.contentCmt').keyup(function(e){
    //     if(e.keyCode == 13)
    //     {
    //         $(this).trigger("enterKey");
    //     }
    // });
});

var getContentDetail = function () {
    var listFields = ['Problem', 'How_did_it_affect_to_work?', 'How_did_it_affect_to_work?', 'How_do_you_think_how_to_fix_the_problem_and_affect?', 'What_do_you_want_leader_help_you?'];
    var question = [];
    $.each(listFields, function( index, value ) {
        var aaa = $('.How_did_it_affect_to_work').text();
        alert(aaa);
        var objQuestion = {};
        objQuestion[value] = $('.'+ value).text();
        question.push(objQuestion);
        var objAnswer = {};
        objAnswer[value + '_ans'] = $(value + '_ans').text();
        question.push(objAnswer);
    });
    return question;
}

var translateReport = function (tag, lang, text) {
    $.ajax({
            type: 'post',
            url: '/reports/translateReport/',
            data : {
                "to_lan" : lang,
                "text" : text
            },
            success: function(response){
                tag.children(".viewanswer").css("display", "none");
                tag.children(".result_translate").css("display", "block");
                tag.children(".result_translate").html(response);
            }
    });
}

var translateComment = function (tag, lang, text) {
    $.ajax({
            type: 'post',
            url: '/reports/translateReport/',
            data : {
                "to_lan" : lang,
                "text" : text
            },
            success: function(response){
                tag.text(response);
            }
        });
}

// function process(e) {
//     var code = (e.keyCode ? e.keyCode : e.which);
//     if (code == 13) { //Enter keycode
//         sendComment();
//     }
// }

var sendComment = function(){
    var comment = $('.contentCmt').val();
    var reportID = $('#btnCmt').attr('data');
    var userID = $('#btnCmt').attr('data-user');
    var teamID = $('#btnCmt').attr('teamID');
    $.ajax({
        type:"POST",
        url: "/comments/addComment",
        data : {
            "content" : comment,
            "report_id" : reportID,
            "user_report" : userID,
            "team_id" : teamID
        },
        success: function (data_success) {
            $('.contentCmt').val('');
            loadListComment();
        }
    });
}
var loadListComment = function(){
    var reportID = $('#btnCmt').attr('data');
    $.ajax({
            type: 'post',
            url: '/comments/getListComment/' + reportID,
            dataType: 'html',
            success: function(response){
                $('body #list-comment-box').html(response);
            }
        }
    )
}