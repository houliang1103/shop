<?php
/* @var $this yii\web\View */
?>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加文章</a>
<!--<a href="<?/*=yii\helpers\Url::to(['index'])*/?>" class="btn btn-success">全部</a>
<a href="<?/*=yii\helpers\Url::to(['index','status'=>1])*/?>" class="btn btn-success">上线</a>
<a href="<?/*=yii\helpers\Url::to(['index','status'=>0])*/?>" class="btn btn-success">下线</a>-->
<div class="table-responsive">
<table class="table">
    <tr>
        <th>ID</th>
        <th>标题</th>
        <th>分类</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($models as $model):
        $status1 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$model->id]).">上线</a>";
        $status2 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$model->id]).">下线</a>";
        ?>
        <tr><td><?=$model->id?></td>
            <td><?=$model->title?></td>
            <td><?=$model->cateName->name?></td>
            <td><?=$model->sort?></td>
            <td><?php if($model->status==1){echo $status1;}else{echo $status2;}?></td>
            <td><?=$model->intro?></td>
            <td><?=date('Y-m-d H:i:s',$model->create_time)?></td>
            <td>
            <a href="<?=yii\helpers\Url::to(['edit','id'=>$model->id])?>" class="btn btn-success">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$model->id])?>" class="btn btn-danger" onclick="return confirm('确定删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>
<?=yii\widgets\LinkPager::widget(['pagination' => $pagination])?>
