$(function() {

    $('#side-menu').metisMenu();
    $('[data-toggle="tooltip"]').tooltip()

    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }

    // 彻底删除文章（单个）
    $('#delArticleAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            title = button.data('title'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.deleteTitle').text(title);
        modal.find('.modal-body input[name="id"]').val(id);
    })

    // 彻底删除文章（多个）
    $('#delAllArticle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            msg = button.data('msg'),
            all = button.data('all'),
            modal = $(this);
        modal.find('.delMsg').text(msg);
        modal.find('.modal-body input[name="all"]').val(all);
    })

    // 恢复文章
    $('#restoreArticle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            title = button.data('title'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.deleteTitle').text(title);
        modal.find('.modal-body input[name="id"]').val(id);
    })

    $('#delUserAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            name = button.data('name'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.modal-title').text('删除用户：' + name);
        modal.find('.deleteUser').text(name);
        modal.find('.modal-body input[name="id"]').val(id);
    })

    $(".userRole").change(function(event) {
        event.preventDefault();
        var oldRoleId = $(this).data('id'),
            newRoleId = $(this).val(),
            userId = $(this).parents('tr').data('id'),
            oldHtml = $(this).parent().html(),
            newRole = $(this).find("option:selected").text(),
            name = $(this).parents('tr').find('.name').text(),
            modal = $('#updateRole');
        $(this).parents('td').find('i.fa').removeClass('hidden');
        $(this).parents('td').find('select').addClass('hidden');

        modal.find('input[name="user_id"]').val(userId);
        modal.find('input[name="role_id"]').val(newRoleId);
        modal.find('.name').text(name);
        modal.find('.role').text(newRole);
        modal.modal('show')

    });

    $('#updateRole').on('hide.bs.modal', function (event) {
        var userId = $(this).find('input[name="user_id"]').val(),
            roleId = $(this).find('input[name="role_id"]').val();
        $('#user-'+userId+' .role input[type="reset"]').click();
        $('#user-'+userId+' .role select').removeClass('hidden');
        $('#user-'+userId+' .role i.fa').addClass('hidden');
    });

    // 删除标签
    $('#delTagAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            name = button.data('name'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.name').text(name);
        modal.find('.modal-body input[name="id"]').val(id);
    });

    // 删除评论
    $('#delCommentAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            body = button.data('body'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.body').text(body);
        modal.find('.modal-body input[name="id"]').val(id);
    });

    $('#delImageAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            name = button.data('name'),
            url = button.data('url'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.image').text(name);
        modal.find('#url').attr('src', url);
        modal.find('.modal-body input[name="id"]').val(id);
    });

    $('#showImageAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            url = button.data('url')
            modal = $(this);
        modal.find('.modal-body img').attr('src', url);
    })

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
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function trashArticle () {
    var modal = $("#delArticleAdmin"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/articles/'+id, {
        id: id,
        _method: 'DELETE'
    }, function(response) {
        if (response == 200) {
            $('tr#article-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else if(response == 404){
            AlertMsg('文章不存在', 'Alert--Danger');
        }else{
            AlertMsg('删除失败', 'Alert--Danger');
        }

    });
}

function delArticle () {
    var modal = $("#delArticleAdmin"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/articles/delete/'+id, {
        id: id,
        _method: 'DELETE'
    }, function(response) {
        if (response == 200) {
            $('tr#article-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else if(response == 404){
            AlertMsg('文章不存在', 'Alert--Danger');
        }else{
            AlertMsg('删除失败', 'Alert--Danger');
        }
    });
}

function restoreArticle () {
    var modal = $("#restoreArticle"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/articles/restore/'+id, function(response) {
        if (response == 200) {
            $('tr#article-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('恢复成功');
        }else if(response == 404){
            AlertMsg('文章不存在', 'Alert--Danger');
        }else{
            AlertMsg('恢复失败', 'Alert--Danger');
        }
    });
}

function delComment () {
    var modal = $("#delCommentAdmin"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/articles/delcomment', {
        id: [id]
    }, function(response) {
        if (response == 200) {
            $('tr#comment-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else if(response == 404){
            AlertMsg('评论不存在', 'Alert--Danger');
        }else{
            AlertMsg('删除失败', 'Alert--Danger');
        }
    });
}

function delCheckedComments () {
    var modal = $("#delAllComments"),
        id = [],
        all = modal.find('input[name="all"]').val();

    $.each($('input[name="delCommentId[]"]:checked'), function(index, val) {
        id.push($(val).val())
    });
    if (id.length) {
        $.post('/admin/articles/delcomment', {
            id: id
        }, function(response) {
            if (response == 200) {
                $.each(id, function(index, val) {
                    $('#comment-'+val).slideUp(function(){
                        $(this).remove();
                    })
                });
                AlertMsg('删除成功');
            }else if(response == 404){
                AlertMsg('评论不存在', 'Alert--Danger');
            }else{
                AlertMsg('删除失败', 'Alert--Danger');
            }
        });
    }else{
        AlertMsg('请选择要删除的评论', 'Alert--Danger');
    }
}

