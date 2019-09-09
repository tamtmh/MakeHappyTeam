$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(".date-create-report").on('click', function () {
        $("#datepicker").datepicker('show');
    });
    $("#datepicker").datepicker({
        showOn: "button",
        buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: "yy-mm-dd",
        maxDate: "0",
        constrainInput: true
    });

    $('.datepicker').datepicker();

    $('input[name="dates"]').daterangepicker({
        maxDate: new Date(),
        locale: {
            format: 'YYYY/MM/DD'
        }
    });

    /* === Active Menu === */
    if (getUrlVars()['teamid'] === undefined) {
        $('.nameTeam ul li').first().addClass("active");
    }

    // fade out flash 'success' messages
    $('.flash-message-success').delay(10).hide('fade', 1500);

    // fade out flash 'error' messages
    $('.flash-message-error').delay(10).hide('fade', 1500);

    // sent report by ajax
    sentReport();

    /* === select date in leader/team === */
    $('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
        getReport();
    });

    /* === select member in team (Leader) === */
    $("#member-in-team").on("change", function() {
        getReport();
    });

    ajaxPagination('#lead-list-report');

    //leader send request
    $("#lead-list-report").on('click', 'button.btnRequest', function () {
        var url = $(this);
        sendNotification(url);
    });

    /* === Change Status for Notification === */
    $('a#not-no-read').on('click', function () {
        changeStatusNotification();
    });

    $('ul#list-notification li').on('click', function () {
        var id = $(this).attr('data-id');
        changeStatusNotification($(this), id);
    });

    $('table#tableNotifi td').on('click', function () {
        var id = $(this).attr('data-id');
        changeStatusNotification($(this), id);
    });



    /* === edit member in team === */
    $("#editMemberInTeamSuccess").hide();
    var dataMembers = [];
    $("#addAndEditMember").on('change','.role-team', function () {
        var role = $(this).val();
        var userTeamID = $(this).parents('tr').attr('data-id');
        var obj = {};
        obj[userTeamID] = role;
        dataMembers.push(obj);
    });
    $("#saveEditMemberTeam").on('click', function () {
        saveMemberInTeam(dataMembers);
    });
    /* === end edit member in team === */

    /* === edit team === */
    // click of image button edit
    $(".upload-avartar-team img[class='avatar-team-edit']").click(function() {
        $("input[id='avatar-team-edit-file']").click();
    });
    $(".icon-upload-file").click(function() {
        $("input[id='avatar-team-edit-file']").click();
    });

    // Preview an image before it is uploaded
    $("#avatar-team-edit-file").change(function() {
        if (checkSize(this, 'avatar-team-edit-file') == true && checkExtension(this, 'avatar-team-edit-file') == true) {
            readURL(this, 'avatar-team-edit', 'avatar-team-edit-file');
        } else {
            $('#editTeamModalCenter div.show-status').addClass('alert-warning').html('<span>Image file (JPEG/JPG/PNG)or maxsize < 2MB</span>');
            setTimeout(function(){
                $("#editTeamModalCenter div.show-status").removeClass('alert-warning');
                $("#editTeamModalCenter div.show-status").html('');
            }, 3000);

        }
    });

    $("#editTeamSuccess").hide();
    var dataEditMember = [];
    $("#list-members-team").on('change', '.role-team', function () {
        var role = $(this).val();
        var userTeamID = $(this).parents('tr').attr('data-id');
        var obj = {};
        obj[userTeamID] = role;
        dataEditMember.push(obj);
    });

    $("#editTeam").on('click', function () {
        editTeam(dataEditMember);
    });
    /* === end edit team === */

    /* === Check All button === */
    $(".selectAll").on('click', function () {
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));
    });

    /* === Add Team Function block === */

    // click of image button add
    $(".icon-upload-file-add-team").click(function() {
        $("input[id='avatar-team-add']").click();
    });
    $(".upload-avartar-team img[class='avatar-team']").click(function() {
        $("input[id='avatar-team-add']").click();
    });

    // Preview an image before it is uploaded
    $("#avatar-team-add").change(function() {
        if (checkSize(this, 'avatar-team-add') == true && checkExtension(this, 'avatar-team-add') == true) {
            readURL(this, 'avatar-team', 'avatar-team-add');
        } else {
            $('#addTeamModalCenter div.show-status').addClass('alert-warning').html('<span>Image file (JPEG/JPG/PNG)or maxsize < 2MB</span>');
            setTimeout(function(){
                $("#addTeamModalCenter div.show-status").removeClass('alert-warning');
                $("#addTeamModalCenter div.show-status").html('');
            }, 3000);
        }
    });

    $('button.btn-add-team').on('click', function() {
        addTeam();
    });

    // reset modal content after close
    var listMemberOriginal = $(".list-edit-member").clone();
    $(".modal").on("hidden.bs.modal", function() {
        $(".list-edit-member").remove();
        var listmemberClone = listMemberOriginal.clone();
        $(".list-members-in-team").append(listmemberClone);
    })

    /* === save add member === */
    $("#saveAddmember").on('click', function () {
        var memberID = [];
        $.each($("input[name='memberID']:checked"), function () {
            memberID.push($(this).val());
        });
        var teamID = $(this).attr('teamID');
        var teamName = $(this).attr('teamName');
        if (memberID.length != 0) {
            $.ajax({
                method: 'post',
                url: '/teams/addMember',
                dataType: 'json',
                data: {
                    "userID": memberID,
                    "team_id": teamID,
                    "team_name": teamName
                },
                success: function (response) {
                    if (response.status === 1) {
                        $('#addAndEditMember div.statusAddMember').addClass('alert-success').html('<span>' + response.message + '</span>');
                        location.reload(true);
                    } else {
                        if (typeof response.message === 'object') {
                            response.message = response.message.name[0];
                        }
                        $('#addAndEditMember div.statusAddMember').addClass('alert-warning').html('<span>' + response.message + '</span>');
                    }
                }
            });
        } else {
            $('#addAndEditMember div.statusAddMember').addClass('alert-danger').html('<span>Please select a member of the team!!!</span>');
            location.reload(true);
        }

    });

    // Delete team
    $("#confirm-delete-team").on('click', '.btn-danger', function () {
        var teamID = $(this).data('id');

        $.ajax({
            method: 'post',
            url: '/teams/deleteTeam',
            data: {
                "team_id": teamID
            },
            success: function (response) {
                window.location.href = window.location.pathname;
            },
            error: function () {
                alert('error');
            }
        });
    });

    //Deletemember
    var memberIDs = [];
    $(".list-members-in-team").on('click', '.delete-member-in-team', function () {
        var teamId = $(this).parents(".user-id").data("teamid");
        var memberId = $(this).parents(".user-id").data("id");
        memberIDs.push(memberId);
        $(this).closest('tr').remove();
        $(".delete-member-team").on('click', function () {
            $.ajax({
                method: 'post',
                url: '/teams/deleteMember',
                data: {
                    teamId: teamId,
                    memberIDs: memberIDs
                },
                success: function (response) {
                    location.reload(true);
                }
            });
        });
    });

    /* === search add member === */
    $(".search").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $(".checkbox-item").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    /* === update avatar profile === */
    $(".alert-upload-file").hide();
    $('.upload-avatar-user').on('click', function() {
        $("input[id='avatar-user-file']").trigger('click');
    });

    // Preview an image before it is uploaded
    $("#avatar-user-file").change(function() {
        if (checkSize(this, 'avatar-user-file') == true && checkExtension(this, 'avatar-user-file') == true) {
            readURL(this, 'avatar-user', 'avatar-user-file');
            updateCoverPhoto("avatar-user-file", 1); // php know upload avatar image
        }
    });

    // /* === update cover photo === */
    $(".update-cover-photo").click(function() {
        $("input[id='avatar-cover-file']").trigger('click');
    });

    $("#avatar-cover-file").change(function() {
        if (checkSize(this, 'avatar-cover-file') == true && checkExtension(this, 'avatar-cover-file') == true) {
            readURL(this, 'cover-photo', 'avatar-cover-file');
            updateCoverPhoto("avatar-cover-file", 2); // php know upload cover photo
        }
    })

    /* === Edit Profile === */
    $(".alert-upload-file-cover").hide();
    $('#user-profile button.edit-profile').on('click', function () {
        $(this).hide().parent().find('.act-h').removeClass('d-none');

        $('#user-profile table td.hide-af-edit').hide();
        $('#user-profile table td.ip-h').removeClass('d-none');

        // Button save click
        $('#user-profile button.save-profile').on('click', function () {
            var data = $('#frm-user-profile').serialize();
            editProfile(data, '/users/editProfile', function (response) {
                if(response.status === 1) {
                    $('#user-profile button.edit-profile').show().parent().find('.act-h').addClass('d-none');
                    $('#user-profile table td.hide-af-edit').show();
                    $('#user-profile table td.ip-h').addClass('d-none');

                    //update data
                    for (var key in response.data){
                        $('#user-profile table td.'+key).text(response.data[key]);
                    }

                }
                var alertType = (response.status === 1) ? 'alert-success' : 'alert-warning';
                $('#user-profile div.show-status').addClass(alertType).html('<span>' + response.message + '</span>').delay(5000).fadeIn( 3000, function() {
                    $('#user-profile div.show-status').removeClass(alertType).html('');
                });
            });
        });
        // Button cancel click
        $('#user-profile button.edit-cancel').on('click', function () {
            $('#user-profile button.edit-profile').show().parent().find('.act-h').addClass('d-none');
            $('#user-profile table td.hide-af-edit').show();
            $('#user-profile table td.ip-h').addClass('d-none');
        })
    });

    $('.fa.btn-refresh.ref-edit').on('click', function () {
        refresh($(this), 'list-edit-member');
    });

    $('.fa.btn-refresh.ref-add-list-edit').on('click', function () {
        refresh($(this), 'list-edit-member');
        refresh($(this), 'list-add-member');
        refresh($(this), 'list-member');
    });

    // /* === scroll team, member === */
    $('.modal').on('shown.bs.modal', function () {
        $('.fa.btn-refresh.ref-add-list-edit').trigger( "click" );
    });

    /*=== Notification Pusher ===*/
    listenNotification();
});

