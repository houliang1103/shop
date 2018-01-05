<?php
/* @var $this yii\web\View */
?>
<h1>商品列表</h1>
<div class="row">
    <div><a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加品牌</a></div>
    <div></div>
</div>


<table class="table">
    <tr>
        <th>序号</th>
        <th>名称</th>
        <th>货号</th>
        <th>价格</th>
        <th>商标</th>
        <th>状态</th>
        <th>分类</th>
        <th>品牌</th>
        <th>库存</th>
        <th>排序</th>
        <th>时间</th>
        <th>操作</th>
    </tr>
    <?php foreach ($goods as $good):
        $status1 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$good->id]).">上线</a>";
        $status2 = "<a title='点击改变状态' href=".yii\helpers\Url::to(['status','id'=>$good->id]).">下线</a>";

        ?>
        <tr>
            <td><?=$good->id?></td>
            <td><?=$good->name?></td>
            <td><?=$good->sn?></td>
            <td><?=$good->shop_price?></td>
            <td><?=\yii\bootstrap\Html::img($good->logo,["height"=>50])?></td>
            <td><?php  if($good->status==1){echo $status1;}else{echo $status2;}?></td>
            <td><?=$good->cateName->name?></td>
            <td><?=$good->brandName->name?></td>
            <td><?=$good->stock?></td>
            <td><?=$good->sort?></td>
            <td><?=date('Y-m-d H:i:s',$good->create_time)?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$good->id])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$good->id])?>" class="btn btn-danger" onclick="return confirm('确定删除？')">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?=yii\widgets\LinkPager::widget(['pagination' => $pages])?>


