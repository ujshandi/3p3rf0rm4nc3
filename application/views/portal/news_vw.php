<div id="rt">
	<div class="center_content">
    	<div class="page_title"><h1>Berita e-Perfomance</h1></div>
        <div class="article_wrapper color">
            <h2><?=($news)?$news->content_title:'Berita yang anda cari tidak tersedia';?></h2>
            <!-- <img src="<?php echo base_url(); ?>/public/images/portal/main-news-foto.JPG" /> -->
            <p><?=($news)?$news->content:'';?></p>
            <!-- <a href="#" class="inlink">selengkapnya</a>-->
            <div class="clear"></div>
        </div>
    </div><!-- end center content -->
</div><!--end block right-->
