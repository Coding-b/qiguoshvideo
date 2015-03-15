<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 21:29
 */
namespace Root\Model;

use Think\Model;

class VideoModel extends Model{
    /**
     * 获取电影列表
     * @param $page
     * @return mixed
     */
    public function getVideoList($page){
        $Video = M('Video');
        return $Video ->where('videoStatus < 2') ->order('createTime desc') -> page($page.',6') -> select();
    }

    /**
     * 获取影片数目
     * @return int
     */
    public function getVideoCount(){
        $Video = M('Video');
        return count($Video ->where('videoStatus < 2')-> select());
    }

    /**
     * 通过审核
     * @param $videoId
     * @return mixed
     */
    public function passVideo($videoId){
        $Video = M('Video');
        $video['videoId'] = $videoId;
        $video['videoStatus'] = 1;
        return $Video -> save($video);
    }

    /**
     * 审核不通过
     * @param $videoId
     * @return mixed
     */
    public function deleteVideo($videoId){
        $Video = M('Video');

        $video['videoId'] = $videoId;
        $video['videoStatus'] = 2;

        return $Video -> save($video);
    }

    /**
     * 获取影片信息
     * @param $videoId
     * @return mixed
     */
    public function getVideoInformation($videoId){
        $Video = M('Video');

        $video['videoId'] = $videoId;

        return $Video -> where($video) -> select()[0];
    }
}