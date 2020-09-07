<?php
/**
 * FecShop file.
 *
 * @link http://www.fecshop.com/
 * @copyright Copyright (c) 2016 FecShop Software LLC
 * @license http://www.fecshop.com/license/
 */
?>
<style>
.cmdlist-container img{width:50%;height:auto;}.cmdlist-container{height:200px;text-align: center;}
</style>
<div class="main container two-columns-left">
<?php // echo count($products); ?>
<?php  $count = 4; $end = $count-1; ?>
	<div class="col-left ">
		<div class="left-breadcrumbs">
		<?= Yii::$service->page->widget->render('base/breadcrumbs',$this); ?>
		</div>
		
	</div>
	<div class="col-main">
		
		<div class="menu_category">
			<div class="category_description">
				<h1 class="category_description_h1"><?=  $name ?></h1>
			</div>
			<div style="width: 80%;margin: auto;">
				<p style="text-align:center;text-indent: 2em;">
				
					我們提供一站式IT服務。 客戶可以花費更少的時間進行IT管理，並專注於他們的業務發展以最大化投資回報。除了具有專業的資訊科技知識，同時對商業營運有相當深入的瞭解。資訊科技支援團各有不同專長，能為不同類型的客戶提供不同的方案，以解決不同電腦問題。
				</p>     
				<div class="layui-fluid layadmin-cmdlist-fluid">  
					<div class="layui-row layui-col-space30">    
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										電腦硬件
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images//pcservice/pc1.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>    
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										電腦升級
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc2.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>  
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										備份復原
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc3.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div> 
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										檢查維修
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc4.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div> 
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										軟件安裝
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc5.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div> 
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										病毒清除
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc6.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div> 
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										網絡共享
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc7.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										打印管理
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc8.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										網站維護
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc9.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										遙距辦公
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc10.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										網路建設
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc11.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>
						<div class="layui-col-md2 layui-col-sm4 layui-col-md4">        
							<div class="cmdlist-container">            
								<div class="cmdlist-text">                
									<p class="info">
										支援服務
									</p>                              
								</div>
								<a href="javascript:;">              </a> <img src="<?= Yii::$service->image->getImgUrl('images/pcservice/pc12.png') ?>" alt="" />                         <a href="javascript:;">              </a>                    
							</div>    
						</div>
					</div>
				</div>      
				<div class="alone-version-desc layui-text">        
					<h2>
						服務包括
					</h2>                       
					<ul style="text-indent: 2em;">          
						<li >
							系統維護
						</li>          
						<li >
							定期檢查
						</li>          
						<li >
							清除電腦病毒
						</li>          
						<li>
							重新安裝Windows系統
						</li>          
						<li>
							解決各類型電腦問題
						</li>          
						<li>
							遠端遙控電腦支援
						</li>          
						<li>
							電話支援
						</li>          
						<li>
							現場支援
						</li>                 
					</ul>             
				</div>
				<div class="alone-version-desc layui-text">        
					<h2>
						其他服務
					</h2>                       
					<ul style="text-indent: 2em;">          
						<li >
							數據備份及恢復
						</li>          
						<li >
							網絡設計安裝、安全
						</li>          
						<li >
							網站維護
						</li>          
						<li>
							網路建設
						</li>          
						<li>
							電腦系統保安
						</li>          
						<li>
							遙距辦公方案
						</li>          
						<li>
							網絡資源共享方案
						</li>          
						<li>
							電話系統
						</li>                 
					</ul>             
				</div>
				<div>
					<h1 class="category_description_h1">收費詳情</h1>
					<table lay-even lay-skin="line row" lay-size="lg">
						<thead>
							<tr>
							  <th>電腦數量</th>
							  <th>電話支援</th>
							  <th>遠程支援</th>
							  <th>現場支援/半年</th>
							  <th>每月定期檢查</th>
							  <th>參考費用/半年</th>
							  <th>平均月費</th>
							</tr> 
						  </thead>
						  <tbody>
							<tr>
							  <td>1-5</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>6小時</td>
							  <td>N</td>
							  <td>$2340</td>
							  <td>$390</td>
							</tr>
							<tr>
							  <td>6-10</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>12小時</td>
							  <td>N</td>
							  <td>$4500</td>
							  <td>$750</td>
							</tr>
							<tr>
							  <td>11-15</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>16小時</td>
							  <td>N</td>
							  <td>$5880</td>
							  <td>$980</td>
							</tr>
							<tr>
							  <td>16-20</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>18小時</td>
							  <td>Y</td>
							  <td>$10200</td>
							  <td>$1700</td>
							</tr>
							<tr>
							  <td>21-30</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>24小時</td>
							  <td>Y</td>
							  <td>$11400</td>
							  <td>$1900</td>
							</tr>
							<tr>
							  <td>31-40</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>30小時</td>
							  <td>Y</td>
							  <td>$17820</td>
							  <td>$2970</td>
							</tr>
							<tr>
							  <td>取決數量</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>無限</td>
							  <td>Y</td>
							  <td colspan=2>提拱報價</td>
							  
							</tr>
						  </tbody>
					</table>
					<div class="alone-version-desc layui-text">
						<ul>          
							<li >
								1台服務器為2台電腦
							</li>          
							<li >
								6個月合約
							</li>          
							<li >
								 現場支援至少2小時計算
							</li>   
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="clear"></div>
</div>
