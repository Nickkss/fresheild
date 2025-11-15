<!-- top영역끝 -->

<!-- 서브이미지 영역시작 -->
<!--TOP IMG 영역 시작-->
<div id="ELITE">
    <div id="elite_top">
    	<img src="/public/assets/images/elite_img.png"/>
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
    	<li class="smenu_basic"><a href="../index.html">HOME</a></li>
        <div class="h_line"></div>
                
         
         <li class="smenu_basic"><a href="4elite.html">엘리트</a>
        	<ul class="sub">
                <li><a href="1outdoor.html">아웃도어</a></li>
                <li><a href="3advance.html">어드벤스</a></li>
            </ul>
        </li>
         
         <div class="h_line"></div>
         
        <li class="smenu_basic"><a href="4elite.html"><strong>ELITE-IV</strong></a>
        	<!--<ul class="sub">
                <li><a href="/product/2outdoor">FR-A100WG</a></li>
            </ul>-->
        </li>
        <li class="smenu_right"><a href="freshield.html"><strong>다른 카테고리보기 ▶</strong></a>
        	
        </li>
    </ul>
    </div>
    <div id="w_line">
    </div>
</div>
<!--SUB MENU 영역 끝-->
<!-- sub menu 영역끝 -->

<!--ELITE 영역 시작-->
<div id="ELITE_INFO">

	<div id="elite_info1">
    	<div class="info1_elite">
        	<div class="Tinfo1_elite">
            효율적인 후레쉴드 진공포장기
            </div>
    		<img src="/public/assets/images/elite_info1.png"/>
        </div>
    </div>
    
    <div id="elite_info2">
    	<div class="info2_elite">
        	<div class="Tinfo2_elite">
            내용물에 따른 3가지 포장방법
            </div>
    		<img src="/public/assets/images/elite_info2.png"/>
        </div>
    </div>
    
    <div id="elite_info3">
    	<div class="info3_elite">
        	<div class="Tinfo3_elite">
            다양하게 활용되는 후레쉴드
            </div>
    		<img src="/public/assets/images/elite_info3.png"/>
        </div>
    </div>
 
    <div id="elite_info4">
    	<div class="info4_elite">
        	<div class="Tinfo4_elite">
            후레쉴드 어드벤스 자세히보기
            </div>
       
            <div id='wrapper'>

			<div id="bigPic">
				<img src="/public/assets/images/elite_bigimg_1.jpg" alt="" />
                <img src="/public/assets/images/elite_bigimg_2.jpg" alt="" />
                <img src="/public/assets/images/elite_bigimg_3.jpg" alt="" />
                <img src="/public/assets/images/elite_bigimg_4.jpg" alt="" />
                <img src="/public/assets/images/elite_bigimg_5.jpg" alt="" />
                <img src="/public/assets/images/elite_bigimg_6.jpg" alt="" />
                <img src="/public/assets/images/elite_bigimg_7.jpg" alt="" />
			</div>
			
			<div id="sPic">
			<ul id="thumbs">
				<li class='active' rel='1'>
                	<img src="/public/assets/images/elite_simg_1.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_1.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_1.jpg'" alt="" />
                </li>
				<li rel='2'>
                	<img src="/public/assets/images/elite_simg_2.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_2.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_2.jpg'" alt="" />
                </li>
				<li rel='3'>
                	<img src="/public/assets/images/elite_simg_3.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_3.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_3.jpg'" alt="" />
                </li>
				<li rel='4'>
                	<img src="/public/assets/images/elite_simg_4.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_4.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_4.jpg'" alt="" />
                </li>
				<li rel='5'>
                	<img src="/public/assets/images/elite_simg_5.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_5.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_5.jpg'" alt="" />
                </li>
				<li rel='6'>
                	<img src="/public/assets/images/elite_simg_6.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_6.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_6.jpg'" alt="" />
                </li>
				<li rel='7'>
                	<img src="/public/assets/images/elite_simg_7.jpg" onMouseOver="this.src='/public/assets/images/elite_aimg_7.jpg'" onMouseOut="this.src='/public/assets/images/elite_simg_7.jpg'" alt="" />
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
            $('#thumbs li').removeClass('active');
            $($('#thumbs li')[index]).addClass('active');
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
        $('#thumbs li').bind('click',function(e){
        	var count = $(this).attr('rel');
        	showImage(parseInt(count)-1);
        });
	});
    
	
	</script>	
        
  

			


	</div>
	



        </div>
    </div>   
    
    <div id="elite_info5">
       	<div id="advance_info6">
    	<div class="info6_outdoor1"> 
        	<div class="info6_outdoor1_IMG" style="float:left; width:475px;height:335px; margin-left:58px; margin-top:90px;">
             <img src="/public/assets/images/EN_elite_info.png"/>
            </div>
            <div class="info6_outdoor1_text" style=" float:left; width:390px; height:290px; margin-top:90px;">
           	<div style="font-family:Nanum Gothic; font-size:20px; font-weight:bold; padding:15px 10px 10px; color:#5b5b93; text-align:left;">SPECIFICATIONS</div>
           	<div style="width:100%; height:35px; background:#bfbfbf; line-height:35px; text-align:center; font-family:Dotum; font-weight:bold; font-size:15px; color:#676767;">Freshield Elite Vacuum Sealer</div>
           	<div>
           		<div class="spec_title">모델명</div>
                <div class="sepc_text">후레쉴드 엘리트 (ELITE-IV)</div>
           	</div>
            <div>
           		<div class="spec_title">정격전압</div>
                <div class="sepc_text">AC 220~240V (50~60Hz)</div>
           	</div>
            <div>
           		<div class="spec_title">소비전력</div>
                <div class="sepc_text">185W</div>
           	</div>
            <div>
           		<div class="spec_title">사이즈</div>
                <div class="sepc_text">W 384 x H 77 x D 144 (mm)</div>
           	</div>
            <div>
           		<div class="spec_title">무  게</div>
                <div class="sepc_text">2.2 kg</div>
           	</div>
            <div>
           		<div class="spec_title">색  상</div>
                <div class="sepc_text">White ＆ Beige</div>
           	</div>
            <div>
           		<div class="spec_title">팩 가능폭</div>
                <div class="sepc_text">11.4 inches (290mm)</div>
           	</div>
            	
        	
        </div>
    </div>
    </div>

        </div>
    
    
    
</div>


<!--ELITE 영역 끝-->


  </div>
 
<!-- bottom 레이아웃 파일-->