{/* <script type="text/javascript">
$(document).ready(function() {
    $.uploadPreview({
        input_field: "#image-upload",
        preview_box: "#image-preview",
        label_field: "#image-label"
    })
});
</script> */}

setInterval(function(){
    $("#notif-counter").load("/counter");
}, 2000);

setInterval(function(){
    $("#msg-counter").load("/msg-counter");
}, 2000);

$(document).ready(function() {
    var url = document.location.toString();
    if (url.match('#')) {
        $('.nav-item a[href="#' + url.split('#')[1] + '"]').tab('show').trigger('click');
        // window.scrollTo(0, 0);
    }

    $('.nav-item a').on('shown', function (e) {
        window.location.hash = e.target.hash;
    });

});

$(document).ready(function() {     


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.action-follow').click(function(){    
        var user_id = $(this).data('id');
        var cObj = $(this);
        var c = $(this).parent("div").siblings(".profile-usermenu").find(".tl-follower").text();


        $.ajax({
           type:'POST',
           url:'/ajaxRequest',
           data:{user_id:user_id},
           success:function(data){
              if(jQuery.isEmptyObject(data.ok[0].s.attached)){
                cObj.find("strong").text("Follow");
                $(cObj).removeClass("btn-alert");
                $(cObj).addClass("btn-success");
                // alert("c: " + c)
                cObj.parent("div").siblings(".profile-usermenu").find(".tl-follower").text(parseInt(c)-1);
              }else{
                SuccessHandler(data.ok[1].id)
                cObj.find("strong").text("Followed");
                $(cObj).removeClass("btn-success");
                $(cObj).addClass("btn-alert");
                // alert("c: " + c )
                cObj.parent("div").siblings(".profile-usermenu").find(".tl-follower").text(parseInt(c)+1);
              }
           }
        });
    });   
    
    function SuccessHandler(data) {
        var id = data;

        $.ajax({
            type:'POST',
            url:'/ajaxRequestInsert',
            data:{id:id},
            success:function(){
                
            },
        });
    }


});


$(document).ready(function() {     


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.fa-thumbs-o-up, .fa-thumbs-o-down').click(function(){    
        var id = $(this).parents(".panel-info").data('id');
        var c = $('#'+this.id+'-bs3').html();
        var cObjId = this.id;
        var cObj = $(this);

        $.ajax({
            type:'POST',
            url:'/ajaxRequestLike',
            data:{id:id},
            success:function(data){
                if(jQuery.isEmptyObject(data.sukses[0].s.attached)){
                $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                $(cObj).removeClass("like-post");
                }else{
                OnSuccess(data.sukses[1].id);
                $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                $(cObj).addClass("like-post");
                }
            },
            error: function(request,  error , status) {
                Session('Error', 'Error'); 
            }
        });


    });    
    
    function OnSuccess(data) {
        var id = data;

        $.ajax({
            type:'POST',
            url:'/ajaxRequestIns',
            data:{id:id},
            success:function(){
                
            },
        });
    }


    $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });                                        
}); 


CKEDITOR.replace( 'article-ckeditor' );


// Prevent dropdown menu from closing when click inside the form
$(document).on("click", ".navbar-right .dropdown-menu", function(e){
    e.stopPropagation();
});

function ConfirmDelete() {
    var x = confirm("Are you sure you want to delete?");
    if (x){
    return true;
    } else {
    return false;
    }
}

function DeleteConfirmation() {
    var x = confirm("Do you want to delete it?");
    if (x){
    return true;
    } else {
    return false;
    }
}

// reply
// $(document).ready(function() {     


//     $.ajaxSetup({
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         }
//     });


//     $('#comment').on('submit', function(e){   
//         e.preventDefault(); 
//         var user_id = $('#user_id').val();
//         var body = $('#comment_body').val();
//         var post_id = $('#post_id').val();


//         $.ajax({
//            type:'POST',
//            url:'/comment',
//            data:{user_id:user_id, body:body, post_id:post_id},
//            success:function(msg){

//            }
//         });
//     });      


// }); 



// Notif
window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

var notifications = [];

const NOTIFICATION_TYPES = {
    follow: 'App\\Notifications\\UserFollowed'
};

//...
$(document).ready(function() {
    // check if there's a logged in user
    if(Laravel.userId) {
        $.get('/notifications', function (data) {
            addNotifications(data, "#notifications");
        });
    }
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    // show only last 5 notifications
    notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if(notifications.length) {
        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
    } else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
    }
}

// Make a single notification string
function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li><a href="' + to + '">' + notificationText + '</a></li>';
}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = '?read=' + notification.id;
    if(notification.type === NOTIFICATION_TYPES.follow) {
        to = 'users' + to;
    }
    return '/' + to;
}

// get the notification text based on it's type
function makeNotificationText(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.follow) {
        const name = notification.data.follower_name;
        text += '<strong>' + name + '</strong> followed you';
    }
    return text;
}