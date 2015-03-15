<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 14-8-21
 * Time: 下午9:17
 */

namespace Home\Controller;

use Think\Controller;
use Think\Upload\Driver\Qiniu;
use Think\Verify;

class UserController extends Controller{
    /**
     * 用户个人信息
     */
    public function information(){
        $user = D('User');

        $userId = $_SESSION['userId'];
        $userInfo = null;
        if(empty($userId) == false){
            $userInfo = $user -> getUserInfo($userId);
            $this -> assign('userInfo',$userInfo);

            $category = D('Category');
            $categoryList = $category -> getVideoCategory();
            $this -> assign('categoryList',$categoryList);

            $this -> display();
        }else{
            $this->error('请先登录','/Study/index.php/Home/Index/index',3);
        }

    }


    /**
     * 投稿中心
     */
    public function contributeCenter(){
        $user = D('User');

        $userId = $_SESSION['userId'];
        $userInfo = null;
        if(empty($userId) == false){
            $userInfo = $user -> getUserInfo($userId);
            $this -> assign('userInfo',$userInfo);

            $category = D('Category');
            $videoCategory = $category -> getVideoCategory();
            $this -> assign('categoryList',$videoCategory);
            $this -> assign('videoCategory',$videoCategory);

            $this -> display();
        }else{
            $this->error('请先登录','/Study/index.php/Home/Index/index',3);
        }
    }

    /**
     * 投稿电影
     */
    public function contributeVideo(){
        $user = D('User');

        $userId = $_SESSION['userId'];

        $video =D('Video');

        $videoInfo['videoType'] = $_POST['videoType'];
        $videoInfo['videoImage'] = $_POST['videoImage'];
        $videoInfo['videoAdd'] = $_POST['videoAdd'];
        $videoInfo['videoName'] = $_POST['videoTitle'];
        $videoInfo['videoDesc'] = $_POST['videoDesc'];
        $videoInfo['videoLabel'] = $_POST['videoLabel'];
        $videoInfo['owner'] = $userId;

        $resultInfo = $video -> addVideo($videoInfo);
        if($resultInfo){
            $result['type'] = true;
            $result['content'] = "上传成功";
            $this -> ajaxReturn($result);
        }else{
            $result['type'] = false;
            $result['content'] = "上传失败";
            $this -> ajaxReturn($result);
        }
    }

    /**
     * 统计信息
     */
    public function statisticsCenter(){
        $this -> error('该页面正在开发中，敬请期待','information');
        return;

        $user = D('User');

        $userId = $_SESSION['userId'];
        $userInfo = null;
        if(empty($userId) == false){
            $userInfo = $user -> getUserInfo($userId);
            $this -> assign('userInfo',$userInfo);

            $category = D('Category');
            $categoryList = $category -> getVideoCategory();
            $this -> assign('categoryList',$categoryList);

            $this -> display();
        }else{
            $this->error('请先登录','/Study/index.php/Home/Index/index',3);
        }
    }

    /**
     * 用户登陆页面
     */
    public function login(){
        $_SESSION['userId'] = null;

        $category = D('Category');
        $categoryList = $category -> getVideoCategory();
        $this -> assign('categoryList',$categoryList);

        $this -> display();
    }

    /**
     * 用户登录
     */
    public function loginUser(){
        $User = D('User');

        if($this -> check_verify($_POST['verify']) == true){
            if($User -> isExit($_POST['userName']) == false){
                $result['type'] = false;
                $result['content'] = "用户名不存在";
                $this -> ajaxReturn($result);
                return;
            }else{
                $user['userName'] = $_POST['userName'];
                $user['password'] = md5($_POST['password']);
                $userId = $User -> login($user);
                if($userId){
                    $result['type'] = true;
                    $result['content'] = "登陆成功";

                    $_SESSION['userId'] = $userId;

                    $this -> ajaxReturn($result);

                    return;
                }else{
                    $result['type'] = false;
                    $result['content'] = "密码错误";
                    $this -> ajaxReturn($result);
                    return;
                }
            }
        }else{
            $result['type'] = false;
            $result['content'] = "验证码错误";
            $this -> ajaxReturn($result);
            return;
        }
    }

