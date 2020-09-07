<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<?=  Yii::$service->cms->staticblock->getStoreContentByIdentify('home-big-img-apphtml5','apphtml5') ?>
<style type="text/css">
	.infinite-scroll-preloader {
		margin-top:-20px;
	}
	.menu-a{
		min-width: 80px;
    	
	}
	.menu-a-all{
		position: absolute;
	    right: 0;
	    top: auto;
	    height: 1.9rem;
	    width: auto;
	    background-color: white;
	    display: inline-block;
	    z-index: 15;
	    -webkit-transform-origin: 50% 100%;
	    transform-origin: 50% 100%;
	    line-height: 1.9rem;
	    font-size: 1rem;
	}
	.buttons-tab::-webkit-scrollbar { width: 0 !important;height: 0 !important }
</style>
<div class="clear"></div>
<div class="fixed-tab" data-offset="44">
	<div  class="fixed-tab-home" >
		<div class="buttons-tab buttons-tab-home"  >
			<a external href="/" class="active menu-a button" ><?= Yii::$service->page->translate->__('Home');?></a>
		<?php if(is_array($category) && !empty($category)): ?>
		  <?php foreach($category as $key => $category1): ?>
	      <a external href="<?= $category1['url']?>" class=" menu-a button"><?= $category1['name']?></a>
	      <?php endforeach?>
	    <?php endif?>
	    </div>
    </div>
    <div class="buttons-tab icon icon-menu pull-right open-menu menu-a-all"></div>
</div>
<div class="home-scroll">      
    <!-- 添加 class infinite-scroll 和 data-distance  向下无限滚动可不加infinite-scroll-bottom类，这里加上是为了和下面的向上无限滚动区分-->
    <div class=" infinite-scroll infinite-scroll-bottom" data-distance="100">
        <div class="list-block">
            <div class="list-container">
				<?php
					$parentThis['products'] = $bestFeaturedProducts;
					$parentThis['name'] = 'featured';
					$parentThis['qtys'] = $qtys;
                    echo Yii::$service->page->widget->render('cms/productlist', $parentThis);
				?>
				
            </div>
        </div>
       
    </div>
</div>	 


<div class="footer-bottom">
	<?=  Yii::$service->cms->staticblock->getStoreContentByIdentify('copy_right_apphtml5','appfront') ?>
</div>				
 
<script>
<?php $this->beginBlock('owl_fecshop_slider') ?>  
$.init();  
$(document).ready(function(){
	currentBaseUrl = "<?=  $currentBaseUrl; ?>";
	$(".footer_bar .change-bar .lang").change(function(){
		redirectUrl = $(this).val();
		location.href=redirectUrl;
		
	});
	
	$(".footer_bar .change-bar .currency").change(function(){
		currency = $(this).val();
		
		htmlobj=$.ajax({url:currentBaseUrl+"/cms/home/changecurrency?currency="+currency,async:false});
		//alert(htmlobj.responseText);
		location.reload() ;
	});
   
});
<?php $this->endBlock(); ?>  
</script>  
<?php $this->registerJs($this->blocks['owl_fecshop_slider'],\yii\web\View::POS_END);//将编写的js代码注册到页面底部 ?>
