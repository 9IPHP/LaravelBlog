$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(function(){
    $('input[name=title]').blur(function(){
        if($('input[name="title"]').val() != '' && $('input[name="slug"]').val() == ''){
            $.get('/articles/getslug', {
                title: $.trim($('input[name="title"]').val())
            }, function(response){
                if(response.status == true)
                    $('input[name="slug"]').val(response.slug)
            }, 'json')
        }
    });
    $('#tag_list').selectize({
        maxItems: 5,
        persist: false,
        createOnBlur: true,
        create: true,
    });
    var $preview, editor, mobileToolbar, toolbar;
    Simditor.locale = 'zh-CN';
    toolbar = ['title', 'bold', 'italic', 'strikethrough', 'color', 'ol', 'ul', 'blockquote', 'code', 'link', 'image', 'hr', 'indent', 'outdent', 'alignment', 'markdown'];
    mobileToolbar = ["bold", "underline", "strikethrough", "color", "ul", "ol"];
    if (mobilecheck()) {
        toolbar = mobileToolbar;
    }
    editor = new Simditor({
        textarea: $('#myEditor'),
        placeholder: '',
        toolbar: toolbar,
        pasteImage: false,
        defaultImage: '/img/image.png',
        upload: {
            url: '/articles/upload',
            fileKey: 'file'
        }
    });
    $preview = $('#preview');
    if ($preview.length > 0) {
        return editor.on('valuechanged', function(e) {
            return $preview.html(editor.getValue());
        });
    }
    Dropzone.options.myDropzone = {
        maxFiles : 1,
        acceptedFiles: 'image/*',
        maxFilesize: 2,
        thumbnailWidth: 400,
        thumbnailHeight: 100,
        addRemoveLinks: true,
        dictRemoveFile: 'Remove',
        dictFileTooBig: 'Image is bigger than 2MB',
        // previewTemplate: '<div id="preview-template" style="display: none;"></div>',
        init: function() {
            this.on('success', function(file, response){
                $("input[name=thumb]").val(response.file_path);
            }).on('removedfile', function(file){
                $("input[name=thumb]").val('');
            })
        }
    };
})


// Navigation Scripts to Show Header on Scroll-Up
jQuery(document).ready(function($) {
    var MQL = 1170;

    //primary navigation slide-in effect
    if ($(window).width() > MQL) {
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
