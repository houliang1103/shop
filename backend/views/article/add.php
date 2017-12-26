<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
/* @var $form ActiveForm */
?>
<div class="article-add">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'cate_id')->dropDownList($catesArr)?>
    <?= $form->field($model, 'status')->radioList(['1'=>'显示','0'=>'隐藏'],['value'=>1]) ?>
    <?= $form->field($model, 'sort')->textInput(['value'=>100]) ?>
    <?= $form->field($model, 'intro')->textarea() ?>
    <?= $form->field($detail, 'content')->widget('kucha\ueditor\UEditor',[])?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- article-add -->
