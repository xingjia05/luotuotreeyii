<?php
return [
    'adminEmail' => 'admin@example.com',
    'domain' => 'http://luotuotree.com',
    'webuploader' => [
        // 后端处理图片的地址，value 是相对的地址
        'uploadUrl' => '/upload/index',
        // 多文件分隔符
        'delimiter' => ',',
        // 基本配置
        'baseConfig' => [
            'defaultImage' => '',
            'disableGlobalDnd' => true,
            'accept' => [
                'title' => 'Images',
                'extensions' => 'gif,jpg,jpeg,bmp,png',
                'mimeTypes' => 'image/*',
            ],
            'pick' => [
                'multiple' => false,
            ],
        ],
    ],
    'imageUploadRelativePath' => './uploads/', // 图片默认上传的目录
    'imageUploadSuccessPath' => '/uploads/', // 图片上传成功后，路径前缀

];
