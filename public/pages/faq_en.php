<?php
/**
 * FAQ Page - English Version
 * Integrated with database in Phase 2
 */
require_once __DIR__ . '/../includes/db.php';

// Fetch English FAQs from database
$faqs = getFaqsByLanguage('en');
?>

<!-- top메뉴영역끝 -->

<!-- top영역시작 -->
<script type="text/javascript" src="/public/assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("ul.sub").hide(); /*서브메뉴 sub를 안보이게*/
		$(".smenu_basic").hover(function(){ /*li에 마우스 오버시*/
			$("ul:not(:animated)",this).slideDown("fast"); /*애니메이션 되지안는건 내리고*/
		},
		function(){
			$("ul",this).slideUp("fast");/*애니메이션 된건 올리고*/
		});
	});
</script>


<!--TOP IMG 영역 시작-->
<div id="FAQ_IMG">
    <div id="FAQ">
    	<img src="/public/assets/images/FAQ_img.png"/>
    </div>
</div>
<!--TOP IMG 영역 끝-->
<!-- top영역끝 -->


<!-- 서브이미지 영역시작 -->
<script type="text/javascript" src="/public/assets/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	$(function(){
		$("ul.sub").hide(); /*서브메뉴 sub를 안보이게*/
		$(".smenu_basic").hover(function(){ /*li에 마우스 오버시*/
			$("ul:not(:animated)",this).slideDown("fast"); /*애니메이션 되지안는건 내리고*/
		},
		function(){
			$("ul",this).slideUp("fast");/*애니메이션 된건 올리고*/
		});
	});
</script>


<!--SUB MENU 영역 시작-->
<div id="SUBMENU">
	<div id="container">
    <ul class="smenu">

        <li class="smenu_basic"><a href="../EN_main.html">HOME</a>
        	<ul class="sub">
            </ul>
        </li>

        <div class="h_line"></div>


        <li class="smenu_basic"><a href="EN_FAQ.html">SUPPORT</a>
        <!--	<ul class="sub">
                <li><a href="/introduction/brandstory">브랜드</a></li>
                <li><a href="/product/freshield">후레쉴드</a></li>
                <li><a href="/board/tip01">제품사용TIP</a></li>

            </ul>-->
        </li>

         <div class="h_line"></div>

        <li class="smenu_basic"><a href="EN_FAQ.html"><strong>FAQ</strong></a>
       	<ul class="sub">
             <li><a href="EN_manual.html">DOWNLOADS</a></li>
         </ul>
        </li>

    </ul>
    </div>

</div>
<!--SUB MENU 영역 끝-->
<!-- 서브이미지 영역끝 -->




<!--FAQ 영역 시작-->
<div id="faq_board">
	<div id="w_line"></div>
    <div id="faq_container">
    	<div id="faq_title">
        Frequently asked questions
        </div>

        <div id="faq_area">
        	<div id="w_line"></div>

            <?php if (empty($faqs)): ?>
                <!-- No FAQs available message -->
                <div class="faq_Q">
                    <p style="text-align:center; padding: 30px; color: #666;">
                        No FAQs available at this time.<br>
                        FAQs will be updated soon.
                    </p>
                </div>
                <div id="w_line"></div>
            <?php else: ?>
                <!-- Dynamic FAQ entries from database -->
                <?php foreach ($faqs as $index => $faq): ?>
                    <div class="faq_Q">
                        <a onclick="this.nextSibling.style.display=(this.nextSibling.style.display=='none')?'block':'none';">
                            <b>Q<?php echo ($index + 1); ?>. <?php echo sanitizeOutput($faq['question']); ?></b>
                        </a>
                        <div class="faq_A" style="display:none;">
                            <ul>
                                <?php echo nl2br(sanitizeOutput($faq['answer'])); ?>
                            </ul>
                        </div>
                    </div>
                    <div id="w_line"></div>
                <?php endforeach; ?>
            <?php endif; ?>



        </div>
    </div>
</div>

<!-- bottom 레이아웃 파일-->
