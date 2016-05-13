$(document).ready(function() {

    var opts = {
          lines: 11 // The number of lines to draw
        , length: 30 // The length of each line
        , width: 20 // The line thickness
        , radius: 54 // The radius of the inner circle
        , scale: 0.25 // Scales overall size of the spinner
        , corners: 1 // Corner roundness (0..1)
        , color: '#000' // #rgb or #rrggbb or array of colors
        , opacity: 0.25 // Opacity of the lines
        , fps: 20 // Frames per second when using setTimeout() as a fallback for CSS
        , zIndex: 0 // The z-index (defaults to 2000000000)
    },
    cardTpl = $('#cardTemplate').length > 0 ?_.template(
        $('#cardTemplate').html()
    ) : '',
    currentEditedId = '';


    $('#newNumberForm').submit(function(e) {

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        var newNumberForm = $(this);

    if(newNumberForm.parsley({ excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden" }).isValid()) {

            var saveBtn = $(this).children('button');

            saveBtn.attr('disabled', 'disabled');

            var userAlias = $('#alias').val(),
                mobileNumber = $('#mobile').val(),
                mobileNetwork = $('#network').val(),
                mobileNetworkText = $('#network option:selected').text();

            $.ajax({
                url: baseUrl + 'dashboard/number/store',
                type: 'post',
                data: {
                    alias: userAlias,
                    mobile: mobileNumber,
                    network: mobileNetwork,
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

                        newNumberForm.parsley().reset();

                    } else {

                        var newNumber = {
                            id: response.id,
                            mobile_number: mobileNumber,
                            alias : userAlias,
                            network: mobileNetworkText
                        };


                        sweetAlert("Good Job!", 'Mobile number has been added!', "success");

                        $('.cards-wrapper').prepend(
                            cardTpl({
                                number: newNumber
                            })
                        );
                    }
                    saveBtn.removeAttr('disabled');
                    return false;
                },

                error: function() {
                    sweetAlert("Oops...", 'Unable to process request!', "error");
                    return false;
                }
            });
        }
    });

    $('.cards-wrapper').on('click', '#removeNumber', function(e) {

        e.preventDefault();

        var $this = $(this);

        $this.spin(opts);

        $this.blur().tooltip('destroy');

        $.ajax({
            type: 'post',
            url: baseUrl + 'dashboard/number/destroy',
            data: {
                id : $(this).data('id'),
                _token: csrfToken
            },
            dataType: 'json',
            success: function(response) {

                if(response.status == 1) {
                    swal("Deleted!", "Number removed from the list.", "success");
                    $this.replaceWith('<a id="undo" href="javascript:void(0);" data-id="'+ $this.data('id') +'" data-toggle="tooltip" data-placement="left" data-trigger="hover" title="Undo remove action"><i class="glyphicon glyphicon-repeat">');
                } else {
                    swal("Opps...", response.message, "error");
                }

                $this.spin(false);
            },
            error: function() {
                sweetAlert("Oops...", 'Unable to process request!', "error");
                return false;
            }
        });
    });

    $('.cards-wrapper').on("click", '#undo', function() {

        var $this = $(this);

        $this.spin(opts);
        $this.blur().tooltip('destroy');

        $.ajax({
            type: 'post',
            url: baseUrl+'dashboard/number/restore',
            data: {
                id: $(this).data('id'),
                _token: csrfToken
            },
            dataType: 'json',
            success: function(response) {

                 if(response.status == 1) {
                    swal("Restored!", "The selected number has been restored.", "success");
                    $this.replaceWith('<a id="removeNumber" href="javascript:void(0);" data-id="'+ $this.data('id') +'" title="Remove number" data-toggle="tooltip" data-placement="left" data-trigger="hover"><i class="glyphicon glyphicon-trash">');
                } else {
                    swal("Opps...", response.message, "error");
                }
                $this.spin(false);

            },
            error:function() {
                sweetAlert("Oops...", 'Unable to process request!', "error");
                return false;
            }
        });
    });

    $('.cards-wrapper').on("click", '[id^=editNumber-]', function() {

        var editNumberFormTemplate = _.template($('#editNumberTemplate').html()),
            $this = $(this),
            $id = $this.data('id');

            currentEditedId = $id;

        $.ajax({
            type: 'post',
            url: baseUrl + 'dashboard/number/details',
            data: {
                id: $id,
                _token : csrfToken
            },
            dataType: "json",
            success: function(response) {

                if(response.status == 1) {

                    $this.parents('ul').siblings('.number-info')
                                            .empty()
                                            .append(
                                                editNumberFormTemplate({
                                                    details: response
                                                })
                                            );
                } else {

                    var message = '<ul>';

                    $.each(response.message, function(index, value) {
                        message += '<li align="left">' + value + '</li>';
                    });

                    message += '<ul>';
                    sweetAlert({
                        title : "Oops...",
                        text: message,
                        type: "error",
                        html: true
                    });
                    newNumberForm.parsley().reset();
                }

            },
            error:function() {
                sweetAlert("Oops...", 'Unable to process request!', "error");
                return false;
            }
        });
    });

    $('.cards-wrapper').on('submit', '#editNumberForm', function(e){

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        var editNumberForm = $(this);

        if(editNumberForm.parsley({ excluded: "input[type=button], input[type=submit], input[type=reset], input[type=hidden], [disabled], :hidden" }).isValid()) {

            var saveBtn = $(this).children('button');

            saveBtn.attr('disabled', 'disabled');

            var userAlias = $('#alias-' + currentEditedId).val(),
                mobileNumber = $('#mobile-' + currentEditedId).val(),
                mobileNetwork = $('#network-' + currentEditedId).val(),
                mobileNetworkText = $('#network-' +  + currentEditedId +' option:selected').text();

            $.ajax({
                url: baseUrl + 'dashboard/number/update',
                type: 'post',
                data: {
                    id: currentEditedId,
                    alias: userAlias,
                    mobile: mobileNumber,
                    network: mobileNetwork,
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

                        editNumberForm.parsley().reset();

                    } else {

                        var updatedNumber = {
                                "id": currentEditedId,
                                "mobile_number": mobileNumber,
                                "alias": userAlias,
                                "network": mobileNetworkText
                        };

                        editNumberForm.parents('div.number-info')
                                        .parents('div.card')
                                        .parents('.card-wrapper')
                                        .empty()
                                        .replaceWith(
                                            cardTpl({number : updatedNumber})
                                        )

                        // console.log(editNumberForm.parents('div.number-info').parents('div.card').parents('.card-wrapper')[0]);

                    }
                    saveBtn.removeAttr('disabled');
                    return false;
                },

                error: function() {
                    sweetAlert("Oops...", 'Unable to process request!', "error");
                    return false;
                }
            });
        }

    });

});