    /**
     * 用户注册页面
     */
    public function register(){
        $category = D('Category');
        $categoryList = $category -> getVideoCategory();
        $this -> assign('categoryList',$categoryList);

        $this -> display();
    }

    /**
     * 注册用户
     */
    public function registerUser(){
        $User = D('User');

        if($this -> check_verify($_POST['verify']) == true){
            if($User -> isExit($_POST['userName']) == true){
                $result['type'] = false;
                $result['content'] = "用户名已存在";
                $this -> ajaxReturn($result);
                return;
            }else{
                $user['userName'] = $_POST['userName'];
                $user['password'] = md5($_POST['password']);
                $user['emailAdd'] = $_POST['emailAdd'];

                if($User -> register($user) == true){
                    $result['type'] = true;
                    $result['content'] = "注册成功";
                    $this -> ajaxReturn($result);
                    return;
                }else{
                    $result['type'] = false;
                    $result['content'] = "注册失败";
                    $this -> ajaxReturn($result);
                    return;
                }
            }
        }else{
            $result['type'] = false;
            $result['content'] = "验证码错误";
            $this -> ajaxReturn($result);
            return;
        }
    }

    /**
     * 获取上传凭证
     */
    public function getUploadToken(){
        $uploadToken['uptoken'] = Qiniu_upToken();
        echo(json_encode($uploadToken));
    }

    /**
     * 上传影片封面
     */
    public function uploadVideoImage(){

    }

    /**
     * 获取验证码
     */
    public function getVerifyCode(){
		ob_clean();
        $Verify = new Verify();
        $Verify -> entry();
    }

    /**
     * 修改密码
     */
    public function changePassword(){
        $User = D('User');
        $user['password'] = md5($_POST['password']);
        $user['userId'] = $_POST['userId'];

        if($User -> changePassword($user)){
            $result['type'] = true;
            $result['content'] = "密码修改成功";
            $this -> ajaxReturn($result);
        }else{
            $result['type'] = false;
            $result['content'] = "密码修改失败";
            $this -> ajaxReturn($result);
        }
    }

    /**
     * 验证码检测
     * @param $code 用户输入的验证码
     * @param string $id
     * @return bool
     */
    function check_verify($code, $id = ''){
        $verify = new \Think\Verify();
        return $verify->check($code, $id);
    }

    /**
     * 预处理指令发出
     */
    function prevideoDeal(){
        $url = "http://api.qiniu.com";
        $data="bucket=qiguovideo&key=playful.mp4&fops=avthumb%2Fflv&persistentNotifyUrl=http://www.baidu.com";
        $accessToken = Qiniu_accessToken("http://api.qiniu.com/pfop/"."?".$data,"");
        echo $accessToken;
    }

    /**
     * Socket版本
     * 使用方法：
     * $post_string = "app=socket&version=beta";
     * request_by_socket('facebook.cn','/restServer.php',$post_string);
     */
    function request_by_socket($accessToken,$remote_server, $remote_path, $post_string, $port = 80, $timeout = 30){
        $socket = fsockopen($remote_server, $port, $errno, $errstr, $timeout);
        if (!$socket) die("$errstr($errno)");

        fwrite($socket, "POST $remote_path HTTP/1.0\r\n");
        fwrite($socket, "HOST: $remote_server\r\n");
        fwrite($socket, "Content-type: application/x-www-form-urlencoded\r\n");
        fwrite($socket, "Authorization: " . $accessToken . "\r\n");
        fwrite($socket, "\r\n");
        fwrite($socket, "mypost=$post_string\r\n");
        fwrite($socket, "\r\n");
        $header = "";
        while ($str = trim(fgets($socket, 4096))) {
            $header .= $str;
        }
        $data = "";
        while (!feof($socket)) {
            $data .= fgets($socket, 4096);
        }
        return $data;
    }
}