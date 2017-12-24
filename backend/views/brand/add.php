<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($brand,"name");
echo $form ->field($brand,"sort");
echo $form ->field($brand,"status")->inline()->radioList(["1"=>"上线","2"=>"下线"],['value'=>1]);
echo $form ->field($brand,"intro")->textarea();
//echo $form ->field($brand,"imgFile")->fileInput();
echo $form->field($brand, 'logo')->widget('manks\FileInput', [
]);
//echo $form ->field($brand,'code')->widget(\yii\captcha\Captcha::className(),[
//    'captchaAction' => 'brands/captcha',
//    'template' => '<div class="row"><div class="col-lg-2">{input}</div><div class="col-lg-2">{image}</div></div>',
//]);
//echo $form ->field($brand,"class_id")->dropDownList(yii\helpers\ArrayHelper::map($class,"id","name"));
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-success"]);
\yii\bootstrap\ActiveForm::end();