$(document).ready(function(){
    $('[data-toggle="help-popover"]').popover({ trigger: 'hover', placement: 'bottom', html: true });

    /*  TAB MENU */
    // for bootstrap 3 use 'shown.bs.tab', for bootstrap 2 use 'shown' in the next line
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        // save the latest tab; use cookies if you like 'em better:
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    // go to the latest tab, if it exists:
    var lastTab = localStorage.getItem('lastTab');
    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }

    // $('[data-toggle="tooltip"]').tooltip();
    $(document).on('mouseenter','[data-toggle=tooltip]', function(){
        $(this).tooltip('show');
    });

    $(document).on('mouseleave','[data-toggle=tooltip]', function(){
        $(this).tooltip('hide');
    });
});
