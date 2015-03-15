var uploader = Qiniu.uploader({
    runtimes: 'html5,flash,html4',    //上传模式,依次退化
    browse_button: 'uploadVideo',       //上传选择的点选按钮，**必需**
    uptoken_url: 'getUploadToken',            //Ajax请求upToken的Url，**必需**（服务端提供）
    url:'http://qiguovideo.qiniudn.com/',    //上传的目标地址
    domain: 'http://qiguovideo.qiniudn.com/',   //bucket 域名，下载资源时用到，**必需**
    container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
    max_file_size: '2048mb',           //最大文件体积限制
    flash_swf_url: '../../Common/js/Moxie.swf',  //引入flash,相对路径
    max_retries: 3,                   //上传失败最大重试次数
    dragdrop: true,                   //开启可拖曳上传
    drop_element: 'container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
    chunk_size: '4mb',                //分块上传时，每片的体积
    auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
    filters : [
        {title : "video files", extensions : "mp4"},
    ],
    init: {
        'FilesAdded': function(up, files) {
            $('#tableVideo').show();
            plupload.each(files, function(file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setStatus("等待...");
            });
            $('#uploadVideo').hide();
        },
        'BeforeUpload': function(up, file) {
            var progress = new FileProgress(file, 'fsUploadProgress');
            var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
            if (up.runtime === 'html5' && chunk_size) {
                progress.setChunkProgess(chunk_size);
            }
        },
        'UploadProgress': function(up, file) {
            var progress = new FileProgress(file, 'fsUploadProgress');
            var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
            progress.setProgress(file.percent + "%", up.total.bytesPerSec, chunk_size);
        },
        'FileUploaded': function(up, file, info) {
            var progress = new FileProgress(file, 'fsUploadProgress');
            progress.setComplete(up, info);

            var res = parseJSON(info);
            var url;
            if (res.url) {
                url = res.url;
            } else {
                var domain = up.getOption('domain');
                url = domain + encodeURI(res.key);
            }

            $('#videoAdd').attr('value',url);

        },
        'Error': function(up, err, errTip) {
            $('#tableVideo').show();
            var progress = new FileProgress(err.file, 'fsUploadProgress');
            progress.setError();
            progress.setStatus(errTip);
        },
        'UploadComplete': function() {

        }
    }
});

function parseJSON(data){
    // Attempt to parse using the native JSON parser first
    if (window.JSON && window.JSON.parse) {
        return window.JSON.parse(data);
    }

    if (data === null) {
        return data;
    }
    if (typeof data === "string") {

        // Make sure leading/trailing whitespace is removed (IE can't handle it)
        data = this.trim(data);

        if (data) {
            // Make sure the incoming data is actual JSON
            // Logic borrowed from http://json.org/json2.js
            if (/^[\],:{}\s]*$/.test(data.replace(/\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g, "@").replace(/"[^"\\\r\n]*"|true|false|null|-?(?:\d+\.|)\d+(?:[eE][+-]?\d+|)/g, "]").replace(/(?:^|:|,)(?:\s*\[)+/g, ""))) {

                return (function() {
                    return data;
                })();
            }
        }
    }
}

var uploader = Qiniu.uploader({
    runtimes: 'html5,flash,html4',    //上传模式,依次退化
    browse_button: 'customerButton',       //上传选择的点选按钮，**必需**
    uptoken_url: 'getUploadToken',            //Ajax请求upToken的Url，**必需**（服务端提供）
    url:'http://qiguovideo.qiniudn.com/',    //上传的目标地址
    domain: 'http://qiguovideo.qiniudn.com/',   //bucket 域名，下载资源时用到，**必需**
    container: 'container',           //上传区域DOM ID，默认是browser_button的父元素，
    max_file_size: '2048mb',           //最大文件体积限制
    flash_swf_url: '../../Common/js/Moxie.swf',  //引入flash,相对路径
    max_retries: 3,                   //上传失败最大重试次数
    dragdrop: true,                   //开启可拖曳上传
    drop_element: 'container',        //拖曳上传区域元素的ID，拖曳文件或文件夹后可触发上传
    chunk_size: '4mb',                //分块上传时，每片的体积
    auto_start: true,                 //选择文件后自动上传，若关闭需要自己绑定事件触发上传
    // Specify what files to browse for
    filters : [
        {title : "Image files", extensions : "jpg,gif,png"},
    ],
    init: {
        'FilesAdded': function(up, files) {
            $('#tableImage').show();
            plupload.each(files, function(file) {
                var progress = new FileProgress(file, 'imgUploadProgress');
                progress.setStatus("等待...");
            });
            $('#customerButton').hide();
        },
        'BeforeUpload': function(up, file) {
            var progress = new FileProgress(file, 'imgUploadProgress');
            var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
            if (up.runtime === 'html5' && chunk_size) {
                progress.setChunkProgess(chunk_size);
            }
        },
        'UploadProgress': function(up, file) {
            var progress = new FileProgress(file, 'imgUploadProgress');
            var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
            progress.setProgress(file.percent + "%", up.total.bytesPerSec, chunk_size);
        },
        'FileUploaded': function(up, file, info) {
            var progress = new FileProgress(file, 'imgUploadProgress');
            progress.setComplete(up, info);

            var res = $.parseJSON(info);
            var url;
            if (res.url) {
                url = res.url;
            } else {
                var domain = up.getOption('domain');
                url = domain + encodeURI(res.key);
            }
            $('#videoImage').attr('value',url);
        },
        'Error': function(up, err, errTip) {
            $('#tableImage').show();
            var progress = new FileProgress(err.file, 'imgUploadProgress');
            progress.setError();
            progress.setStatus(errTip);
        },
        'UploadComplete': function() {

        }
    }
});

function onSubmit(){
    var videoTitle = $('#video-title-in').val();
    var videoDesc = $('#video-introduction-in').val();
    var videoType = $('#video-kind-in').val();
    var videoLabel = $('#video-labels-in').val();
    var videoImage = $('#videoImage').val();
    var videoAdd = $('#videoAdd').val();
    if(videoTitle.length == 0){
        setWarm('影片标题不能为空');
        return;
    }

    if(videoDesc.length == 0){
        setWarm('影片描述不能为空');
        return;
    }

    if(videoType.length == 0){
        setWarm('影片分类不能为空');
        return;
    }

    if(videoLabel.length == 0){
        setWarm('影片标签不能为空');
        return;
    }
    if(videoImage.length == 0){
        setWarm('请上传影片封面');
        return;
    }
    if(videoAdd.length == 0){
        setWarm('请上传影片');
        return;
    }

    $.post("contributeVideo",{videoAdd:videoAdd,videoImage:videoImage,videoTitle:videoTitle,videoDesc:videoDesc,videoType:videoType,videoLabel:videoLabel},function(data){onSuccessReturn(data)});
}

function setWarm(message){
    $("#warm").show();
    $("#warm-message-content").html(message);
    setTimeout(function hide(){
        $("#warm").fadeOut();
    },2 * 1000);
}

function onSuccessReturn(data){
    if(data.type == true){
        confirm("上传成功,请等待管理员的审核！");
        window.location = "contributeCenter";
    }else{
        setWarm(data.content);
    }
}