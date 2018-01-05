<?php

namespace backend\controllers;

use app\models\Brand;
use app\models\Category;
use app\models\GoodsGallery;
use app\models\GoodsIntro;
use backend\models\Goods;
use Symfony\Component\Console\Helper\Helper;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
{
    //处理富文本内容
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ]
        ];
    }
    //展示页面
    public function actionIndex()
    {

        $goods = Goods::find();
        //获得搜索数据
        $request = \Yii::$app->request;
        $status = $request->get('status');
        $minprice = $request->get('minprice');
        $maxprice = $request->get('maxprice');
        $keyword= $request->get('keyword');

        if(in_array($status,['0','1'])){
            $goods->andWhere("status==={$status}");
        }
        if ($minprice){
            $goods->andWhere("shop_price>={$minprice}");
        }
        if ($maxprice){
            $goods->andWhere("shop_price<={$maxprice}");
        }
        if ($keyword){
            $goods->andWhere("name like '%{$keyword}%' or sn like '%{$keyword}%'");
        }
        $pages = new Pagination(
            [
                'totalCount' => $goods->count(),
                'pageSize' => 2
            ]
        );
        $goods = $goods->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index',compact('goods','pages'));
    }
    //添加商品
    public function actionAdd(){
        //实例商品对象
        $goods = new Goods();

        //实例商品详情
        $intro = new GoodsIntro();
        //获得所有品牌
        $brand = Brand::find()->asArray()->all();
        $brands =ArrayHelper::map($brand,'id','name');
        //获得所有分类
        $cate = Category::find()->orderBy('tree,lft')->all();
        $cates =ArrayHelper::map($cate,'id','nameText');
        //判断传值方式
        $request =new Request();
        if ($request->isPost) {
            //给商品绑定数据
            $goods->load($request->post());
            //后端验证数据
            if ($goods->validate()) {
                //判断是否手动输入货号
                if (empty($goods->sn)) {
                    //得到今日时间
                    $curr_time = strtotime(date('Ymd'));
                    //获取数据库今日货物数
                    $count = Goods::find()->where("create_time>={$curr_time}")->count();
                    $count = $count+1;
                    $sn = substr('000'.$count,-4);
                    $goods->sn = date('Ymd').$sn;
                }
            }
                //保存数据
            if ($goods->save()) {
                //给商品详情绑定数据
                $intro->load($request->post());
                $intro->goods_id = $goods->id;
                //验证数据
                if ($intro->validate()) {
                    $intro->save();
                }

                //给图库添加数据
                foreach ($goods->imgsFile as $img){
                    //实例图库
                    $images = new GoodsGallery();
                    $images->path = $img;
                    $images->goods_id = $goods->id;
                    //验证数据
                    if ($images->validate()) {
                        $images->save();
                    }
                }
                \Yii::$app->session->setFlash('success','商品添加成功');
                return $this->redirect('index');
            }
        }
        return $this->render('add', compact('cates','goods','brands','intro'));
    }
    public function actionEdit($id){
        //实例商品对象
        $goods = Goods::findOne($id);
        //实例商品详情
        $intro = GoodsIntro::findOne(['goods_id'=>$id]);
//        var_dump($intro);exit();
        //获得对应的图片
        $goodsImages = GoodsGallery::find()->where(["goods_id"=>$id])->asArray()->all();
        $goods->imgsFile = array_column($goodsImages,'path');
        //获得所有品牌
        $brand = Brand::find()->asArray()->all();
        $brands =ArrayHelper::map($brand,'id','name');
        //获得所有分类
        $cate = Category::find()->orderBy('tree,lft')->all();
        $cates =ArrayHelper::map($cate,'id','nameText');
        //判断传值方式
        $request =new Request();
        if ($request->isPost) {
            //给商品绑定数据
            $goods->load($request->post());
            //后端验证数据
            if ($goods->validate()) {
                //判断是否手动输入货号
                if (empty($goods->sn)) {
                    //得到今日时间
                    $curr_time = strtotime(date('Ymd'));
                    //获取数据库今日货物数
                    $count = Goods::find()->where("create_time>={$curr_time}")->count();
                    $count = $count+1;
                    $sn = substr('000'.$count,-4);
                    $goods->sn = date('Ymd').$sn;
                }
            }
                //保存数据
            if ($goods->save()) {
                //给商品详情绑定数据
                $intro->load($request->post());
                $intro->goods_id = $goods->id;
                //验证数据
                if ($intro->validate()) {
                    $intro->save();
                }

                //给图库添加数据
                foreach ($goods->imgsFile as $img){
                    //实例图库
                    $images = new GoodsGallery();
                    $images->path = $img;
                    $images->goods_id = $goods->id;
                    //验证数据
                    if ($images->validate()) {
                        $images->save();
                    }
                }
                \Yii::$app->session->setFlash('success','商品添加成功');
                return $this->redirect('index');
            }
        }
        return $this->render('add', compact('cates','goods','brands','intro'));
    }

}
