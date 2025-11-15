<!-- top영역끝 -->

<!-- 서브이미지 영역시작 -->
<!--TOP IMG 영역 시작-->
<div id="HANDPUMP">
    <div id="handpump_top">
    	<img src="/public/assets/images/handpump_img.png"/>
    </div>
</div>
<!--TOP IMG 영역 끝-->
<div id="w_line"></div>
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
        
        
        <li class="smenu_basic"><a href="1outdoor.html">후레쉴드</a>
        <!--	<ul class="sub">
                <li><a href="/introduction/brandstory">브랜드</a></li>
                <li><a href="/board/tip01">제품사용TIP</a></li>
                <li><a href="/board/FAQ">고객센터</a></li>
                <li><a href="/business/b2b">B2B</a></li>
            </ul>-->
        </li>
         
         <div class="h_line"></div>
         
        <li class="smenu_basic"><a href="5genisys.html">진공용기</a>
        	<ul class="sub">
                <li><a href="1outdoor.html">진공포장기</a></li>
                <li><a href="7rollbag.html">진공비닐</a></li>
            </ul>
        </li>
        
        <div class="h_line"></div>
         
        <li class="smenu_basic"><a href="6handpump.html"><strong>핸드펌프</strong></a>
        	<ul class="sub">
                <li style=""><a href="5genisys.html">제니시스</a></li>
               </ul>
        </li>
        
    </ul>
    </div>
    <div id="w_line">
    </div>
</div>
        	

<!--SUB MENU 영역 끝-->
<!-- sub menu 영역끝 -->


<!--HAND PUMP 영역 시작-->
<div id="HANDPUMP_INFO">
	

	<div id="handpump_info1">
    	<div class="info1_handpump">
        	<div class="Tinfo1_handpump">
            야외에서도 쉽게! 후레쉴드 핸드펌프 
            </div>
    		<img src="/public/assets/images/handpump_info1.png"/>
        </div>
    </div>
    
    <div id="handpump_info2">
    	<div class="info2_handpump">
        	<div class="Tinfo2_handpump1">
            간편한 사용법, 활용도 높은 핸드펌프
            </div>
    		<img src="/public/assets/images/handpump_info2.png"/>
            <div class="Tinfo2_handpump2">
            후레쉴드 진공용기와 위즈백 플러스 지퍼백에 호환 가능한 핸드펌프는 몇 번의 펌프질로 쉽게 진공 포장을  할 수 있습니다.
