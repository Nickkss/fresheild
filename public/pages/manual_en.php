<?php
/**
 * Manual/Downloads Page - English Version
 * Integrated with database in Phase 2
 */
require_once __DIR__ . '/../includes/db.php';

// Fetch English Manuals from database
$manuals = getManualsByLanguage('en');
$totalManuals = count($manuals);
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
<div id="MANUAL_IMG">
    <div id="MANUAL">
    	<img src="/public/assets/images/manual_img1.png"/>
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
         
        <li class="smenu_basic"><a href="EN_manual.html"><strong>DOWNLOADS</strong></a>
       <ul class="sub">
                <li><a href="EN_manual.html">FAQ</a></li>
            </ul>
        </li>
        
    </ul>
    </div>

</div>
<!--SUB MENU 영역 끝-->
<!-- 서브이미지 영역끝 -->





<!--MANUAL 영역 시작-->
<div id="manual_board">
	<div id="manual_container">
	    	<div id="manual_title">
	         DOWNLOADS
	        	</div>
	        <div id="manual_area">
       		 <div id='module_board' class='him_module' rel='en_manual'><!-- 게시판 스타일시트 -->
<link rel="stylesheet" type="text/css" href="/public/assets/board.css">
<!-- contents -->
<form id="bbsSearchForm">
<input type="hidden" name="p" value="1" /><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="bbs_small" align="left">
Total <b><?php echo $totalManuals; ?></b> posts
        </td>
        <td align="right">
			<div id="searcher">
			<select name="search_field" class="select">
					<option value="title" >제목</option>
					<option value="content" >내용</option>
					<option value="mname" >작성자</option>
			</select>
			<input type="text" name="search_word" value="" class="input">
			<input type="image" src="/public/assets/img/btn_search.png" title="검색" align="absbottom">
			</div>
        </td>
    </tr>
</table>
</form>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_tbl_title">
                <colgroup>
                    <col width="60px"/>
                    <col width=""/>
                    <col width="80px"/>
                </colgroup>
                <tr align="center" bgcolor="#FFFFFF">
                    <th>번호</th>
                    <th>제목</th>
                    <th>작성자</th>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_tbl_list">
                <colgroup>
                    <col width="60px"/>
                    <col width="30px"/>
                    <col width=""/>
                    <col width="80px"/>
                </colgroup>
                <tbody>
                <?php if (empty($manuals)): ?>
                    <!-- No manuals available message -->
                    <tr>
                        <td colspan="3" align="center" style="padding: 30px; color: #666;">
                            No downloads available at this time.<br>
                            Downloads will be updated soon.
                        </td>
                    </tr>
                <?php else: ?>
                    <!-- Dynamic manual entries from database -->
                    <?php foreach ($manuals as $index => $manual): ?>
                    <tr>
                        <td><?php echo ($totalManuals - $index); ?></td>
                        <td>
                            <?php if (!empty($manual['file_path'])): ?>
                            <img src="/public/assets/img/icon_file.gif" align="absmiddle"/>
                            <?php endif; ?>
                        </td>
                        <td class="title ellipsis">
                            <a href="<?php echo sanitizeOutput($manual['file_path']); ?>" target="_blank" download>
                                <?php echo sanitizeOutput($manual['title']); ?>
                            </a>
                            <?php if ($manual['download_count'] > 10): ?>
                            <img src="/public/assets/img/icon_hit.gif" align="absmiddle"/>
                            <?php endif; ?>
                            <?php if (!empty($manual['description'])): ?>
                            <br><span class="bbs_small" style="color: #666;">
                                <?php echo sanitizeOutput($manual['description']); ?>
                            </span>
                            <?php endif; ?>
                        </td>
                        <td align="center" class="bbs_small">
                            <?php echo !empty($manual['file_size']) ? formatFileSize($manual['file_size']) : '-'; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" style="padding-top:10px">
            <table class="tbl-paging">
                <tr>
                    <td>
                        <a href="EN_manualf27e.html?bbs_id=en_manual&amp;m=list&amp;p=1&amp;search_category="><img src="/public/assets/img/paging_first.png"></a><a href="EN_manualf27e.html?bbs_id=en_manual&amp;m=list&amp;p=1&amp;search_category="><img src="/public/assets/img/kr/paging_prev.png"></a>
                    </td>
                    <td class="page">
                            <a href="EN_manualf27e.html?bbs_id=en_manual&amp;m=list&amp;search_category=&amp;p=1" class="page selected" >1</a>
                    </td>
                    <td><a href="EN_manualf27e.html?bbs_id=en_manual&amp;m=list&amp;p=1&amp;search_category="><img src="/public/assets/img/kr/paging_next.png"></a><a href="EN_manualf27e.html?bbs_id=en_manual&amp;m=list&amp;p=1&amp;search_category="><img src="/public/assets/img/paging_last.png"></a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>



<script type="text/javascript">
var bl = {
	bbs_id:'en_manual',
	init:function() {
		if (Ext.get('search_category')) {
			Ext.get('search_category').on('change',function(event,v) {
				Ext.getDom('bbsSearchForm').submit();
			});
		}
	},
	view:function(seq, is_manager) {
		if (is_manager==1) {
			document.location.href='?m=view&bbs_id=en_manual&p=1&search_category=&seq='+seq;
        }
		else if (is_manager==0) {
			alert(xpack[2416]);
			return false;
		}
        else {
            HIM.Window.open('../lib/bbs/password.html', xpack[2322], {
                bbs_id: this.bbs_id,
                seq: seq,
                cmd: 'content',
                act: 'view',
				p:'1'
            }, {
                width: 330,
                height: 230
            });
        }
	}
}

Ext.onReady(function(){
	bl.init();
});
</script>
<script type="text/javascript"> 
</script></div>
       		 </div>
   	 </div>

</div>
 
<!-- bottom 레이아웃 파일-->