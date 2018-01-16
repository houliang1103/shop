<?php

namespace frontend\controllers;

use backend\models\Category;
use backend\models\Goods;
use frontend\models\Cart;
use yii\web\Cookie;


class GoodsController extends \yii\web\Controller
{
    public $enableCsrfValidation=false;
    //商品首页
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param $id 分类ID
     * @return string
     * 分类商品展示
     */
    public function actionLists($id){

        //通过ID找到该分类信息
        $cate = Category::findOne($id);
        //找该分类和他的所有子类
        $cates = Category::find()->where(['tree'=>$cate->tree])->andWhere("lft>={$cate->lft}")->andWhere("rgt<={$cate->rgt}")->asArray()->all();
        //获得所有分类的ID
        $catesIds = array_column($cates,'id');
        //找到所有商品
        $model = Goods::find()->where(['in','goods_category_id',$catesIds])->andWhere(['status'=>1])->asArray()->all();


        return $this->render('lists',compact('model'));
    }
    //商品详情
    public function actionDetail($id){
        $good = Goods::findOne($id);

        return $this->render('goods',compact('good'));
    }

    /**
     * @param $id 商品ID
     * @param $amount  购物车该商品数量
     * @return \yii\web\Response
     */
    public function actionCart($id,$amount){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //2.1取出以前的cookie
            $cookieOld = \Yii::$app->request->cookies->getValue('cart',[]);
            //2.2判断是否存有该商品 存在修改
            if (array_key_exists($id,$cookieOld)) {
                $cookieOld[$id] += $amount;
//                echo 1111;exit;
            }else{
                //2.3不存在新增
                $cookieOld[$id]=(int)$amount;
            }
            //游客  存cookie 1.1得到设置cookie的对象
            $setCookie = \Yii::$app->response->cookies;
            //1.2 保存cookie
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>$cookieOld,
                'expire'=>time()+3600*24*30
            ]);

            $setCookie->add($cookie);
        }else{
            //已经登录  判断数据库是否有该商品的订单
            $user_id = \Yii::$app->user->id;
            $cartOld = Cart::find()->where(['goods_id'=>$id])->andWhere(['user_id'=>$user_id])->all();
            if ($cartOld) {
                //存在 执行修改
                $cartOld[0]->amount += $amount;
                $cartOld[0]->save();

            }else{
                //不存在  执行添加
                $car = new Cart();
                $car->goods_id = $id;
                $car->amount = $amount;
                $car->user_id = $user_id;
                $car->save();

            }

        }
        return $this->redirect('cart-lists');
    }


    //购物车列表展示
    public function actionCartLists(){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //游客从cookie中取出数据
            $cart = \Yii::$app->request->cookies->getValue('cart',[]);
            //取出数组中的ID  也就是商品的ID
            $cartIds = array_keys($cart);
            //通过ID找出商品
            $goods = Goods::find()->where(['in','id',$cartIds])->asArray()->all();
            //绑定数量到数组中  也可不执行次步骤，在视图中单独拿去
            foreach ($goods as $k => $good) {
                $goods[$k]['amount'] = $cart[$good['id']];
                //  $goods[1]['num']=$cart[$good['id']];
            }

        }else{
            //已经登录  从数据库中取出数据
            $user_id = \Yii::$app->user->id;
            $carts = Cart::find()->where(['user_id'=>$user_id])->asArray()->all();

            $goodsIds=[];
            //取出数组中的ID  也就是商品的ID
            foreach ($carts as $k=>$v){
                $goodsIds[$k]=$v['goods_id'];
            }
            //通过ID找出商品
            $goods = Goods::find()->where(['in','id',$goodsIds])->asArray()->all();
            //绑定数量到数组中  也可不执行次步骤，在视图中单独拿去
            foreach ($goods as $k => $good) {
                $goods[$k]['amount'] = Cart::findOne(['goods_id'=>$good['id'],'user_id'=>\Yii::$app->user->id])->amount;
                //  $goods[1]['num']=$cart[$good['id']];
            }

        }
        return $this->render('cart-lists',compact('goods'));
    }

    /**
     * @param $id  商品ID
     * @param $amount  商品数量
     * 修改购物车商品数量
     */
    public function actionUpdate($id,$amount){
        //判断是否登录
        if (\Yii::$app->user->isGuest){
            //游客修改cookie
            $setCookie = \Yii::$app->response->cookies;
            $cartOld = \Yii::$app->request->cookies->getValue('cart',[]);
            //保存cookie值
            $cartOld[$id]=$amount;
            //1.2 保存cookie
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>$cartOld,
                'expire'=>\Yii::$app->params['cookieTime']
            ]);
            $setCookie->add($cookie);


        }else {
            //已登录修改数据库
            $user_id = \Yii::$app->user->id;
            $cartOld = Cart::find()->where(['goods_id' => $id])->andWhere(['user_id' => $user_id])->all();
            $cartOld[0]->amount= $amount;
            $cartOld[0]->save();

        }
        return  11;

    }

    //删除购物车的商品
    public function actionDel($id){
        //判断是否登录
        if (\Yii::$app->user->isGuest) {
            //游客删除cookie
            $setCookie = \Yii::$app->response->cookies;
            $cookie = \Yii::$app->request->cookies->getValue('cart');
            unset($cookie[$id]);
            //1.2 保存cookie
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>$cookie,
                'expire'=>time()+3600*24*30
            ]);
            $setCookie->add($cookie);

        }else{
            //已登录删除数据库数据
            Cart::findOne(['user_id'=>\Yii::$app->user->id,'goods_id'=>$id])->delete();
        }
        return $this->redirect('cart-lists');
    }



}
