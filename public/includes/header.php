<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo isset($lang) ? $lang : 'ko'; ?>" xml:lang="<?php echo isset($lang) ? $lang : 'ko'; ?>">
<head>
<title>후레쉴드 |  freshield.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- CSS -->
<link href="/public/assets/css/_style.css" rel="stylesheet">
<link href="/public/assets/css/style.css" rel="stylesheet">
<link href="/public/assets/css/main_menu.css" rel="stylesheet">
<link href="/public/assets/css/main_layout.css" rel="stylesheet">
<link href="/public/assets/css/main_slide.css" rel="stylesheet">
<link href="/public/assets/css/brandstory.css" rel="stylesheet">
<link href="/public/assets/css/sub_menu.css" rel="stylesheet">
<link href="/public/assets/css/product.css" rel="stylesheet">
<link href="/public/assets/css/manual.css" rel="stylesheet">
<link href="/public/assets/css/b2b.css" rel="stylesheet">
<link href="/public/assets/css/sitemap.css" rel="stylesheet">
<link href="/public/assets/css/tip.css" rel="stylesheet">
<link href="/public/assets/css/FAQ.css" rel="stylesheet">
<link href="/public/assets/css/freshield_menu.css" rel="stylesheet" type="text/css">
<link href="/public/assets/css/intro_slide.css" rel="stylesheet">
<link rel="stylesheet" href="/public/assets/css/photo.css" type="text/css">

<!-- JS -->
<script type="text/javascript" src="/public/assets/js/active.js"></script>
<script type="text/javascript" src="/public/assets/js/jquery.js"></script>
<script type="text/javascript" src="/public/assets/js/jquery-1.7.2.min.js"></script>
<script src="/public/assets/js/main_bn.js"></script>

<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Merienda:400,700">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" language="javascript" charset="utf-8" src="/public/assets/js/nav.js"></script>

<style type="text/css">
img {border:0px none; float:left;}
a:link {text-decoration: none;}
a:visited {text-decoration: none;}
a:hover {text-decoration: none;}
a:active {text-decoration: none;}
</style>

<script type="text/javascript" src="http://errdoc.gabia.io/404.html"></script>
<script type="text/javascript" src="/public/assets/js/jquery.banner.js"></script>
<script type="text/javascript">
<!--
$(function() {
	$("#INTRO_IMG_BOX").jQBanner({
		nWidth:980,
		nHeight:745,
		nCount:2,
		isActType:"left",
		nOrderNo:1,
		isStartAct:"N",
		isStartDelay:"Y",
		nDelay:5000,
		isBtnType:"img"});
});
//-->
</script>

<script>
var lang_client = {
}
</script>
<script>
var required_lang = {
	getHref:function(lang) {
		var href = window.location.href.split('?');
		var domain = href[0];
		var queryString =  href[1];
		var decode = Ext.urlDecode(queryString);
		Ext.apply(decode,{lang:lang});
		return domain+'?'+Ext.urlEncode(decode);
	},
	change: function(lang) {
		var href = this.getHref(lang);
		document.location.href=href
	}
}
</script>

<script>
$(".slides").poposlides();
</script>

<script type="text/javascript" src="/public/assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("ul.sub").hide();
		$(".smenu_basic").hover(function(){
			$("ul:not(:animated)",this).slideDown("fast");
		},
		function(){
			$("ul",this).slideUp("fast");
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$("ul.sub").hide();
		$(".smenu_long").hover(function(){
			$("ul:not(:animated)",this).slideDown("fast");
		},
		function(){
			$("ul",this).slideUp("fast");
		});
	});
</script>

<meta http-equiv="X-UA-Compatible" content="IE=10" />
<meta http-equiv='imagetoolbar' content='no' >
<link rel="stylesheet" type="text/css" href="/public/assets/css/ext-all.css">
<link rel="stylesheet" type="text/css" href="/public/assets/css/common.css">
<script type="text/javascript" src="/public/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/assets/js/ext-jquery-adapter.js"></script>
<script type="text/javascript" src="/public/assets/js/ext-all-3.js"></script>
<script type="text/javascript" src="/admin/lang/kr/lang.js"></script>
<script type="text/javascript" src="/public/assets/js/common.js"></script>
<!--[if lt IE 9]>
  <script src="https://html5shim.googlecode.com/svn/trunk/html5.html"></script>
<![endif]-->

</head>
<body id="main">

