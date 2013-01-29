<?php
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));

$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}


    
echo $OUTPUT->doctype() ?>


<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>

<!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="http://www.wosc.edu/uploads/moodle/ie7fix2x.css" />
<![endif]-->

<link rel="stylesheet" media="print" type="text/css" href="http://moodle.wosc.edu/theme/simplespace/style/woscprint.css" />

<!-- 	<script src="http://www.wosc.edu/js/jquery.min.js" type="text/javascript"></script> -->

</head>

<body id="<?php echo $PAGE->bodyid ?>" class="<?php echo $PAGE->bodyclasses.' '.join(' ', $bodyclasses) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

<div id="header-wrap"><div id="page-header"></div>
	<div id="header-container">
		<div id="header-inner">
			
			<div id="headleft">
<!--		<?php if ($hasheading) {
		echo $PAGE->heading;
		}
		?> -->
			</div>
			<div id="headright">
<!--			<?php
			
			 if ($hascustommenu) { ?>
 <div id="custommenu"><?php echo $custommenu; ?></div>
<?php } 			?>-->
			</div>
			
		</div>
	</div>
</div>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<!-- ########################################### -->
<!-- ########################################### -->
<!-- ################ Start Header ############# -->
<!-- ########################################### -->
<!-- ########################################### -->

<div class="headwrap">
<div class="headwrap-bottom">

 <span class="headleft-time">Pioneer Time (CST): &nbsp; <strong><?=date("h:ia - F d Y")?></strong></span>

        <div class="container_12 header">

        <div class="grid_8 logo">

<div style="float:left;margin: -3px 0 -8px -28px;"><img title="WOSC Home Page" alt="WOSC Webpage Logo Header" src="http://www.wosc.edu/img/2xheader-seal.png" align="left">
<img title="WOSC Home Page" alt="WOSC Webpage Logo Header" style="margin: 5px 0 0 -8px;" src="http://www.wosc.edu/img/2xheader-name.png" align="left"></div>

        </div><!-- /grid_8 logo -->



        <div class="grid_4 last h-details">

                <div class="logged-in">

        <span class="toprightlinks logout">
		<!--<?php
        echo $OUTPUT->login_info();
        ?> --></span>

            </div> <!-- /logged-in-->

</div> <!-- /grid_4 last h-details -->

        <div class="container_12 nav">

    <?php
  include("$CFG->dirroot/theme/simplespace/wosctopmenu.php");
     ?>

        </div><!-- /container_12 nav -->

    </div><!-- /container_12 header -->

</div><!-- /headwrap -->


<!-- ########################################### -->
<!-- ################ PAS ALERT ################ -->
<!--
<style type="text/css">
div#alert{background: red;color: black;margin: -12px 12px 0px 12px;-moz-box-shadow:4px 3px 6px rgba(0,0,0,0.5);-webkit-border-radius:5px;-webkit-box-shadow:4px 3px 6px rgba(0,0,0,0.5);border-bottom:0px solid rgba(0,0,0,0.25);  -moz-border-radius-topleft: 7px;  -moz-border-radius-topright: 7px;  -webkit-border-top-left-radius: 7px;  -webkit-border-top-right-radius: 7px;  -moz-border-radius-bottomleft: 7px;  -moz-border-radius-bottomright: 7px;  -webkit-border-bottom-left-radius: 7px;  -webkit-border-bottom-right-radius: 7px;
}
div#notice{background: #FDB813;margin: -12px 12px 0px 12px;color: black;z-index:1;-moz-box-shadow:4px 3px 6px rgba(0,0,0,0.5);-webkit-border-radius:5px;-webkit-box-shadow:4px 3px 6px rgba(0,0,0,0.5);border-bottom:0px solid rgba(0,0,0,0.25);  -moz-border-radius-topleft: 7px;  -moz-border-radius-topright: 7px;  -webkit-border-top-left-radius: 7px;  -webkit-border-top-right-radius: 7px;  -moz-border-radius-bottomleft: 7px;  -moz-border-radius-bottomright: 7px;  -webkit-border-bottom-left-radius: 7px;  -webkit-border-bottom-right-radius: 7px;
}
</style>


<table style="margin: 0px auto 2px auto;" width="100%"><tbody><tr align="center"><td>
 <div id="alert" style="padding: 10px 12px 5px;"><strong><font style="float: right;" size="1" color="yellow"><blink><em>
ALERT</em></blink></font>
<font style="float: left;" size="1" color="yellow"><blink><em>
ALERT</em></blink></font>
<font size="2" color="white"><em><div  style="margin: -5px 0pt 5px;">

This is a test of the Pioneer Alert System. &nbsp; | &nbsp; TEST ONLY A TEST

</font></em></div></strong>
 </div></td></tr></tbody></table>
-->

<!-- ########################################### -->
<!-- ########################################### -->
<!-- ################ Start Main ############### -->
<!-- ########################################### -->
<!-- ########################################### -->


<div id="textcontainer-wrap%">
<div id="textcontainer">
<div class="thetitle%">
<div class="innertitle%">

 </div>
</div>
<div class="rightinfo">
<?php
 echo "<div class='innerrightinfo'>";
                    if (isloggedin())
                    {
 			echo ''.$OUTPUT->user_picture($USER, array('size'=>65)).'';
 			}
 			else {
 			?>
 			<img class="userpicture" src="<?php echo $CFG->wwwroot .'/theme/'. current_theme().'/pix_core/u/f1.png' ?>" />
 			<?php
 			}
	    echo "<div class='user'>";
            echo $OUTPUT->login_info();
            echo "</div>";
	    echo $OUTPUT->lang_menu();
            echo $PAGE->headingmenu;
       		echo"<div class=\"ppin\"></div>";
       echo "</div>";
       ?>

