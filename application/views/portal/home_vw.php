 <!--[if IE]><script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot/excanvas.js"></script><![endif]-->
 
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.min.js"></script>
 <script language="javascript" type="text/javascript" src="<?=base_url()?>/public/admin/js/jqplot.1.0.8/plugins/jqplot.pieRenderer.min.js"></script>
 <link rel="stylesheet" type="text/css" href="<?=base_url()?>/public/admin/js/jqplot.1.0.8/jquery.jqplot.css" />

<div id="rt">
	<h3 class="lefthead">Dashboard</h2>
	<div class="slider">
		<div class="flexslider">
            <ul class="slides">
                <li>
                    <!--<a href="#"><img src="<?php echo base_url(); ?>/public/images/portal/slider-image1.jpg" alt="" title="" border="0"/></a> -->
                    <div id="dashboardFrontKl" style="height:300px;width:350px;top:50px;left:25%"></div> 
                    <table width="100%">
					  <thead>
						<th>No</th>
						<th>Deskripsi</th>
						<th>Satuan</th>					
						<th>Capaian</th>
					  </thead>
					  <tbody>
						<?
						//	$i=($offset)?$offset:0;
					
							for ($i=0;$i<count($dataDashboadKl);$i++){							
								
								echo '<tr>';
								echo '<td>'.($i+1).'</td>';
								echo '<td>'.$dataDashboadKl[$i][0].'</td>';
								echo '<td>'.$dataDashboadKl[$i][1].'</td>';
								echo '<td align="right">'.$dataDashboadKl[$i][2].' %</td>';
								
								
								echo '</tr>';
								//$i++;
							}
							if ($i==0){
								echo '<tr>';
								echo '<td colspan="5">Belum ada data.</td>';
								
								echo '</tr>';
							}
						?>
					  </tbody>
					</table>
                    <p class="flex-caption">Kementerian Perhubungan</p>
                </li>
				
				<?  //generate dashboard eselon 1
				//var_dump(count($listEselon1));die;
					for ($i=0;$i<count($listEselon1);$i++){
					//	var_dump($listEselon1[$i]['data']);die;
						echo '<li>';
						echo '  <div id="dashboardFrontE1-'.$i.'" style="height:300px;width:350px;top:50px;left:25%"></div> ';
						echo '  <table width="100%">
								  <thead>
									<th>No</th>
									<th>Deskripsi</th>
									<th>Satuan</th>					
									<th>Capaian</th>
								  </thead>
								  <tbody>';
								  
							
							for ($j=0;$j<count($listEselon1[$i]['data']);$j++){							
								
								echo '<tr>';
								echo '<td>'.($j+1).'</td>';
								echo '<td>'.$listEselon1[$i]['data'][$j][0].'</td>';
								echo '<td>'.$listEselon1[$i]['data'][$j][1].'</td>';
								echo '<td align="right">'.$listEselon1[$i]['data'][$j][2].' %</td>';
								
								
								echo '</tr>';
								//$i++;
							}
							if ($i==0){
								echo '<tr>';
								echo '<td colspan="5">Belum ada data.</td>';
								
								echo '</tr>';
							}
							
						echo '  </tbody>
								</table>';		  
						echo '<p class="flex-caption">'.$listEselon1[$i][1].'</p>';
						echo '</li>';
					}
					
				?>
                <!--<li>
                    <a href="#"><img src="<php echo base_url(); ?>/public/images/portal/slider-image2.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li>
                <li>
                    <a href="#"><img src="<php echo base_url(); ?>/public/images/portal/slider-image3.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li>
                  <li>
                    <a href="#"><img src="<php echo base_url(); ?>/public/images/portal/slider-image4.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li> -->
            </ul>
	  	</div>
    </div><!--end slider-->
    <div class="big-shadow"></div>
    
    <div class="center_content"  style="display:none">
        <?if($latest_news){?>
    	<div class="page_title"><h1>Latest News</h1></div>
        <div class="article_wrapper color">
            <h2><a href="<?=base_url()?>portal/page/news/<?=$latest_news->row()->content_id?>"><?=$latest_news->row()->content_title?></a></h2>
            <h6 class="meta"><?= date("d M Y", strtotime($latest_news->row()->date_post)); ?></h6>
        <!--    <img src="<?php echo base_url(); ?>/public/images/portal/main-news-foto.JPG" /> -->
            <p><?=$latest_news->row()->summary?></p>
            <!-- <=base_url()?>portal/page/news/<=$latest_news->row()->content_id?> !-->
            <a href="<?=base_url()?>portal/page/news/<?=$latest_news->row()->content_id?>" class="inlink">selengkapnya</a>
            <div class="clear"></div>
        </div>
        
        <div class="section_full">
        	<div class="section">
            	<h2>Berita Lain</h2>
                <hr/>
                <?
                    $i=0;
                    foreach ($latest_news->result() as $news) {
                        if($i>0){
                ?>
                <div class="features">
                    <img src="<?php echo base_url(); ?>/public/images/portal/pic-small.jpg" alt="" title="" border="0" class="feat_thumb" />
                    <div class="feat_details">
                    <p class="feat_text"><span class="meta"><?= date("d M Y", strtotime($news->date_post)); ?></span><?=$news->summary?></p>
                    <a href="<?=base_url()?>portal/page/news/<?=$news->content_id?>" class="read_more clear">Detail</a>
                    </div>
                </div>
                <?
                        }
                        $i++;
                    }
                ?>
                <div class="clear">&nbsp;</div>
                <a href="#" class="inlink">list berita</a>
            </div>
            
            <div class="section last list">
            	<h2>List Berita</h2>
                <hr/>
                <ul>
                <? foreach ($latest_news->result() as $news) {?>
                 <li><a href="<?=base_url()?>portal/page/news/<?=$news->content_id?>" title=""><?=$news->content_title?></a></li>
                <?}?>
                </ul>
            </div>
        </div><!-- end section full -->
        <?}else{?>
            <div class="page_title"><h1>Saat ini data berita masih kosong</h1></div>
        <?}?>
        <div class="clear"></div>
    </div><!-- end center content -->
</div><!--end block right-->
<script  type="text/javascript" >
$('.flexslider').flexslider({
			  animation: "slide",
		});
$(document).ready(function(){
	
		setTimeout(function(){
		
				$.jqplot('dashboardFrontKl',  
					[[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]],
					{gridPadding: {top:30, bottom:80, left:10, right:0}}
				);
				<?
				for ($i=0;$i<count($listEselon1);$i++){
			?>
					$.jqplot('dashboardFrontE1-<?=$i?>',  
						[[[1, 2],[3,5.12],[5,13.1],[7,33.6],[9,85.9],[11,219.9]]],
						{gridPadding: {top:30, bottom:80, left:10, right:0}}
					);
		
			<?	}?>	
			
		
		}, 1000);
		
		
		
});


</script>
