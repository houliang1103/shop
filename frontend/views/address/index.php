
<?php
/* @var $addr frontend\models\Address */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>收货地址</title>
	<link rel="stylesheet" href="/static/style/base.css" type="text/css">
	<link rel="stylesheet" href="/static/style/global.css" type="text/css">
	<link rel="stylesheet" href="/static/style/header.css" type="text/css">
	<link rel="stylesheet" href="/static/style/home.css" type="text/css">
	<link rel="stylesheet" href="/static/style/address.css" type="text/css">
	<link rel="stylesheet" href="/static/style/bottomnav.css" type="text/css">
	<link rel="stylesheet" href="/static/style/footer.css" type="text/css">

	<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/static/js/header.js"></script>
	<script type="text/javascript" src="/static/js/home.js"></script>

</head>
<body>
<!-- 顶部导航 start -->
<?php
include_once Yii::getAlias('@app/views/common/nav.php');
?>
<!-- 顶部导航 end -->

<!-- 头部 start -->
<?php
include_once Yii::getAlias('@app/views/common/header.php');
?>
<!-- 头部 end -->
	
	<div style="clear:both;"></div>

	<!-- 页面主体 start -->
	<div class="main w1210 bc mt10">
		<div class="crumb w1210">
			<h2><strong>我的XX </strong><span>> 我的订单</span></h2>
		</div>
		
		<!-- 左侧导航菜单 start -->
		<div class="menu fl">
			<h3>我的XX</h3>
			<div class="menu_wrap">
				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="/static/">我的订单</a></dd>
					<dd><b>.</b><a href="/static/">我的关注</a></dd>
					<dd><b>.</b><a href="/static/">浏览历史</a></dd>
					<dd><b>.</b><a href="/static/">我的团购</a></dd>
				</dl>

				<dl>
					<dt>账户中心 <b></b></dt>
					<dd class="cur"><b>.</b><a href="/static/">账户信息</a></dd>
					<dd><b>.</b><a href="/static/">账户余额</a></dd>
					<dd><b>.</b><a href="/static/">消费记录</a></dd>
					<dd><b>.</b><a href="/static/">我的积分</a></dd>
					<dd><b>.</b><a href="/static/">收货地址</a></dd>
				</dl>

				<dl>
					<dt>订单中心 <b></b></dt>
					<dd><b>.</b><a href="/static/">返修/退换货</a></dd>
					<dd><b>.</b><a href="/static/">取消订单记录</a></dd>
					<dd><b>.</b><a href="/static/">我的投诉</a></dd>
				</dl>
			</div>
		</div>
		<!-- 左侧导航菜单 end -->

		<!-- 右侧内容区域 start -->
		<div class="content fl ml10">
			<div class="address_hd">
				<h3>收货地址薄</h3>
                <?php $sort=1; foreach ($address as $addr):?>
				<dl class=""> <!-- 最后一个dl 加类last -->
					<dt><?=$sort.' . '.$addr->name.' '.$addr->tel.' '.$addr->province.' '.$addr->city.' '.$addr->area.' '.$addr->address?> </dt>
					<dd>

						<a href="javascript:void(0)" class="status" id="<?=$addr->id?>"><?=$addr->status==2?'设为默认地址':''?></a><?=$addr->status==1?'默认地址':''?>
                        <a href="<?=\yii\helpers\Url::to(['del','id'=>$addr->id])?>">删除</a>
					</dd>
				</dl>
                <?php $sort++; endforeach;?>
			</div>

			<div class="address_bd mt10">
				<h4>新增收货地址</h4>
				<form action="<?=\yii\helpers\Url::to('add')?>" method="post" name="address_form">
                    <input type="hidden" name="Address[user_id]" value="<?=Yii::$app->user->id?>">
						<ul>
							<li>
								<label for=""><span>*</span>收 货 人：</label>
								<input type="text" name="Address[name]" class="txt" />
							</li>
							<li>
								<label for=""><span>*</span>所在地区：</label>

                                <select name="Address[province]"></select><select name="Address[city]"></select><select name="Address[area]"></select>
                                <script type="text/javascript" src="/js/PCASClass.js"></script>
                                <script type="text/javascript">
                                    new PCAS("Address[province]","Address[city]","Address[area]");
                                </script>
							</li>
							<li>
								<label for=""><span>*</span>详细地址：</label>
								<input type="text" name="Address[address]" class="txt address"  />
							</li>
							<li>
								<label for=""><span>*</span>手机号码：</label>
								<input type="text" name="Address[tel]" class="txt" />
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="checkbox" name="Address[status]" value="1" class="check" />设为默认地址
							</li>
							<li>
								<label for="">&nbsp;</label>
								<input type="submit" name="" class="btn" value="保存" />
							</li>
						</ul>
					</form>
			</div>	

		</div>
		<!-- 右侧内容区域 end -->
	</div>
	<!-- 页面主体 end-->

	<div style="clear:both;"></div>

	<!-- 底部导航 start -->
	<div class="bottomnav w1210 bc mt10">
		<div class="bnav1">
			<h3><b></b> <em>购物指南</em></h3>
			<ul>
				<li><a href="/static/">购物流程</a></li>
				<li><a href="/static/">会员介绍</a></li>
				<li><a href="/static/">团购/机票/充值/点卡</a></li>
				<li><a href="/static/">常见问题</a></li>
				<li><a href="/static/">大家电</a></li>
				<li><a href="/static/">联系客服</a></li>
			</ul>
		</div>
		
		<div class="bnav2">
			<h3><b></b> <em>配送方式</em></h3>
			<ul>
				<li><a href="/static/">上门自提</a></li>
				<li><a href="/static/">快速运输</a></li>
				<li><a href="/static/">特快专递（EMS）</a></li>
				<li><a href="/static/">如何送礼</a></li>
				<li><a href="/static/">海外购物</a></li>
			</ul>
		</div>

		
		<div class="bnav3">
			<h3><b></b> <em>支付方式</em></h3>
			<ul>
				<li><a href="/static/">货到付款</a></li>
				<li><a href="/static/">在线支付</a></li>
				<li><a href="/static/">分期付款</a></li>
				<li><a href="/static/">邮局汇款</a></li>
				<li><a href="/static/">公司转账</a></li>
			</ul>
		</div>

		<div class="bnav4">
			<h3><b></b> <em>售后服务</em></h3>
			<ul>
				<li><a href="/static/">退换货政策</a></li>
				<li><a href="/static/">退换货流程</a></li>
				<li><a href="/static/">价格保护</a></li>
				<li><a href="/static/">退款说明</a></li>
				<li><a href="/static/">返修/退换货</a></li>
				<li><a href="/static/">退款申请</a></li>
			</ul>
		</div>

		<div class="bnav5">
			<h3><b></b> <em>特色服务</em></h3>
			<ul>
				<li><a href="/static/">夺宝岛</a></li>
				<li><a href="/static/">DIY装机</a></li>
				<li><a href="/static/">延保服务</a></li>
				<li><a href="/static/">家电下乡</a></li>
				<li><a href="/static/">京东礼品卡</a></li>
				<li><a href="/static/">能效补贴</a></li>
			</ul>
		</div>
	</div>
	<!-- 底部导航 end -->

	<div style="clear:both;"></div>
	<!-- 底部版权 start -->
	<div class="footer w1210 bc mt10">
		<p class="links">
			<a href="/static/">关于我们</a> |
			<a href="/static/">联系我们</a> |
			<a href="/static/">人才招聘</a> |
			<a href="/static/">商家入驻</a> |
			<a href="/static/">千寻网</a> |
			<a href="/static/">奢侈品网</a> |
			<a href="/static/">广告服务</a> |
			<a href="/static/">移动终端</a> |
			<a href="/static/">友情链接</a> |
			<a href="/static/">销售联盟</a> |
			<a href="/static/">京西论坛</a>
		</p>
		<p class="copyright">
			 © 2005-2013 京东网上商城 版权所有，并保留所有权利。  ICP备案证书号:京ICP证070359号 
		</p>
		<p class="auth">
			<a href="/static/"><img src="/static/images/xin.png" alt="" /></a>
			<a href="/static/"><img src="/static/images/kexin.jpg" alt="" /></a>
			<a href="/static/"><img src="/static/images/police.jpg" alt="" /></a>
			<a href="/static/"><img src="/static/images/beian.gif" alt="" /></a>
		</p>
	</div>
	<!-- 底部版权 end -->
<script>
    $('.status').click(function () {
        console.dir($(this).attr('id'));
        $.get('status',{'id':$(this).attr('id')},function (data) {
            location.reload()
        })
    });
</script>
</body>
</html>

