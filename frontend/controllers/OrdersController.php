<?php

namespace frontend\controllers;


use dosamigos\qrcode\lib\Enum;
use dosamigos\qrcode\QrCode;
use backend\models\Goods;
use EasyWeChat\Foundation\Application;
use frontend\models\Address;
use frontend\models\Cart;
use frontend\models\Orders;
use frontend\models\OrederDetail;
use yii\db\Exception;
use yii\helpers\Url;

class OrdersController extends \yii\web\Controller
{
    private  $orderId;
    public $enableCsrfValidation=false;
    //结算账单
    public function actionPayment(){
        //需要先判断是否登录
        if (\Yii::$app->user->isGuest) {
            //游客需要先登录才能结算
            \Yii::$app->session->set('back','/goods/payment');
            return $this->redirect(['/user/login']);
        }
        //获得所选商品
        $goods_id = \Yii::$app->request->post('goods_id');
        if (!$goods_id){
            return $this->redirect('/goods/cart-lists');
        }
        $carts = Cart::find()->where(['in','goods_id',$goods_id])->andWhere(['user_id'=>\Yii::$app->user->id])->all();
        //获得所有的地址
        $address = Address::find(['user_id'=>\Yii::$app->user->id])->orderBy('status')->all();

        return $this->render('pay',compact('address','carts'));
    }
    //订单信息入库
    public function actionAdd(){

        //获得数据；
        $request = \Yii::$app->request;
        if ($request->isPost) {
            //开启事务
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $orderNew = NEW Orders();
                //获取地址信息
                $address = Address::findOne($request->post('address_id'));
                //绑定地址信息
                $orderNew->name=$address->name;
                $orderNew->tel=$address->tel;
                $orderNew->province=$address->province;
                $orderNew->city=$address->city;
                $orderNew->area=$address->area;
                $orderNew->address=$address->address;
                $orderNew->user_id=$address->user_id;


                $orderNew->price=$request->post('price');
                $orderNew->sn=date('ymdHis').rand(1000,9999);
                $orderNew->send_type=$request->post('sendType');
                $orderNew->pay_type=$request->post('payType');
                if (!$orderNew->save()) {
                    throw  new Exception("订单有误");
                }
                //订单详细信息入库
                foreach ($request->post('goods_id') as $good_id){
                    $orderDetail = New OrederDetail();
                    //找到对应商品的信息
                    $orderDetail->goods_id=$good_id;
                    $orderDetail->logo=Goods::findOne($good_id)->logo;
                    $orderDetail->price=Goods::findOne($good_id)->shop_price;
                    $orderDetail->amount=Cart::findone(['goods_id'=>$good_id,'user_id'=>\Yii::$app->user->id])->amount;
                    //判断数据库中商品数量是否大于此时订单中商品数量

                    if ($orderDetail->amount>Goods::findOne($good_id)->stock){
                        throw  new Exception("库存不足");
                    }
                    $orderDetail->price=Goods::findOne($good_id)->shop_price;
                    $orderDetail->order_id=$orderNew->id;
                    $orderDetail->goods_name=Goods::findOne($good_id)->name;
                    if ($orderDetail->save()) {
                        //减少库存
                        Goods::updateAllCounters(['stock'=>-$orderDetail->amount],['id'=>$good_id]);
                    }
                    //清空购物车
                    Cart::findOne(['user_id'=>\Yii::$app->user->id,'goods_id'=>$good_id])->delete();
                }
                $transaction->commit();//提交事务
            } catch(Exception $e) {

                $transaction->rollBack();//回滚

                throw $e;
            }
          //  Url::to(['orders/show','id'=>$orderNew->id]);
            $this->redirect(['show','id'=>$orderNew->id]);
        }
    }
    //订单提交成功
    public function actionShow($id){

        return $this->render('wepay', ['id' =>$id]);

    }
    //生成二维码
    public function actionWepay($id){
        //查出订单
        $goodsOrder = Orders::findOne($id);

        //easywechat全局对象
        $app = new Application(\Yii::$app->params['easyWechat']);
        //支付对象
        $payment = $app->payment;
        //放订单详情信息
        $attributes = [
            'trade_type'       => 'NATIVE', // JSAPI，NATIVE，APP... 支付类型:NATIVE 原生扫码支付
            'body'             => '悟空商城订单 ',//订单标题
            'detail'           => '京西订单 好多商品',//详情
            'out_trade_no'     => $goodsOrder->sn,//订单编号
            'total_fee'        => $goodsOrder->price*100, // 单位：分 支付金额
            'notify_url'       => Url::to(['orders/finish'],true), // 支付结果通知网址，如果不设置则会使用配置里的默认地址
            //'openid'           => '当前用户的 openid', // trade_type=JSAPI，此参数必传，用户在商户appid下的唯一标识，
            // ...
        ];
        //创建订单
        $order = new \EasyWeChat\Payment\Order($attributes);
        //统一下单
        $result = $payment->prepare($order);
        // var_dump($result);
        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){
            // $prepayId = $result->prepay_id;
            //echo  $result->code_url;
            //二维码生成
            return QrCode::png($result->code_url,false,Enum::QR_ECLEVEL_H,6);
        }else{
            var_dump($result);
        }

    }

    //支付后确认订单
    public function actionfinish(){


        $app = new Application(\Yii::$app->params['easyWechat']);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 使用通知里的 "微信支付订单号" 或者 "商户订单号" 去自己的数据库找到订单
            $order = Orders::findOne(['sn'=>$notify->out_trade_no]);

            if (!$order) { // 如果订单不存在
                return 'Order not exist.'; // 告诉微信，我已经处理完了，订单没找到，别再通知我了
            }
            // 如果订单存在
            // 检查订单是否已经更新过支付状态
            if ($order->status!=1) { // 假设订单字段“支付时间”不为空代表已经支付
                return true; // 已经支付成功了就不再更新了
            }

            // 用户是否支付成功
            if ($successful) {
                // 不是已经支付状态则修改为已经支付状态
                $order->update_time = time(); // 更新支付时间为当前时间
                $order->status = 2;
            }

            $order->save(); // 保存订单

            return true; // 返回处理完成
        });

        return $response;
    }

}
