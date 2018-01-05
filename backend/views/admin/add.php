<h2>添加管理员</h2>
<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($models ,'username');
echo $form->field($models ,'password')->passwordInput();
echo $form->field($models ,'email');
echo $form->field($models ,'roles')->inline()->checkboxList($roles);
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-info']);
\yii\bootstrap\ActiveForm::end();