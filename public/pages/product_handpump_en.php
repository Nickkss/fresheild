<!-- top영역끝 -->

<!-- 서브이미지 영역시작 -->
<!--TOP IMG 영역 시작-->
<div id="HANDPUMP">
    <div id="handpump_top">
    	<img src="/public/assets/images/EN_handpump_img.png"/>
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

<script type="text/javascript">
	$(function(){
		$("ul.sub").hide(); /*서브메뉴 sub를 안보이게*/
		$(".smenu_long").hover(function(){ /*li에 마우스 오버시*/
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
    	<li class="smenu_basic"><a href="../EN_main-2.html">HOME</a></li>
        <div class="h_line"></div>
        <!--<li class="smenu_basic"><a href="/product/1outdoor">후레쉴드</a>
        	<ul class="sub">
                <li><a href="/introduction/brandstory">브랜드</a></li>
                <li><a href="#">제품사용TIP</a></li>
                <li><a href="#">고객센터</a></li>
            </ul>
        </li>
         <div class="h_line"></div>
        <li class="smenu_basic"><a href="/product/freshield">진공포장기</a>
        	<ul class="sub">
                <li><a href="#">진공용기</a></li>
                <li><a href="#">진공비닐</a></li>
            </ul>
        </li>
        <div class="h_line"></div>-->
         
         <li class="smenu_basic"><a href="EN_5genisys.html">Canisters</a>
        	<!--<ul class="sub">
                <li><a href="/product/EN_3advance">ADVANCE</a></li>
                <li><a href="/product/EN_4elite">ELITE</a></li>
            </ul>-->
        </li>
         
         <div class="h_line"></div>
         
        <li class="smenu_basic"><a href="EN_6handpump.html"><strong>Hand Pump</strong></a>
        	<ul class="sub">
                <li><a href="EN_5genisys.html">Genisys</a></li>
              <!--  <li><a href="/product/EN_3outdoor">FR-EL1000</a></li>-->
            </ul>
        </li>
        
        
        
        <li class="smenu_right"><a href="EN_freshield.html"><strong>BACK ▶</strong></a>
        	
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
        	<div class="Tinfo1_handpump">Use Everywhere! Freshield Hand Pump</div>
    		<img src="/public/assets/images/EN_handpump_info1.png"/>
        </div>
    </div>
    
    <div id="handpump_info2">
    	<div class="info2_handpump">
        	<div class="Tinfo2_handpump1">Ease Enhances Usability</div>
    		<img src="/public/assets/images/EN_handpump_info2.png"/>
            <div class="Tinfo2_handpump2">
            Frehsield Hand Pump which is compatible with Genisys canisters ＆ Wizvac Plus vacuum zipper bag is easily able to suck air out with several pumping. You can use it everywhere and easily store ＆ carry it with the small size.
            
            </div>
        </div>
    </div>
    
    
    
    <div id="handpump_info3">
    	<div class="info3_handpump">
        	<div class="Tinfo3_handpump">Product Images</div>
       
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
           	<div style="font-family:Nanum Gothic; font-size:20px; font-weight:bold; padding:15px 10px 10px; color:#5b5b93;text-align:left;">Specifications</div>
           	<div style="width:100%; height:35px; background:#bfbfbf; line-height:35px; text-align:center; font-family:Dotum; font-weight:bold; font-size:15px; color:#676767;">Freshield Hand Pump</div>
           	<div>
           		<div class="spec_title" style="width:145px">Model</div>
                <div class="sepc_text">Freshield Hand Pump</div>
           	</div>
            <div>
           		<div class="spec_title" style="width:145px">Op. Type</div>
                <div class="sepc_text">Manual</div>
           	</div>
            <div>
           		<div class="spec_title1" style="text-align:left">Compatibility</div>
                <div class="sepc_text1" style="text-align:left">vacuum canister (Genisys)<br/>vacuum zipper bag (Wizvac Plus)</div>
           	</div>
            
            	
            </div>          
        	
        </div>

        </div>
    </div>
    
 
    
    
</div>


<!--HAND PUMP 영역 끝-->
  </div>
 

<!-- bottom 레이아웃 파일-->