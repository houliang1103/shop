<?php

namespace backend\controllers;

use app\models\Brand;
use flyok666\qiniu\Qiniu;
use yii\data\Pagination;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (isset($_GET['status'])) {
            $query = Brand::find()->where(['status'=>$_GET['status']]);//得到对象

        }else{
            $query = Brand::find();//得到对象

        }
        $count = $query->count();//总条数
        $pagination = new Pagination(['pageSize' => 5,'totalCount' => $count]);
        $brands = $query->offset($pagination->offset)->limit($pagination->limit)->all();
        //展示页面
        return $this->render('index',['brands' => $brands,'pagination'=>$pagination]);
    }
    //添加
    public function actionAdd(){
        $brand = new Brand();
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $brand->load($request->post());
                //后台验证数据是否有效
                if ($brand->validate()) {
                    //写入数据
                    if ($brand->save(false)) {
                        \Yii::$app->session->setFlash('success','添加成功');
                        return $this->redirect('index');
                    }else{
                        \Yii::$app->session->setFlash('danger','写入数据失败');
                    }
                }else{
                    \Yii::$app->session->setFlash('danger','数据有误');
                }
        }else{
            return $this->render('add', ['brand' => $brand]);
        }
    }
    //修改
    public function actionEdit($id){
        $brand = Brand::findOne($id);
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $brand->load($request->post());
            //后台验证数据是否有效
            if ($brand->validate()) {
                //写入数据
                if ($brand->save()) {
                    \Yii::$app->session->setFlash('success','修改成功');
                    return $this->redirect('index');
                }else{
                    \Yii::$app->session->setFlash('danger','写入数据失败');
                }
            }else{
                \Yii::$app->session->setFlash('danger','数据有误');
            }
        }else{
            return $this->render('add', ['brand' => $brand]);
        }
    }
    //删除
    public  function actionDel($id){
        if (Brand::findOne($id)->delete()) {
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect('index');
        }
    }
    //普通上传图片
 /*   public function actionUpload(){
//        var_dump($_FILES);exit;
        //{"code": 0, "url": "http://domain/图片地址", "attachment": "图片地址"}
        $file = UploadedFile::getInstanceByName('file');
        if ($file) {
            $path = 'images/brand/'.uniqid().'.'.$file->extension;
            //上传
            $file->saveAs($path,false);
        }

        $result = [
            'code'=>0,
            'url' =>'/'.$path,
            'attachment'=>$path
        ];
        return json_encode($result);
    }*/
   //七牛云上传图片
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
    //声明一个方法改变上线状态
    public function actionStatus($id){
        $brand = Brand::findOne($id);
        if ($brand->status==1){
            $brand->status=0;
            $brand->save();
        }else{
            $brand->status=1;
            $brand->save();
        }
        return $this->redirect('index');
    }

}
