<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/12
 * Time: 11:21
 */

namespace frontend\components;



use frontend\models\Cart;
use yii\base\Component;
use yii\web\Cookie;

class ShopCart extends Component
{
    private $_cart;
    public function __construct(array $config = [])
    {
        $this->_cart = \Yii::$app->request->cookies->getValue('cart');
        parent::__construct($config);
    }
    //增
    public function add($id,$amount){
        //2.2判断是否存有该商品 存在修改
        if (array_key_exists($id,$this->_cart)) {
            $this->_cart[$id] += $amount;
//                echo 1111;exit;
        }else{
            //2.3不存在新增
            $this->_cart[$id]=(int)$amount;
        }
        return $this;
    }

    //删
    public function del($id)
    {
        unset($this->_cart[$id]);
        return $this;

    }
    //清空Cookie
    public function flush(){
        $this->_cart=[];
        return $this;
    }
    //改
    public function update($id,$amount){

        $this->_cart[$id] =$amount;
        return $this;
    }
    //查
    public function get(){
        return $this->_cart;
    }
    //保存
    public function save(){

        //游客  存cookie 1.1得到设置cookie的对象
        $setCookie = \Yii::$app->response->cookies;
        //1.2 保存cookie
        $cookie = new Cookie([
            'name'=>'cart',
            'value'=>$this->_cart,
            'expire'=>\Yii::$app->params['cookieTime']
        ]);

        $setCookie->add($cookie);

    }
    //cookie 数据同步入库
    public function sysDb(){

        foreach ($this->_cart as $goodId=>$amount){
            //判断当前商品在数据库中是否存在
            $userId=\Yii::$app->user->id;//用户Id
            //取出商品Id对应购物车数据
            $cart=Cart::findOne(['goods_id'=>$goodId,'user_id'=>$userId]);
            if ($cart) {
                //如果存在 修改+$amount
                $cart->amount+=$amount;
                $cart->save();
            }else{
                //新增
                $cart=new Cart();
                $cart->amount=$amount;
                $cart->goods_id=$goodId;
                $cart->user_id=$userId;
                $cart->save();
            }
         }
         return $this;
    }

}
