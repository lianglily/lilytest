// author jacob chen
+function($){

    $.smConfig.rawCitiesData = provinceList;

}(Zepto);
/* jshint unused:false*/

+ function($) {
	
    "use strict";
    var format = function(data) {
        var result = [];
	    result["id"] = [];
		result['name'] = [];
        for(var i=0;i<data.length;i++) {
            var d = data[i];
            if(d.name === "请选择") continue;
			
			if(getCookie('lang_code')){
				var code=getCookie('lang_code');
				if(d['name_'+code]){
					var name=d['name_'+code];
				}else{
					var name=d['name'];
				}
			}else{
				var name=d['name'];
			}
		
            result['name'].push(name);
			result['id'].push(d.id);
        }
        if(result.length) return result;
        return result;
    };
	function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+ d.toUTCString();
			document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
		} 
	function getCookie(cname) {
		var name = cname + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for(var i = 0; i <ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			 }
			 if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			 }
		 }
		return "";
	} 
    var formatId = function(data) {
        var result = [];
        for(var i=0;i<data.length;i++) {
            var d = data[i];
            if(d.name === "请选择") continue;
            result.push(d.id);
        }
        if(result.length) return result;
        return [""];
    };
	
	var formatDate=  function(data) {
        var result = [];
		var weekdays=checkweekday(data.weekday)['weekdays'];
		
		result.push(weekdays.toString());
        if(result.length) return result;
        return [""];
    };
	
	var formatDateId =function(data) {
        var result = [];
		result.push(data.weekday);
        if(result.length) return result;
        return [""];
    };
	
    var sub = function(data) {
        if(!data.sub) return [""];
		var sub=format(data.sub);
		
        return sub;
    };

    var subId = function(data){
		
        if (!data.sub) return [""];
        var sub=format(data.sub);
		
        return sub['id'];
    };
	
	var subDate = function(data) {
		
        if(!data.weekday) return [""];
        return formatDate(data);
    };
	
	var subDateId = function(data){
		
        if (!data.weekday) return [""];
        return formatDateId(data);
    };

    var getCities = function(d) {
        for(var i=0;i< raw.length;i++) {
            if(raw[i].id == d){
				
				return sub(raw[i]);
			}
        }
        return [""];
    };

    var getCitiesId = function(d) {
        for(var i=0;i< raw.length;i++) {
            if(raw[i].id == d) return subId(raw[i]);
        }
        return [""];
    };

    var getDistricts = function(p, c) {
        for(var i=0;i< raw.length;i++) {
			
            if(raw[i].id == p) {
				
                for(var j=0;j< raw[i].sub.length;j++) {
					
                    if(raw[i].sub[j].id == c) {
						
                        return sub(raw[i].sub[j]);
                    }
                }
            }
        }
        return [""];
    };
	var genDisplayVal=function(p,c,d){
		console.log(p,c,d);
		if(!raw[p-1]){
			return p+" "+c+" "+d;
		}
		if(!raw[p-1]['sub'][c-1]){
			return p+" "+c+" "+d;
		}
		if(!raw[p-1]['sub'][c-1]['sub'][d-1]){
			return p+" "+c+" "+d;
		}
		var weekday=raw[p-1]['sub'][c-1]['sub'][d-1]['weekday'];
		$('#date').val(weekday);
		$('#weekday').val(weekday);
		$('#newaddress').attr('data-weekday',weekday);
		return raw[p-1]['sub'][c-1]['name']+" "+raw[p-1]['sub'][c-1]['sub'][d-1]['name'];
	}
	var getDistrictsId = function(p, c) {
        for(var i=0;i< raw.length;i++) {
            if(raw[i].id == p) {
				
                for(var j=0;j< raw[i].sub.length;j++) {
                    if(raw[i].sub[j].id == c) {
						
                        return subId(raw[i].sub[j]);
                    }
                }
            }
        }
        return [""];
    };
	
	var getDates = function(p, c , d) {
        for(var i=0;i< raw.length;i++) {
            if(raw[i].id == p) {
                for(var j=0;j< raw[i].sub.length;j++) {
                    if(raw[i].sub[j].id == c) {
						for(var k=0;k<raw[i].sub[j].sub.length;k++){
							if(raw[i].sub[j].sub[k].id== d){
								
								return subDate(raw[i].sub[j].sub[k]);
							}
						}
                    }
                }
            }
        }
        return [""];
    };
	
	var getDatesId = function(p, c , d) {
        for(var i=0;i< raw.length;i++) {
            if(raw[i].id == p) {
				
                for(var j=0;j< raw[i].sub.length;j++) {
                    if(raw[i].sub[j].id == c) {
						for(var k=0;k<raw[i].sub[j].sub.length;k++){
							if(raw[i].sub[j].sub[k].id==d){
								return subDateId(raw[i].sub[j].sub[k]);
							}
						}
                    }
                }
            }
        }
        return [""];
    };

    var raw = $.smConfig.rawCitiesData;
    var rawId = $.smConfig.rawCitiesData;
    var provincesNames = raw.map(function(d) {
		if(getCookie('lang_code')){
			var code=getCookie('lang_code');
			if(d['name_'+code]){
				var name=d['name_'+code];
			}else{
				var name=d['name'];
			}
		}else{
			var name=d['name'];
		}
        return name;
    });
    var provincesIds = raw.map(function(d) {
        return d.id;
    });
    var provinceCheckedID=$('#province').val()?$('#province').val():1;
	var provinceCheckedID=$('#city').val()?$('#city').val():1;
	var provinceCheckedID=$('#district').val()?$('#district').val():1;
	var citys = sub(raw[provinceCheckedID-1]);
	var initCities = citys['name'];
    var initCitiesIds = citys['id'];
	
	var districts = sub(raw[provinceCheckedID-1]['sub'][0]);
	
    var initDistricts = districts['name'];
	var initDistrictsIds = districts['id'];
	
	var initDates = subDate(raw[provinceCheckedID-1]['sub'][0]['sub'][0]);
	var initDatesIds = subDateId(raw[provinceCheckedID-1]['sub'][0]['sub'][0]);

    var currentProvince = provinceCheckedID;//provincesIds[0];
    var currentCity = initCitiesIds[0];
    var currentDistrict = initDistrictsIds[0];
	var currentDate = initDatesIds[0];

    var t;
    var defaults = {

        cssClass: "city-picker",
        rotateEffect: false,  //为了性能
		onOpen:function(picker){
			
			var provinceCheckedID=$('#province').val();
			
            var newCity;
			var newDistrict;
			var newDate;
            
            newCity = picker.cols[0].value;
			
            if(provinceCheckedID !== currentProvince) {
                
				clearTimeout(t);

                t = setTimeout(function(){
					var cities=getCities(provinceCheckedID);
					
                    var districts=getDistricts(provinceCheckedID, 1);
                    var newDistricts = districts['name'];
					var newDistrictsId = districts['id'];
					newDistrict = newDistrictsId[0];
					
					var newDates = getDates(provinceCheckedID, newCity,newDistrict);
					var newDatesId = getDatesId(provinceCheckedID, newCity,newDistrict);
					newDate= newDatesId[0];
					picker.cols[0].replaceValues(cities['id'],cities['name']);
                    picker.cols[1].replaceValues(newDistrictsId,newDistricts);
					
					//picker.cols[2].replaceValues(newDatesId,newDates);
					
                    currentProvince = provinceCheckedID;
                    currentCity = newCity;
					currentDistrict = newDistrict;
					currentDate = newDate;
					
                    picker.updateValue();
                }, 200);
                return;
            }
			/*newDistrict = picker.cols[1].value;
			if(newDistrict !== currentDistrict) {
				
				
                picker.cols[2].replaceValues(getDatesId(newProvince, newCity,newDistrict),getDates(newProvince, newCity,newDistrict));
                currentDistrict = newDistrict;
                picker.updateValue();
            }*/
		},
        onChange: function (picker, values, displayValues) {
			
            var provinceCheckedID=$('#province').val();
            var newCity;
			var newDistrict;
			var newDate;
            
            newCity = picker.cols[0].value;
			
            if(newCity !== currentCity) {
                
				clearTimeout(t);

                t = setTimeout(function(){
					//var cities=getCities(provinceCheckedID);
                    var districts=getDistricts(provinceCheckedID, newCity);
                    var newDistricts = districts['name'];
					var newDistrictsId = districts['id'];
					newDistrict = newDistrictsId[0];
					
					var newDates = getDates(provinceCheckedID, newCity,newDistrict);
					var newDatesId = getDatesId(provinceCheckedID, newCity,newDistrict);
					newDate= newDatesId[0];
					//picker.cols[0].replaceValues(cities['id'],cities['name']);
                    picker.cols[1].replaceValues(newDistrictsId,newDistricts);
					
					//picker.cols[2].replaceValues(newDatesId,newDates);
					
                    currentProvince = provinceCheckedID;
                    currentCity = newCity;
					currentDistrict = newDistrict;
					currentDate = newDate;
					
                    picker.updateValue();
                }, 200);
                return;
            }
			/*newDistrict = picker.cols[1].value;
			if(newDistrict !== currentDistrict) {
				
				
                picker.cols[2].replaceValues(getDatesId(newProvince, newCity,newDistrict),getDates(newProvince, newCity,newDistrict));
                currentDistrict = newDistrict;
                picker.updateValue();
            }*/
        },
		
        cols: [
            {
                textAlign: 'center',
                values: initCitiesIds,
                displayValues: initCities,
                cssClass: "col-city"
            },
            {
               textAlign: 'center',
               values: initDistrictsIds,
			   displayValues: initDistricts,
               cssClass: "col-district"
            },
			/*{
               textAlign: 'center',
               values: initDatesIds,
			   displayValues: initDates,
               cssClass: "col-date"
            }*/
        ],
        formatValue: function (picker, value, displayValue){
			var provinceCheckedID=$('#province').val();
            $(picker.params.province).val(provinceCheckedID);
            $(picker.params.city).val(value[0]);
			$(picker.params.district).val(value[1]);
			//$(picker.params.date).val(value[2]);
			//$('#province').val(1);
			$('#city').val(value[0]);
			$('#district').val(value[1]);
			$('#date').val(provinceList[provinceCheckedID-1]['sub'][value[0]-1]['sub'][value[1]-1]['weekday']);
			$('#weekday').val(provinceList[provinceCheckedID-1]['sub'][value[0]-1]['sub'][value[1]-1]['weekday']);
            return displayValue.join(' ');
        }
    };
	

    $.fn.cityPicker = function(params) {
        return this.each(function() {
            if(!this) return;
            var p = $.extend(defaults, params);
			
            var value;
            var val;
            //计算value
            /*if (p.value) {
                $(this).val(p.value.join(' '));
                val = $(this).val();
                if (val && val.split(' ').length > 1)
                    value = val.split(' ');
            } else {
                //待改进

                val = $(this).val();
                if (val && val.split(' ').length > 1)
                    value = val.split(' ');*/
				var val1=$('#province').val();
                var val2 = $(this).siblings("#city").val();
                var val3 = $(this).siblings("#district").val();
				var val4 = $(this).siblings("#date").val();
				
				
                if(val1+val2+val3 > 1)
                    p.value = [val1, val2,val3];
            //}
			
            if (p.value) {
				
                $(this).val(genDisplayVal(p.value[0],p.value[1],p.value[2]));
                /*if(p.value[0]) {
                    
					currentCity = p.value[0];
					var districts=getDistricts(currentProvince, p.value[0]);
					
                    p.cols[1].values = districts['id'];
                    p.cols[1].displayValues = districts['name'];
                }
                if(p.value[1]) {
                    currentDistrict = p.value[1];
                    p.cols[2].values = getDatesId(currentProvince,p.value[0], p.value[1]);
					p.cols[2].displayValues = getDates(currentProvince,p.value[0], p.value[1]);
                } else {
                    p.cols[2].values = getDatesId(currentProvince,p.value[0], p.cols[1].values[0]);
					p.cols[2].displayValues = getDates(currentProvince,p.value[0], p.cols[1].values[0]);
                }
				
                !p.value[2] && (p.value[2] = '');
                currentDate = p.value[2];*/
            }
			
            $(this).picker(p);
			
			
        });
    };
	//$.init();
}(Zepto);

