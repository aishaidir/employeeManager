var array = [];

function baseURL() { 
    return "http://localhost/employee_report_manager/"; 
}

function copyToClipboard(text) {
   $('#copy_to_clipbpard').css({'visibility':'visible', 'opacity':1});
        setTimeout(function(){
            $('#photo_url').val(text).focus().select();
        }, 300);
   
}

function checkBoxes(id) {
    var selected = [], checkElem = document.getElementById(id).elements;
    for(var i=0;i<checkElem.length;i++){
        if(checkElem[i].type == 'checkbox' && checkElem[i].checked == true){
            selected.push(checkElem[i].value);
        } 
    }
    return selected;
}

function permission(perm) {
    var res = true;
    if(perm != 1) {
        res = false;
    }
    return res;
}

function permissionModal() {
    var permissionModal = $('#permission');
        permissionModal.css({'visibility':'visible', 'opacity':1});
}

function scrollWindow() {
    window.scrollTo(500,-500);
}

function getSubCat(action, id, tbl, col, subCat, subCatVal) {
    var res;
    $.ajax({
        type: "POST",
        url: baseURL()+"controllers/htmlcontrol.php",
        data: "action="+action+"&id="+id+"&tbl="+tbl+"&col="+col,
        success: function(response) {
            if(response == 0) {
                $("#"+subCat).html('<option value="">-- Select --</option>');
            } else {
                $("#"+subCat).html(response);
                $("#"+subCat).val(subCatVal);
                console.log(response);
            }

        }
    });
    return res;
}

function removeParticipant(id, name) {
    var assignTo = $("#assign_to");
    var option = '<option data-name="'+ name +'" value="'+ id +'">'+ name +'</option>';
    
    $("#participant"+id).remove();

    assignTo.append(option);
    array.splice( $.inArray(id,array) ,1 );

    var participantsList = $("#participants_list");
    participantsList.val(array);
}


$(document).ready(function(){

    $('body').on('click', '.delete', function(e) {
        e.preventDefault();
        var perm = $('#perm').val();
        if ( permission(perm) ) {
        var id = $(this).attr('data-entity-id'), model = $(this).attr('data-entity-model'), 
            modal = $('.modal#delete_modal'), confirmDelete = $('.confirm_delete');
            modal.css({'visibility':'visible', 'opacity':1});
            confirmDelete.attr('href', baseURL()+ 'delete/' + model + '/' + id);
        } else {
            $('.modal#permission').css({'visibility':'visible', 'opacity':1});
        }
    });

    $('body').on('click', '.cancel_delete', function(){
        var modal = $('.modal');
            modal.css({'visibility':'hidden', 'opacity':0});
    });

    $('body').on('click', '.close', function(){
        var modal = $('.modal');
            modal.css({'visibility':'hidden', 'opacity':0});
    });

    $('body').on('click', '#hide_notifier', function(){
        var notifier = $('.notifier');
            notifier.css({'visibility':'hidden', 'opacity':0}).html("");
    });

    $('body').on('click', '.submit_report', function(){

        var modal = $('.modal#submit_report_modal'), submitReportForm = $('.submit_report_form'),
            weeklyId = $("#weekly_id").val(),
            keyChallenges = $("#key_challenges").val(),
            recommendations = $("#recommendations").val();
            modal.css({'visibility':'visible', 'opacity':1});

            $("#weekly_id_").val(weeklyId);
            $("#key_challenges_").val(keyChallenges);
            $("#recommendations_").val(recommendations);

    });

    $('body').on('click', '#edit_day_report', function(){

        var modal = $('.modal#edit_report');

            id = $(this).attr("data-id");
            dailyId = $("#daily_id"+id).val(),
            activity = $("#activity"+id).val(), 
            milestone = $("#milestone"+id).val(),
            editDailyId = $("#edit_daily_id"),
            editActivity = $("#edit_activity"),
            editMilestone = $("#edit_milestone");
            
            editDailyId.val(dailyId);
            editActivity.val(activity);
            editMilestone.val(milestone);

        modal.css({'visibility':'visible', 'opacity':1});
    });

    $("body").on("change", "#assign_to", function() {
        var id = $(this).val();
        var name = $('option:selected', this).attr("data-name"); 
        var participants = $("#participants");
        var participant = "";
        var participantsList = $("#participants_list");
        
        try {
            participant = $('<div id="participant'+id+'" onclick="javascript:removeParticipant('+id+', \''+ name +'\')" class="participant"><p>'+ name +'</p><span class="remove_participant"><i class="ion ion-close"></i></span></div>');
            participants.append(participant);
            array.push(id);
            participantsList.val(array);
            console.log(array);
            $('option:selected', this).remove();
        } catch(error) {
            console.log(error);
        }
    });

    $("body").on("click", ".task_title_bar", function() {
        var parent = $(this).parent(".task");
        var id = $(this).attr("id");
        var arrow = $(this).find("span.task_arrow").children("i");
        var folder = $(this).find("span.task_folder").children("i");
        var taskInfo = parent.find(".task_info");

        if(id == 1) {
            taskInfo.slideUp(150);
            $(this).attr("id", 0);
            arrow.removeClass("ion-android-arrow-dropdown");
            arrow.addClass("ion-android-arrow-dropright");
            folder.removeClass("fa-folder-open");
            folder.addClass("fa-folder");
        } else {
            taskInfo.slideDown(150);
            $(this).attr("id", 1);
            arrow.removeClass("ion-android-arrow-dropright");
            arrow.addClass("ion-android-arrow-dropdown");
            folder.removeClass("fa-folder");
            folder.addClass("fa-folder-open");
        }
    });

    $("body").on("click", ".view_participant_perf", function() {
         var modal = $('.modal#review_participant'), participantId = $(this).attr("data-id"), taskId = $(this).attr("data-task-id");
         modal.css({'visibility':'visible', 'opacity':1});

        $("input[name='rating']").prop('checked', false);
        $("#author_remarks").val("");

         $.ajax({
            url: baseURL()+"controllers/task.php",
            type: "POST",
            data: "action=get_participant_status"+"&task_id="+taskId+"&participant_id="+participantId,
            beforeSend: function() {},
            success: function(response) {
                var parsedResponse = $.parseJSON(response);
                var status = parsedResponse.status == 0 ? "Hasn't responded" : "Has responded"; 
                var remarks = parsedResponse.remarks == "" ? "-" : parsedResponse.remarks; 
                var dateUpdated = parsedResponse.date_updated == "0000-00-00 00:00:00" ? "-" : parsedResponse.date_updated; 
                var authorRating = parsedResponse.author_rating ? parsedResponse.author_rating : "";
                
                $("#participant_id").val(parsedResponse.id);
                $("#participant_name").text(parsedResponse.name);
                $("#participant_status").text(status);
                $("#participant_remarks").text(remarks);
                $("#participant_date_updated").text(dateUpdated);
                $("#author_remarks").val(parsedResponse.author_remarks);

                if(authorRating != "") {
                    var radios = $('input:radio[name=rating]');
                    if(radios.is(':checked') === false) {
                        radios.filter('[value='+ authorRating +']').prop('checked', true);
                    }
                }
            },
            complete: function() {},
            error: function() {},
            timeout: 60000
         });
    });
})









































