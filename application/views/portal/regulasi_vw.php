<div id="rt">
	<div class="center_content">
    	<div class="page_title"><h1>Regulasi Terkait</h1></div>
        <div class="article_wrapper color">
            <!-- <h2><?=$reg->content_title?></h2> -->
            <? if($regulasi){?>
            <table width="100%">
              <thead>
                <th>No</th>
                <th>Nomor Regulasi</th>
                <th>Deskripsi</th>
                <th>Link Download</th>
              </thead>
              <tbody>
                <?
                    $i=($offset)?$offset:0;
                    foreach ($regulasi->result() as $reg) {
                        $i++;
                        echo '<tr>';
                        echo '<td>'.$i.'</td>';
                        echo '<td>'.$reg->content_title.'</td>';
                        echo '<td>'.$reg->content.'</td>';
                        echo "<td><a href='{$reg->url}'>Download</a></td>";
                        echo '</tr>';
                    }
                ?>
              </tbody>
            </table>
            <?= $this->pagination->create_links();?>

            <? }else{ ?>
                <div class="article_wrapper color">
                    <h2>Saat ini data berita masih kosong</h2>
                </div>
            <? }?>
          <div class="clear"></div>
        </div>
    </div><!-- end center content -->
</div><!--end block right-->
