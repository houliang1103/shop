<?php

namespace frontend\controllers;

class AddressController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    //修改收货地址
    public function actionAddress($id){
        $user = User::findOne($id);
        return $this->render('address',compact('user'));
    }
}
