/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/utils/tinymce.js ***!
  \***************************************/
var toolbar = "undo redo | styleselect | bold italic underline strikethrough\n        | fontselect fontsizeselect formatselect\n        | alignleft aligncenter alignright alignjustify\n        | outdent indent |  numlist bullist\n        | forecolor backcolor removeformat\n        | pagebreak | charmap emoticons\n        | fullscreen  preview save print\n        | insertfile image media template link anchor codesample | ltr rtl | code";
var plugins = ['advlist autolink link image lists charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime', 'media nonbreaking table emoticons template paste help', 'autosave save directionality codesample toc', 'imagetools textpattern noneditable  quickbars'];
var block_formats = "paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;\n         Header 4=h4;Header 5 =h5;Header 6=h6;\n         Div =div; Pre=pre";

if (window.tinymce) {
  tinymce.init({
    selector: '.tinymce',
    plugins: plugins,
    block_formats: block_formats,
    toolbar: toolbar,
    branding: false,
    images_upload_url: "{{route('admin.tinymce')}}",
    automatic_uploads: true,
    images_upload_base_path: '/storage',
    toolbar_sticky: true,
    autosave_ask_before_unload: true,
    image_advtab: true,
    convert_urls: false,
    relative_url: false,
    // link
    default_link_target: '_blank',
    link_context_toolbar: true,
    link_default_protocol: 'https',
    rel_list: [{
      title: 'None',
      value: ''
    }, {
      title: 'No Referrer',
      value: 'noreferrer'
    }, {
      title: 'External Link',
      value: 'external'
    }],
    setup: function setup(editor) {
      editor.on('change', function () {
        editor.save();
      });
    }
  });
}
/******/ })()
;