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
	
?>
<style>
.searchbar button{margin-right: 0.4rem;width: 1.5rem;}
.searchbar form{display: grid;}
.button-tab-display{display: block;width: 20vw;-webkit-align-self: flex-start;align-self: flex-start;overflow:hidden}
.content-block-display{max-height: 90vh;overflow: scroll;padding-right:0}
.content-block-tabs{width: 65vw;}
.content-block-title-display{margin:0rem;padding:0.75rem;}
.list-block-button{margin-right: 0.5rem;border:0px;font-size: 0.9em;}
</style>
<div class="panel-overlay">
</div>
<!-- Left Panel with Reveal effect -->
<div class="popup " id='panel-left-menu'>
	<div class="content-block">
		<div class="searchbar row">
			<button  class="button button-link button-light button-nav pull-left close-popup">
		      <span class="icon icon-left"></span>
		    </button>
			<form method="get"  name="searchFrom" class="js_topSeachForm" action="<?= Yii::$service->url->getUrl('catalogsearch/index');   ?>">
                <div class="search-input">
                  <label class="icon icon-search" for="search"></label>
                  <input name="q" type="search" id="search" placeholder="<?= Yii::$service->page->translate->__('Products keyword'); ?>" value="<?=  \Yii::$service->helper->htmlEncode(Yii::$app->request->get('q'));  ?>" />
                </div>
            </form>
		</div>
		<div class="category_menu">
			<?php if(is_array($categoryArr) && !empty($categoryArr)): ?>
			<div class="flex">
			  <div class="buttons-tab button-tab-display" >
			  	<?php $i=0; foreach($categoryArr as $key => $category1): ?>
			  	    <?php if($i==0 ||!isset($category1['childMenu']) ){?>
			  	    <a  external href="<?= $category1['url'] ?>" class=" button"><?= $category1['name'] ?></a>
			  	   <?php }elseif($i==1){?>
			    	<a  href="#<?= $key ?>" class="tab-link button active"><?= $category1['name'] ?></a>
			    	<?php }else{ ?>
			    	<a href="#<?= $key ?>" class="tab-link button"><?= $category1['name'] ?></a>
			    	<?php } ?>
			    <?php $i++; endforeach; ?>
			  </div>
			  <div class="content-block content-block-display" >
			    <div class="tabs content-block-tabs" >
			      <?php $i=0; foreach($categoryArr as $key => $category1): ?>
			      <?php if($i==1){?>
			      <div id="<?= $key ?>" class="tab active">
			      	<?php $childMenu1 = $category1['childMenu'];   ?>
					<?php if(is_array($childMenu1) && !empty($childMenu1)): ?>
					<?php foreach($childMenu1 as $category2): ?>
			        <div class="content-block-title content-block-title-display" ><a href="<?= $category2['url'] ?>"><?= $category2['name'] ?></a></div>
					  <div class="list-block flex">
					  	<?php $childMenu2 = $category2['childMenu'];   ?>
						<?php if(is_array($childMenu2) && !empty($childMenu2)): ?>
						<?php foreach($childMenu2 as $category3): ?>
					    <a href="<?= $category3['url'] ?>" class="button list-block-button" ><?= $category3['name'] ?></a>
					    <?php endforeach; ?>
						<?php endif; ?>
					  </div>
					  <?php endforeach; ?>
					  <?php endif; ?>
			      </div>
			      <?php }else{ ?>
			      <div id="<?= $key ?>" class="tab">
			        <?php $childMenu1 = $category1['childMenu'];   ?>
					<?php if(is_array($childMenu1) && !empty($childMenu1)): ?>
					<?php foreach($childMenu1 as $category2): ?>
			        <div class="content-block-title content-block-title-display" ><a href="<?= $category2['url'] ?>"><?= $category2['name'] ?></a></div>
					  <div class="list-block flex">
					  	<?php $childMenu2 = $category2['childMenu'];   ?>
						<?php if(is_array($childMenu2) && !empty($childMenu2)): ?>
						<?php foreach($childMenu2 as $category3): ?>
					    <a href="<?= $category3['url'] ?>" class="button list-block-button" ><?= $category3['name'] ?></a>
					    <?php endforeach; ?>
						<?php endif; ?>
					  </div>
					  <?php endforeach; ?>
					  <?php endif; ?>
					  
			      </div>
			      <?php } ?>
			      <?php $i++;endforeach; ?>
			      
			    </div>
			  </div>
			</div>
			<?php endif;?>
			<!-- <?php if(is_array($categoryArr) && !empty($categoryArr)): ?>
				<ul>
				<?php foreach($categoryArr as $category1): ?>
					<li class="item-content">
						<div class="item-title">
							<a href="<?= $category1['url'] ?>" class="nav_t" external><?= $category1['name'] ?></a>	
						</div>
						<?php $childMenu1 = $category1['childMenu'];   ?>
						<?php if(is_array($childMenu1) && !empty($childMenu1)): ?>
							<ul>
								<?php foreach($childMenu1 as $category2): ?>
									<span class="icon icon-right"></span>
									<li class="item-content">
										<div class="item-title">
											<a href="<?= $category2['url'] ?>" external>
												<?= $category2['name'] ?>
											</a>
										</div>
										<?php $childMenu2 = $category2['childMenu'];   ?>
										<?php if(is_array($childMenu2) && !empty($childMenu2)): ?>
											<ul>
											<?php foreach($childMenu2 as $category3): ?>
												<span class="icon icon-right"></span>
												<li class="item-content">
													<div class="item-title"><a href="<?= $category3['url'] ?>" external><?= $category3['name'] ?></a></div>
												</li>
												
											<?php endforeach; ?>
											</ul>
										<?php endif; ?>
									</li>
								<?php endforeach; ?>
							</ul>
							<?php //echo $category1['menu_custom'];  ?>
									
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>  -->
		</div>
		
	</div>
  <div class="list-block">
	<!-- .... -->
  </div>
