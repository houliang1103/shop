/*
@功能：购物车页面js
@作者：diamondwang
@时间：2013年11月14日
*/
$(function(){


        //总计金额
        var total = 0;
        $(".col5 span").each(function(){
            total += parseFloat($(this).text());
        });

        $("#total").text(total.toFixed(2));


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


	//收货人修改
	$("#address_modify").click(function(){
		$(this).hide();
		$(".address_info").hide();
		$(".address_select").show();
	});

	$(".new_address").click(function(){
		$("form[name=address_form]").show();
		$(this).parent().addClass("cur").siblings().removeClass("cur");

	}).parent().siblings().find("input").click(function(){
		$("form[name=address_form]").hide();
		$(this).parent().addClass("cur").siblings().removeClass("cur");
	});

	//送货方式修改
	$("#delivery_modify").click(function(){
		$(this).hide();
		$(".delivery_info").hide();
		$(".delivery_select").show();
	})

	$("input[name=delivery]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//支付方式修改
	$("#pay_modify").click(function(){
		$(this).hide();
		$(".pay_info").hide();
		$(".pay_select").show();
	})

	$("input[name=pay]").click(function(){
		$(this).parent().parent().addClass("cur").siblings().removeClass("cur");
	});

	//发票信息修改
	$("#receipt_modify").click(function(){
		$(this).hide();
		$(".receipt_info").hide();
		$(".receipt_select").show();
	})

	$(".company").click(function(){
		$(".company_input").removeAttr("disabled");
	});

	$(".personal").click(function(){
		$(".company_input").attr("disabled","disabled");
	});

});