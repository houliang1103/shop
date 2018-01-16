<?php

namespace frontend\controllers;

use frontend\models\Address;
use frontend\models\User;

class AddressController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    public function actionIndex(){
        $user_id = \Yii::$app->user->id;
        $address = Address::find(['user_id'=>$user_id])->orderBy('status')->all();
        return $this->render('index',compact('address'));
    }

    //新增地址
    public function actionAdd(){

        //绑定数据
        $address = new Address();

        $address->load(\Yii::$app->request->post());
        if ($address->status==='1'){
            //改变地址的status
            $addressAll = Address::findAll(['user_id'=>\Yii::$app->user->id]);
            foreach ($addressAll as $addr){
                $addr->status = 2;
                $addr->save();
            }
        }
        //验证
        if ($address->validate()) {
            if ($address->save()) {
                return $this->redirect('index');
            }
        }
        return $this->redirect('index');
    }
    //设置地址为默认地址
    public function actionStatus($id){
        //改变地址的status
        $address = Address::findAll(['user_id'=>\Yii::$app->user->id]);
        foreach ($address as $addr){
            $addr->status = 2;
            $addr->save();
        }
        $address = Address::findOne($id);
        $address->status=1;
        if ($address->save()) {

            return 111;
        }
    }

    //删除地址
    public function actionDel($id){
        $address = Address::findOne($id);
        if ($address->delete()) {
            return $this->redirect('index');
        }
    }
}
