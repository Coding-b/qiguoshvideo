<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/24
 * Time: 0:16
 */
namespace Root\Controller;


use Think\Controller;
use Think\Page;
use Think\Upload\Driver\Qiniu\QiniuStorage;

class ContributeController extends Controller{
    /**
     * 投稿管理
     */
    public function index(){
        $adminId = $_SESSION['AdminId'];
        if(empty($adminId) == true){
            $this->error('请先登录','/index.php/Root/User/login',3);
        }

        $category = D('Category');
        $video = D('Video');

        $page = $_GET['p'];
        if(empty($page)){
            $page = 1;
        }

        $videoList = $video -> getVideoList($page);
        $categoryList = $category -> getVideoCategory();
        $videoCount = $video -> getVideoCount();

        $Page = new Page($videoCount,6);// 实例化分页类 传入总记录数和每页显示的记录数
        $Page -> rollPage = 5;
        $Page -> setConfig('header',$videoCount);
        $Page -> setConfig('first','1...');
        $Page -> setConfig('prev','<<');
        $Page -> setConfig('next','>>');
        $Page->setConfig('theme',"<ul class='pagination'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a>共%HEADER%条记录</a></ul>");

        $show = $Page -> show();
        // 分页显示输出
        $this->assign('page',$show);// 赋值分页输出

        $this -> assign('categoryList',$categoryList);
        $this -> assign('videoList',$videoList);

        $this -> display();
    }

    /**
     * 删除当前电影
     */
    public function deleteVideo(){
        $Video = D('Video');

        $videoId = $_GET['videoId'];
        $qiniuSetting = C('QINIU_MANAGER_SETTING');

        $qiniu = new QiniuStorage($qiniuSetting);
        dump($qiniu);
        $file = $Video -> getVideoInformation($videoId);

        $key = urldecode($file['videoAdd']);

        $pos = strrpos($key,'/') + 1;

        $key = substr($key,$pos);
        $response = $qiniu -> del($key);

        if(empty($response) == true){
            if($Video -> deleteVideo($videoId)){
                $this -> success('修改成功','index');
            }else{
                $this -> error('修改失败');
            }
        }else{

            $this -> error('1修改失败');
        }
    }

    /**
     * 通过审核
     */
    public function passVideo(){
        $Video = D('Video');

        $videoId = $_GET['videoId'];

        if($Video -> passVideo($videoId)){
            $this -> success('修改成功','index');
        }else{
            $this -> error('修改失败');
        }
    }
} 