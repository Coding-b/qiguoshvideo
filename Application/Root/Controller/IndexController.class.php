<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/23
 * Time: 23:22
 */
namespace Root\Controller;

use Think\Controller;
use Think\Page;

class IndexController extends Controller{
    /**
     * 后台首页
     */
    public function index(){

        $adminId = $_SESSION['AdminId'];
        if(empty($adminId) == true){
            $this->error('请先登录','/index.php/Root/User/login',3);
            return;
        }

        $category = D('Category');
        $user = D('User');

        $page = $_GET['p'];
        if(empty($page)){
            $page = 1;
        }

        $categoryList = $category -> getVideoCategory();
        $userList = $user -> getNormalUser($page);

        $userCount = $user -> getNormalUserCount();

        $Page = new Page($userCount,6);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page->rollPage = 5;
        $Page->setConfig('header',$userCount);
        $Page -> setConfig('first','1...');
        $Page -> setConfig('prev','<<');
        $Page -> setConfig('next','>>');
        $Page->setConfig('theme',"<ul class='pagination'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a>共%HEADER%条记录</a></ul>");

        $show = $Page -> show();
        // 分页显示输出
        $this->assign('page',$show);// 赋值分页输出

        $this -> assign('categoryList',$categoryList);
        $this -> assign('userList',$userList);


        $this -> display();
    }

    public function deleteUser(){
        $userId = $_GET['userId'];

        $user = D('User');

        if($user -> deleteUser($userId)){
            $this -> success('删除成功','Index/index');
        }else{
            $this -> error('删除失败');
        }

    }
} 