<?php
/* @var $this yii\web\View */
?>
<h1>角色列表</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加角色</a>

<table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>权限</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($models as $model):
        ?>
        <tr>
            <td><?=$model->name?></td>
            <td><?=$model->description?></td>
            <td><?php
                //实例组件获得角色对应的所有权限
                $auth =Yii::$app->authManager;
                $string='';
                foreach ($auth->getPermissionsByRole($model->name) as $permission){
                    $string .= $permission->description." || ";
                }
                echo substr($string,0,-3) ;
                ?>
            </td>
            <td><a href="<?=yii\helpers\Url::to(['edit','name'=>$model->name])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','name'=>$model->name])?>" class="btn btn-danger" onclick="return confirm('确认删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>


