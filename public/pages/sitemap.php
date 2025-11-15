<!-- top영역끝 -->

<!-- 상단이미지 영역시작 -->
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
<div id="SITEMAP_IMG">
    <div id="SITEMAP">
    	<img src="/public/assets/images/sitemap_img.png"/>
    </div>
</div>
<!--TOP IMG 영역 끝-->
<!-- 상단이미지 영역끝 -->

<!-- 서브메뉴 영역시작 -->
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
    	
        <li class="smenu_basic"><a href="../index.html">HOME</a>
        	<ul class="sub">
            </ul>
        </li>
        
        <div class="h_line"></div>
        
        
        <li class="smenu_basic"><a href="sitemap.html"><strong>사이트맵</strong></a>
        	        </li>
         
       
        
    </ul>
    </div>
    <div id="w_line">
    </div>
</div>
<!--SUB MENU 영역 끝-->
<!-- 서브메뉴 영역끝 -->

<!--SITEMAP 영역 시작-->
<div id="sitemap_board">
	<div id="sitemap_container">
    	<div id="sitemap_title">
        후레쉴드 사이트맵
        </div>
        <div id="sitemap_area">
        	<div id="sitemap_Wline"></div>
            <div id="sitemap_box">
            	<div class="Smap_box1">
                    <div class="Smap_menu">
                    브랜드
                    </div>
                        <div class="Smap_Smenu">
                        <a href="../introduction/brandstory.html">브랜드 소개</a>
                        </div>
                        <div class="Smap_Smenu">
                        <a href="../introduction/certification.html">인증 현황</a>
                        </div>
                </div>
                
                <div class="Smap_box1">
                    <div class="Smap_menu">
                    후레쉴드
                    </div>
                        <div class="Smap_Smenu">
                        <a href="../product/1outdoor.html">진공포장기</a>
                        </div>
                        <div class="Smap_Smenu">
                        <a href="../product/5genisys.html">진공용기</a>
                        </div>
                         <div class="Smap_Smenu">
                        <a href="../product/7rollbag.html">진공비닐</a>
                        </div>
                </div>
                <div class="Smap_box2">
                    <div class="Smap_menu">
                    제품사용 TIP
                    </div>
                        <div class="Smap_Smenu">
                        <a href="#">활용 TIP</a>
                        </div>
                        <div class="Smap_Smenu">
                        <a href="#">블로그 후기</a>
                        </div>
                </div>
                <div class="Smap_box1">
                    <div class="Smap_menu">
                    고객센터
                    </div>
                        <div class="Smap_Smenu">
                        <a href="../board/FAQ.html">FAQ</a>
                        </div>
                        <div class="Smap_Smenu">
                        <a href="../board/manual.html">사용설명서</a>
                        </div>
                </div>
                
                <div class="Smap_box1">
                    <div class="Smap_menu">
                    B2B
                    </div>
                        <div class="Smap_Smenu">
                        <a href="../business/b2b.html">B2B 문의</a>
                        </div>
                </div>
                <div class="Smap_box2">
                    <div class="Smap_menu">
                    ENGLISH
                    </div>
                        <div class="Smap_Smenu">
                        <a href="javascript:;" onClick="required_lang.change('kr')">한글 사이트</a>
                        </div>
                        <div class="Smap_Smenu">
                        <a href="javascript:;" onClick="required_lang.change('en')">영문 사이트</a>
                        </div>
                </div>
            </div>
        </div>
    </div>

</div>

















<!--
    <div class="sub_box">
  <div id="content">
    <div id="subtitle">
    <h2 class="tit">SITEMAP<span>&nbsp;&nbsp;홈페이지를 방문해 주셔서 감사합니다.</span></h2>
      <ul class="subtitle01_1">
        <li><img src="/public/assets/images/bul_h.gif" alt="home" /> <span class="subtitle">Home <img src="/public/assets/images/location.gif" alt="" /> <strong>SITEMAP</strong></span></li>
      </ul>
    </div>
      <div id="sub_content">
	  <div class="blank30">
	  <div class="sitebox" style="margin-right: 16px;">
			<ul>
				<li class="sb_title">회사소개</li>
				<li class="sb_menu"><a href="/introduction/foodone">푸드원 (Food One)</a></li>
				<li class="sb_menu"><a href="/introduction/greetings">CEO 인사말</a></li>
				<li class="sb_menu"><a href="/introduction/history">연혁</a></li>
				<li class="sb_menu"><a href="/introduction/map">찾아오시는 길</a></li>
			</ul>
		</div>
		
		<div class="sitebox" style="margin-right: 16px;">
			<ul>
				<li class="sb_title">사업소개</li>
				<li class="sb_menu"><a href="/business/business">사업소개</a></li>
				<li class="sb_menu"><a href="/business/product">제품소개</a></li>
				<li class="sb_menu"><a href="/business/store">푸드원몰</a></li>
				
			</ul>
		</div>
		
		<div class="sitebox" style="margin-right: 16px;">
			<ul>
				<li class="sb_title">홍보센터</li>
				<li class="sb_menu"><a href="/pr/notice">공지사항</a></li>
				<li class="sb_menu"><a href="/pr/community">커뮤니티</a></li>
				
			</ul>
		</div>
		
		<div class="sitebox">
			<ul>
				<li class="sb_title">인재채용</li>
				<li class="sb_menu"><a href="/careers/talent">인재상</a></li>
				<li class="sb_menu"><a href="/careers/procedures">채용절차</a></li>
				<li class="sb_menu"><a href="/careers/notification">채용공고</a></li>
				<li class="sb_menu"><a href="/careers/inquiry">채용문의</a></li>
			</ul>
		</div>
		
	  
	  </div>
	  
	  <div class="end_box">
	  <div class="sitebox" style="margin-right: 17px;">
			<ul>
				<li class="sb_title">사회공헌</li>
				<li class="sb_menu"><a href="/social/social">사회공헌 활동</a></li>
				
			</ul>
		</div>
		
	  
	  
	  </div>
	  

      </div>
  </div>  

  -->
  
  <!-- left영역시작
<div id="mainNav">
    <div id="left_menu">
      <h2 class="tit"><span>SITEMAP</span>사이트맵</h2>
      <ul class="left_sub0">
        <li class="left_menu01_1"><a href="/sitemap/sitemap">SITEMAP</a></li>
    </ul>
	  
	  
    </div>
  </div>
 
  
  </div> -->
 
<!-- bottom 레이아웃 파일-->