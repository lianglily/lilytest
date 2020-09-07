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
.info {
    text-align: center;
    font-size: 0.6rem;
    font-weight: normal;
    color: #fff;
    margin: 0;
    padding: 12px 0 16px 0;
    border-radius: 0 0 15px 15px;
	line-height: 1.25;
	background: #b8bcc5;
}
a:link { text-decoration: none;color: blue}
　　 a:active { text-decoration:blink}
　　 a:hover { text-decoration:underline;color: red}
　　 a:visited { text-decoration: none;color: green}
a:hover .info{
	background: #666666f5;
	transition: all 0.3s ease 0.3s;
}
.flex_center{
	display: -webkit-flex; /* Safari */
	display: flex;
	justify-content: center;
    align-items: center;
    align-content: center;
    justify-items: center;
}
.row-div{margin-bottom: 10px;}
.row-div-a{display: grid;}
</style>
<div style="padding:10px;">
	<div class="row">
	<?php if(is_array($categoryArr) && !empty($categoryArr)): ?>
	<?php foreach($categoryArr as $category1): ?>
		<div class="col-50 row-div" >
		<a href="<?= $category1['url'] ?>" class="row-div-a">
			<img class="lazy" data-src="<?php echo $category1['image']?$category1['image']:'' ?>" alt="<?= $category1['name'] ?>" class="width-100">
			<div class="cmdlist-text code">
                <p class="info"><?= $category1['name'] ?></p>
            </div>
		</a>
		</div>
	<?php endforeach; ?>
	<?php endif; ?>		
	</div>
</div>

	