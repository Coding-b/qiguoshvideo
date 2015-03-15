<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/24
 * Time: 21:06
 */

namespace Root\Controller;


use Think\Controller;
use Think\Verify;

class UserController extends Controller{
    /**
     * 登陆
     */
    public function login(){
        $_SESSION['AdminId'] = null;

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

                    $_SESSION['AdminId'] = $userId;

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
     * 验证码检测
     * @param $code 用户输入的验证码
     * @param string $id
     * @return bool
     */
    function check_verify($code, $id = ''){
		$verify = new Verify();
        return $verify->check($code, $id);
    }

    /**
     * 获取验证码
     */
    public function getVerifyCode(){
		ob_clean();
        $Verify = new Verify();
        $Verify -> entry();
    }
} 