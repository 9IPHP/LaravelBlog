$(function(){

    if($('#tag_list').length > 0) $('#tag_list').selectize({
        maxItems: 5,
        persist: false,
        createOnBlur: true,
        create: true,
    });
    // Simditor setting
    var $preview, editor, mobileToolbar, toolbar;
    Simditor.locale = 'zh-CN';
    toolbar = ['title', 'bold', 'italic', 'strikethrough', 'color', 'ol', 'ul', 'blockquote', 'code', 'link', 'image', 'hr', 'indent', 'outdent', 'alignment', 'markdown'];
    mobileToolbar = ["bold", "underline", "strikethrough", "color", "ul", "ol"];
    if (mobilecheck()) {
        toolbar = mobileToolbar;
    }
    if(webConfig.canUpload){
        uploadSetting = {
            url: '/articles/upload',
            fileKey: 'file'
        }
    }else{
        uploadSetting = false
    }
    editor = new Simditor({
        textarea: $('#myEditor'),
        placeholder: '',
        toolbar: toolbar,
        pasteImage: false,
        defaultImage: '/img/image.png',
        upload: uploadSetting,
        codeLanguages:[
            {
                name: 'PHP',
                value: 'php'
            }, {
                name: 'CSS',
                value: 'css'
            }, {
                name: 'HTML,XML',
                value: 'xml'
            }, {
                name: 'JavaScript',
                value: 'js'
            }, {
                name: 'SQL',
                value: 'sql'
            }, {
                name: 'JSON',
                value: 'json'
            }, {
                name: 'Markdown',
                value: 'markdown'
            }, {
                name: 'Bash',
                value: 'bash'
            }, {
                name: 'Apache',
                value: 'apache'
            }
        ],
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
                $(".intro-header").css('background-image', 'url('+response.file_path+')');
            }).on('removedfile', function(file){
                $(".intro-header").css('background-image', 'url('+$(".intro-header").data('bg')+')');
                $("input[name=thumb]").val('');
            })
        },
    };
})