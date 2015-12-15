$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
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

    // 文章详情页操作
    $('.js-action').click(function() {
        var id = $(this).parents('.article').data('id'),
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
                    if ($that.hasClass('js-delete')){
                        if(response.action == 'up'){
                            AlertMsg('收藏成功');
                        }else{
                            $that.parents('.todel').slideUp(function(){
                                $(this).remove();
                            })
                            AlertMsg('删除成功', 'Alert--Danger');
                        }
                    } else if(response.action == 'up'){
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

$(document).on('submit', '#commentForm', function(event) {
    event.preventDefault();
    var article_id = $('#commentForm [name="article_id"]').val(),
        body = $('#commentForm [name="body"]').val(),
        $commentNum = $('.commentNum'),
        commentNumber = parseInt($commentNum.eq(0).text()),
        $submit = $('#commentBtn');
    if(body == '') {
        AlertMsg('评论内容不能为空', 'Alert--Danger');
        return;
    }
    $submit.attr('disabled', true).fadeTo('slow', 0.5);
    $.ajax({
        url: '/comment/store',
        type: 'POST',
        dataType: 'json',
        data: {
            article_id: article_id,
            body: body
        },
        success: function(response){
            if (response.status == 200) {
                $('#commentForm [name="body"]').val('');
                $("#commentPreview").html('');
                $('#commentsList').prepend(marked(response.html))
                $commentNum.text(commentNumber + 1);
                $('#commentsList pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
                $body.animate( { scrollTop: $('#commentsList').offset().top - 10}, 900);
                AlertMsg(response.msg);
            }else{
                AlertMsg(response.msg, 'Alert--Danger');
            }
            $submit.attr('disabled', false).fadeTo('slow', 1);
        },
        error: function(response){
            if (response.status == 401)
                AlertMsg('请先登录', 'Alert--Danger');
            $submit.attr('disabled', false).fadeTo('slow', 1);
        }
    });
});
$(document).on('click', '#commentsList .pager a', function(event) {
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1],
        article_id = $('.article').data('id');
    getArticleComment(article_id, page);
});

function getArticleComment (article_id, page) {
    $.ajax({
        url: '/comment/get',
        type: 'GET',
        dataType: 'json',
        data: {
            article_id: article_id,
            page: page
        },
        success: function(response){
            if (response.status == 200) {
                $('#commentsList').html(response.html);
                $('#commentsList pre code').each(function(i, block) {
                    hljs.highlightBlock(block);
                });
                $body.animate( { scrollTop: $('#commentsList').offset().top - 70}, 900);
            }else{
                AlertMsg(response.msg, 'Alert--Danger');
            }
        },
        error: function(response){
        }
    });
}

$("#commentBody").bind('blur keyup',  function(event) {
    var source = $(this).val();
    var mark = marked(source);
    $("#commentPreview").html(mark);
    $('#commentPreview pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
});
$(document).on('propertychange', function(e){
    var source = $(this).val();
    var mark = marked(source);
    $("#commentPreview").html(mark);
    $('#commentPreview pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
})

(function() {
  $(function() {
    return $('textarea[data-autoresize]').each(function(index, elem) {
      var offset, resizeTextarea;
      offset = elem.offsetHeight - elem.clientHeight;
      resizeTextarea = function(el) {
        return $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
      };
      return $(elem).on('keyup input', function() {
        return resizeTextarea(elem);
      }).removeAttr('data-autoresize');
    });
  });

}).call(this);

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

function replyOne(e) {
    replyContent = $("#commentBody"),
    oldContent = replyContent.val(),
    prefix = "@" + e + " ",
    newContent = "",
    oldContent.length > 0 ? oldContent != prefix && (newContent = oldContent + "\n" + prefix) : newContent = prefix,
    replyContent.focus(),
    replyContent.val(newContent),
    moveEnd($("#commentBody"))
    // $body.animate( { scrollTop: $('#commentsList').offset().top - 70}, 900);
}

function moveEnd (e) {
    e.focus();
    var t = void 0 === e.value ? 0 : e.value.length;
    if (document.selection) {
        var n = e.createTextRange();
        n.moveStart("character", t), n.collapse(), n.select()
    } else "number" == typeof e.selectionStart && "number" == typeof e.selectionEnd && (e.selectionStart = e.selectionEnd = t)
};