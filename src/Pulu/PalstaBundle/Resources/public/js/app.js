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
    /*if (Modernizr.touch) {
        $(window).load(function () {
            setTimeout(function () {
                window.scrollTo(0, 1);
            }, 0);
        });
    }*/

})(jQuery, this);

/* -----------------------------------------
Main page
----------------------------------------- */
$(document).ready(function() {

    var locale = $('#locale').attr('data-locale');

    $('#keyword-cloud .keyword').live('click', function() {
        var $this = $(this);
        var keyword_id = $this.attr('data-keyword_id');
        $.ajax({
            type: "POST",
            url: Routing.generate('pulu_palsta_keyword', {'_locale': locale}),
            data: {
                keyword_id: keyword_id,
                locale: locale
            },
            success: function(data) {
                var keyword_results = $('#keyword-results');
                keyword_results.empty();

                var table = '<table class="by-keyword wide hide"><thead><tr><th>#</th><th>'+translations['article']+'</th><th>'+translations['visits']+'</th></tr></thead><tbody>';
                $.each(data['data'], function(index, element) {
                    var link = Routing.generate('pulu_palsta_article', {'article_number': element.article_number, 'name': element.link_name, '_locale': locale});
                    table = table + '<tr><td>' + (index + 1) + '.</td><td><a href="' + link + '">' + element.name + '</a></td><td>' + element.visits + '</td></tr>';
                });
                table = table + '</tbody></table>';

                keyword_results.append(table);
                $('table.by-keyword').fadeIn(1000);
            },
            dataType: "json"
        });
        return false;

    });
    
});

$(document).ready(function() {

    /* -----------------------------------------
    Contents
    ----------------------------------------- */

    var contentsTable = $('table#contents').dataTable({
        'bFilter': false,
        'bInfo': false,
        'bPaginate': false,
        "aoColumnDefs": [
            { "asSorting": [ "asc", "desc" ], "aTargets": [ 0 ] },
            { "asSorting": [ "desc", "asc" ], "aTargets": [ 1 ] },
            { "asSorting": [ "desc", "asc" ], "aTargets": [ 2 ] },
            { "asSorting": [ "desc", "asc" ], "aTargets": [ 3 ] },
            { "asSorting": [ "desc", "asc" ], "aTargets": [ 4 ] },
            { "asSorting": [ "desc", "asc" ], "aTargets": [ 5 ] },
            { "asSorting": [ "desc", "asc" ], "aTargets": [ 6 ] }
        ]
    });

    var sort = getParameterByName('sort');
    if (sort != null) {
        if (sort == 'name') {
            contentsTable.fnSort([[0, 'asc']]);
        } else if (sort == 'visit') {
            contentsTable.fnSort([[1, 'desc']]);
        } else if (sort == 'rating') {
            contentsTable.fnSort([[2, 'desc']]);
        } else if (sort == 'comments') {
            contentsTable.fnSort([[3, 'desc']]);
        } else if (sort == 'commented') {
            contentsTable.fnSort([[4, 'desc']]);
        } else if (sort == 'modified') {
            contentsTable.fnSort([[5, 'desc']]);
        } else if (sort == 'published') {
            contentsTable.fnSort([[6, 'desc']]);
        }        
    }


    /* -----------------------------------------
    Article
    ----------------------------------------- */

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

    $(".fancybox").fancybox({
        loop: false,
        helpers: {
            title: {
                type: 'inside'
            }
        },
        beforeLoad: function() {
            var el, id = $(this.element).data('title-id');
            if (id) {
                el = $('#' + id);
                if (el.length) {
                    this.title = el.html();
                }
            }
        },
    });

    // Beer tasting
    var $beerTable = $('table#beer-tasting-beers');
    if ($beerTable.length) {
        var beerTastingTable = $beerTable.dataTable({
            'bFilter': false,
            'bInfo': false,
            'bPaginate': false,
            "aoColumnDefs": [
                { "asSorting": [ "asc", "desc" ], "aTargets": [ 0 ] },
                { "asSorting": [ "asc", "desc" ], "aTargets": [ 1 ] },
                { "asSorting": [ "desc", "asc" ], "aTargets": [ 2 ] },
                { "asSorting": [ "asc", "desc" ], "aTargets": [ 3 ] },
                { "asSorting": [ "asc", "desc" ], "aTargets": [ 4 ] },
                { "asSorting": [ "desc", "asc" ], "aTargets": [ 5 ] },
                { "asSorting": [ "desc", "asc" ], "aTargets": [ 6 ] },
                { "asSorting": [ "desc", "asc" ], "aTargets": [ 7 ] }
            ]
        });
        beerTastingTable.fnSort([[0, 'desc']]);
    }

    // Municipality
    $('#sortByImageTaken').bind('click', function() {
        var me = $(this);
        var direction = me.attr('data-direction');
        me.attr('data-direction', -1 * direction);
        var images = $('#signImagesContainer').children('.imgContainer').get();
        images.sort(function(a, b) {
            var $a = $(a);
            var $b = $(b);
            var aTaken = $a.attr('data-sortby-taken');
            var bTaken = $b.attr('data-sortby-taken');
            if (aTaken == bTaken) {
                var aName = $a.attr('data-sortby-name');
                var bName = $b.attr('data-sortby-name');
                return +aName < +bName ? direction * 1 : direction * -1;
            }
            return aTaken < bTaken ? direction * 1 : direction * -1;
        });
        $.each(images, function(i, e) {
            $('#signImagesContainer').append(e);
        });
    });
    $('#sortByName').bind('click', function() {
        var me = $(this);
        var direction = me.attr('data-direction');
        me.attr('data-direction', -1 * direction);
        var images = $('#signImagesContainer').children('.imgContainer').get();
        images.sort(function(a, b) {
            var aName = $(a).attr('data-sortby-name');
            var bName = $(b).attr('data-sortby-name');
            return +aName < +bName ? direction * 1 : direction * -1;
        });
        $.each(images, function(i, e) {
            $('#signImagesContainer').append(e);
        });
    });

});

$(window).load(function() {
    var thisHash = window.location.hash;
    if (window.location.hash.indexOf('#img-') === 0) {
        $(thisHash + ' .fancybox').trigger('click');
    }
});

function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

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
