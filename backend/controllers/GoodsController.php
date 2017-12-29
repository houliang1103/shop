<?php

namespace backend\controllers;

use app\models\Brand;
use app\models\Category;
use app\models\GoodsGallery;
use app\models\GoodsIntro;
use backend\models\Goods;
use flyok666\qiniu\Qiniu;
use Symfony\Component\Console\Helper\Helper;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Request;

class GoodsController extends \yii\web\Controller
{
    //展示页面
    public function actionIndex()
    {
        return $this->render('index');
    }
    //添加商品
    public function actionAdd(){
        //实例商品对象
        $goods = new Goods();
        //实例图库
        $images = new GoodsGallery();
        //实例商品详情
        $intro = new GoodsIntro();
        //获得所有品牌
        $brand = Brand::find()->asArray()->all();
        $brands =ArrayHelper::map($brand,'id','name');
        //获得所有分类
        $cate = Category::find()->asArray()->all();
        $cate[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];
        $cates = Json::encode($cate);
        //$request = new Request();
        //查出数据库中最后一条数据货号
        $last_goods = Goods::find()->orderBy('id DESC')->limit(1,1)->all();
        $pre_time =date('Ymd',$last_goods[0]->create_time);
        //判断传值方式
        $request =new Request();
        if ($request->isPost) {
            //给商品绑定数据
            $goods->load($request->post());
            //判断是否手动输入货号
            if (empty($goods->sn)) {
                //判断最后一条数据的时间是否与当前时间一样
                if ($pre_time-date('Ymd',time())==0){
                    //判断是否有输入货号
                    $goods->sn = $last_goods[0]->sn+1;
                }else{
                    $goods->sn =  time().sprintf('%04d',1);
                    echo $goods-sn;exit;//TODO 记得删除
                }
            }
            //验证数据是否有误
            if ($goods->validate()) {
                //保存数据
                $goods->save();
            }
            //给商品详情绑定数据
            $intro->load($request->post());
            $intro->goods_id = $goods->id;
            var_dump($intro);exit;
            //验证数据
            if ($intro->validate()) {
                $intro->save();
            }
            var_dump($request->post()['GoodsGallery']['path']);
            //给图库添加数据
            foreach ($request->post()['GoodsGallery']['path'] as $img){

                $images->path = $img;
                $images->goods_id = $goods->id;
                //验证数据
                if ($images->validate()) {
                    if ($images->save()) {
                        \Yii::$app->session->setFlash('success','添加商品成功');
                        return $this->refresh();
                    }

                }
            }
        }
        return $this->render('add', compact('cates','goods','brands','intro','images'));
    }
    //上传图片处理
    public function actionUpload(){
        //上传七牛云开始
        $config = [
            'accessKey' => 'PjykTWwZiGEitP4-CES5qYfsBADJb_Gap3hJed9X',//AK
            'secretKey' => 'pCVfybojhsir1IT4GWGGkSo5An9THdynw9IbRXWq',//SK
            //'domain' => 'http://p1ht4b07w.bkt.clouddn.com',//临时域名
            'domain' => 'http://p1jr2kct2.bkt.clouddn.com',//临时域名
            'bucket' => 'yii-shop',//空间名称
            'area' => Qiniu::AREA_HUADONG//区域
        ];
        $qiniu = new Qiniu($config);//实例化对象
//var_dump($qiniu);exit;
        $key = uniqid();//上传后的文件名  多文件上传有坑
        $qiniu->uploadFile($_FILES['file']["tmp_name"], $key);//调用上传方法上传文件
        $url = $qiniu->getLink($key);//得到上传后的地址

        //返回的结果
        $result = [
            'code' => 0,
            'url' => $url,
            'attachment' => $url

        ];
        return json_encode($result);
    }

}
