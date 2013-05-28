<div id="header">
<div id="header-top">
            	<div id="top-block-left">
                	<p>You are signed in as: <?=$this->session->userdata('full_name')?></p>
                </div>
                <ul id="top-toolbox">
                	<!--<li><a href="#" id="settings-link">Settings</a></li>
					<li><a href="#" id="profile-link">Edit Profile</a></li> -->
                    <li><a href="<?=base_url()?>login/logout_user" id="logout-link">Logout</a></li>
                </ul>
                <div class="clear"></div>
            </div>
            <div id="header-middle">
           		<a href="#" id="logo">Senator Indonesia Admin</a>
            </div>
            <!-- Top Menu -->
            <div id="menu">
            	<ul class="topnav">
					<li  id="active-item"><a href="#" id="menu-home">Home</a>
					<!-- Dropdown Part -->
                        <ul class="subnav">
	                    <li><a href="<?php echo base_url()?>admin/about" id="fixed-layout">About</a></li>
	                    <li><a href="<?php echo base_url()?>admin/contact" id="fixed-layout">Contact Us</a></li>
	                    <li><a href="<?php echo base_url()?>admin/partners" id="fixed-layout">Partner</a></li>
	                    <li><a href="<?php echo base_url()?>admin/gallery" id="fixed-layout">Gallery</a></li>
	                    
					</ul>
					</li>
                    <li><a href="<?php echo base_url()?>admin/event" id="menu-event">Event</a></li>
                    <li><a href="<?php echo base_url()?>admin/category/sub" id="menu-asset">Sub Category</a></li>
                    <li><a href="<?php echo base_url()?>admin/content/sub" id="menu-asset">Sub Content</a></li>
					<li><a href="#" id="menu-layout">Content</a>
                        <!-- Dropdown Part -->
                        <ul class="subnav">
                            <li><a href="<?php echo base_url()?>admin/content/index/<?=CAT_HOTNEWS;?>" id="fixed-layout">Hot News</a></li>
                            <li><a href="<?php echo base_url()?>admin/content/index/<?=CAT_HUBUNGAN;?>" id="fixed-layout">Hub. Pusat & Daerah</a></li>
                            <li><a href="<?php echo base_url()?>admin/content/index/<?=CAT_ABOUT_LAW;?>" id="fixed-layout">About Law Center</a></li>
                            <li><a href="<?php echo base_url()?>admin/content/index/<?=CAT_DOKUMEN;?>" id="fixed-layout">Dokumen</a></li>
                            <li><a href="<?php echo base_url()?>admin/content/index/<?=CAT_QUICKFAQ;?>" id="fixed-layout">Quick Faq</a></li>
                           
                        </ul>
                        <!-- End Dropdown Part -->
                    </li>
					 <li class="right"><a href="<?php echo base_url()?>admin/users" id="menu-users">Users</a></li>
                    <!--<li class="right"><a href="themes.html" id="menu-theme">Themes</a></li>
                    <li class="right" id="last"><a href="#" id="menu-layout">Layouts</a>
                        <!-- Dropdown Part -->
                        <!--<ul class="subnav">
                            <li><a href="#" id="fixed-layout">Fixed Layout</a></li>
                            <li><a href="#" id="liquid-layout">Liquid Layout</a></li>
                        </ul>
                        <!-- End Dropdown Part -->
                    </li>
                </ul>
		  	</div>
            <!-- END Menu -->
			
			 </div>