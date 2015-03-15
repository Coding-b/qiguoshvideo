<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 16:25
 */
namespace Root\Model;
use Think\Model;

class UserModel extends Model{
    /**
     * 用户登录
     * @param $userInfo
     * @return bool
     */
    public function login($userInfo){
        $User = M('User');
        $user['userName'] = $userInfo['userName'];
        $user['userKind'] = 1;//标识管理员
        $result = $User -> where($user) -> getField('password');
        $userId = $User -> where($user) -> getField('userId');
        if($result == $userInfo['password']){
            return $userId;
        }else{
            return false;
        }
    }

    /**
     * 获取普通用户列表
     * @return mixed
     */
    public function getNormalUser($page){
        $User = M('User');
        $user['userKind'] = 0;
        return $User -> where($user) ->page($page.',10')-> select();
    }

    /**
     * 获取普通用户数量
     * @return int
     */
    public function getNormalUserCount(){
        $User = M('User');
        $user['userKind'] = 0;
        return count($User -> where($user) -> select());
    }

    /**
     * 更换密码
     * @param $user 用户信息
     * @return mixed
     */
    public function changePassword($user){
        $User = M('User');
        return $User -> save($user);
    }


    public function deleteUser($userId){
        $User = M('User');
        return $User -> delete($userId);
    }

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
}