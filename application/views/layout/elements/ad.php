<div id="sl_ad">
<?php if($_SERVER['SERVER_ADDR']!='::1'): ?>
<script type="text/javascript">
<!--
var s_width=document.getElementById("main");
var adUnit =document.getElementById("sl_ad");
var adWidth = s_width.offsetWidth;

/* Replace this with your AdSense Publisher ID */
google_ad_client = "ca-pub-5400903051441488";

if ( adWidth >= 728 ) {
/* Leaderboard 728x90 */
google_ad_slot = "7215435937";
google_ad_width = 728;
google_ad_height = 90;
} else if ( adWidth >= 468 ) {
/* Banner (468 x 60) */
google_ad_slot = "6719978733";
google_ad_width = 468;
google_ad_height = 60;
} else if ( adWidth >= 336 ) {
/* Large Rectangle (336 x 280) */
google_ad_slot = "7201979136";
google_ad_width = 336;
google_ad_height = 280;
} else {
google_ad_slot = "4189637134";
google_ad_width = 250;
google_ad_height = 250;
}




//-->
</script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
<?php else: ?>
<script type="text/javascript">
<!--
var s_width=document.getElementById("main");
var adUnit =document.getElementById("sl_ad");
var adWidth = s_width.offsetWidth;
adUnit.style.backgroundColor='red'

if ( adWidth >= 728 ) {
/* Leaderboard 728x90 */
adUnit.style.width = '728px';
adUnit.style.height = '90px'
} else if ( adWidth >= 468 ) {
/* Banner (468 x 60) */
adUnit.style.width = '468px';
adUnit.style.height = '60px';
} else if ( adWidth >= 336 ) {
/* Large Rectangle (336 x 280) */
adUnit.style.width = '336px';
adUnit.style.height = '60px';
} else {
adUnit.style.width  = '250px';
adUnit.style.height = '250px';
}

//-->
</script>
<?php endif ?>	
</div>