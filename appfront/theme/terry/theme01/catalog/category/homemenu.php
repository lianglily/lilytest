<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?php  //var_dump($categoryArr);
    /*$i=0;
	foreach($categoryArr as $key => $val){
			
		$treedata[$i]=[];
		$treedata[$i]['title']=$val['name'];
		$treedata[$i]['href']=$val['url'];
		$treedata[$i]['id']=1;
		$treedata[$i]['field']='testtestest';
		$treedata[$i]['spread']=true;	
		
		if(isset($val['childMenu'])){
			$treedata[$i]['children']=[];
			$j=0;
			foreach($val['childMenu'] as $key1 => $val1){
				$treedata[$i]['children'][$j]=[];
				$treedata[$i]['children'][$j]['title']=$val1['name'];
				$treedata[$i]['children'][$j]['href']=$val1['url'];
				$treedata[$i]['children'][$j]['id']=2;
				//$treedata[$i]['children'][j]['spread']=true;
				
				if(isset($val1['childMenu'])){
					$treedata[$i]['children'][$j]['children']=[];
					$k=0;
					foreach($val1['childMenu'] as $key2 => $val2){
						
						$treedata[$i]['children'][$j]['children'][$k]=[];
						$treedata[$i]['children'][$j]['children'][$k]['title']=$val2['name'];
						$treedata[$i]['children'][$j]['children'][$k]['href']=$val2['url'];
						$treedata[$i]['children'][$j]['children'][$k]['id']=3;
						$k++;
					}
				}
			    $j++;
			}
		}
		$i++;
	}*/
	
?>
<style>
div[data-id ="1"] .layui-tree-entry:nth-child(1) a{
	font-weight: 900;
    font-size: 0.95rem;
    color:#004e80;
}
div[data-id ="2"] .layui-tree-entry:nth-child(1) a{
	font-size: 0.85rem;
	font-weight: unset;
	color:#004e80;
}
div[data-id ="3"] .layui-tree-entry:nth-child(1) a{
	font-size: 0.8rem;
	font-weight: unset;
	color:#004e80;
}
</style>
<div class="col-left">
<div id="test1"></div>
</div>
<script>
<?php $this->beginBlock('tree') ?>  
	layui.use('tree', function(){
		var tree = layui.tree;
		var data=<?= json_encode($categoryArr)?>;
		var treedata=[];
		
		for(var i=0;i<data.length;++i){
			
			treedata[i]=[];
			treedata[i]['title']=data[i]['name'];
			treedata[i]['href']=data[i]['url'];
			treedata[i]['id']=1;
			treedata[i]['field']='testtestest';
			treedata[i]['spread']=true;	
			
			if(data[i]['childMenu']){
				treedata[i]['children']=[];
				for(var j=0;j<data[i]['childMenu'].length;++j){
					treedata[i]['children'][j]=[];
					treedata[i]['children'][j]['title']=data[i]['childMenu'][j]['name'];
					treedata[i]['children'][j]['href']=data[i]['childMenu'][j]['url'];
					treedata[i]['children'][j]['id']=2;
					//treedata[i]['children'][j]['spread']=true;
					
					if(data[i]['childMenu'][j]['childMenu']){
						treedata[i]['children'][j]['children']=[];
						for(var k=0;k<data[i]['childMenu'][j]['childMenu'].length;++k){
							treedata[i]['children'][j]['children'][k]=[];
							treedata[i]['children'][j]['children'][k]['title']=data[i]['childMenu'][j]['childMenu'][k]['name'];
							treedata[i]['children'][j]['children'][k]['href']=data[i]['childMenu'][j]['childMenu'][k]['url'];
							treedata[i]['children'][j]['children'][k]['id']=3;
						}
					}
				}
			}
		}
		
		var inst1 = tree.render({
	      elem: '#test1'  //绑定元素
	      ,onlyIconControl:true
	      ,isJump:true
	      ,showLine:false
	      ,data: treedata
	      ,click:function(){
				$(".layui-tree-txt").attr("target", "_self");
		 }
	    });
	});
<?php $this->endBlock(); ?>  
</script> 
<?php $this->registerJs($this->blocks['tree'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?> 
	