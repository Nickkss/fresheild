<!-- top영역끝 -->

<!-- 서브이미지 영역시작 -->
<!--TOP IMG 영역 시작-->
<div id="TOP_IMG">
    <div id="BRANDSTORY">
    	<img src="/public/assets/images/cerification_top.png"/>
    </div>
</div>
<!--TOP IMG 영역 끝-->
<!-- 서브이미지 영역끝 -->

 
<!-- sub menu 영역시작 -->
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
        
        
        <li class="smenu_basic"><a href="brandstory.html">브랜드</a>
       <!-- 	<ul class="sub">
                <li><a href="/product/1outdoor">후레쉴드</a></li>
                <li><a href="/board/tip01">제품사용TIP</a></li>
                <li><a href="/board/FAQ">고객센터</a></li>
                <li><a href="/business/b2b">B2B</a></li>
            </ul>-->
        </li>
         
         <div class="h_line"></div>
         
        <li class="smenu_basic"><a href="certification.html"><strong>인증현황</strong></a>
        	<ul class="sub">
                <li><a href="brandstory.html">브랜드소개</a></li>
            </ul>
        </li>
        
    </ul>
    </div>
    <div id="w_line">
    </div>
</div>
<!--SUB MENU 영역 끝-->
<!-- sub menu 영역끝 -->



<!--BRANDSTORY 영역 시작-->
<div id="CERTIFICATION">
	<div id="info_certification">
    	
        <div id="certification_title">
        	Freshield 진공관련 특허현황
        </div>
        
        <div id="certification_img">
   			<img src="/public/assets/images/cerification_img.png"/>
        </div>
        
        
        
    </div>
</div>


 
<!--BRANDSTORY 영역 끝-->
  
  </div>
 
<!-- bottom 레이아웃 파일-->