실내는 물론 야외에서도 진공포장을 할 수 있고, 심플한 디자인과 작은 사이즈로 휴대하거나 보관 할 때 좋습니다.
            
            </div>
        </div>
    </div>
    
    
    
    <div id="handpump_info3">
    	<div class="info3_handpump">
        	<div class="Tinfo3_handpump">
            후레쉴드 핸드펌프 자세히보기
            </div>
       
            <div id='wrapper'>

			<div id="bigPic">
				<img src="/public/assets/images/handpump_bigimg_1.jpg" alt="" />
                <img src="/public/assets/images/handpump_bigimg_2.jpg" alt="" />
                <img src="/public/assets/images/handpump_bigimg_3.jpg" alt="" />
                <img src="/public/assets/images/handpump_bigimg_4.jpg" alt="" />

			</div>
			
			<div id="sPic2">
			<ul id="thumbs2">
				<li class='active' rel='1'>
                	<img src="/public/assets/images/handpump_simg_1.jpg" onMouseOver="this.src='/public/assets/images/handpump_aimg_1.jpg'" onMouseOut="this.src='/public/assets/images/handpump_simg_1.jpg'" alt="" />
                </li>
				<li rel='2'>
                	<img src="/public/assets/images/handpump_simg_2.jpg" onMouseOver="this.src='/public/assets/images/handpump_aimg_2.jpg'" onMouseOut="this.src='/public/assets/images/handpump_simg_2.jpg'" alt="" />
                </li>
				<li rel='3'>
                	<img src="/public/assets/images/handpump_simg_3.jpg" onMouseOver="this.src='/public/assets/images/handpump_aimg_3.jpg'" onMouseOut="this.src='/public/assets/images/handpump_simg_3.jpg'" alt="" />
                </li>
				<li rel='4'>
                	<img src="/public/assets/images/handpump_simg_4.jpg" onMouseOver="this.src='/public/assets/images/handpump_aimg_4.jpg'" onMouseOut="this.src='/public/assets/images/handpump_simg_4.jpg'" alt="" />
                </li>
				
                
			</ul>
            </div>
	


		<script type="text/javascript">
	var currentImage;
    var currentIndex = -1;
    var interval;
    function showImage(index){
        if(index < $('#bigPic img').length){
        	var indexImage = $('#bigPic img')[index]
            if(currentImage){   
            	if(currentImage != indexImage ){
                    $(currentImage).css('z-index',2);
                    clearTimeout(myTimer);
                    $(currentImage).fadeOut(250, function() {
					    myTimer = setTimeout("showNext()", 20000);
					    $(this).css({'display':'none','z-index':1})
					});
                }
            }
            $(indexImage).css({'display':'block', 'opacity':1});
            currentImage = indexImage;
            currentIndex = index;
            $('#thumbs2 li').removeClass('active');
            $($('#thumbs2 li')[index]).addClass('active');
        }
    }
    
    function showNext(){
        var len = $('#bigPic img').length;
        var next = currentIndex < (len-1) ? currentIndex + 1 : 0;
        showImage(next);
    }
    
    var myTimer;
    
    $(document).ready(function() {
	    myTimer = setTimeout("showNext()", 3000);
		showNext(); //loads first image
        $('#thumbs2 li').bind('click',function(e){
        	var count = $(this).attr('rel');
        	showImage(parseInt(count)-1);
        });
	});
    
	
	</script>	
        
  

			


	</div>
    		
        </div>
    </div>
    
    <div id="handpump_info4">
    	<div class="info4_handpump">
    		    	<div class="info6_outdoor1"> 
        	<div class="info6_outdoor1_IMG" style="float:left; width:475px;height:335px; margin-left:58px; margin-top:40px;">
             <img src="/public/assets/images/EN_handpump_info4.png"/>
            </div>
            <div class="info6_outdoor1_text" style=" float:left; width:390px; height:290px; margin-top:90px;">
           	<div style="font-family:Nanum Gothic; font-size:20px; font-weight:bold; padding:15px 10px 10px; color:#5b5b93; text-align:left;">SPECIFICATIONS</div>
           	<div style="width:100%; height:35px; background:#bfbfbf; line-height:35px; text-align:center; font-family:Dotum; font-weight:bold; font-size:15px; color:#676767;">Freshield Hand Pump</div>
           	<div>
           		<div class="spec_title" style="width:145px;">모델명</div>
                <div class="sepc_text">후레쉴드 핸드펌프</div>
           	</div>
            <div>
           		<div class="spec_title" style="width:145px;">타  입</div>
                <div class="sepc_text">수 동</div>
           	</div>
            <div>
           		<div class="spec_title1" style="text-align:left; border-right:#ccc 1px solid; border-bottom:#ccc 1px solid; height:64px; width:145px; line-height:32px; font-family:Dotum; font-size:13px; font-weight:bold; float:left; padding-left:12px; color:#676767;">호  환</div>
                <div class="sepc_text1" style="border-bottom:#ccc 1px solid; height:64px; text-align:left; width:220px; line-height:32px; font-family:Dotum; font-size:13px; float:left; padding-left:12px;">후레쉴드 진공용기 (제니시스)<br/>후레쉴드 위즈백 플러스</div>
           	</div>
            
            	
            </div>          
        	
        </div>

        </div>
    </div>

    
 
    
    
</div>


<!--HAND PUMP 영역 끝-->
  </div>
 
<!-- bottom 레이아웃 파일-->