</div>

<div class="panel-overlay"></div>
<!-- Left Panel with Reveal effect -->
<div class="panel panel-left panel-reveal theme-dark" id='panel-left-account'>
	<div class="content-block">
		<div class="searchbar row">
			
			<div class="search-input">
			  <label class="icon icon-search" for="search"></label>
			  <input type="search" id='search' placeholder='输入关键字...'/>
			</div>
		</div>
		<div class="category_menu list-block">
			<ul>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->homeUrl();  ?>" external><?= Yii::$service->page->translate->__('Home'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('customer/account/index'); ?>" external><?= Yii::$service->page->translate->__('My Account'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('checkout/cart'); ?>" external><?= Yii::$service->page->translate->__('Shopping Cart'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('customer/order'); ?>" external><?= Yii::$service->page->translate->__('My Order'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('customer/productfavorite'); ?>" external><?= Yii::$service->page->translate->__('My Favorite'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('company-profile'); ?>" external><?= Yii::$service->page->translate->__('Company Profile'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('contacts'); ?>" external><?= Yii::$service->page->translate->__('Contact Us'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('registere-members'); ?>" external><?= Yii::$service->page->translate->__('Registere'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('check-sale'); ?>" external><?= Yii::$service->page->translate->__('Check Sale'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('payment'); ?>" external><?= Yii::$service->page->translate->__('Payment Method'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('return'); ?>" external><?= Yii::$service->page->translate->__('Return Plan'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('delivery-time-and-cost'); ?>" external><?= Yii::$service->page->translate->__('Delivery Time and Cost'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('exceptions'); ?>" external><?= Yii::$service->page->translate->__('Exceptions'); ?></a></div>
					</div>
				</li>
				<li class="item-content">
					<div class="item-inner">
						<div class="item-title"><a href="<?= Yii::$service->url->getUrl('terms-use'); ?>" external><?= Yii::$service->page->translate->__('Terms of use'); ?></a></div>
					</div>
				</li>
			</ul>
		</div>
		
	</div>
  <div class="list-block">
	<!-- .... -->
  </div>
</div>