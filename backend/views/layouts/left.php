<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">

                <p><?php
                    if (Yii::$app->user->isGuest){
                        echo "<a href=".yii\helpers\Url::to('login').">请登录</a>";
                    }else{

                        echo "欢迎：".Yii::$app->user->identity->username;
                    }
                    ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
       <!-- <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>-->
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'admin', 'options' => ['class' => 'header']],
                    ['label' => '管理员', 'icon' => 'file-code-o', 'url' => ['admin/index']],
                    //['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
//                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'RBAC',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '权限列表', 'icon' => 'file-code-o', 'url' => ['auth-item/index'],],
                            ['label' => '添加权限', 'icon' => 'dashboard', 'url' => ['auth-item/add'],],
                            ['label' => '角色列表', 'icon' => 'dashboard', 'url' => ['role/index'],],
                            ['label' => '添加角色', 'icon' => 'dashboard', 'url' => ['role/add'],],
                            /*[
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],*/
                        ],
                    ],

                    [
                        'label' => '品牌管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '品牌展示', 'icon' => 'file-code-o', 'url' => ['brand/index'],],
                            ['label' => '添加品牌', 'icon' => 'dashboard', 'url' => ['brand/add'],],
                            /*[
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],*/
                        ],
                    ],

                    [
                        'label' => '商品管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '商品展示', 'icon' => 'file-code-o', 'url' => ['goods/index'],],
                            ['label' => '添加商品', 'icon' => 'dashboard', 'url' => ['goods/add'],],
                        ],
                    ],
                    [
                        'label' => '商品分类',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '分类展示', 'icon' => 'file-code-o', 'url' => ['category/index'],],
                            ['label' => '添加分类', 'icon' => 'dashboard', 'url' => ['category/add'],],
                        ],
                    ],
                    [
                        'label' => '文章管理',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章展示', 'icon' => 'file-code-o', 'url' => ['article/index'],],
                            ['label' => '添加文章', 'icon' => 'dashboard', 'url' => ['article/add'],],
                        ],
                    ],
                    [
                        'label' => '文章分类',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => '文章分类展示', 'icon' => 'file-code-o', 'url' => ['article-categrory/index'],],
                            ['label' => '添加文章分类', 'icon' => 'dashboard', 'url' => ['article-categrory/add'],],
                        ],
                    ],

                ],
            ]
        ) ?>

    </section>

</aside>
