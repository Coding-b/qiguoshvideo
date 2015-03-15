<?php
/**
 * Created by PhpStorm.
 * User: bingo
 * Date: 2014/9/17
 * Time: 21:28
 */
namespace Home\Model;
use Think\Model;

class CategoryModel extends Model{
    /**
     * 获取顶级分类列表
     * @return array 顶级分类列表
     */
    public function getTopCategory(){
        $Category = M('Category');
        $category = $Category ->where('categoryParent = 0') -> select();
        return $category;
    }

    public function getVideoCategory(){
        $Category = M('Category');
        $category['categoryType'] = 1;
        $category['categoryParent'] = 0;
        $videoCategory = $Category -> where($category) -> select();
        $i = 0;
        foreach($videoCategory as $cate){
            $secondCate = $Category -> where('categoryParent = '.$cate['categoryId']) -> select();
            $videoCategory[$i]['secondCategory'] = $secondCate;
            $i ++;
        }
        return $videoCategory;
    }
}