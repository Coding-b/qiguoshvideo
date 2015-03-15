<?php
namespace Home\Controller;

use Think\Controller;
use Think\Page;

class IndexController extends Controller{
    /**
     * 首页
     */
    public function index(){
        $category = D('Category');
        $slide = D('Slide');
        $video = D('Video');
        $Video = M('Video');
        $user = D('User');

        $userId = $_SESSION['userId'];
        $userInfo = null;
        if(empty($userId) == false){
            $userInfo = $user -> getUserInfo($userId);
        }

        $p = $_GET['p'];
        if(empty($p)){
            $p = 1;
        }


        $categoryList = $category -> getVideoCategory();
        $slideList = $slide -> getSlide();
        $topVideo = $video -> getPopVideo(2);

        $newVideo = $Video ->where('videoStatus = 1') -> order('createTime desc') ->page($p.',6') -> select();
        $newCount = count($newVideo);
        for($i = 0;$i < $newCount;$i ++){
            $newVideo[$i]['labels'] = explode(',',$newVideo[$i]['videoLabel']);
        }

        $count = count($Video ->where('videoStatus = 1') -> select());
        $Page = new Page($count ,6);
        $Page->rollPage = 5;
        $Page->setConfig('header',$count);
        $Page -> setConfig('first','1...');
        $Page -> setConfig('prev','<<');
        $Page -> setConfig('next','>>');
        $Page->setConfig('theme',"<ul class='pagination'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a>共%HEADER%条记录</a></ul>");

        $show = $Page -> show();

        $this -> assign('categoryList',$categoryList);
        $this -> assign('slideList',$slideList);
        $this -> assign('topVideoList',$topVideo);
        $this -> assign('newVideoList',$newVideo);
        $this -> assign('page',$show);
        $this -> assign('userInfo',$userInfo);

        $this -> display();
    }

    /**
     * ajax获取当页的电影
     * @param $page 页数
     */
    public function refreshVideo($page){
        $video = D('Video');
        $newVideo = $video -> getNewVideo($page);

        $this -> ajaxReturn($newVideo);
    }
}