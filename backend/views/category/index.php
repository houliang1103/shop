<?php
/* @var $this yii\web\View */
?>
<a href="<?=yii\helpers\Url::to(['add'])?>" class="btn btn-success">添加分类</a>
<div class="table-responsive">
<table class="table">
    <tr>
        <th style="text-align: center">折叠|展开</th>
        <th>序号</th>
        <th>名称</th>
        <th>父类ID</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php

    foreach ($cates as $cate):


        ?>
        <tr class="tree_tr" data-tree="<?=$cate->tree?>" data-lft="<?=$cate->lft?>" data-rgt="<?=$cate->rgt?>">

            <td style="text-align: center"><span class="glyphicon glyphicon-minus btn-info" title="点击展开|折叠子类"></span></td>
            <td><?=$cate->id?></td>
            <td><?=$cate->nameText?></td>
            <td><?=$cate->parent_id?></td>
            <td><?=$cate->intro?></td>
            <td><a href="<?=yii\helpers\Url::to(['edit','id'=>$cate->id])?>" class="btn btn-info">修改</a>
                <a href="<?=yii\helpers\Url::to(['del','id'=>$cate->id])?>" class="btn btn-danger" onclick="return confirm('会连同该目录下的子分类一起删除，确认删除？')">删除</a>
            </td>
        </tr>

    <?php endforeach;?>
</table>
</div>
<?php
$js = <<<aaa
 $('.tree_tr').click(function () {
        var tr = $(this);
        var tree_parent = tr.attr('data-tree');
        var lft_parent = tr.attr('data-lft');
        var rgt_parent = tr.attr('data-rgt');
        //改变图标
        tr.find('span').toggleClass('glyphicon glyphicon-minus');
        tr.find('span').toggleClass('glyphicon glyphicon-plus');
        $('.tree_tr').each(function (i,v) {
            var tree = $(v).attr('data-tree');
            var lft = $(v).attr('data-lft');
            var rgt = $(v).attr('data-rgt');
            if (tree==tree_parent && lft-lft_parent>0 && rgt-rgt_parent<0){
                //判断父类是否是展开状态
                if (tr.find('span').hasClass('glyphicon glyphicon-plus')){
                    //改变图标
                    $(v).find('span').removeClass('glyphicon glyphicon-minus');
                    $(v).find('span').addClass('glyphicon glyphicon-plus');
                    $(v).hide();
                }else {
                    //改变图标
                    $(v).find('span').removeClass('glyphicon glyphicon-plus');
                    $(v).find('span').addClass('glyphicon glyphicon-minus');
                    $(v).show();
                }
            }
        });
    });
aaa;
    $this->registerJs($js);
?>
