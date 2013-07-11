<div id="rt">
	<div class="slider">
		<div class="flexslider">
            <ul class="slides">
                <li>
                    <a href="#"><img src="<?php echo base_url(); ?>/public/images/portal/slider-image1.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li>
                <li>
                    <a href="#"><img src="<?php echo base_url(); ?>/public/images/portal/slider-image2.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li>
                <li>
                    <a href="#"><img src="<?php echo base_url(); ?>/public/images/portal/slider-image3.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li>
                  <li>
                    <a href="#"><img src="<?php echo base_url(); ?>/public/images/portal/slider-image4.jpg" alt="" title="" border="0"/></a>
                    <p class="flex-caption">Selamat datang di Sistem Aplikasi Pengukuran Kinerja Kementerian Perhubungan (e-Performance)</p>
                </li>
            </ul>
	  	</div>
    </div><!--end slider-->
    <div class="big-shadow"></div>
    
    <div class="center_content">
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

</script>
