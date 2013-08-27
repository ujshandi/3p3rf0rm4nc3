<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title><?=$title_page?></title>
	<link type="image/x-icon" href="<?php echo base_url(); ?>public/images/favicon.ico" rel="shortcut icon">
	<?php if(count($css) > 0) load_css($css);?>    
	<?php if(count($js) > 0) load_js($js);?>    

	<script type="text/javascript">var  base_url = "<?php echo base_url(); ?>"</script>
	<script>
	function runScript(e) {
		if (e.keyCode == 13) {
			document.getElementById('formLogin').submit();
		}
	}
	</script>
</head>
<body>

<div id="header">
    <div class="header_content">
  
    <div class="logo"><a href="<?=base_url();?>portal">home</a></div>
    <div class="title"><h1>e-Performance</h1><h2>Sistem Informasi Pengukuran Kinerja Kementerian Perhubungan</h2></div>
    
    <div class="menu">
       <ul>
            <li><a href="<?=base_url();?>portal">home</a></li>
               <? if($sess_fullname!=''){?>
            <li><a href="<?=base_url();?>home">aplikasi</a></li>
            <li><a href="<?=base_url()?>security/login/logout_user" class="logout">LOGOUT</a></li>
            <? }?>
          <!--   <li><a href="<?=base_url();?>home">dashboard</a></li>-->
        </ul> 
    </div><!--end top menu-->
    <div class="clear"></div> 
    </div><!--end header content--> 
</div><!-- End of Header-->

<div id="wrap">
<div id="lt">
	<h3 class="lefthead">Informasi</h3>
    <div class="leftbox grd">
        <ul class="borderedlist">
            <li><a href="<?=base_url()?>portal/page" title="">Dashboard</a></li>
            <li><a href="<?=base_url()?>portal/page/about" title="">Tentang e-Performance</a></li>
            <li><a href="<?=base_url()?>portal/page/akip" title="">Sistem AKIP</a></li>
            <li><a href="<?=base_url()?>portal/page/regulasi" title="">Regulasi Terkait</a></li>
            <li><a href="<?=base_url()?>portal/page/news" title="">Berita Kinerja</a></li>
            <li><a href="<?=base_url()?>portal/page/faq" title="">FAQ</a></li>
            <li class="last"><a href="<?=base_url()?>portal/page/contact" title="">Kontak</a></li>
        </ul>
    </div>
    
    <div class="apl_box">
    <? if($sess_fullname!=''){?>
      <!--  <h3 class="typo">Selamat Datang, <?=$sess_fullname;?></h3>
        <p>Silahkan klik tombol dibawah ini untuk menuju ke dashboard aplikasi e-Perfomance</p>
        <hr/>
        <a href="<?=base_url();?>home" class="more_bgcolor more_rounded centered">DASHBOARD</a> -->
    <? }else{?>
        <h3 class="typo">LOGIN Aplikasi</h3>
        <hr/>
        <p>Masukkan username dan password Anda untuk masuk aplikasi e-Performance</p>
        <form class="front" id="formLogin" method="post" action="<?=base_url();?>security/login/login_usr/portal">
        <input name="username" type="text"  id="username_id" title="Username"/>
        <input name="password" type="password" id="password" title="Password" onkeypress="runScript(event)"/>
        <span style="color:#ff3333"><?php echo $this->session->flashdata('err_login'); ?></span>
        <hr/>
        <a href="#" class="more_bgcolor more_rounded centered" onClick="document.getElementById('formLogin').submit();">LOGIN</a>
        </form>
    <? }?>
    </div>
   <!--
    <h3 class="lefthead">Link Terkait</h3>
    <div class="leftbox grd">
        <ul class="borderedlist">
            <?
                $numItems = count($links);
                $i = 0;
                foreach ($links->result() as $link){
            ?>
                <li class="<?=(++$i === $numItems)?'last':'';?>"><a href="http://<?=$link->url?>" title=""><?=$link->content_title?></a></li>
            <? }?>
        </ul>
    </div> -->
</div><!--end block left-->
