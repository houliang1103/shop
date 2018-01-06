<?php

namespace backend\controllers;

use backend\filters\CheckFilter;
use backend\models\Admin;
use backend\models\LoginForm;
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;

class AdminController extends \yii\web\Controller
{


    //验证码
    public function actions()
    {
        return [
            'captcha'=>[
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' =>YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4
            ]
        ];
    }
    public function actionIndex()
    {
        $models = Admin::find()->all();
        return $this->render('index',compact('models'));
    }
    //添加管理员
    public function actionAdd(){
        //实例对象
        $models = new Admin();
        //获得所有角色 先实例组件
        $auth = \Yii::$app->authManager;
        $role = $auth->getRoles();
        $roles = ArrayHelper::map($role,'name','description');
        //判断传值方式 及后台验证数据
        if ($models->load(\Yii::$app->request->post()) && $models->validate()){
            //设置登录令牌
            $models->token = \Yii::$app->security->generateRandomString();
            //对密码Hash加密
            $models->password = \Yii::$app->security->generatePasswordHash($models->password);
            //设置最后登录IP
            $models->last_ip = ip2long(\Yii::$app->request->userIP);
            $models->last_login_at=time();
            //保存数据
            if ($models->save()) {
                //给用户指定分组 需要先找的对应的角色
                if ($models->roles){
                foreach ($models->roles as $roles){
                    $role = $auth->getRole($roles);
                    $auth->assign($role,$models->id);
                }}
                \Yii::$app->user->login($models);
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect('/admin/index');
            }
        }
        return $this->render('add',compact('models','roles'));
    }

    //修改管理员
    public function actionEdit($id){
        //实例对象
        $models =Admin::findOne($id);
        //获得所有角色 先实例组件
        $auth = \Yii::$app->authManager;
        $role = $auth->getRoles();
        $roles = ArrayHelper::map($role,'name','description');
        //获得管理员对应的分组
        $models->roles =array_keys($auth->getRolesByUser($id));
        //接触之前管理员的分组
        foreach ($models->roles as $roleObj){
            $auth->revoke($auth->getRole($roleObj),$id);
        }
        //判断传值方式 及后台验证数据
        if ($models->load(\Yii::$app->request->post()) && $models->validate()){
            //对密码Hash加密
            $models->password = \Yii::$app->security->generatePasswordHash($models->password);
            //设置最后登录IP
            $models->last_ip = ip2long(\Yii::$app->request->userIP);
            $models->last_login_at = time();
            //保存数据
            if ($models->save()) {
                //给用户指定分组 需要先找的对应的角色
                if ($models->roles){
                foreach ($models->roles as $roleName){
                    $role = $auth->getRole($roleName);
                    $auth->assign($role,$models->id);
                }}
                \Yii::$app->user->login($models);
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect('/admin/index');
            }
        }
        return $this->render('add',compact('models','roles'));
    }

    //删除管理员
    public function actionDel($id){
        if (Admin::findOne($id)->delete()) {
            //解除管理员分组关系
            $auth = \Yii::$app->authManager;
            $roles = $auth->getRolesByUser($id);
            foreach ($roles as $role){
                $auth->revoke($role,$id);
            }
            \Yii::$app->session->setFlash('success','删除成功');
            return $this->redirect('index');
        }
    }

    //管理员登录
    public function actionLogin(){
        //判断是否登录
        if (!\Yii::$app->user->isGuest){
            return $this->redirect('/goods/index');
        }

        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()){
            //通过用户名查找管理员是否存在
            $admin = Admin::findOne(['username'=>$model->username]);
            if ($admin){
                //判断密码是否一致
                if (\Yii::$app->security->validatePassword($model->password,$admin->password)){
                    //验证通过用组件登录
                    \Yii::$app->user->login($admin,$model->rememberMe?3600*24*7:0);
                    //修改登录时间和登录Ip
                    $admin->last_ip = ip2long(\Yii::$app->request->userIP);
                    $admin->last_login_at = time();
                    $admin->save();
                    \Yii::$app->session->setFlash('success','登录成功');
                    //跳转
                    return $this->redirect('/goods/index');
                }else{
                    $model->addError('password','密码不正确');
                }
            }else{
                $model->addError('username','用户不存在');
            }
        }
        return $this->render('login', ['model' => $model]);
    }
public function actionLogout(){
        \Yii::$app->user->logout();
         return $this->redirect('/admin/login');
}

}
