<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 21:28
 */
namespace Home\Model;

use Think\Model;

class ReviewModel extends Model{
    /**
     * 获取影片的评论
     */
    public function getVideoReviewReply($reviewList){
        $Review = M('Review');
        $i = 0;
        foreach($reviewList as $review){
            $reviewReplay = $Review -> where("reviewParent = ". $review['reviewId']) -> select();
            $reviewList[$i]['reviewReply'] = $reviewReplay;
            $i ++;
        }
        return $reviewList;
    }
} 