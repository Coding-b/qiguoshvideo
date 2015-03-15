<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 16:25
 */
namespace Home\Model;
use Think\Model;

class UserModel extends Model{
    /**
     * 是否存在该名成用户
     * @param $userName 名称
     * @return bool true--存在;false--不存在
     */
    public function isExit($userName){
        $User = M('User');
        $user['userName'] = $userName;
        $result = $User -> where($user) -> select();
        if($result == null){
            return false;
        }else{
            $count = count($result);
            if($count == 0){
                return false;
            }else{
                return true;
            }
        }

    }

    /**
     * 用户注册
     * @param $user 用户信息
     * @return bool true--成功;false--失败
     */
    public function register($user){
        $User = M('User');

        $result = $User -> data($user) -> add();
        if($result == true){
           return true;
        }else{
            return false;
        }
    }

    /**
     * 用户登录
     * @param $userInfo
     * @return bool
     */
    public function login($userInfo){
        $User = M('User');
        $user['userName'] = $userInfo['userName'];
        $result = $User -> where($user) -> getField('password');
        $userId = $User -> where($user) -> getField('userId');
        if($result == $userInfo['password']){
            return $userId;
        }else{
            return false;
        }
    }

    public function getUserInfo($userId){
        $User = M('User');
        $user['userId'] = $userId;
        return $User -> where($user) -> select()[0];
    }

    public function changePassword($user){
        $User = M('User');
        return $User -> save($user);
    }
}