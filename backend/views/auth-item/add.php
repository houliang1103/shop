<a href="<?=yii\helpers\Url::to(['index'])?>" class="btn btn-success"><<返回权限列表</a>
<?php

$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo \yii\bootstrap\Html::submitButton('提交' ,['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
