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
Main page
----------------------------------------- */
$(document).ready(function() {

    $('#tag-cloud ul').find('a').live('click', function() {
        var tag_id = $(this).attr('data-tag_id');
        var heading = $(this).html();
        $('table.by-tag').hide();
        $('#select-tag').hide();
        $('#tag-results').find('h3').remove();
        $('#tag-results').prepend('<h3 style="margin-top: 0">' + heading + '</h3>');
        $('#table' + tag_id).fadeIn('slow');
        return false;
    });
    
});

/* -----------------------------------------
Contents
----------------------------------------- */
$(document).ready(function() {
    $('table#contents').dataTable({
        'bFilter': false,
        'bInfo': false,
        'bPaginate': false
    });

});

/* -----------------------------------------
Article
----------------------------------------- */

function ShowRating (element, rating) {
    var stars = element.find('div');
    stars.removeClass('selected highlighted');
    rating = parseInt(rating);
    if (rating < 1 || rating > stars.length) {
        return false;
    }
    stars.eq(rating-1).addClass('selected').prevAll().addClass('highlighted');
    return true;
}

$(document).ready(function() {

    var locale = $('#locale').attr('data-locale');

    // Add comment
    $('form#articleComment').submit(function() {
        var $form = $(this);
        $.ajax({
            type: "POST",
            url: Routing.generate('pulu_palsta_article_comment', {'_locale': locale}),
            data: $(this).serialize(),
            success: function(data) {
                if (data['success'] == true) {
                    alertify.success(data['message']);
                    $('table#comments').closest('div').fadeIn(2000);
                    $('table#comments').find('tbody:last').append('<tr style="display: none"><td style="width: 12%"><strong>' + data['data']['author_name'] + '</strong><br /><small>' + data['data']['created'] + '</small></td><td>' + data['data']['comment'] + '</td></tr>');
                    $('table#comments').find('tr:last').fadeIn(2000);
                    $form[0].reset();
                } else {
                    alertify.error(data['message']);
                }
            },
            error: function(data) {
                alertify.error(translations['failed_to_send_your_comment']);
            },
            dataType: "json"
        });
        return false;

    });

    // Rating
    $('#rating').each(function() {
        var $this = $(this);
        ShowRating($this, $this.data('rating'));
    }).bind({
        mouseleave: function() {
            var $this = $(this);
            ShowRating($this, $this.data('rating'));
        }
    }).find('div').bind({
        mouseenter: function() {
            var $this = $(this);
            ShowRating($this.parent(), $this.index() + 1);
        },
        click: function() {
            var article_id = $('#article_id').attr('data-id');
            var $this = $(this);
            var $parent = $this.parent();
            var idx = $this.index() + 1;
            if ($parent.data('rating') == idx) {
                // Remove rating
                ShowRating($parent, 0);
                $parent.data('rating', 0);
            } else {
                // Set rating
                ShowRating($parent, idx);
                $parent.data('rating', idx);
            }
            $.ajax({
                type: "POST",
                url: Routing.generate('pulu_palsta_article_rating', {'_locale': locale}),
                data: {
                    rating: $parent.data('rating'),
                    article_id: article_id
                },
                success: function(data) {
                    if (data['success'] == true) {
                        alertify.success(data['message']);
                    } else {
                        alertify.error(data['message']);
                    }
                },
                error: function(data) {
                    alertify.error(translations['your_rating_failed']);
                },
                dataType: "json"
            });
        }
    });

});


/* -----------------------------------------
Admin
----------------------------------------- */
$(document).ready(function() {
    
    // Notice
    $('#notice').delay(2000).slideUp(2000);

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
        } else {
            $('#language-en').hide();
            $('a.switch-language[data-to="en"]').css("font-weight", "normal");
        }
    });

});