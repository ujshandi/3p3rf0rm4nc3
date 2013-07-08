<div id="rt">
    
    <div class="center_content">
        <?if($akips){?>
    	<div class="page_title"><h1>Daftar AKIP</h1></div>
        <?
            $i=0;
            foreach ($akips->result() as $akip) {
        ?>
        <div class="article_wrapper color">
            <h2><a href="<?=base_url()?>portal/page/news/<?=$akip->content_id?>"><?=$akip->content_title?></a></h2>
            <h6 class="meta"><?= date("d M Y", strtotime($akip->date_post)); ?></h6>
            <img src="<?php echo base_url(); ?>/public/images/portal/main-news-foto.JPG" />
            <p><?=$akip->summary?></p>
            <!-- <=base_url()?>portal/page/news/<=$akip->content_id?> !-->
            <a href="<?=base_url()?>portal/page/akip_det/<?=$akip->content_id?>" class="inlink">selengkapnya</a>
            <div class="clear"></div>
        </div>
        <?= $this->pagination->create_links();?>
        <?
                $i++;
            }
        ?>
        
        <?}else{?>
            <div class="article_wrapper color">
                <h2>Saat ini data berita masih kosong</h2>
            </div>
        <?}?>


        <div class="clear"></div>
    </div><!-- end center content -->
</div><!--end block right-->