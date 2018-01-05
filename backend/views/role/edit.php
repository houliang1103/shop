<h2> 修改角色 </h2>
<?php
$form = yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name')->textInput(['disabled'=>'disabled']);
echo $form->field($model,'description')->textarea();
echo $form->field($model,'premission')->inline()->checkboxList($premissions);
echo \yii\bootstrap\Html::submitButton('提交' ,['class'=>'btn btn-info']);
yii\bootstrap\ActiveForm::end();