var updateCoverPhoto = function(idImage, mark) {
    var file_data = $('#' + idImage).prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('mark', mark);
    $(".update-cover-photo").hide();
    $.ajax({
        method: 'post',
        url: '/users/uploadAvatar',
        dataType: 'text',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(response) {
            if (response == 1 && mark == 2) {
                $(".alert-upload-file-cover").show();
                $(".update-cover-photo").hide();
                $(".alert-upload-file-cover").delay(3000).fadeOut();
                setTimeout(function(){
                    $(".update-cover-photo").show();
                }, 3000);
            }
            if (response == 1 && mark == 1) {
                $(".alert-upload-file").show();
                $(".profile-content-text").css("padding-top", "34px");
                $(".alert-upload-file").delay(3000).fadeOut();
                setTimeout(function(){
                    $(".profile-content-text").css("padding-top", "20px");
                }, 3000);
            }
            if (response == 0) {
                $(".message-error-upload-file").css("display", "block").delay(5000).fadeOut();
                $(".message-error-upload-file").html("Update fail!");
            }
        }
    });
}

var checkSize = function(input, idTeam) {
    var fileSize = input.files[0].size;
    if (fileSize > 2097152 || fileSize.fileSize > 2097152) {  //1MB = 1048576 Bytes
        $(".message-error-upload-file").css("display", "block").delay(5000).fadeOut();
        $(".message-error-upload-file").html("Allowed file size exceeded. (Max. 2 MB)");
        return false;
    }
    return true;
}

