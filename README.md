# 项目-商城开发
### 项目介绍
1. 项目简介  
类似京东商城的B2C商城 (C2C B2B O2O P2P ERP进销存CRM客户关系管理)，电商或电商类型的服务在目前来看依旧是非常常用，虽然纯电商的创业已经不太容易，但是各个公司都有变现的需要，所以在自身应用中嵌入电商功能是非常普遍的做法。我们使用git管理代码，协同开发。

2. 主要功能模块  
系统包括：
* 后台：品牌管理、商品分类管理、商品管理、订单管理、系统管理和会员管理六个功能模块。
* 前台：首页、商品展示、商品购买、订单管理、在线支付等。
3. 开发环境和技术  
   开发环境:	Window  
   开发工具: Phpstorm+PHP7.0+GIT+Apache  
   相关技术: Yii2.0+CDN+jQuery+sphinx
4. 项目人员组成周期成本

4.1. 人员组成

职位 |	人数 | 备注
---|---|---
项目经理和组长 |	1 |	一般小公司由项目经理负责管理，中大型公司项目由项目经理或组长负责管理
开发人员 | 3 |	
UI设计人员 |	0 |	
前端开发人员 |	1 |	专业前端不是必须的，所以前端开发和UI设计人员可以同一个人
测试人员 |	1 |	有些公司并未有专门的测试人员，测试人员可能由开发人员完成测试。  
>公司有测试部，测试部负责所有项目的测试。  
项目测试由产品经理进行业务测试。  
项目中如果有测试，一般都具有Bug管理工具(现都被集成在项目管理工具中)。

4.2. 项目周期成本

人数 |	周期 |	备注
---|---|---
1 |	两周需求及设计 |	项目经理
1 |	两周 |	UI设计 |	UI/UE
4（1测试 2后端 1前端 |	3个月(第1周需求设计,9周时间完成编码, 2周时间进行测试和修复) | 开发人员、测试人员 
 
5. 系统功能模块

5.1. 需求

- [x]  品牌管理：
- [x]  文章管理：
- [x]  商品分类管理：
- [x]  商品管理：
- [x]  账号管理：
- [x]  权限管理：
- [x]  菜单管理：
- [x]  订单管理：
>
5.2. 流程

* 自动登录流程
* 购物车流程
* 订单流程

5.3. 设计要点（数据库和页面交互)  
系统前后台设计：前台www.yiishop.com 后台admin.yiishop.com 对url地址美化   
商品无限级分类设计：  
购物车设计  
### 功能开发
---
1. 品牌功能  

1.1. 需求 
>
品牌管理功能涉及品牌的列表展示、品牌添加、修改、删除功能。  
品牌需要保存缩略图和简介。  
品牌删除使用逻辑删除。        
1.2.  流程  
>
实现品牌的增删改查功能  
完善功能，提升体验  
1.3. 要点难点及解决方案  
>
删除使用逻辑删除,只改变status属性,不删除记录  
使用webupload插件,提升用户体验  
使用composer下载和安装webupload  
composer安装插件报错,解决办法: composer require bailangzhan/yii2-webuploader    
注册七牛云账号 安装yii2 七牛云插件 composer require flyok666/yii2-qiniu   
将品牌logo上传到七牛云  
---
2. 文章功能

2.1. 需求 
>
文章的增删改查  
文章分类的增删改查  
  
2.2.设计要点  
>
文章内容与文章使用垂直分表 建立1对1关系

2.3.要点难点及解决方案
>
文章分类不能重复,通过添加验证规则unique解决
文章垂直分表,创建表单使用文章模型和文章详情模型
文章内容添加使用富文本框 下载富文本插件composer require kucha/ueditor "*"
---
3. 商品分类功能  
3.1需要  
商品分类的增删除改查
无限级分类
列表展示页需要折叠  
3.2设计要点  
利用ztree展示分类 利用nested实现左值右值  
3.3.要点难点及解决方案  
ztree插件 composer require liyuze/yii2-ztree 进入页面就要展开 点击分类后Js控制value；
nested： composer require creocoder/yii2-nested-sets 不能用detelte去删除root节点,要用内置的deleteWithChildren()去删除
健壮性的的时候不能放到自己的子孙节点,这个需要异常捕获
JS字符串比较 lft>clft 改成lft-clft>0

# yii-admin
1. 下载RBAC包
> php composer.phar require mdmsoft/yii2-admin "~2.0"
2. 在mian.php中配置
```php
return [
    'modules' => [
        'aaaa' => [//记得aaaa不能重名,可随意更改
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',//top  botton right 菜单位置
            ...
        ]
        ...
    ],
    ...
    'components' => [
        ...
        'authManager' => [
            'class' => 'yii\rbac\PhpManager', // or use 'yii\rbac\DbManager'
        ]
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];

```
3. 菜单数据迁移
> yii migrate --migrationPath=@mdm/admin/migrations
4. rbac  建表
> yii migrate --migrationPath=@yii/rbac/migrations

5.  多国语言包  配置在conponents 中
```php

//多国语言包，设置admin-rbac 菜单
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
        ],

```


# 前台
1. 购物车模块
---
1.1  需求
>//  存cookie 1.1得到设置cookie的对象
            $setCookie = \Yii::$app->response->cookies;
            //1.2 保存cookie
            $cookie = new Cookie([
                'name'=>'cart',
                'value'=>$cookieOld,
                'expire'=>time()+3600*24*30
            ]);

            $setCookie->add($cookie);
模拟京东，未登录也可以加入购物车，将数据存储在COOkie中
>
登录后将COOkie数据同步到数据库，并删除COOkie数据
>
1.2 难点
>
需要将cookie存储数据做封装，除去重复代码


2. 订单模块
---
2.1 需求
>
提交订单时，删除购物车对应数据，判断库存是否足够，订单生成后生成微信二维码进行支付
>
2.2 难点
>
由于需要对三个数据表操作，为了保证一致，需要用到事务，微信支付返回为POST传值，需要关闭csrf恶意提交数据；定时清理为处理的订单。


### 其他
1. 抽奖 
> 
redis-set
2. 秒杀 
> 
防止库存为负：a-文件锁，b-redis（list队列存储数据）
3. 缓存
>
session入redis
ob缓存
