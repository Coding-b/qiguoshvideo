<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 14-8-17
 * Time: 下午4:40
 */

namespace Home\Controller;

use Think\Controller;
use Think\Page;

class VideoController extends Controller{
    /**
     * 播放视频
     */
    public function playVideo(){
        $user = D('User');

        $userId = $_SESSION['userId'];
        $userInfo = null;
        if(empty($userId) == false){
            $userInfo = $user -> getUserInfo($userId);
        }
        $this -> assign('userInfo',$userInfo);

        $videoId = $_GET['videoId'];
        if(empty($videoId)){
            $this -> redirect('Index/index','页面跳转中。。。。');
        }
        $p = $_GET['p'];
        if(empty($p)){
            $p = 1;
        }

        $category = D('Category');
        $video = D('Video');
        $videoReview = D('Review');

        $Review = M('Review');

        $video -> addVideViewedTimes($videoId);

        $categoryList = $category -> getVideoCategory();
        $topVideo = $video -> getPopVideo(3);
        $reviewList = $Review -> where('reviewParent = 0 AND videoId = '.$videoId) -> page($p.',4') -> select();
        $count = count($Review -> where('reviewParent = 0 AND videoId = '.$videoId) -> select());
        $reviewList = $videoReview -> getVideoReviewReply($reviewList);
        $Page = new Page($count ,4);
        $Page->rollPage = 5;
        $Page->setConfig('header',$count);
        $Page -> setConfig('first','1...');
        $Page -> setConfig('prev','<<');
        $Page -> setConfig('next','>>');
        $Page->setConfig('theme',"a<ul class='pagination'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a>共%HEADER%条记录</a></ul>");

        $show = $Page -> show();

        $videoInfo = $video -> getVideoInfomation($videoId);

        $videoInfo['videoAdd'] = urlencode($videoInfo['videoAdd']);
        $videoInfo['videoHtml5'] = urldecode($videoInfo['videoAdd']);
        $videoInfo['labels'] = explode(',',$videoInfo['videoLabel']);

        $this -> assign('categoryList',$categoryList);
        $this -> assign('topVideoList',$topVideo);
        $this -> assign('videoInfo',$videoInfo);
        $this -> assign('reviewList',$reviewList);
        $this -> assign('page',$show);//分页
        $this -> assign('reviewCount',$count);

        $this -> display();
    }

    /**
     * 获取资源的下载url
     */
    public function getDownloadUrl($videoId){
        $video = D('Video');

        $downloadUrl = $video -> getVideoAddress($videoId);
        if($downloadUrl == false){
            return $downloadUrl;
        }else{
            $realDownloadUrl = Qiniu_Sign($downloadUrl);
            return $realDownloadUrl;
        }
    }

    public function videoList(){
        $p = $_GET['p'];
        if(empty($p)){
            $p = 1;
        }

        $user = D('User');

        $userId = $_SESSION['userId'];
        $userInfo = null;
        if(empty($userId) == false){
            $userInfo = $user -> getUserInfo($userId);
        }
        $this -> assign('userInfo',$userInfo);

        $video = D('Video');
        $category = D('Category');

        $categoryId = $_GET['categoryId'];
        $secondCategory = $_GET['secondCategory'];
        if(empty($secondCategory) == true){
            $videoList = $video -> getVideoList($categoryId,0,$p);
            $count = $video -> getVideoCount($categoryId,0,$p);
        }else{
            $videoList = $video -> getVideoList($categoryId,$secondCategory,$p);
            $count = $video -> getVideoCount($categoryId,$secondCategory,$p);
        }
        $categoryList = $category -> getVideoCategory();


        $Page = new Page($count ,8);
        $Page->rollPage = 5;
        $Page->setConfig('header',$count);
        $Page -> setConfig('first','1...');
        $Page -> setConfig('prev','<<');
        $Page -> setConfig('next','>>');
        $Page->setConfig('theme',"<ul class='pagination'></li><li>%FIRST%</li><li>%UP_PAGE%</li><li>%LINK_PAGE%</li><li>%DOWN_PAGE%</li><li>%END%</li><li><a>共%HEADER%条记录</a></ul>");

        $show = $Page -> show();

        $topVideoList = $video -> getPopVideo(3);

        $this -> assign('categoryList',$categoryList);
        $this -> assign('videoList',$videoList);
        $this -> assign('topVideoList',$topVideoList);
        $this -> assign('page',$show);

        $this -> display();
    }
} 