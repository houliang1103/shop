<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goods */
/* @var $form ActiveForm */
?>
<div class="goods-add">

    <?php $form = ActiveForm::begin(); ?>
        <div class="col-md-6">
        <?= $form->field($goods, 'name') ?>
        <?= $form->field($goods, 'sn')->textInput(['placeholder'=>'不填写会自动生成货号']) ?>
        <?= $form->field($goods, 'market_price') ?>
        <?= $form->field($goods, 'shop_price') ?>

        <?= $form->field($goods, 'brand_id')->dropDownList($brands,['prompt'=>'请选择一个品牌']) ?>
         <?= $form->field($goods, 'goods_category_id')->dropDownList($cates,['prompt'=>'请选择一个分类'])//商品所属分类 ?>
        <?= $form->field($goods, 'stock') ?>
        <?= $form->field($goods, 'status')->radioList([1=>'上架',0=>'下架'],['value'=>1])?>
        <?= $form->field($goods, 'sort')->textInput(['value'=>100]) ?>

        </div>
    <div class="col-md-6">

        <?= $form->field($goods, 'logo')->widget('manks\FileInput', [
        ]);//logo上传?>

        <?= $form->field($goods, 'imgsFile')->widget('manks\FileInput', [
            'model' => $goods,
            'attribute' => 'file',
            'clientOptions' => [
                'pick' => [
                    'multiple' => true,
                ],
            ]
        ]);//多图片上传
        ?>


        <?= $form->field($intro, 'content')->widget(\kucha\ueditor\UEditor::className());//富文本编辑器?>


        <div class="form-group">
            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
        </div>
            </div>
    <?php ActiveForm::end();
    ?>

</div><!-- goods-add -->
