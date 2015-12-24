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

    $('#delArticleAdmin').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            title = button.data('title'),
            id = button.data('id'),
            modal = $(this);
        modal.find('.modal-title').text('删除：' + title);
        modal.find('.deleteTitle').text(title);
        modal.find('.modal-body input[name="id"]').val(id);
    })

    $('#delAllArticle').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            msg = button.data('msg'),
            all = button.data('all'),
            modal = $(this);
        modal.find('.delMsg').text(msg);
        modal.find('.modal-body input[name="all"]').val(all);
    })

    $(".userRole").change(function(event) {
        event.preventDefault();
        var oldRoleId = $(this).data('id'),
            newRoleId = $(this).val(),
            userId = $(this).parents('tr').data('id'),
            oldHtml = $(this).parent().html(),
            newRole = $(this).find("option:selected").text(),
            name = $(this).parents('tr').find('.name').text();
        $(this).parents('td').html('<i class="fa fa-spin fa-refresh"></i>');
        $.ajax({
            url: '/admin/users/update',
            type: 'post',
            dataType: 'json',
            data: {
                role_id: newRoleId,
                user_id: userId
            },
            success: function(response){
                if (response) {

                }else{

                }
            }
        });

    });
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
            AlertMsg('文章不存在');
        }else{
            AlertMsg('删除失败');
        }
        modal.modal('hide')

    });
}

function delArticle () {
    var modal = $("#delArticleAdmin"),
        id = modal.find('input[name="id"]').val();
    modal.modal('hide')
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
            AlertMsg('文章不存在');
        }else{
            AlertMsg('删除失败');
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
    modal.modal('hide')
    if(!all){
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
                    if (all) {
                        $("#trashArticles tr.article").slideUp(function(){
                            $(this).remove();
                        })
                        $("#page").remove();
                    }else{
                        $.each(id, function(index, val) {
                            console.log(val);
                            $('#article-'+val).slideUp(function(){
                                $(this).remove();
                            })
                        });
                    }
                    AlertMsg('删除成功');
                }else{
                    AlertMsg('删除失败');
                }
            }
        });
    }else{
        AlertMsg('请选择要删除的文章');
    }
}