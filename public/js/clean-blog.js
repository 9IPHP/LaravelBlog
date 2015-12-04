$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
    $('.article-body p>img').each(function(index, el) {
        // console.log($(el).parents('p').css('text-align'));
        $(el).attr('data-action', 'zoom');
    });

    // 文章是否显示及是否开启评论设置
    $(".article-opt").click(function(){
        var $that = $(this),
            $child = $that.children('i'),
            id = $that.parents('li.article').data('id');
        if ($that.hasClass('publish')) type = 'is_active';
        else if($that.hasClass('comment')) type = 'comment_status';
        else return;
        if($child.hasClass('fa-square-o')) {
            $child.removeClass('fa-square-o').addClass('fa-spinner fa-spin');
            newStatus = 1;
        } else {
            $child.removeClass('fa-check-square-o').addClass('fa-spinner fa-spin');
            newStatus = 0;
        }
        $.post('/articles/active', {
            id: id,
            newStatus: newStatus,
            type: type
        }, function(response) {
            if(response == 200){
                if(newStatus) $child.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
                else $child.removeClass('fa-spinner fa-spin').addClass('fa-square-o');
            }else{
                if(newStatus) $child.removeClass('fa-spinner fa-spin').addClass('fa-square-o');
                else $child.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
            }
        });
    })
})


// Navigation Scripts to Show Header on Scroll-Up
jQuery(document).ready(function($) {
    var MQL = 1170;

    //primary navigation slide-in effect
    if (webConfig.navScroll && $(window).width() > MQL) {
        var headerHeight = $('.navbar-custom').height();
        $(window).on('scroll', {
                previousTop: 0
            },
            function() {
                var currentTop = $(window).scrollTop();
                //check if user is scrolling up
                if (currentTop < this.previousTop) {
                    //if scrolling up...
                    if (currentTop > 0 && $('.navbar-custom').hasClass('is-fixed')) {
                        $('.navbar-custom').addClass('is-visible');
                    } else {
                        $('.navbar-custom').removeClass('is-visible is-fixed');
                    }
                } else {
                    //if scrolling down...
                    $('.navbar-custom').removeClass('is-visible');
                    if (currentTop > headerHeight && !$('.navbar-custom').hasClass('is-fixed')) $('.navbar-custom').addClass('is-fixed');
                }
                this.previousTop = currentTop;
            });
    }
});
