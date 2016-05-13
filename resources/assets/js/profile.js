$(document).ready(function(){
    if(typeof currentPage != 'undefined' && currentPage == 'profile') {
        //SHOW PASSWORD
        $('#showCurrentPassword, #showNewPassword').click(function(){

            var thisId = $(this).data('for'),
                currentAttr = $('#'+thisId).attr('type'),
                dataInfo = $(this).data('info');

            if(currentAttr == 'password') {

                if(dataInfo == 'currentPassword') {
                    $('#currentPassword').attr('type', 'text');
                } else if(dataInfo == 'newPassword') {
                    $('#newPassword').attr('type', 'text');
                }

            } else if(currentAttr == 'text') {

                if(dataInfo == 'currentPassword') {
                    $('#currentPassword').attr('type', 'password');
                } else if(dataInfo == 'newPassword') {
                    $('#newPassword').attr('type', 'password');
                }

            }

        });

        // DROP ZONE PROFILE
        var timeDelay = 3500
        Dropzone.options.avatarZone = {
            clickable: true,
            // acceptedFiles: 'image/jpg,image/jpeg,image/png,image/gif',
            dictDefaultMessage: '<div class="avatar-action"><i class="glyphicon glyphicon-camera"></i></div>',
            sending: function(file,xhr,formData){
                formData.append("_token", csrfToken);
            },
            success: function(file, xhr) {

                if(xhr.status == 0) {
                    // alert(xhr.errors.Avatar[0]);
                    sweetAlert("Oops...", xhr.errors.Avatar[0], "error");
                    $('.dz-success-mark').hide();
                    $('.dz-error-mark')
                                        .show()
                                        .delay(timeDelay)
                                        .fadeOut('slow');
                    $('#avatarZone').css({'box-shadow': '0px 0px 2px 5px rgba(226,131,39,.3)'});
                    // return false;
                } else {
                    $('.dz-success-mark').show().delay(timeDelay).fadeOut('slow');
                    $('.dropzone').css({
                        'background': 'url('+ baseUrl + 'uploads/profile/' + xhr.photo +')',
                        'box-shadow': '0px 0px 2px 5px rgba(101,159,19,.3)'
                    });
                }


            },
            error: function(file, errorMessage, xhr) {
                // alert('Unable to process request' || xhr );
                $('.dz-success-mark').hide();
                $('.dz-error-mark')
                                    .show()
                                    .delay(timeDelay)
                                    .fadeOut('slow');
                $('#avatarZone').css({'box-shadow': '0px 0px 2px 5px rgba(226,131,39,.3)'});
                // return false;
            }
        }

        $('#avatarZone').mouseover(function(){
            $('.avatar-action').show();
        }).mouseout(function(){
            $('.avatar-action').hide();
        });

        $('#profileForm').submit(function(e){

            e.preventDefault();

            if($(this).parsley({ excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden" }).isValid()) {

                $.ajax({
                    url: baseUrl + 'dashboard/profile/store',
                    type: 'post',
                    data: {
                        fullname: $('#fullname').val(),
                        address: $('#address').val(),
                        // email: $('#email').val(),
                        contact: $('#contact').val(),
                        _token: csrfToken
                    },
                    dataType: 'json',
                    success: function(response) {

                        // console.log(response.status);

                        if(response.status == 0) {
                            var message = '<ul>';
                            $.each(response.message, function(index, value){
                                message += '<li align="left">' + value + '</li>';
                            })
                            message += '<ul>';
                            sweetAlert({
                                title : "Oops...",
                                text: message,
                                type: "error",
                                html: true
                            })
                        } else {
                            sweetAlert("Good Job!", 'Profile updated!', "success");
                        }
                    },

                    error: function() {
                        sweetAlert("Oops...", 'Unable to process request!', "error");
                    }
                });
            }
        });

        $('#loginForm').submit(function(e){

            e.preventDefault();

            if($(this).parsley({ excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden" }).isValid()) {

                $.ajax({
                    url: baseUrl + 'dashboard/profile/login/update',
                    type: 'post',
                    data: {
                        currentPassword: $('#currentPassword').val(),
                        newPassword: $('#newPassword').val(),
                        _token: csrfToken
                    },
                    success: function(response) {

                        if(response.status == 0) {

                            var message = '<ul>';
                            $.each(response.message, function(index, value){
                                message += '<li align="left">' + value + '</li>';
                            });
                            message += '<ul>';
                            sweetAlert({
                                title : "Oops...",
                                text: message,
                                type: "error",
                                html: true
                            });
                        } else {
                            sweetAlert("Good Job!", 'Profile updated!', "success");
                        }
                        // sweetAlert("Oops...", message, "error");
                    },

                    error: function() {
                        sweetAlert("Oops...", 'Unable to process request', "error");
                    }
                });
            }
        });
    }
});
