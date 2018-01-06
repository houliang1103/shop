<?php
/* @var $this yii\web\View */
?>
<h1>权限列表</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>

<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加权限</a>

<div class="table-responsive">
<table class="table">
    <tr>
        <th>名称</th>
        <th>描述</th>
        <th>操作</th>
    </tr>
    <?php

    foreach ($models as $model):


        ?>
        <tr>
            <td><?=(strpos($model->name,'/')?'----':'').$model->name?></td>
            <td><?=$model->description?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','name'=>$model->name])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','name'=>$model->name])?>" class="btn btn-danger" onclick="return confirm('确认删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>