var checkExtension = function(input, idTeam) {
    var file = input.files[0];
    var imagefile = file.type;
    var match = ["image/jpeg", "image/png", "image/jpg"];
    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
        $(".message-error-upload-file").css("display", "block").delay(5000).fadeOut();
        $(".message-error-upload-file").html('Please select a valid image file (JPEG/JPG/PNG).');
        $('#' + idTeam).val('');
        return false;
    }
    return true;
}

var readURL = function(input, classTeam, idTeam) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.' + classTeam).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
        $('#'.idTeam).hide();

    }
}

var editProfile = function(data, url, callback) {
    $.ajax({
        method: 'post',
        url: url,
        dataType: 'json',
        data: data,
        success: function (response) {
            callback(response);
        }
    });
}


var getUrlVars = function () {
    var vars = [],
        hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

var editTeam = function (dataMembers) {
    var teamID = $("#teamID").val();
    var data = $('#frm-edit-team').serialize(); //name, des
    var file_data = $('#avatar-team-edit-file').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('data', data);
    form_data.append('dataMembers', JSON.stringify(dataMembers));
    if (dataMembers.length == 0 && nameTeam == null && desTeam == null) {
        $('.modal').modal('hide');
        return true;
    } else {
        $.ajax({
            method: 'post',
            url: '/teams/editTeam',
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            data: form_data,
            success: function(response) {
                if (response.status === 1) {
                    $('#editTeamModalCenter div.show-status').addClass('alert-success').html('<span>' + response.message + '</span>');
                    $('#frm-add-team')[0].reset();
                    location.reload(true);
                } else {
                    if (typeof response.message === 'object') {
                        response.message = response.message.name[0];
                    }
                    $('#editTeamModalCenter div.show-status').addClass('alert-warning').html('<span>' + response.message + '</span>');
                    setTimeout(function(){
                        $("#editTeamModalCenter div.show-status").removeClass('alert-warning');
                        $("#editTeamModalCenter div.show-status").html('');
                    }, 3000);
                }
            }
        });
    }
}

var saveMemberInTeam = function(dataMembers) {
    var url = location.reload();
    if (dataMembers.length == 0) {
        $('.modal').modal('hide');
        return true;
    } else {
        var teamID = $("#tableEditMember").parents().find(".user-id").data("teamid");
        $.ajax({
            method: 'post',
            url: '/teams/editMembers',
            dataType: 'text',
            data: {teamId: teamID, dataList: dataMembers},
            success: function (response) {
                if (response == true) {
                    $("#editMemberInTeamSuccess").show();
                    location.reload(true);

                }
            }
        });
    }
}

var changeStatusNotification = function (obj, id) {
    var data = null;
    if (typeof(id) != "undefined" && id !== null) {
        data = { id: id }
    };
    $.ajax({
        method: 'post',
        url: '/notifications/changeStatus',
        data: data,
        success: function (response) {
            if (response == 1) {
                $('span.fa-stack').css('visibility','hidden');
            } else {
                var redirectUrl = obj.find('span.url-redirect a').attr('href');
                window.location.href = redirectUrl;
            }
        }
    });
}

// send notification
var sendNotification = function (url) {
    var toID = url.attr("dataID");
    var reportID = url.attr("reportID");
    var content = '<a href="/reports/create/' + reportID + '"> requires you create detail content of reports</a>';
    $.ajax({
        method: 'post',
        url: '/leaders/sendRequest',
        data: {
            "toID": toID,
            "reportID": reportID,
            "content": content
        },
        success: function (response) {
            var text = '<button type="button" class="btn btn-warning btn-sm btnProgress">In Progress</button>'
            url.parent().html(text);
        }
    })
}
var ajaxPagination = function (page) {
    $(page).on('click', 'nav ul li a', function (event) {
        event.preventDefault();
        var urls = $(this).attr('href');
        //get param from url
        var params = new window.URLSearchParams(window.location.search);
        var member = $("#member-in-team").val();
        $.ajax({
            method: 'post',
            url: urls,
            dataType: 'html',
            data: {dateReport: $('#dateRange').val(), teamID: params.get('teamid'), member: member},
            success: function (response) {
                $('#lead-list-report').html(response);
            }
        })
    });
}

var getReport = function () {
    var select_date = $("#dateRange").val();
        var member = $("#member-in-team").val();
        //get param from url
        var params = new window.URLSearchParams(window.location.search);
        $.ajax({
            method: 'post',
            url: '/leaders/listReport',
            dataType: 'html',
            data: {dateReport: select_date, teamID: params.get('teamid'), member: member},
            success: function (response) {
                $('#lead-list-report').html(response);
            }
        })
    // });
}

var sentReport = function () {
    var emoji_id = "";
    $("#image_emoji_1").click(function () {
        $(this).css('background-color', 'lavender');
        $("#image_emoji_2").css('background-color', 'transparent');
        $("#image_emoji_3").css('background-color', 'transparent');
        emoji_id = 1;
    })
    $("#image_emoji_2").click(function () {
        $(this).css('background-color', 'lavender');
        $("#image_emoji_1").css('background-color', 'transparent');
        $("#image_emoji_3").css('background-color', 'transparent');
        emoji_id = 2;
    })
    $("#image_emoji_3").click(function () {
        $(this).css('background-color', 'lavender');
        $("#image_emoji_2").css('background-color', 'transparent');
        $("#image_emoji_1").css('background-color', 'transparent');
        emoji_id = 3;
    })

    $("#sent_report_index").click(function () {
        $(this).prop('disabled', true);
        var score = $("#score_val option:selected").val();
        var comment = $(".whatsay").val();
        var teamID = $("#teamIDReport").val();
        $.ajax({
            method: "post",
            url: '/Reports/addReport',
            dataType: 'text',
            data: {team_id: teamID, emoji_id: emoji_id, score: score, comment: comment},
            success: function (response) {
                var returnedData = JSON.parse(response);
                if (typeof(returnedData.error) != 'undefined') {
                    alert(returnedData.error);
                } else {
                    returnedData = returnedData.success;
                    var html = "";
                    html += "<tr>";
                    html += "<td>";
                    html += returnedData[0]['DATE(created)'];
                    html += "</td>";
                    html += "<td>";
                    html += "<img style='width: 30%;' src='/img/emoji/emoji_" + returnedData['TReport']['emoji_id'] + ".gif' />";
                    html += "</td>";
                    html += "<td>";
                    html += returnedData['TReport']['score'];
                    html += "</td>";
                    html += "<td>";
                    html += returnedData['TReport']['status'];
                    html += "</td>";
                    html += "<td>";
                    if (returnedData['TReport']['report_status'] == 1) {
                        html += '<button type="button " class="btn btn-primary btn-sm ">Request</button>';
                    } else if (returnedData['TReport']['report_status'] == 2) {
                        html += '<button type="button " class="btn btn-success btn-sm ">Detail</button>';
                    } else {
                        html += '';
                    }
                    html += "</td>";
                    html += "</tr>";

                    $('table#table-add-report > tbody').before(html);

                    if (returnedData.count >= 1) {
                        $('table#table-add-report > tbody > tr:last').remove();
                    }

                    var form = "";
                    form += '<div class="row">';
                    form += '   <div class="col-md-2 col-sm-2 col-5 emoji">';
                    form += '       <h5>Status</h5>';
                    form += "       <img src='/img/emoji/emoji_" + returnedData['TReport']['emoji_id'] + ".gif' />";
                    form += '   </div>';
                    form += '   <div class="col-md-2 col-sm-2 col-5 score">';
                    form += '       <h5>Score</h5>';
                    form += '       <p>' + returnedData['TReport']['score'] + '</p>';
                    form += '   </div>';
                    form += '   <div class="col-md-7 col-sm-7 col-11 status">';
                    form += '       <h4 style ="margin: 7%;">' + returnedData['TReport']['status'] + '</h4>';
                    form += '   </div>';
                    form += '</div>';
                    $("#fr_form").replaceWith(form);
                }
            },
            error: function (xhr) {
                alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
            },
            complete: function () {
                $('#sent_report_index').prop('disabled', false);
            }
        });
    });
}

/* === add Team Function === */
var addTeam = function () {
    var data = $('#frm-add-team').serialize();
    var file_data = $('#avatar-team-add').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    form_data.append('data', data);
    $.ajax({
        method: 'post',
        url: '/teams/addTeam',
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(response) {
            if (response.status === 1) {
                $('#addTeamModalCenter div.show-status').addClass('alert-success').html('<span>' + response.message + '</span>');
                $('#frm-add-team')[0].reset();
                location.reload(true);
            } else {
                if (typeof response.message === 'object') {
                    response.message = response.message.name[0];
                }
                $('#addTeamModalCenter div.show-status').addClass('alert-warning').html('<span>' + response.message + '</span>');
                setTimeout(function(){
                    $("#addTeamModalCenter div.show-status").removeClass('alert-warning');
                    $("#addTeamModalCenter div.show-status").html('');
                }, 3000);
            }
        }
    });
}

var refresh = function (obj, tab) {
    var teamID = obj.data('teamid');

    var data = {teamID: teamID, tab: tab};
    $.ajax({
        method: 'post',
        url: '/teams/getMember',
        dataType: 'html',
        beforeSend: function () {
            obj.toggleClass('d-none');
            $('img.refresh-loading').toggleClass('d-none');
        },
        data: data,
        success: function (response) {
            $('.' + tab).html(response);
        },
        complete: function () {
            obj.toggleClass('d-none');
            $('img.refresh-loading').toggleClass('d-none');
        }
    });
}

var listenNotification = function(){

    var pusher = new Pusher('5c94ee7d8dcf8c4bdcd6', {
        cluster: 'ap1',
        forceTLS: true
    });

    var channel = pusher.subscribe('notification');
    channel.bind('e_tmh-noti', function(data) {
        $.each(data, function(i, item){
            $('li.iconInfo#'+ i +' span.p1.fa-stack.fa-lg.count-notification-show').css('visibility', 'visible').attr('data-count', item.num);
            $('li.iconInfo#'+ i +' b.number-unread').text(item.num);
            //console.log(item.data.TNotification['id']);
            var classUnread = (item.data.TNotification['read'] == 0 || item.data.TNotification['read'] == 1) ? 'unread' : 'read';
            var src_avartar = (item.data.TUser['avatar_user'] !== '') ? '/img/avatar_user/' + item.data.TUser['avatar_user'] : '/img/user.png';
            var classIcon = (item.data.TNotification['read'] == 0 || item.data.TNotification['read'] == 1) ? 'text-success' : 'text-muted';

            var html = $('<li>').attr({
                'data-id': item.data.TNotification['id'],
            }).addClass('row ' + classUnread)
                .append($('<div>').addClass('col-md-2 col-sm-2 col-xs-2 col-2')
                    .append($('<span>').addClass('avatar_menu')
                        .append($('<img>').attr('src' , src_avartar))))
                .append($('<div>').addClass('col-md-10 col-sm-10 col-xs-10 col-10 contentNofi')
                    .append($('<span>')
                        .append($('<a>').attr( 'href', '#').addClass('nameUser').text(item.data.TUser['username'] + ' ')))
                    .append($('<span>').addClass('message url-redirect').html(item.data.TNotification['content']))
                    .append($('<p>').addClass('rIcon')
                        .append($('<i>').addClass('fa fa-dot-circle-o ' + classIcon)))
                    .append($('<br/>'))
                    .append($('<p>').addClass('timeNotifi').text(item.data.TNotification['created']))
                );
            $('li.iconInfo#'+ i +' ul#list-notification div.drop-content').prepend(html);
        })
    });
}