function delTag () {
    var modal = $("#delTagAdmin"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/articles/deltag', {
        id: [id]
    }, function(response) {
        if (response == 200) {
            $('tr#tag-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else if(response == 404){
            AlertMsg('标签不存在', 'Alert--Danger');
        }else{
            AlertMsg('删除失败', 'Alert--Danger');
        }
    });
}

function delCheckedTags () {
    var modal = $("#delAllTags"),
        id = [],
        all = modal.find('input[name="all"]').val();

    $.each($('input[name="delTagId[]"]:checked'), function(index, val) {
        id.push($(val).val())
    });
    if (id.length) {
        $.post('/admin/articles/deltag', {
            id: id
        }, function(response) {
            if (response == 200) {
                $.each(id, function(index, val) {
                    $('#tag-'+val).slideUp(function(){
                        $(this).remove();
                    })
                });
                AlertMsg('删除成功');
            }else if(response == 404){
                AlertMsg('标签不存在', 'Alert--Danger');
            }else{
                AlertMsg('删除失败', 'Alert--Danger');
            }
        });
    }else{
        AlertMsg('请选择要删除的标签', 'Alert--Danger');
    }
}

function delImage () {
    var modal = $("#delImageAdmin"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/images/delimage', {
        id: [id]
    }, function(response) {
        if (response == 200) {
            $('tr#image-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else if(response == 404){
            AlertMsg('图片不存在', 'Alert--Danger');
        }else{
            AlertMsg('删除失败', 'Alert--Danger');
        }
    });
}

function delCheckedImages () {
    var modal = $("#delAllImages"),
        id = [],
        all = modal.find('input[name="all"]').val();

    $.each($('input[name="delImageId[]"]:checked'), function(index, val) {
        id.push($(val).val())
    });
    if (id.length) {
        $.post('/admin/images/delimage', {
            id: id
        }, function(response) {
            if (response == 200) {
                $.each(id, function(index, val) {
                    $('#image-'+val).slideUp(function(){
                        $(this).remove();
                    })
                });
                AlertMsg('删除成功');
            }else if(response == 404){
                AlertMsg('图片不存在', 'Alert--Danger');
            }else{
                AlertMsg('删除失败', 'Alert--Danger');
            }
        });
    }else{
        AlertMsg('请选择要删除的图片', 'Alert--Danger');
    }
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

function checkAll (name) {
    $('input[type="checkbox"][name="'+name+'[]"]').prop('checked', true);
}

function unCheckAll (name) {
    $('input[type="checkbox"][name="'+name+'[]"]').prop('checked', false);
}

function delCheckedArticles () {
    var modal = $("#delAllArticle"),
        id = [],
        all = modal.find('input[name="all"]').val();
    if(all == 0){
        $.each($('input[name="delArticleId[]"]:checked'), function(index, val) {
            id.push($(val).val())
        });
    }
    if (all == 1 || id.length) {
        $.ajax({
            url: '/admin/articles/deletes',
            type: 'post',
            dataType: 'json',
            data: {
                id: id,
                all: all
            },
            success: function(response){
                if (response) {
                    if (all == 1) {
                        $("#trashArticles tr.article").slideUp(function(){
                            $(this).remove();
                        })
                        $("#page").remove();
                    }else{
                        $.each(id, function(index, val) {
                            $('#article-'+val).slideUp(function(){
                                $(this).remove();
                            })
                        });
                    }
                    AlertMsg('删除成功');
                }else{
                    AlertMsg('删除失败', 'Alert--Danger');
                }
            }
        });
    }else{
        AlertMsg('请选择要删除的文章', 'Alert--Danger');
    }
}

function updateRole () {
    var modal = $('#updateRole'),
        user_id = modal.find('input[name="user_id"]').val(),
        role_id = modal.find('input[name="role_id"]').val();
    $.ajax({
        url: '/admin/users/changerole',
        type: 'post',
        dataType: 'json',
        data: {
            role_id: role_id,
            user_id: user_id
        },
        success: function(response){
            if (response.status == 200) {
                $('#user-'+user_id+' .userRole').html(response.html);
            }else{
                AlertMsg(response.msg, 'Alert--Danger');
            }
        }
    });
}

function delUser () {
    var modal = $("#delUserAdmin"),
        id = modal.find('input[name="id"]').val();

    $.post('/admin/users/' + id, {
        id: id,
        _method: 'DELETE'
    }, function(response) {
        if (response.status == 200) {
            $('tr#user-'+id).slideUp(function(){
                $(this).remove();
            })
            AlertMsg('删除成功');
        }else {
            AlertMsg(response.msg, 'Alert--Danger');
        }
    });
}