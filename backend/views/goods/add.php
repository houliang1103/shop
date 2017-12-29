<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($goods, 'name') ?>
        <?= $form->field($goods, 'sn')->textInput(['placeholder'=>'不填写会自动生成货号']) ?>
        <?= $form->field($goods, 'market_price') ?>
        <?= $form->field($goods, 'shop_price') ?>

        <?= $form->field($goods, 'brand_id')->dropDownList($brands) ?>
        <?= $form->field($goods, 'stock') ?>
        <?= $form->field($goods, 'status')->radioList([1=>'上架',0=>'下架'],['value'=>1])?>
        <?= $form->field($goods, 'sort')->textInput(['value'=>100]) ?>
        <?= $form->field($goods, 'goods_category_id') ?>
        <?php
        //商品所属分类
        echo \liyuze\ztree\ZTree::widget([
            'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
			},
			callback: {
				onClick: function(e,treeId, treeNode){
				$("#goods-goods_category_id").val(treeNode.id);
				}
			}			
		}',
            'nodes' => $cates
        ]);

        //logo上传
        echo $form->field($goods, 'logo')->widget('manks\FileInput', [
        ]);
        //多图片上传
        echo $form->field($images, 'path')->widget('manks\FileInput', [
        ]);
        //富文本编辑器
        echo $form->field($intro, 'content')->widget('kucha\ueditor\UEditor',[]);
?>

        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end();
    $js = <<<aaa
var treeObj = $.fn.zTree.getZTreeObj("w1");
 treeObj.expandAll(true);
var node = treeObj.getNodeByParam("id","{$goods->goods_category_id}", null);
treeObj.selectNode(node);
aaa;
    $this->registerJs($js);
    ?>

</div><!-- goods-add -->
