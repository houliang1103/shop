<?php
/* @var $v frontend\models\Address */
/* @var $cart frontend\models\Cart */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>填写核对订单信息</title>
	<link rel="stylesheet" href="/static/style/base.css" type="text/css">
	<link rel="stylesheet" href="/static/style/global.css" type="text/css">
	<link rel="stylesheet" href="/static/style/header.css" type="text/css">
	<link rel="stylesheet" href="/static/style/fillin.css" type="text/css">
	<link rel="stylesheet" href="/static/style/footer.css" type="text/css">

	<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/static/js/cart2.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php
include_once Yii::getAlias('@app/views/common/nav.php');
?>
<!-- 顶部导航 end -->
	
	<div style="clear:both;"></div>
	
	<!-- 页面头部 start -->
	<div class="header w990 bc mt15">
		<div class="logo w990">
			<h2 class="fl"><a href="<?=\yii\helpers\Url::to(['goods/index'])?>"><img src="/static/images/timg.jpg" height="80" alt="悟空商城"></a></h2>
			<div class="flow fr flow2">
				<ul>
					<li>1.我的购物车</li>
					<li class="cur">2.填写核对订单信息</li>
					<li>3.成功提交订单</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- 页面头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 主体部分 start -->
<form id="form_order" method="post" action="<?=\yii\helpers\Url::to('add')?>">
	<div class="fillin w990 bc mt15">
		<div class="fillin_hd">
			<h2>填写并核对订单信息</h2>
		</div>

		<div class="fillin_bd">
			<!-- 收货人信息  start-->
			<div class="address">
				<h3>收货人信息 <a href="<?=\yii\helpers\Url::to('/address/index')?>" id="">[修改]</a></h3>
				<div class="address_select">
					<ul>
                        <?php foreach ($address as $k=>$v):?>
						<li >
							<input type="radio" value="<?=$v->id?>" name="address_id"  <?=$k==0?'checked':''?> value="<?=$v->id?>" /><?=$v->name.' '.$v->tel.' '.$v->province.' '.$v->city.' '.$v->area.' '.$v->address?>

						</li>
                        <?php endforeach;?>
					</ul>

				</div>
			</div>
			<!-- 收货人信息  end-->

			<!-- 配送方式 start -->
			<div class="delivery">
				<h3>送货方式 </h3>
				<div class="delivery_info">
                    <table>
                    <?php $n=0; foreach (Yii::$app->params['sendType'] as $sk=>$sv):?>
                        <tr><td><input  type="radio" name="sendType" <?=$n==0?'checked':''?> value="<?=$sk.$sv[1]?>" class="sendPrice"><?=$sk.' >>> '.$sv[0]?> <span style="color: #ff5440">运费：</span><span style="color: #ff5440" ><?=$sv[1]?></span></td></tr>
                    <?php $n++; endforeach;?>
                    </table>
				</div>


			</div> 
			<!-- 配送方式 end --> 

			<!-- 支付方式  start-->
			<div class="pay">
				<h3>支付方式</h3>

				<div class="pay_select">
					<table>
                        <?php $num=0; foreach (Yii::$app->params['payType'] as $pk=>$pv):?>
						<tr >
							<td class="col1"><input type="radio" value="<?=$pk?>" <?=$num==0?'checked':''?> name="payType" /><?=$pk?></td>
							<td class="col2"><?=$pv?></td>
						</tr>
                        <?php $num++;  endforeach;?>
					</table>
				</div>
			</div>
			<!-- 支付方式  end-->

			<!-- 发票信息 start-->

			<!-- 发票信息 end-->

			<!-- 商品清单 start -->
			<div class="goods">
				<h3>商品清单</h3>
				<table>
					<thead>
						<tr>
							<th class="col1">商品</th>
							<th class="col3">价格</th>
							<th class="col4">数量</th>
							<th class="col5">小计</th>
						</tr>	
					</thead>
					<tbody>
                    <?php $sum=0;$sum_price=0; foreach ($carts as $cart):?>
						<tr >

							<td class="col1"><a href="<?=\yii\helpers\Url::to(['/goods/detail','id'=>$cart->goods_id])?>"><img src="<?=\backend\models\Goods::findOne($cart->goods_id)->logo?>" alt="" /></a>  <strong><a href=""><?=\backend\models\Goods::findOne($cart->goods_id)->name?></a></strong></td>
							<td class="col3">￥<?=\backend\models\Goods::findOne($cart->goods_id)->shop_price?></td>
							<td class="col4"> <?=$cart->amount?></td>
                            <input type="hidden" name="amount[]" value="<?=$cart->amount?>">
							<td class="col5"><span>￥<?php echo $one_price=\backend\models\Goods::findOne($cart->goods_id)->shop_price*$cart->amount;?></span>
                            <input type="hidden" name="goods_id[]" value="<?=$cart->goods_id?>">
                            </td>
						</tr>
                    <?php $sum +=$cart->amount;$sum_price +=$one_price; endforeach;?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="5">
								<ul>
									<li>
										<span id="sum_goods"><?=$sum?> 件商品，总商品金额：</span>

                                        <span>￥</span><span id="sum_price"><?=$sum_price?></span>
									</li>

									<li>
										<span>运费：</span>
                                        <span>￥</span><span id="sum_send"></span>
									</li>
									<li>
										<span>应付总额：</span>
                                        <span>￥</span><span id="sum_pay">5076.00</span>
									</li>
								</ul>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<!-- 商品清单 end -->
		
		</div>

		<div class="fillin_ft">
            <input type="hidden" value="" name="price" id="post_price">
			<a id="submit" href="javascript:void(0)"><span >提交订单</span></a>
			<p>应付总额：￥<strong id="sum_money">5076.00元</strong></p>

		</div>
	</div>
</form>
    <!-- 主体部分 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt15">
		<p class="links">
			<a href="">关于我们</a> |
			<a href="">联系我们</a> |
			<a href="">人才招聘</a> |
			<a href="">商家入驻</a> |
			<a href="">千寻网</a> |
			<a href="">奢侈品网</a> |
			<a href="">广告服务</a> |
			<a href="">移动终端</a> |
			<a href="">友情链接</a> |
			<a href="">销售联盟</a> |
			<a href="">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href=""><img src="/static/images/xin.png" alt="" /></a>
			<a href=""><img src="/static/images/kexin.jpg" alt="" /></a>
			<a href=""><img src="/static/images/police.jpg" alt="" /></a>
			<a href=""><img src="/static/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->

<script>
    //找到运费的值
    console.dir($(":checked :eq(1)").next().next().text());
    $('#sum_send').text($(":checked :eq(1)").next().next().text());
    $('.sendPrice').click(function () {
        console.dir($(this).next().next().text());
        $('#sum_send').text($(this).next().next().text());
        $('#sum_pay').text($('#sum_send').text()*1+$('#sum_price').text()*1);
        $('#sum_money').text($('#sum_pay').text());
        $('#post_price').val($('#sum_pay').text());
    });
    //获得所有总的价格
    $('#sum_pay').text($('#sum_send').text()*1+$('#sum_price').text()*1);
    $('#sum_money').text($('#sum_pay').text());
    $('#post_price').val($('#sum_pay').text());
    //提交表单数据
   /* $('#submit').click(function () {
        $.post('add',$('#form_order').serialize(),function (data) {

        });
    });*/

    $('#submit').click(function () {
        $('#form_order').submit();
    });
</script>
</body>
</html>