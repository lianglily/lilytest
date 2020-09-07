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
.layui-nav-child dt{
	text-indent:2em;
}
.padding_0{
	padding:0;
	background-color: white;
}
.layui-nav-child-div{
	display:flex;display: -webkit-flex;width:400px;flex-wrap:wrap
}
.layui-nav-child {
    display: none;
    position: absolute;
    left: 0;
    top: 40px;
    min-width: 100%;
    line-height: 36px;
    padding: 5px 0;
    box-shadow: 0 2px 4px rgba(0,0,0,.12);
    border: 1px solid #d2d2d2;
    background-color: #fff;
    z-index: 100;
    border-radius: 2px;
    white-space: nowrap;
}
.layui-nav .layui-nav-item {
    position: relative;
    display: inline-block;
    vertical-align: middle;
    line-height: 40px;
}
.layui-nav {
    position: relative;
    padding: 0 20px;
    
    color: #fff;
    font-size: 0;
    box-sizing: border-box;
	border-bottom: 3px solid #004e80;
}
</style>
<div class="top_menu">
	
	<?php if(is_array($categoryArr) && !empty($categoryArr)): ?>
	<ul class="layui-nav padding_0" lay-filter="">
<?php foreach($categoryArr as $category1): ?>
  <li class="layui-nav-item">
    <a href="<?= $category1['url'] ?>" ><?= $category1['name'] ?></a>
	<?php $childMenu1 = isset($category1['childMenu']) ? $category1['childMenu'] : null;   ?>
	<?php if(is_array($childMenu1) && !empty($childMenu1)): ?>
    <dl class="layui-nav-child"> <!-- 二级菜单 -->
	<div class="layui-nav-child-div">
	<?php foreach($childMenu1 as $category2): ?>
	  <div>
      <dd><a href="<?= $category2['url'] ?>"><?= $category2['name'] ?></a></dd>
		<?php $childMenu2 = isset($category2['childMenu']) ? $category2['childMenu'] : null;   ?>
		<?php if(is_array($childMenu2) && !empty($childMenu2)): ?>
		<?php foreach($childMenu2 as $category3): ?>
		  <dt><a href="<?= $category3['url'] ?>"><?= $category3['name'] ?></a></dt>
		<?php endforeach; ?>
		<?php endif; ?>
	  
	  </div>
    <?php endforeach; ?>
	</div>
    </dl>
	<?php endif; ?>
  </li>
 <?php endforeach; ?>
</ul>
<?php endif; ?>
</div>


	