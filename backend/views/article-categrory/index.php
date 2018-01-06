<?php
/* @var $this yii\web\View */
?>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加分类</a>

<div class="table-responsive">
<table class="table">
    <tr>
        <th>ID</th>
        <th>名称</th>
        <th style="text-align: center">是否帮助类</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($cates as $cate):
        $status1 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$cate->id]).">上线</a>";
        $status2 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$cate->id]).">下线</a>";
        ?>
        <tr><td><?=$cate->id?></td>
            <td><?=$cate->name?></td>
            <td style="text-align: center"><?php if($cate->is_help==1){echo '<i class="glyphicon glyphicon-remove text-danger btn-lg"></i>';}else{
                echo '<i class="glyphicon glyphicon-ok text-success btn-lg"></i>';
                }?></td>
            <td><?=$cate->sort?></td>
            <td><?php if($cate->status==1){echo $status1;}else{echo $status2;}?></td>
            <td><?=$cate->intro?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$cate->id])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$cate->id])?>" class="btn btn-danger" onclick="return confirm('确定删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>