<!--TOP 영역 시작-->
<div id="TOP">
<div id="TOPMENU">
	<div class="LOGO"><a href="<?php echo isset($is_english) && $is_english ? '/en_index.php' : '/index.php'; ?>"><img src="/public/assets/images/top_logo.png"></a></div>
    <div class="MENULIST">
    	<?php if(isset($is_english) && $is_english): ?>
    	<!-- English Menu -->
    	<div class="MENU_EN">
            <ul class="oneMenu_EN">
            	<li><a href="/public/pages/brandstory_en.php">BRAND</a></li>

                <li><a href="/public/pages/product_freshield_en.php">PRODUCTS</a>
                    <ul class="twoMenu_EN">
                    	<li><a href="/public/pages/product_freshield_en.php">Vacuum sealers</a>
                            <ul class="threeMenu1_EN">
                                <li style="border-top:1px solid #E4E4E4; height:41px;">
                                	<a href="/public/pages/product_outdoor1_en.php">OUTDOOR</a>
                                </li>
                                 <li style="border-left:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_advance_en.php">ADVANCE</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; height:42px;border-bottom:1px solid #E4E4E4;">
                                	<a href="/public/pages/product_elite_en.php">ELITE</a>
                                </li>
                        	</ul>
                        </li>
                        <li><a href="/public/pages/product_genisys_en.php">Canisters</a>
                        	<ul class="threeMenu2_EN">
                                <li style="border-top:1px solid #E4E4E4;  height:43px;">
                                	<a href="/public/pages/product_genisys_en.php">GENISYS</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; border-bottom:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_handpump_en.php">HAND PUMP</a>
                                </li>
                        	</ul>
                        </li>
                        <li><a href="/public/pages/product_rollbag_en.php">Rolls ＆ Bags</a>
                        	<ul class="threeMenu3_EN">
                                <li style="border-top:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_rollbag_en.php">Rolls ＆ Bags</a>
                                </li>
                                <li style="border-bottom:1px solid #E4E4E4; border-left:1px solid #E4E4E4; height:42px;">
                                	<a href="#">Wizvac Plus</a>
                                </li>
                        	</ul>
                        </li>
                      </ul>
                </li>
                <li><a href="/public/pages/tip_en.php">TIPS</a></li>
                <li><a href="/public/pages/faq_en.php">SUPPORT</a>
                	<ul class="twoMenu_EN">
                    	<li><a href="/public/pages/faq_en.php">FAQ</a></li>
                        <li><a href="/public/pages/manual_en.php">Downloads</a></li>
                    </ul>
                </li>
                <li><a href="mailto:freshield@freshield.com">CONTACT</a></li>
                <li><a href="#">LANGUAGE</a>
                	<ul class="twoMenu_EN">
                    	<li><a href="/index.php">한국어</a></li>
                        <li><a href="/en_index.php">ENGLISH</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php else: ?>
        <!-- Korean Menu -->
        <div class="MENU">
            <ul class="oneMenu">
            	<li><a href="/public/pages/brandstory.php">브랜드</a>
                	<ul class="twoMenu">
                    	<li><a href="/public/pages/brandstory.php">브랜드소개</a></li>
                        <li><a href="/public/pages/certification.php">인증현황</a></li>
                    </ul>
                </li>

                <li><a href="/public/pages/product_freshield.php">후레쉴드</a>
                    <ul class="twoMenu">
                    	<li><a href="/public/pages/product_freshield.php">진공포장기</a>
                            <ul class="threeMenu1">
                                <li style="border-top:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_outdoor4.php">아웃도어</a>
                                </li>
                                 <li style="border-left:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_advance.php">어드밴스</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; height:42px;border-bottom:1px solid #E4E4E4;">
                                	<a href="/public/pages/product_elite.php">엘리트</a>
                                </li>
                        	</ul>
                        </li>
                        <li><a href="/public/pages/product_genisys.php">진공용기</a>
                        	<ul class="threeMenu2">
                                <li style="border-top:1px solid #E4E4E4;  height:43px;">
                                	<a href="/public/pages/product_genisys.php">제니시스</a>
                                </li>
                                <li style="border-left:1px solid #E4E4E4; border-bottom:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_handpump.php">핸드펌프</a>
                                </li>
                        	</ul>
                        </li>
                        <li><a href="/public/pages/product_rollbag.php">롤＆백</a>
                        	<ul class="threeMenu3">
                                <li style="border-top:1px solid #E4E4E4; height:42px;">
                                	<a href="/public/pages/product_rollbag.php">롤＆백</a>
                                </li>
                                <li style="border-bottom:1px solid #E4E4E4; border-left:1px solid #E4E4E4; height:42px;">
                                	<a href="#">위즈백 플러스</a>
                                </li>
                        	</ul>
                        </li>
                      </ul>
                </li>
                <li><a href="/public/pages/tip.php">활용 TIP</a></li>
                <li><a href="/public/pages/faq.php">고객지원</a>
                	<ul class="twoMenu">
                    	<li><a href="/public/pages/faq.php">FAQ</a></li>
                        <li><a href="/public/pages/manual.php">자료실</a></li>
                    </ul>
                </li>
                <li><a href="mailto:freshield@freshield.com">문의하기</a></li>
                <li><a href="#">언어선택</a>
                	<ul class="twoMenu">
                    	<li><a href="/index.php">한국어</a></li>
                        <li><a href="/en_index.php">ENGLISH</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>
</div>
<!--TOP 영역 끝-->
