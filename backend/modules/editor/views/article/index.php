<?php

use yii\helpers\Html;

$this->title = Yii::t('app', '创建文章');
$this->params['breadcrumbs'][] = $this->title;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>创建文章</title>
    <!-- Theme included stylesheets -->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" />
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <style type="text/css">
      body > #standalone-container {
        margin: 50px auto;
        max-width: 720px;
      }
      #editor-container {
        height: 350px;
      }
    </style>

</head>



<body>
    <div id="standalone-container">
        <div id="toolbar-container">
        <span class="ql-formats">
            <select class="ql-font"></select>
            <select class="ql-size"></select>
        </span>
        <span class="ql-formats">
            <button class="ql-bold"></button>
            <button class="ql-italic"></button>
            <button class="ql-underline"></button>
            <button class="ql-strike"></button>
        </span>
        <span class="ql-formats">
            <select class="ql-color"></select>
            <select class="ql-background"></select>
        </span>
        <span class="ql-formats">
            <button class="ql-script" value="sub"></button>
            <button class="ql-script" value="super"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-header" value="1"></button>
            <button class="ql-header" value="2"></button>
            <button class="ql-blockquote"></button>
            <button class="ql-code-block"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-list" value="ordered"></button>
            <button class="ql-list" value="bullet"></button>
            <button class="ql-indent" value="-1"></button>
            <button class="ql-indent" value="+1"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-direction" value="rtl"></button>
            <select class="ql-align"></select>
        </span>
        <span class="ql-formats">
            <button class="ql-link"></button>
            <button class="ql-image"></button>
            <button class="ql-video"></button>
            <button class="ql-formula"></button>
        </span>
        <span class="ql-formats">
            <button class="ql-clean"></button>
        </span>
        </div>
        <div id="editor-container"></div>
    </div>
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/KaTeX/0.7.1/katex.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js" ></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script src="/js/quill/image-drop.min.js"></script>
    <script src="/js/quill/image-paste.min.js"></script>
   <!--  <script src="/js/quill/image-resize.min.js"></script> -->
    <script type="text/javascript">
    $(function () {
         var quill = new Quill('#editor-container', {
            modules: {
              // ImageResize: {},
              imagePaste: {},
              imageDrop: true,
              formula: true,
              syntax: true,
              toolbar: '#toolbar-container'
            },
            placeholder: 'Compose an epic...',
            theme: 'snow'
          });
    });

    </script>
</body>
</html>