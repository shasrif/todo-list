let API_URL = 'http://127.0.0.1:8000/api';
$(document).ready(function(){
    //User registration action
    $('body').on('click', '.btn-register', function(e) {
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var password_confirmation = $('#password_confirmation').val();
        console.log(email + " " + password)
        if(email && password) {
            $.ajax({
                url: API_URL + "/register",
                type: "post",
                data: {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: password_confirmation
                },
                success: function(res) {
                    console.log(res);
                    window.location.href='/dashboard';
                }
            })
        } else {
            if(name == '') {
                $('#name').addClass('field_error');
            }
            if(email == '') {
                $('#email').addClass('field_error');
            }
            if(password == '') {
                $('#password').addClass('field_error');
            }
            if(password_confirmation == '') {
                $('#password_confirmation').addClass('field_error');
            }
            if(password_confirmation !== password) {
                $('#password_confirmation').addClass('field_error');
            }
        }
    });

    //User login action
    $('body').on('click', '.btn-login', function(e) {
        e.preventDefault();
        var email = $('#email').val();
        var password = $('#password').val();
        if(email && password) {
            $.ajax({
                url: API_URL + "/login",
                type: "post",
                data: {
                    email: email,
                    password: password
                },
                success: function(res) {
                    window.location.href='/dashboard';
                }
            });
        } else {
            if(email == '') {
                $('#email').addClass('field_error');
            }
            if(password == '') {
                $('#password').addClass('field_error');
            }
        }
    });

    //Create new list action
    $('body').on('click', '.btn-post', function(e) {
        e.preventDefault();
        var title = $('#title').val();
        var content = $('#body').val();
        var token = $('#get_token').val();
        if(title && content && token) {
            var settings = {
                "url": API_URL + "/posts",
                "method": "POST",
                "timeout": 0,
                "headers": {
                  "Accept": "application/json",
                  "Content-Type": "application/json",
                  "Authorization": "Bearer " + token,
                  "Cookie": "laravel_session=httaKlljKnXgEQXiKVZiVw7Rk2Im4c0ep9C31DpP"
                },
                "data": JSON.stringify({
                  "title": title,
                  "body": content
                }),
            };
              
            $.ajax(settings).done(function (response) {
                $('#addTaskModal').modal('hide');
                $('#title').val('');
                $('#body').val('');
                $('.load-ajax-posts').html(response);
            });
        } else {
            if(title == '') {
                $('#title').addClass('field_error');
            }
            if(content == '') {
                $('#body').addClass('field_error');
            }
        }
    });

    //Update list action
    $(document).on('click', '.btn-post-update', function(e) {
        e.preventDefault();
        var id = $('#post_id').val();
        console.log(id)
        var title = $('#edit_title').val();
        var content = $('#edit_body').val();
        var token = $('#get_token').val();
        if(title && content && token) {
            var settings = {
                "url": API_URL + "/posts/" + id,
                "method": "PUT",
                "timeout": 0,
                "headers": {
                  "Accept": "application/json",
                  "Content-Type": "application/json",
                  "Authorization": "Bearer " + token,
                  "Cookie": "laravel_session=httaKlljKnXgEQXiKVZiVw7Rk2Im4c0ep9C31DpP"
                },
                "data": JSON.stringify({
                  "title": title,
                  "body": content
                }),
            };
              
            $.ajax(settings).done(function (response) {
                $('#editTaskModal').modal('hide');
                $('#edit_title').val('');
                $('#edit_body').val('');
                $('.post-row-' + id).html(response);
            });
        } else {
            if(title == '') {
                $('#edit_title').addClass('field_error');
            }
            if(content == '') {
                $('#edit_body').addClass('field_error');
            }
        }
    });

    //logout action
    $('body').on('click', '.dropdown-item', function(e) {
        e.preventDefault();
        var token = $('#get_token').val();
        if(token) {
            var settings = {
                "url": API_URL + "/logout",
                "method": "POST",
                "timeout": 0,
                "headers": {
                  "Accept": "application/json",
                  "Authorization": "Bearer " + token,
                  "Cookie": "laravel_session=httaKlljKnXgEQXiKVZiVw7Rk2Im4c0ep9C31DpP"
                },
            };
              
            $.ajax(settings).done(function (response) {
                window.location.href="/";
            });
        }
    });

    $('body').on('keyup paste', '#title, #body, #edit_title, #edit_body, #name, #email, #password, #password_confirmation', function(){
        $(this).removeClass('field_error');
    })
});

//post edit action
function todo_edit(id) {
    if(id) {
        var token = $('#get_token').val();
        var settings = {
            "url": API_URL + "/posts/" + id,
            "method": "GET",
            "timeout": 0,
            "headers": {
              "Accept": "application/json",
              "Authorization": "Bearer " + token,
              "Cookie": "laravel_session=httaKlljKnXgEQXiKVZiVw7Rk2Im4c0ep9C31DpP"
            },
        };
          
        $.ajax(settings).done(function (response) {
            $('.pust-edit-task').html(response);
            $('#editTaskModal').modal({
                show : true
            });
        });
    }
}

//Chnage post status action
function change_status(id, status) {
    if(id) {
        $.ajax({
            url: API_URL + "/posts/status",
            type: "post",
            data: {
                id: id,
                status: status
            },
            success: function(res) {
                console.log(res);
                $('.status-' + id).html(res);
            }
        });
    }
}

//post delete action
function todo_delete(id) {
    if(id) {
        var token = $('#get_token').val();
        var settings = {
            "url": API_URL + "/posts/" + id,
            "method": "DELETE",
            "timeout": 0,
            "headers": {
              "Accept": "application/json",
              "Authorization": "Bearer " + token,
              "Cookie": "laravel_session=httaKlljKnXgEQXiKVZiVw7Rk2Im4c0ep9C31DpP"
            },
        };
          
        $.ajax(settings).done(function (response) {
            $('.status-' + id).parents('tr').remove();
        });
    }
}