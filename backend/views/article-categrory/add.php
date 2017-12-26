<?php
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($cate,"name");
echo $form ->field($cate,"sort")->textInput(['value'=>100]);
echo $form ->field($cate,"status")->inline()->radioList(["1"=>"显示","0"=>"隐藏"],['value'=>1]);
echo $form ->field($cate,"is_help")->inline()->radioList(["0"=>"是","1"=>"非"],['value'=>0]);
echo $form ->field($cate,"intro")->textarea();
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-success"]);
\yii\bootstrap\ActiveForm::end();