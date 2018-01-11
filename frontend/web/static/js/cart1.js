/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/

$(function(){
	function update(id,amount){
		$.get('update',{'id':id,'amount':amount},function (data) {
			console.dir(data);
        })
	}
	//减少
	$(".reduce_num").click(function(){
		var amount = $(this).parent().find(".amount");
		if (parseInt($(amount).val()) <= 1){
			alert("商品数量最少为1");
		} else{
			$(amount).val(parseInt($(amount).val()) - 1);
		}
		//获得数量及商品ID
		var num = $(this).next('.amount').val();
		var id = $(this).parent().parent().attr('id');
		console.log(num,id);
		update(id,num);
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//增加
	$(".add_num").click(function(){
		var amount = $(this).parent().find(".amount");
		$(amount).val(parseInt($(amount).val()) + 1);
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(amount).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
        //获得数量及商品ID
        var num = $(this).prev('.amount').val();
        var id = $(this).parent().parent().attr('id');
        console.log(num,id);
        update(id,num);

		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));
	});

	//直接输入
	$(".amount").blur(function(){
		if (parseInt($(this).val()) < 1){
			alert("商品数量最少为1");
			$(this).val(1);
		}
        //获得数量及商品ID
        var num = $(this).val();
        var id = $(this).parent().parent().attr('id');
        console.log(num,id);
		update(id,num);
		//小计
		var subtotal = parseFloat($(this).parent().parent().find(".col3 span").text()) * parseInt($(this).val());
		$(this).parent().parent().find(".col5 span").text(subtotal.toFixed(2));
		//总计金额
		var total = 0;
		$(".col5 span").each(function(){
			total += parseFloat($(this).text());
		});

		$("#total").text(total.toFixed(2));

	});
});