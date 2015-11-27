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
                //window.scrollTo(0, 1);
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
            smartIndent: false,
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
            smartIndent: false,
            indentUnit: 4,
            indentWithTabs: true,
            lineWrapping: true,
            lineNumbers: true
        });
    }

    // Beer tasting
    var $beerSelect = $('select#beer-select');
    $beerSelect.change(function() {
        var beer_id = $(this).val();
        var module_id = $(this).attr('data-module_id');
        var $form = $('form#beer-edit');
        if (beer_id == "") {
            $form.find('input[name="id"]').val('');
            $form.find('input[name="name"]').val('');
            $form.find('input[name="price"]').val('');
            $form.find('input[name="alc"]').val('');
            $form.find('input[name="grade"]').val('');
            $form.find('input[name="drunk"]').val('');
            $form.find('textarea[name="desc"]').val('');
            $form.find('input[name="beer_id"]').val('');
            $form.find('select[name="style"]').val('');
            $form.find('select[name="country"]').val('');

            $form.find('#deleteConfirmation').hide();
            $('input[name="beer_id"]').val('');
        } else {
            $.ajax({
                type: "get",
                dataType: "json",
                url: Routing.generate('pulu_palsta_admin_module_use', {'id': module_id, 'beer_id': beer_id}),
                success: function(data) {
                    var beer = data.beer;
                    $form.find('input[name="id"]').val(beer.id);
                    $form.find('input[name="name"]').val(beer.name);
                    $form.find('input[name="price"]').val(beer.price);
                    $form.find('input[name="alc"]').val(beer.alc);
                    $form.find('input[name="grade"]').val(beer.grade);
                    $form.find('input[name="drunk"]').val(beer.drunk_date);
                    $form.find('textarea[name="desc"]').val(beer.description);
                    $form.find('input[name="beer_id"]').val(beer.id);
                    $form.find('select[name="style"]').val(beer.style);
                    $form.find('select[name="country"]').val(beer.country);

                    $form.find('#deleteConfirmation').show();
                    $('input[name="beer_id"]').val(beer.id);
                }
            });
        }
    });
    var init_beer_select = $beerSelect.attr('data-init_beer');
    if (typeof init_beer_select !== undefined && init_beer_select != "") {
        $beerSelect.val(init_beer_select).change();
    }

    // Toggle keywords
    var $toggleKeywords = $('#toggleKeywords');
    $toggleKeywords.click(function() {
        var currentText = $toggleKeywords.html();
        var altText = $toggleKeywords.attr('data-alt-text');
        $toggleKeywords.html(altText);
        $toggleKeywords.attr('data-alt-text', currentText);
        $('tr[data-special="1"]').toggle();
    });

});