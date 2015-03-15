<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/24
 * Time: 0:20
 */

namespace Root\Controller;


use Think\Controller;

class InformationController extends Controller{
    /**
     * 统计信息
     */
    public function index(){

        $adminId = $_SESSION['AdminId'];
        if(empty($adminId) == false){
            $category = D('Category');

            $categoryList = $category -> getVideoCategory();

            $this -> assign('categoryList',$categoryList);

            $this -> display();
        }else{
            $this->error('请先登录','/index.php/Root/User/login',3);
        }
    }
} 