<div class="topnav">
    <div class="topnav_bd w1210 bc">
        <div class="topnav_left">

        </div>
        <div class="topnav_right fr">
            <ul>
                <li >您好，欢迎来到悟空商城！
                    <?=Yii::$app->user->isGuest?'[<a href="/user/login">登录</a>] [<a href="/user/regist">免费注册</a>]':Yii::$app->user->identity->username.'【<a href="/user/logout">退出</a>】'?>

                </li>
                <li class="line">|</li>
                <li>我的订单</li>
                <li class="line">|</li>
                <li>客户服务</li>

            </ul>
        </div>
    </div>
</div>