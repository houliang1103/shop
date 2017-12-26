<?php

namespace backend\controllers;

use app\models\Article;
use app\models\ArticleCategrory;
use app\models\Detail;
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
            ]
        ];
    }
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