</div>
</div>
</div>

<div id="ie6-container-wrap">
	<div id="container">
	
	<div id="johncontrols">
	<div class="johncontrolsleft">
		<?php if ($hasnavbar) { ?>
        <div class="navbar clearfix">
            <div class="breadcrumb"> <?php echo $OUTPUT->navbar();  ?></div>
            
        </div>
        <?php } ?>
        </div>
	
	<div class="johncontrolsright">
	<?php if ($hasnavbar) {
	echo $PAGE->button;
	}
	?>
	</div>
	</div>
	
	<div id="page-content">
        <div id="region-main-box">
            <div id="region-post-box">
            
                <div id="region-main-wrap">
                    <div id="region-main">
                        <div class="region-content">
        <span class="coursehome"><strong><font color="#004000" ><a href="/course/view.php?id=<?php echo $COURSE->id ?>">Course Home - <?php echo $PAGE->heading ?></a></font></strong></span>
                            <?php echo core_renderer::MAIN_CONTENT_TOKEN ?>
                        </div>
                    </div>
                </div>
                
                <?php if ($hassidepre) { ?>
                <div id="region-pre" class="block-region">
                    <div class="region-content">
       
                        <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                    </div>
                </div>
                <?php } ?>
                <?php if ($hassidepost) { ?>
                <div id="region-post" class="block-region">
                    <div class="region-content">
                        <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                    </div>
                </div>
                <?php } ?>
                
            </div>
        </div>
    </div>
      
	
	<!-- Containers end -->
	<div class="johnclear"></div>
	</div>
</div>
	

<!-- START OF FOOTER -->
<div id="footer-wrap"><div id="page-footer"></div>
	<div id="footer-container">
		<div id="footer">
		
		 <?php if ($hasfooter) {
		 echo "<div class='johndocsleft'>";
        echo $OUTPUT->login_info();
       // echo $OUTPUT->home_link();
       // echo $OUTPUT->standard_footer_html();
        echo "</div>";
        }
        ?>
	
<!-- ######### Follow WOSC ########## -->
<p style="text-align: center;float: left; margin: 0 0 0 95px;"><span style="font-size: medium;">
<a href="http://www.youtube.com/user/WOSCPioneer/feed" target="_blank"><img title="WOSC on YouTube!" src="http://wosc.edu/uploads/icons/youtubesm.png" alt="WOSC on YouTube!" style="margin-left: 7px; margin-right: 7px; margin-top: 5px; margin-bottom: -4px;" height="18" width="18" /></a>
<a href="https://plus.google.com/u/0/b/101944146311992766861/101944146311992766861/about" target="_blank"><img title="Official Google Plus!" src="http://wosc.edu/img/icons/googleplus.gif" alt="Official Google Plus!" style="margin-left: 7px; margin-right: 7px; margin-top: 5px; margin-bottom: -4px;" height="18" width="18" /></a>
<a href="http://www.facebook.com/pages/Altus-OK/Western-Oklahoma-State-College/40937995917" target="_blank"><img title="WOSC on Facebook!" src="http://wosc.edu/uploads/icons/facebookbig.gif" alt="WOSC on Facebook!" style="margin-left: 7px; margin-right: 7px; margin-top: 5px; margin-bottom: -4px;" height="18" width="18" /></a>
<a href="http://news.wosc.edu/" target="_blank"><img title="Official WOSC Blog!" src="http://wosc.edu/img/icons/rss16x16.png" alt="Official WOSC Blog!" style="margin-left: 7px; margin-right: 7px; margin-top: 5px; margin-bottom: -4px;" height="18" width="18" /></a>
<a href="http://www.linkedin.com/company/western-oklahoma-state-college" target="_blank"><img title="WOSC on Linkedin!" src="http://wosc.edu/img/icons/linkedin.gif" alt="WOSC on Linkedin!" style="margin-left: 7px; margin-right: 7px; margin-top: 5px; margin-bottom: -4px;" height="18" width="18" /><img title="WOSC on Twitter!" src="http://wosc.edu/uploads/icons/twitterbig.gif" alt="WOSC on Twitter!" style="margin-left: 7px; margin-right: 7px; margin-top: 5px; margin-bottom: -4px;" height="18" width="18" /></a>
<br /><a href="http://wosc.edu/follow" title="View All" target="_blank"><em><span style="font-size: small;">View All Networking Sites</span></em></a>
</span></p>
<!-- ######### Follow WOSC ########## -->	
	
       
         
    <?php if ($hasfooter) { ?>
    <div class="johndocs">
      
<!--            <?php echo page_doc_link(get_string('moodledocslink')) ?> -->
<?php echo $OUTPUT->standard_footer_html() ?> 
<!-- <b>Pioneer Time:</b> <span id="servertime"></span>       		 -->

<!-- ######### Host Name ########## -->
<span style="margin:0 50px 0 0;float:left;"><a href="http://wosc.edu">WOSC.edu Home</a></span><?php 
$server = substr(gethostname(), -1);
echo "Host: $server";
?>
<!-- ######### Host Name ########## -->       
       
    </div>
    <?php } ?>
        
		</div>
	</div>
</div>




</div>
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
