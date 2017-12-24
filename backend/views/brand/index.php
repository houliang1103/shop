<?php
/* @var $this yii\web\View */
?>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加品牌</a>
<a href="<?=yii\helpers\Url::to(['index'])?>" class="btn btn-success">全部</a>
<a href="<?=yii\helpers\Url::to(['index','status'=>1])?>" class="btn btn-success">上线</a>
<a href="<?=yii\helpers\Url::to(['index','status'=>0])?>" class="btn btn-success">下线</a>
<table class="table">
    <tr>
        <th>商标</th>
        <th>ID</th>
        <th>品牌</th>
        <th>排序</th>
        <th>状态</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($brands as $brand):
        $status1 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$brand->id]).">上线</a>";
        $status2 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$brand->id]).">下线</a>";
        ?>
        <tr>
            <td><?=\yii\bootstrap\Html::img("/".$brand->logo,["height"=>50])?></td>
            <td><?=$brand->id?></td>
            <td><?=$brand->name?></td>
            <td><?=$brand->sort?></td>
            <td><?php if($brand->status==1){echo $status1;}else{echo $status2;}?></td>
            <td><?=$brand->intro?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$brand->id])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$brand->id])?>" class="btn btn-danger" onclick="return confirm('确定删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=yii\widgets\LinkPager::widget(['pagination' => $pagination])?>
