<?php
/* @var $this yii\web\View */
/* @var $model backend\models\Admin */
?>
<h1>管理员列表</h1>

<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加管理员</a>
<div class="table-responsive">
<table class="table">
    <tr>
        <th>序号</th>
        <th>名称</th>
        <th>邮箱</th>
        <th>创建时间</th>
        <th>最后登录IP</th>
        <th>最后登录时间</th>
        <th>操作</th>
    </tr>
    <?php
    foreach ($models as $model):
        ?>
        <tr>
            <td><?=$model->id?></td>
            <td><?=$model->username?></td>
            <td><?=$model->email?></td>
            <td><?=date('Y-m-d H:i:s',$model->created_at)?></td>
            <td><?=long2ip($model->last_ip)?></td>
            <td><?=date('Y-m-d H:i:s',$model->last_login_at)?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$model->id])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$model->id])?>" class="btn btn-danger" onclick="return confirm('确认删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
    </div>


