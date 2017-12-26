<?php

namespace backend\controllers;

use app\models\ArticleCategrory;
use yii\web\Request;

class ArticleCategroryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $cates = ArticleCategrory::find()->all();
        return $this->render('index',compact('cates'));
    }
    //添加
    public function actionAdd(){
        $cate = new ArticleCategrory();
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $cate->load($request->post());
            //后台验证数据是否有效
            if ($cate->validate()) {
                //写入数据
                if ($cate->save(false)) {
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect('index');
                }else{
                    \Yii::$app->session->setFlash('danger','写入数据失败');
                }
            }else{
                \Yii::$app->session->setFlash('danger','数据有误');
            }
        }else{
            return $this->render('add', ['cate' => $cate]);
        }
    }
    //修改
    public function actionEdit($id){
        $cate = ArticleCategrory::findOne($id);
        $request = new Request();
        if ($request->isPost) {
            //绑定数据
            $cate->load($request->post());
            //后台验证数据是否有效
            if ($cate->validate()) {
                //写入数据
                if ($cate->save(false)) {
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect('index');
                }else{
                    \Yii::$app->session->setFlash('danger','写入数据失败');
                }
            }else{
                \Yii::$app->session->setFlash('danger','数据有误');
            }
        }else{
            return $this->render('add', ['cate' => $cate]);
        }
    }
    //删除
    public function actionDel($id)
    {
        if (ArticleCategrory::findOne($id)->delete()) {
            \Yii::$app->session->setFlash('success','删除成功');

        }else{
            \Yii::$app->session->setFlash('danger','删除修改');
        }
        return $this->redirect('index');
    }
    //声明一个方法改变上线状态
    public function actionStatus($id){
        $cate = ArticleCategrory::findOne($id);
        if ($cate->status==1){
            $cate->status=0;
            $cate->save();
        }else{
            $cate->status=1;
            $cate->save();
        }
        return $this->redirect('index');
    }

}
