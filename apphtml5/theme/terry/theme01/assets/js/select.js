layui.use('form', function() {
	var form = layui.form;
	var layer=layui.layer;
	
	//text
	var province = $("#billing_country"),
		city = $("#billing_state"),
		district = $("#billing_city");
	//id
	var province_val=$("#billing_country").data('country')?$("#billing_country").data('country'):1;
		city_val=$("#billing_state").data('state')?$("#billing_state").data('state'):1;
		district_val=$("#billing_city").data('city')?$("#billing_city").data('city'):1;
		
	var provinceText,
		cityText,
		districtText,
		provinceItem=province_val-1,
		cityItem=city_val-1,
		districtItem=district_val-1;
	
	//初始将省份数据赋予
	for (var i in provinceList) {
		if(getCookie('lang_code')){
			var code=getCookie('lang_code');
			if(provinceList[i]['name_'+code]){
				var name=provinceList[i]['name_'+code];
			}else{
				var name=provinceList[i]['name'];
			}
		}else{
			var name=provinceList[i]['name'];
		}
		addEle(province, name,provinceList[i]['id'],provinceList[i]['translate'],province_val);
	}
	$.each(provinceList[provinceItem].cityList, function(i, item) {
		
		if(getCookie('lang_code')){
			var code=getCookie('lang_code');
			
			if(item['name_'+code]){
				var name=item['name_'+code];
			}else{
				var name=item['name'];
			}
		}else{
			var name=item['name'];
		}
		addEle(city, name,item.id,item.translate,city_val);
	})
	$.each(provinceList[provinceItem]['cityList'][cityItem].areaList, function(i, item) {
		if(getCookie('lang_code')){
			var code=getCookie('lang_code');
			if(item['name_'+code]){
				var name=item['name_'+code];
			}else{
				var name=item['name'];
			}
		}else{
			var name=item['name'];
		}
		addEle(district, name,item.id,item.translate,district_val);
		if(district_val==item.id){
			//弹框提示可以送货时间
			weekdays=checkweekday(item.weekday)['weekdays'];
			//layer.alert("Delivery time："+weekdays.join(','));
			$('#shippingDateDesc').text(weekdays.join(','));
			$('#weekday').val(item.weekday);
		}
	})
	//赋予完成 重新渲染select
	form.render('select');
	
	//向select中 追加内容
	function addEle(ele, value,id,translate,checkvalue='') {
		var optionStr = "";
		if(checkvalue==id){
			optionStr = "<option checked value=" + id + " >" + value + "</option>";
		}else{
			optionStr = "<option value=" + id + " >" + value + "</option>";
		}
		
		ele.append(optionStr);
	}

	//移除select中所有项 赋予初始值
	function removeEle(ele) {
		
		ele.find("option").remove();
		var optionStar = "";
		ele.append(optionStar);
	}

	
	
	//选定省份后 将该省份的数据读取追加上
	form.on('select(province)', function(data) {
		
		//id
		provinceText = data.value;
		
		$.each(provinceList, function(i, item) {
			if (provinceText == item.id) {
				provinceItem = item.id -1 ;
				return provinceItem;
			}
		});
		removeEle(city);
		removeEle(district);
		
		$.each(provinceList[provinceItem].cityList, function(i, item) {
			//console.log(item.name,item.id,item.translate);
			if(getCookie('lang_code')){
				var code=getCookie('lang_code');
				if(item['name_'+code]){
					var name=item['name_'+code];
				}else{
					var name=item['name'];
				}
			}else{
				var name=item['name'];
			}
			addEle(city, name,item.id,item.translate,1);
		})
		$.each(provinceList[provinceItem]['cityList'][0]['areaList'], function(i, item) {
			if(getCookie('lang_code')){
				var code=getCookie('lang_code');
				if(item['name_'+code]){
					var name=item['name_'+code];
				}else{
					var name=item['name'];
				}
			}else{
				var name=item['name'];
			}
			addEle(district, name,item.id,item.translate,1);
			if(1==item.id){
				//弹框提示可以送货时间
				weekdays=checkweekday(item.weekday)['weekdays'];
				//layer.alert("Delivery time："+weekdays.join(','));
				$('#shippingDateDesc').text(weekdays.join(','));
				$('#weekday').val(item.weekday);
			}
		})
		//重新渲染select 
		form.render('select');
	})

	////选定市或直辖县后 将对应的数据读取追加上
	form.on('select(city)', function(data) {
		
		cityText = data.value;
		
		$.each(provinceList[provinceItem]['cityList'], function(i, item) {
			if (cityText == item.id) {
				cityItem = item.id -1;
				return cityItem;
			}
		});
		removeEle(district);
		$.each(provinceList[provinceItem]['cityList'][cityItem]['areaList'], function(i, item) {
			if(getCookie('lang_code')){
				var code=getCookie('lang_code');
				if(item['name_'+code]){
					var name=item['name_'+code];
				}else{
					var name=item['name'];
				}
			}else{
				var name=item['name'];
			}
			addEle(district, name,item.id,item.translate,1);
			if(1==item.id){
				//弹框提示可以送货时间
				weekdays=checkweekday(item.weekday)['weekdays'];
				//layer.alert("Delivery time："+weekdays.join(','));
				$('#shippingDateDesc').text(weekdays.join(','));
				$('#weekday').val(item.weekday);
			}
		})
		
		//重新渲染select 
		form.render('select');
	})
	
	////选定市或直辖县后 将对应的数据读取追加上
	form.on('select(district)', function(data) {
		
		districtText = data.value;
		
		$.each(provinceList[provinceItem].cityList[cityItem], function(i, item) {
		
			if (districtText == item.id) {
				districtItem = item.id - 1;
				return districtItem;
			}
		});
		//console.log(provinceList[provinceItem]['cityList'][cityItem].areaList);
		$.each(provinceList[provinceItem]['cityList'][cityItem]['areaList'], function(i, item) {
			
			if (districtText == item.id) {
				
				//弹框提示可以送货时间
				weekdays=checkweekday(item.weekday)['weekdays'];
				//layer.alert("Delivery time："+weekdays.join(','));
				$('#shippingDateDesc').text(weekdays.join(','));
				$('#weekday').val(item.weekday);
				return cityItem;
			}
		})
		//重新渲染select 
		form.render('select');
	})



})
	function checkweekday(val){
		var high= val >> 8;
		var low= val & 0xff;
		var weekdays=[];
		var weeks=[];
		for(var i=7,j=1;i>0;--i,++j){
			
			if((low & 1)){
				weekdays.push(j);
			}
			low=low>>1;
			if((high & 1)){
				weeks.push(j);
			}
			high=high>>1;
		}
		return {"weekdays":weekdays,"weeks":weeks};
	}
