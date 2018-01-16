<?php

namespace backend\controllers;

use backend\models\Article;
use backend\models\ArticleCategrory;
use backend\models\Detail;
use flyok666\qiniu\Qiniu;
use kucha\ueditor\UEditorAction;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class ArticleController extends \yii\web\Controller
{
    //富文本编辑
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
           'config' => [
                "imageUrlPrefix"  => "www.hou1103.cn",//图片访问路径前缀
                "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
            ],
        ];
    }


    /*public function actionUpload()
    {
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

        $configs = [
            "imageUrlPrefix"  => "",//图片访问路径前缀
            "imagePathFormat" => $url
        ];
        $ueditor = new UEditorAction($configs);
        return json_encode($result);

        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
            ],
              'config' => [
                  "imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                  "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
              ],


        ];
    }*/
    //展示
    public function actionIndex()
    {
        $model = Article::find();
        $count = $model->count();//总条数
        $pagination = new Pagination(['pageSize' => 5,'totalCount' => $count]);
        $models = $model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('index',['models' => $models,'pagination'=>$pagination]);
    }
    //添加
    public function actionAdd(){
        $model=new Article();
        $detail=new Detail();
        //得到所有分类
        $cates =  ArticleCategrory::find()->asArray()->all();
        //转换为数组
        $catesArr=ArrayHelper::map($cates,'id','name');
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()) {
                //文章写入数据库
                $model->save();
                //文章内容写入数据库
                if ($detail->load($request->post())) {
                    $detail->article_id=$model->id;
                    if ($detail->save()) {
                        \Yii::$app->session->setFlash('success','添加文章成功');
                        return $this->redirect(['index']);
                    }else{
                        \Yii::$app->session->setFlash('danger','写入失败');
                    }
                }
            }else{
                \Yii::$app->session->setFlash('danger','数据有误');
            }
        }
        return $this->render('add', compact('model','detail','catesArr'));
    }
    //修改
    public function actionEdit($id){
        $model = Article::findOne($id);
        //找对对应的内容对象
        $detail = Detail::findOne(['article_id'=>$id]);
        //得到所有分类
        $cates =  ArticleCategrory::find()->asArray()->all();
        //转换为数组
        $catesArr=ArrayHelper::map($cates,'id','name');
        $request=\Yii::$app->request;
        if ($request->isPost){
            $model->load($request->post());
            if ($model->validate()) {
                //文章写入数据库
                $model->save();
                //文章内容写入数据库
                if ($detail->load($request->post())) {
                    if ($detail->save()) {
                        \Yii::$app->session->setFlash('success','文章修改成功');
                        return $this->redirect(['index']);
                    }else{
                        \Yii::$app->session->setFlash('danger','写入失败');
                    }
                }
            }else{
                \Yii::$app->session->setFlash('danger','数据有误');
            }
        }
        return $this->render('add', compact('model','detail','catesArr'));
    }

    //删除
    public function actionDel($id){
        //删除文章
        $result = Article::findOne($id)->delete();
        //删除内容
        $result2 = Detail::findOne($id)->delete();
        return $this->redirect('index');
    }
    //声明一个方法改变上线状态
    public function actionStatus($id){
        $Article = Article::findOne($id);
        if ($Article->status==1){
            $Article->status=0;
            $Article->save();
        }else{
            $Article->status=1;
            $Article->save();
        }
        return $this->redirect('index');
    }
}
