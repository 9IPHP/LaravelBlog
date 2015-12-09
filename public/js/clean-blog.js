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
        $.ajax({
            type: 'post',
            url: '/articles/active',
            data: {
                id: id,
                newStatus: newStatus,
                type: type
            },
            dataType: 'json',
            success: function(response){
                if(response == 200){
                    if(newStatus) $child.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
                    else $child.removeClass('fa-spinner fa-spin').addClass('fa-square-o');
                }else{
                    if(newStatus) $child.removeClass('fa-spinner fa-spin').addClass('fa-square-o');
                    else $child.removeClass('fa-spinner fa-spin').addClass('fa-check-square-o');
                }
            },
            error: function(data){

            }
        });
    });

    $('.js-action').click(function() {
        var id = $(this).parents('.article-footer-meta').data('article-id'),
            $that = $(this),
            $icon = $that.children('i'),
            $count = $that.children('span'),
            action = $that.data('action'),
            count = parseInt($count.html());
        $that.attr('disabled', true);
        if(action == 'Like'){
            var ajaxUrl = '/articles/like',
                icon = 'fa-thumbs-o-up',
                iconActive = 'fa-thumbs-up',
                msg = '点赞成功';
        } else if(action == 'Collect'){
            var ajaxUrl = '/articles/collect',
                icon = 'fa-bookmark-o',
                iconActive = 'fa-bookmark',
                msg = '收藏成功';
        }
        $.ajax({
            type: 'post',
            url: ajaxUrl,
            data: {
                id: id,
            },
            dataType: 'json',
            success: function(response){
                if (response.status == 200) {
                    if(response.action == 'up'){
                        $icon.removeClass(icon).addClass(iconActive);
                        $count.html(count+1);
                        AlertMsg(msg);
                    }
                    else{
                        $icon.removeClass(iconActive).addClass(icon);
                        $count.html(count-1);
                    }
                    $that.attr('disabled', false);
                };
            },
            error: function(data){
                var status = data.status;
                if(status == 401) AlertMsg('登录后才能进行此操作', 'Alert--Danger');
            }
        });
    });

    $('#delArticleUserCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            title = button.data('title'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.modal-title').text('删除：' + title)
        modal.find('.modal-body input[name="id"]').val(id)
    })

    $('[data-toggle="tooltip"]').tooltip()
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

function delArticle () {
    var modal = $("#delArticleUserCenter"),
        id = modal.find('input[name="id"]').val();
    $.post('/article/'+id, {
        id: id,
        _method: 'DELETE'
    }, function(response) {
        if (response == 200) {
            $('.article[data-id='+id+']').slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else{
            AlertMsg('删除失败');
        }
        modal.modal('hide')

    });
}

function AlertMsg (msg, newclass) {
    var alertDom = $($("#flash-template").html());
    $(".Alert").remove();
    alertDom.addClass(newclass || '').find(".Alert__body").html(msg).end().appendTo("body").hide().fadeIn(300).delay(2800).animate({
        marginRight: "-100%"
    }, 300, "swing", function() {
        $(this).remove()
    })
}
