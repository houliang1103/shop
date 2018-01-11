<?php

namespace backend\controllers;

use backend\models\Category;
use yii\data\Pagination;
use yii\db\Exception;
use yii\helpers\Json;
use yii\web\Request;

class CategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $cates = Category::find()->orderBy('tree,lft')->all();//得到对象

        return $this->render('index',compact('cates'));
    }
    //添加
    public function actionAdd(){
        //获得所有分类
        $models = Category::find()->asArray()->all();
        $models[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];

        $models = Json::encode($models);
        $cates = new Category();
        $request = new Request();
        if ($request->isPost) {
            $cates->load($request->post());
            if ($cates->parent_id==0) {
                //判断为顶级分类
                $cates->makeRoot();
                \Yii::$app->session->setFlash("success","添加一级分类".$cates->name."成功");
            }else{
                //不是顶级分类
                $parentCate = Category::findOne($cates->parent_id);
                $cates->prependTo($parentCate);
                \Yii::$app->session->setFlash("success","把".$cates->name."添加到".$parentCate->name."成功");
                //$newZeeland->insertBefore($australia);添加到指定的分类后面
            }
            //刷新
            return $this->refresh();
        }
        return $this->render('add',compact('cates','models'));

    }
    //修改
    public function actionEdit($id){
        //获得所有分类
        $models = Category::find()->asArray()->all();
        $models[]=['id'=>0,'name'=>'顶级分类','parent_id'=>0];

        $models = Json::encode($models);
        $cates = Category::findOne($id);
        $request = new Request();
        if ($request->isPost) {
            $cates->load($request->post());
            try{
                if ($cates->parent_id==0) {
                    //判断为顶级分类
                    $cates->save();
                    \Yii::$app->session->setFlash("success","修改一级分类".$cates->name."成功");
                }else{
                    //不是顶级分类
                    $parentCate = Category::findOne($cates->parent_id);
                    $cates->prependTo($parentCate);
                    \Yii::$app->session->setFlash("success",$cates->name."修改到".$parentCate->name."成功");
                    //$newZeeland->insertBefore($australia);添加到指定的分类后面
                }

            }catch (Exception $exception){
                \Yii::$app->session->setFlash("danger",$exception->getMessage());
                return $this->refresh();
            }
            //刷新
            return $this->redirect('index');
        }
        return $this->render('add',compact('cates','models'));

    }
    //删除
    public function actionDel($id){
        $result = Category::findOne($id);
        if ($result->deleteWithChildren()) {
            \Yii::$app->session->setFlash("success",$result->name."分类删除成功");
            return $this->redirect('index');
        }else{
            var_dump($result->error);
        }
    }

}
