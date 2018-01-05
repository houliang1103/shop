<?php

namespace backend\controllers;

use backend\models\AuthItem;

class AuthItemController extends \yii\web\Controller
{
    //展示列表
    public function actionIndex()
    {
        //实例化Auth组件
        $auth = \Yii::$app->authManager;
        $models = $auth->getPermissions();
        return $this->render('index',compact('models'));
    }
    //添加权限
    public function actionAdd(){
        //实例model
        $model = new AuthItem();
        //实例auth组件
        $auth = \Yii::$app->authManager;
        //判断传值方式和后台验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            //创建权限
            $permission = $auth->createPermission($model->name);
            //设置权限
            $permission->description = $model->description;
            //权限入库
            if ($auth->add($permission)) {
                \Yii::$app->session->setFlash('success',"添加".$model->name."权限成功");
                return $this->refresh();
            }
        }
        return $this->render('add',compact('model'));
    }
    public function actionEdit($name){
        //实例model
        $model =AuthItem::findOne($name);
        //实例auth组件
        $auth = \Yii::$app->authManager;
        //判断传值方式和后台验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            //得到该权限
            $permission = $auth->getPermission($name);
            //设置权限
            $permission->description = $model->description;
            //权限入库
            if ($auth->update($name,$permission)) {
                \Yii::$app->session->setFlash('success',"修改".$model->name."权限成功");
                return $this->redirect('index');
            }
        }
        return $this->render('edit',compact('model'));
    }
    //删除权限
    public function actionDel($name){
        //实例组件
        $auth = \Yii::$app->authManager;
        $permission =$auth->getPermission($name);
        if ($auth->remove($permission)) {
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect('index');
        }
    }


}
