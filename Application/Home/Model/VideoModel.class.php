<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 21:29
 */
namespace Home\Model;

use Think\Model;

class VideoModel extends Model{
    /**
     * 添加电影到当前电影库
     * @param $video 电影信息
     * @return bool 添加是否成功
     */
    public function addVideo($video){
        $Video = M('Video');
        return $Video -> data($video) -> add();
    }

    /**
     * 删除电影
     * @param $videoName 电影的key
     * @return bool 删除是否成功
     */
    public function deleteVideo($videoName){
        return true;
    }

    /**
     * 获取电影列表
     * @param $videoType 电影限制条件
     * @param $limit 条数（0表示不限制）
     * @return array 电影列表
     */
    public function getVideo($videoType ,$limit){
        $Video = M('Video');
        $videoList = $Video -> where($videoType) ->limit($limit) -> select();
        return $videoList;
    }

    /**
     * 获取最受欢迎的电影列表
     * @param $limit 条数
     */
    public function getPopVideo($limit){
        $Video = M('Video');
        $videoList = $Video ->where('videoStatus = 1') -> order('viewed desc')-> limit($limit) -> select();
        $count = count($videoList);
        for($i = 0;$i < $count;$i ++){
            $videoList[$i]['labels'] = explode(',',$videoList[$i]['videoLabel']);
        }
        return $videoList;
    }

    /**
     * 获取指定电影id的地址
     * @param $videoId 电影ID
     * @return mixed 电影的下载地址
     */
    public function getVideoAddress($videoId){
        $Video = M('Video');
        $videoInfo['videoId'] = $videoId;
        $videoAdd = $Video -> where($videoInfo) -> getField('videoAdd');
        if($videoAdd)
            return $videoAdd;
        else
            return false;
    }

    /**
     * 获取影片信息
     * @param $videoId 电影ID
     * @return mixed 电影的信息
     */
    public function getVideoInfomation($videoId){
        $Video = M('Video');
        $video['videoId'] = $videoId;
        $videoInfo = $Video -> where($video) -> select();
        if($videoInfo)
            return $videoInfo[0];
        else
            return false;
    }

    public function getVideoList($categoryId ,$secondCategory,$page){
        $Category = M('Category');
        $Video = M('Video');
        if($secondCategory == 0){
            $videoList = $Category -> where('categoryParent = '.$categoryId) -> join('Video on videoType = categoryId') -> page($page.',8') -> select();
        }else{
            $videoList = $Video -> where('videoType = '.$secondCategory) -> page($page.',8')  -> select();
        }
        return $videoList;
    }

    /**
     * 获取当前所有记录
     * @param $categoryId
     * @param $secondCategory
     * @return int
     */
    public function getVideoCount($categoryId ,$secondCategory){
        $Category = M('Category');
        $Video = M('Video');
        if($secondCategory == 0){
            $videoList = $Category -> where('categoryParent = '.$categoryId) -> join('Video on videoType = categoryId') -> select();
        }else{
            $videoList = $Video -> where('videoType = '.$secondCategory) -> select();
        }
        return count($videoList);
    }

    public function addVideViewedTimes($videoId){
        $Video = M('Video');
        $video['videoId'] = $videoId;

        $viewedTimes = $Video -> where($video) -> select()[0]['viewed'];
        $video['viewed'] = $viewedTimes + 1;

        return $Video -> save($video);

    }

}