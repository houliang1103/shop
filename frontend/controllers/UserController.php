<?php

namespace frontend\controllers;

use frontend\models\LoginForm;
use frontend\models\User;
use Mrgoon\AliSms\AliSms;
use yii\helpers\Json;
use yii\web\Request;

class UserController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
   //验证码
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('/goods/index');
    }
    //注册
    public function actionRegist(){

        //判断传值方式
        $request = new Request();
        if ($request->isPost) {
            //实例user
            $user = new User();

            //绑定场景
            $user->setScenario('regist');
            //绑定数据
            $user->load($request->post());
            //验证数据
            if ($user->validate()) {
                $user->password_hash = \Yii::$app->security->generatePasswordHash($user->password);//转hash密码
                $user->auth_key = \Yii::$app->security->generateRandomString();
                if ($user->save(false)) {
                    \Yii::$app->user->login($user);
                    return Json::encode([
                        'status'=>1,
                        'msg'=>'注册成功',
                    ]);
                }
            }
            return Json::encode([
                'status'=>0,
                'msg'=>'注册失败',
                'data'=>$user->errors
            ]);
        }

        return $this->render('regist');
    }


    //手机验证码验证
    public function actionCheck($mobile){
        //生成随机6位数
        $code = rand(100000,999999);

        //阿里云短信验证
       /* $config = [
            //'access_key' => 'your access key',
            'access_key' => 'LTAIwcDNkyvf05oC',//应用ID
            //'access_secret' => 'your access secret',
            'access_secret' => 'MC2TcIRz67A6yHNIuDHe4ZxkTmtfIw',//密匙
            'sign_name' => 'blog联盟',//签名
        ];
        //$aliSms = new Mrgoon\AliSms\AliSms();
        $aliSms = new AliSms();
        //$response = $aliSms->sendSms(填写的电话号码, 模板CODE, ['name'=> 'value in your template'], $config);
        $response = $aliSms->sendSms($mobile, 'SMS_120405869', ['code'=> $code], $config);*/
        //保存验证码
        \Yii::$app->session->set("tel_".$mobile,$code);

        return $code;
    }
    //登录
    public function actionLogin(){
        //判断是否登录
        if (!\Yii::$app->user->isGuest){
            return $this->redirect('/goods/index');
        }
        //判断传值方式
        $request = \Yii::$app->request;
        if ($request->isPost){
            $model = new User();
            //绑定场景
            $model->setScenario('login');
            //绑定数据
            $model->load($request->post());
            //验证数据
            if ($model->validate()) {
                $user = User::findOne(['username'=>$model->username]);
                if ($user){
                    //判断密码是否一致
                    if (\Yii::$app->security->validatePassword($model->password,$user->password_hash)){
                        //验证通过用组件登录
                        \Yii::$app->user->login($user,$model->rememberMe?3600*24*7:0);
                        //修改登录时间和登录Ip
                        $user->login_ip = ip2long($request->userIP);
                        $user->save(false);
                        \Yii::$app->session->setFlash('success','登录成功');
                        //跳转
                        return $this->redirect('/goods/index');
                    }
                }
//                    $model->addError('username','用户不存在');
            }

           \Yii::$app->session->setFlash('danger','登录失败');
            return $this->redirect('login');
        }
   return $this->render('login');
    }

    public function actionLogout(){
        if (\Yii::$app->user->logout()) {
            return $this->redirect('login');
        }
    }

}
