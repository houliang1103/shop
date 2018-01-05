<?php

namespace backend\controllers;

use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

class RoleController extends \yii\web\Controller
{
    //展示列表
    public function actionIndex()
    {
        //实例组件
        $auth = \Yii::$app->authManager;
        $models = $auth->getRoles();
        return $this->render('index',compact('models'));
    }
    //添加权限
    public function actionAdd(){
        //实例model
        $model = new AuthItem();
        //实例auth组件
        $auth = \Yii::$app->authManager;
        //获得所有权限
        $premission = $auth->getPermissions();
        $premissions = ArrayHelper::map($premission,'name','description');
        //判断传值方式和后台验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            //创建角色
            $role = $auth->createRole($model->name);
            //设置权限
            $role->description = $model->description;
            //权限入库
            if ($auth->add($role)) {
                //给角色添加权限
                if($model->premission){
                    foreach ($model->premission as $preName){
                        //获得权限对象
                        $premissionObj = $auth->getPermission($preName);
                        //添加权限给角色  注意是参数都是对象，需要先获得对象
                        $auth->addChild($role,$premissionObj);
                    }
                }
                \Yii::$app->session->setFlash('success','添加角色成功');
                return $this->refresh();
            }
        }
        return $this->render('add',compact('model','premissions'));
    }



    //修改角色
    public function actionEdit($name){
        //实例model
        $model =AuthItem::findOne($name);
        //实例auth组件
        $auth = \Yii::$app->authManager;

        //获得所有权限
        $premission = $auth->getPermissions();
        $premissions = ArrayHelper::map($premission,'name','description');
        $model->premission = array_keys($auth->getPermissionsByRole($name)) ;
        //判断传值方式和后台验证数据
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            //得到该角色
            $role = $auth->getRole($name);
            //设置描述
            $role->description = $model->description;
            //权限入库
            if ($auth->update($name,$role)) {
                //给角色添加权限先删除之前的权限
                $auth->removeChildren($role);
                if($model->premission){
                    foreach ($model->premission as $preName){
                        //获得权限对象
                        $premissionObj = $auth->getPermission($preName);
                        //添加权限给角色  注意是参数都是对象，需要先获得对象
                        $auth->addChild($role,$premissionObj);
                    }
                }
                \Yii::$app->session->setFlash('success','修改角色成功');
                return $this->redirect('index');
            }
        }
        return $this->render('edit',compact('model','premissions'));
    }



    //删除权限
    public function actionDel($name){
        //实例组件
        $auth = \Yii::$app->authManager;
        $role =$auth->getRole($name);
        if ($auth->remove($role)) {
            \Yii::$app->session->setFlash('success','删除角色成功');
            return $this->redirect('index');
        }
    }


}
