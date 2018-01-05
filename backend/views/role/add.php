<h2> 添加角色 </h2>
<a href="<?=yii\helpers\Url::to(['index'])?>" class="btn btn-success"><<返回角色列表</a>
<?php

$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'description')->textarea();
echo $form->field($model,'premission')->inline()->checkboxList($premissions);
echo \yii\bootstrap\Html::submitButton('提交' ,['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
