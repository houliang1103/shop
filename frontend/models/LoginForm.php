<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3
 * Time: 22:43
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe;
    public $code;

    public function rules()
    {
        return [
            [['username','password','code',],'required'],
            [['rememberMe'],'safe'],
            [['code'],'captcha','captchaAction' => 'user/captcha'],
        ];

    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名',
            'password'=>'密码',
            'rememberMe'=>'记住密码',
            'code'=>'验证码',
        ];
    }

}