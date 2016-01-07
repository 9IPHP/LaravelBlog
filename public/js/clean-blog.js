$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
$(function(){
    window.alert = AlertMsg;

    $('.article-body p>img').each(function(index, el) {
        // console.log($(el).parents('p').css('text-align'));
        $(el).attr('data-action', 'zoom');
    });

    // 文章是否显示及是否开启评论设置
    $(".article-opt").click(function(){
        var $that = $(this),
            $child = $that.children('i'),
            id = $that.parents('li.article').data('id');
        if($that.hasClass('comment')) type = 'comment_status';
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
        if ($(this).hasClass('doing')) {return;}
        $(this).addClass('doing').fadeTo('slow', 0.5);
        var id = $(this).parents('.article').data('id'),
            $that = $(this),
            $icon = $that.children('i'),
            $count = $that.children('span'),
            action = $that.data('action'),
            count = parseInt($count.html());
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
                            AlertMsg('删除成功');
                        }
                    } else if(response.action == 'up'){
                        $icon.removeClass(icon).addClass(iconActive);
                        $count.html(count+1);
                        AlertMsg(msg);
                    } else{
                        $icon.removeClass(iconActive).addClass(icon);
                        $count.html(count-1);
                    }
                }else if(response.status == 404){
                    AlertMsg('文章不存在', 'Alert--Danger');
                }
                setTimeout(function() {$that.fadeTo('slow', 1, function(){
                    $that.removeClass('doing');
                });}, 2000);
            },
            error: function(data){
                var status = data.status;
                if(status == 401) AlertMsg('登录后才能进行此操作', 'Alert--Danger');
            }
        });
    });

    // 用户中心删除文章
    $('#delArticleUserCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            title = button.data('title'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.title').text(title);
        modal.find('.modal-body input[name="id"]').val(id);
    })

    // 用户中心回收站清空或恢复文章
    $('#trashArticleUserCenter').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            title = button.data('title'),
            id = button.data('id'),
            action = button.data('action'),
            modal = $(this);
        if(action == 'restore') {
            noticeTile = '恢复文章：'+title;
            noticeMsg = '确认要恢复文章《'+title+"》？";
        } else {
            noticeTile = '彻底删除：'+title;
            noticeMsg = '确认要彻底删除文章《'+title+"》？";
        }
        modal.find('.modal-title').text(noticeTile);
        modal.find('.noticeMsg').text(noticeMsg);
        modal.find('.modal-body input[name="id"]').val(id);
        modal.find('.modal-body input[name="action"]').val(action);
    })
    $('.showEmoji').popover({
        html: true,
        content: $("#emoji-template").html(),
        trigger: "focus",
        // placement: 'top',
    })

    $('[data-toggle="tooltip"]').tooltip();

    // Textarea自动缩放
    $('textarea[data-autoresize]').each(function(index, elem) {
      var offset, resizeTextarea;
      offset = elem.offsetHeight - elem.clientHeight;
      resizeTextarea = function(el) {
        return $(el).css('height', 'auto').css('height', el.scrollHeight + offset);
      };
      return $(elem).on('keyup input', function() {
        return resizeTextarea(elem);
      }).removeAttr('data-autoresize');
    });

    // ParseEmoji
    $.fn.ParseEmoji = function() {
        emotionsMap = {};
        for (var i = 1; i <= 20; i++) {
            emotionsMap[':e'+i+':'] = '/img/emojis/'+i+'.png';
        };
        $(this).each(function() {
            var $this = $(this);
            if($this.hasClass('parsed')) return;
            var html = $this.html();
            html = html.replace(/:[^\:]*?:/g, function($1) {
                var url = emotionsMap[$1];
                if (url) {
                    return '<img class="emoji" src="' + url + '" alt="' + $1 + '" />';
                }
                return $1;
            });
            $this.addClass('parsed');
            $this.html(html);
        });

        return this;
    };


    $(".comment-body").ParseEmoji();
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
                $(".comment-body").ParseEmoji();
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
                $(".comment-body").ParseEmoji();
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
    $("#commentPreview").removeClass('parsed').ParseEmoji();
    $('#commentPreview pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
});

