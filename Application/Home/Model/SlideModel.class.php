<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 21:41
 */
namespace Home\Model;

class SlideModel extends \Think\Model{
    /**
     * 获取取当前的展示图片
     * @return array 展示图片列表
     */
    public function getSlide(){
        $slide = M('Slide');
        $slideList = $slide -> select();
        return $slideList;
    }

    /**
     * 更新一个展示图片
     * @param $slide 展示图片信息
     * @return bool 是否更新成功
     */
    public function refreshSlide($slide){
        return true;
    }

    /**
     * 添加展示图片
     * @param $slide 展示图片信息
     * @return bool 是否添加成功
     */
    public function addSlide($slide){
        return true;
    }

    /**
     * 删除展示图片
     * @param $slideId 展示图片ID
     * @return bool 是否删除成功
     */
    public function deleteSlide($slideId){
        return true;
    }
} 