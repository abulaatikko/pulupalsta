;(function ($, window, undefined) {
    'use strict';

    var $doc = $(document),
    Modernizr = window.Modernizr;


    $.fn.foundationAlerts           ? $doc.foundationAlerts() : null;
    $.fn.foundationAccordion        ? $doc.foundationAccordion() : null;
    $.fn.foundationTooltips         ? $doc.foundationTooltips() : null;
    $('input, textarea').placeholder();


    $.fn.foundationButtons          ? $doc.foundationButtons() : null;


    $.fn.foundationNavigation       ? $doc.foundationNavigation() : null;


    $.fn.foundationTopBar           ? $doc.foundationTopBar() : null;

    $.fn.foundationCustomForms      ? $doc.foundationCustomForms() : null;
    $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;


    $.fn.foundationTabs             ? $doc.foundationTabs() : null;


    $("#featured").orbit();

    // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
    // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
    // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
    // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
    // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

    // Hide address bar on mobile devices
    if (Modernizr.touch) {
        $(window).load(function () {
            setTimeout(function () {
                window.scrollTo(0, 1);
            }, 0);
        });
    }

})(jQuery, this);

/* -----------------------------------------
Admin
----------------------------------------- */
$(document).ready(function() {
    
    // Delete confirmation
    $("#deleteConfirmation").click(function() {
        $("#deleteConfirmationModal").reveal();
        return false;
    });
    $("#deleteConfirmationModal").find(".close").click(function() {
        $(this).trigger('reveal:close');
        return false;
    });

    // Article localization
    $('#language-en').hide();
    $('a.switch-language[data-to="fi"]').css("font-weight", "bold");
    $('.switch-language').bind('click', function() {
        var to = $(this).attr('data-to');
        $('#language-' + to).show();
        $('a.switch-language[data-to="' + to + '"]').css("font-weight", "bold");
        if (to == 'en') {
            $('#language-fi').hide();    
            $('a.switch-language[data-to="fi"]').css("font-weight", "normal");
            CM1.refresh();
            CM2.refresh();
        } else {
            $('#language-en').hide();
            $('a.switch-language[data-to="en"]').css("font-weight", "normal");
            CM1.refresh();
            CM2.refresh();
        }

    });

    // Article body codemirror
    var textarea1 = $('#article_localizations_0_body').get(0);
    if (typeof textarea1 != "undefined") {
        var CM1 = CodeMirror.fromTextArea(textarea1, {
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            lineWrapping: true,
            lineNumbers: true
        });
    }
    var textarea2 = $('#article_localizations_1_body').get(0);
        if (typeof textarea2 != "undefined") {
        var CM2 = CodeMirror.fromTextArea(textarea2, {
            mode: "application/x-httpd-php",
            indentUnit: 4,
            indentWithTabs: true,
            lineWrapping: true,
            lineNumbers: true
        });
    }

});