$(document).on('propertychange', '#commentBody', function(e){
    var source = $(this).val();
    var mark = marked(source);
    $("#commentPreview").html(mark);
    $('#commentPreview pre code').each(function(i, block) {
        hljs.highlightBlock(block);
    });
})

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
    });
}

function articleRestoreOrDelete () {
    var modal = $("#trashArticleUserCenter"),
        id = modal.find('input[name="id"]').val(),
        action = modal.find('input[name="action"]').val();
    $.post('/articles/opt', {
        id: id,
        action: action
    }, function(response) {
        if (response.status == 200) {
            $('.article[data-id='+id+']').slideUp(function(){
                $(this).remove();
            })
            AlertMsg(response.msg);
        }else{
            AlertMsg(response.msg, 'Alert--Danger');
        }
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

function replyTo(a) {
    /*replyContent = $("#commentBody");
    if (!replyContent.length) {
        AlertMsg('请先登录！', 'Alert--Danger');
    }
    oldContent = replyContent.val();
    prefix = "@" + e + " ";
    newContent = "";
    oldContent.length > 0 ? oldContent != prefix && (newContent = oldContent + "\n" + prefix) : newContent = prefix;
    replyContent.focus();
    replyContent.val(newContent);
    moveEnd($("#commentBody"));*/

    var b;
    a = " @" + a + " ";
    if (document.getElementById("commentBody") && document.getElementById("commentBody").type == "textarea") {
        b = document.getElementById("commentBody")
    } else {
        return false
    }
    if (document.selection) {
        b.focus();
        sel = document.selection.createRange();
        sel.text = a;
        b.focus()
    } else if (b.selectionStart || b.selectionStart == "0") {
        var c = b.selectionStart;
        var d = b.selectionEnd;
        var e = d;
        b.value = b.value.substring(0, c) + a + b.value.substring(d, b.value.length);
        e += a.length;
        b.focus();
        b.selectionStart = e;
        b.selectionEnd = e
    } else {
        b.value += a;
        b.focus()
    }
    // $body.animate( { scrollTop: $('#commentsList').offset().top - 70}, 900);
}

function insertEmoji(a) {
    var b;
    a = " :" + a + ": ";
    if (document.getElementById("commentBody") && document.getElementById("commentBody").type == "textarea") {
        b = document.getElementById("commentBody")
    } else {
        return false
    }
    if (document.selection) {
        b.focus();
        sel = document.selection.createRange();
        sel.text = a;
        b.focus()
    } else if (b.selectionStart || b.selectionStart == "0") {
        var c = b.selectionStart;
        var d = b.selectionEnd;
        var e = d;
        b.value = b.value.substring(0, c) + a + b.value.substring(d, b.value.length);
        e += a.length;
        b.focus();
        b.selectionStart = e;
        b.selectionEnd = e
    } else {
        b.value += a;
        b.focus()
    }
}

function moveEnd (e) {
    e.focus();
    var t = void 0 === e.value ? 0 : e.value.length;
    if (document.selection) {
        var n = e.createTextRange();
        n.moveStart("character", t), n.collapse(), n.select()
    } else "number" == typeof e.selectionStart && "number" == typeof e.selectionEnd && (e.selectionStart = e.selectionEnd = t)
};

function follow (that, id) {
    if($(that).hasClass('doing')){
        return;
    }
    $(that).addClass('doing').fadeTo('slow', 0.5);
    $.post('/users/follow', {
        id: id
    }, function(data, textStatus, xhr) {
        if(data == 1){
            $(that).removeClass('label-success')
                .addClass('label-warning')
                .html('取消关注');
            AlertMsg('关注成功');
        }else if(data == -1){
            $(that).removeClass('label-warning')
                .addClass('label-success')
                .html('关注');
        }else if(data == 404){
            AlertMsg('用户不存在', 'Alert--Danger');
        }else if(data == 401){
            AlertMsg('不能关注自己', 'Alert--Danger');
        }
        setTimeout(function() {$(that).fadeTo('slow', 1, function(){
            $(that).removeClass('doing');
        });}, 2000);
    });
}