<?php
/* @var $this yii\web\View */
echo '<a href="'.yii\helpers\Url::to(['index']).'" class="btn btn-info">返回列表</a>';
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($cates,"name");
echo $form->field($cates,"parent_id")->hiddenInput();
echo  \liyuze\ztree\ZTree::widget([
    'setting' => '{
			data: {
				simpleData: {
					enable: true,
					pIdKey: "parent_id",
				}
			},
			callback: {
				onClick: function(e,treeId, treeNode){
				$("#category-parent_id").val(treeNode.id);
				}
			}			
		}',
    'nodes' => $models
]);
//$cates->parent_id = isset($cates->parent_id)?$cates->parent_id:0;
echo $form ->field($cates,"intro")->textarea();
//echo $form ->field($brand,"imgFile")->fileInput();
echo \yii\bootstrap\Html::submitButton("提交",["class"=>"btn btn-success"]);
\yii\bootstrap\ActiveForm::end();
$js = <<<aaa
var treeObj = $.fn.zTree.getZTreeObj("w1");
 treeObj.expandAll(true);
var node = treeObj.getNodeByParam("id","{$cates->parent_id}", null);
treeObj.selectNode(node);
aaa;
$this->registerJs($js);


