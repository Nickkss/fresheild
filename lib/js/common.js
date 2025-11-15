var HIMBUILDER = function(){}
HIMBUILDER.prototype = {

}
var HIM = HIMBUILDER.prototype;

var jq = jQuery.noConflict();

/**
 * firefox:firebug 미설치시 예외처리
 */
if (! window.console)
{
	window.console = {};
	window.console.debug = function() {};
	window.console.error = function() {};
	window.console.trace = function() {};
}

/**
 * IE6 백그라운드 이미지 껌벅임 및 메모리 문제 해결
 */
if(jQuery.browser.msie && parseInt(jQuery.browser.version, 10) == 6) {
	try {
		document.execCommand("BackgroundImageCache", false, true);
	} catch(err) {}
}

/**
 * ajaxForm 옵션 초기 셋팅을 한다.
 */
var ajaxOption = {
	dataType: 'html',
	beforeSend: function() {
		var el = '<div id="loading_container"><div id="loading">Loading...</div></div>' ;
		jq('#loading_container').remove();
		jq(el).appendTo('body');
	},
	complete: function(request, status) {
		jq('#loading_container').remove();
	},
	error: function(xhr, textStatus, errorThrown) {
		if (textStatus) {
			alert(xhr.status + ": " + textStatus);
		}
	}
};
jq.ajaxSetup(ajaxOption);

/**
 * ajax 콜백 함수(alert 처리)
 */
function ajaxCallback(data,state,target)
{
	if (state=="success") {
		if (data) alert(data);
		else alert("저장되었습니다.");
	} else {
		alert("처리 중 오류가 발생했습니다. 다시 시도하세요.");
		return false;
	}
	if (target=="reload") {
		document.location.reload();
	}
}

/**
 * ajax 콜백 함수(alert 처리)
 */
function jsonCallback(data,state,target)
{
	if (data.result=="success") {
		if (data.msg) alert(data.msg);
		else alert("저장되었습니다.");
	} else {
		if (data.msg) alert(data.msg);
		return false;
	}
	if (target=="reload") {
		document.location.reload();
	}
}

/**
 * Dialog 생성
 */

var gDialogID;
function gDialogOpen(url, param, callback)
{
	var dlg_id = param.id ? param.id : "dialog_frame";
	var dlg_title = param.t ? param.t : '';
	var c = param.c ? param.c : "load";
	var w = param.w ? param.w : 500;
	var h = param.h ? param.h : 300;
	var z = param.z ? param.z : 1;
	var nm = param.nm==1 ? false : true;
	var mh = param.mh ? param.mh : 200;

	createDialogContainer(dlg_id, dlg_title);
	jq('#' + dlg_id).dialog({
		bgiframe : true,
		autoOpen : false,
		width : w,
		height: h,
		minHeight: mh,
		resizable: true,
		modal : nm,
		title : dlg_title,
		zIndex: z,
		open: function() {
			switch (c) {
			case "appl":
				jq(this).html(jq('#'+url).html());
				//jq('#'+url).show();
				//jq('#'+url).appendTo(this);
				break;
			case "frame":
				var fel = "<iframe id=\"ifrm_"+dlg_id+"\" name=\"ifrm_"+dlg_id+"\" src=\""+url+"\" style=\"width:100%;height:100%;\" scrolling=\"no\" frameborder=\"0\"></iframe>";
				jq(fel).appendTo(this);
				break;
			default:
				jq(this).load(url, function() {
					jq('#loading_container').remove();
				});
				break;
			}
		},
		close: function() {
			if (callback) callback();
			jq(this).remove();
			/*
			switch (c) {
			case "appl":
				jq(this).remove();
				//jq('#'+url).hide();
				break;
			case "frame":
				jq(this).remove();
				break;
			default:
				jq(this).remove();
				break;
			}
			*/
		}
	}).dialog('open');
	gDialogID = dlg_id;
}

function gDialogClose(gid)
{
	if (gid) {
		jq('#' + gid).dialog('close');
		jq('#' + gid).remove();
		jq('#' + gid).dialog('destroy');
	} else {
		if (gDialogID) {
			jq('#' + gDialogID).dialog('close');
			jq('#' + gDialogID).remove();
			jq('#' + gDialogID).dialog('destroy');
		}
	}
}

function getDialogID()
{
	if (gDialogID) return gDialogID;
	else return "dialog_frame";
}

function gDialogReload(id)
{
	
}

function createDialogContainer(id,title)
{
	var el = '<div id="'+id+'"></div>';
	jq(el).appendTo('body');
}

function gLocation(url)
{
	location.href = url;
}

function _GID(el)
{
	return document.getElementById(el);
}

function _GNAME(el)
{
	return document.getElementsByName(el);
}

function setDefaultValue(el, val)
{
	var ftype = jq(":input[name='" + el + "']").attr('type').toLowerCase();
	if (ftype == "select" || ftype == "select-one" || ftype == "text" || ftype == "textarea" || ftype == "hidden") {
		jq(":" + ftype + "[name='" + el + "']").val(val);
	} else {
		jq(":input[name='" + el + "'][value='" + val + "']").attr('checked','checked');
	}
}

function setFormValue(f, v)
{
	if ( typeof v == "undefined" ) return false;
	jQuery.each( v, function ( key, value ) {
		var els = document.getElementsByName ( key );
		if ( els == "undefined" ) return true;
		if ( els.length == 0 ) return true;

		if ( jq(els).parents().find('form').attr('name') != f ) return true;
		var el = els[0];
		var tagname = el.tagName.toLowerCase();
		var type = el.type;

		if ( tagname == "input" && type == "text" ) el.value = value;
		else if ( tagname == "input" && type == "hidden" ) el.value = value;
		else if ( tagname == "input" && type == "radio"  ) {
			jq("input[name="+key+"]").each( function( i ) {
				if ( this.value == value ) this.checked = "checked";
			});
		} else if ( tagname == "input" && type == "checkbox" ) {
			if ( el.value == value ) el.checked = "checked";
		} else if ( tagname == "select" ) {
			var select_values = value.split(",");
			for (var n=0; n<select_values.length; n++ ) {
				jq("select[name="+key+"] > option").each( function( i ) {
					if ( this.value == select_values[n] ) this.selected = "selected";
				});
			}
		} else if ( tagname == "textarea" ) el.value = value;
	});
}

/**
 * 퀵메뉴 스크롤
 * 사용법 : jq(window).load(quick_menu_slide).resize(quick_menu_slide).scroll(quick_menu_slide);
*/
function quick_menu_slide()
{ 
  var moveTop = 0; 
  if(moveTop<0) moveTop=0; 

  if(jq(document.body).scrollTop()==0) var scrollTop=jq(document.documentElement).scrollTop(); 
  else var scrollTop=jq(document.body).scrollTop();   

  if(!document.compatMode||document.compatMode=="BackCompat") var scrollHeight=document.body.scrollHeight; 
  else var scrollHeight=document.documentElement.scrollHeight; 

  var moveHeight=scrollTop+moveTop; 
  if(moveHeight+jq("#scroll").height()<scrollHeight) { 
    jq("#scroll").stop(); 
    jq("#scroll").animate({"top": moveHeight}, 800); 
    jq("#scroll").css("display","block"); 
  } 
}

/**
 * 체크박스 전체 선택 
 * @param string el : 전체 선택 체크박스
 * @param string targetEl : 적용될 체크박스 클래스명
 */
function checkAll(el, targetEl)
{
	if( jq(el).attr('rel') == 'yes' ) {
		var do_check = false;
		jq(el).attr('rel', 'no');
	} else {
		var do_check = true;
		jq(el).attr('rel', 'yes');
	}
	jq(targetEl).each(function(e, el) {
		jq(el).attr('checked', do_check);
	});
}


/**
 * 현재 시각을 Time 형식으로 리턴
 */
function getCurrentTime(date)
{
	return toTimeString(new Date(date));
}

/**
 * 자바스크립트 Date 객체를 Time 스트링으로 변환
 * @param date date : Date Object
 */
function toTimeString(date)
{
	var year  = date.getFullYear();
	var month = date.getMonth() + 1; // 1월=0,12월=11이므로 1 더함
	var day   = date.getDate();

	if (("" + month).length == 1) { month = "0" + month; }
	if (("" + day).length   == 1) { day   = "0" + day;   }

	return ("" + year + month + day)
}

/**
 * 현재 年을 YYYY형식으로 리턴
 */
function getYear(date)
{
	return getCurrentTime(date).substr(0,4);
}

/**
 * 현재 月을 MM형식으로 리턴
 */
function getMonth(date)
{
	return getCurrentTime(date).substr(4,2);
}

/**
 * 현재 日을 DD형식으로 리턴
 */
function getDay(date)
{
	return getCurrentTime(date).substr(6,2);
}

function getDate(day)
{
	var d = new Date();
	var dt = d - day*24*60*60*1000;
	return getYear(dt) + '-' + getMonth(dt) + '-' + getDay(dt);
}

/**
 * 파일타입 체크
 * @param string allow_file : 허용가능한 확장자
 */
function validatorAdd(allow_file)
{
	jq.validator.addMethod("fileTyepCheck", function(value) {
		if(value) {
			return value.match( eval("/\.(" + allow_file + ")$/i") ) ? true : false;
		} else {
			return true;
		}
	}, '첨부 가능한 파일이 아닙니다.');
}

/**
 * 쿠키 설정
 * @param string name : 쿠키이름
 * @param string value : 쿠키값
 * @param string expires : 유효기간
 * @param string path : 유효경로
 * @param string domain : 유효도메인
 * @param string secure : 보안적용
 */
function setCookie (name, value, expires) { 
	var argv = setCookie.arguments;
	var argc = setCookie.arguments.length;
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expires);

	var path = (3 < argc) ? argv[3] : null;
	var domain = (4 < argc) ? argv[4] : null;
	var secure = (5 < argc) ? argv[5] : false;
	document.cookie= name + "=" + escape(value) +
		((expires) ? "; expires=" + exdate.toGMTString() : "") +
		((path) ? "; path=" + path : "") +
		((domain) ? "; domain=" + domain : "") +
		((secure) ? "; secure" : "");
}

/**
 * 쿠키 호출
 * @param string name : 호출할 쿠키이름
 */
function getCookieVal (offset) { 
	var endstr = document.cookie.indexOf (";", offset);
	if (endstr == -1) endstr = document.cookie.length;
	return unescape(document.cookie.substring(offset, endstr));
} 

function getCookie(name)
{
	var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    } else {
        begin += 2;
    }
    var end = document.cookie.indexOf(";", begin);
    if (end == -1) {
        end = dc.length;
    }
    return unescape(dc.substring(begin + prefix.length, end));
}

/**
 * 쿠키 삭제
 * @param string name : 삭제할 쿠키명
 * @param string path : 삭제 path
 * @param string domain : 삭제 도메인
 */
function delCookie(name, path, domain)
{
    if (getCookie(name)) {
        document.cookie = name + "=" + 
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            "; expires=Thu, 01-Jan-70 00:00:01 GMT";
    }
}

function in_array(val,arr)
{
	for (var i=0;i<arr.length;i++){
		if (arr[i]==val) return true;
	}
	return false;
}

/**
 * position left of object
 */
function findPosX(obj)
{
	var curleft = 0;
	if(obj.offsetParent){
		while(obj.offsetParent){
			curleft += obj.offsetLeft; 
			obj = obj.offsetParent;
		}
	}
	return curleft;
}

/**
 * position top of object
 */
function findPosY(obj)
{
	var curtop = 0;
	if(obj.offsetParent){
		while(obj.offsetParent){
			curtop += obj.offsetTop; 
			obj = obj.offsetParent;
		}
	}
	return curtop;
}

function notAllow(pObj)
{
	for (var i = 0 ; i < pObj.value.length ; i ++ ) {
		if ( pObj.value.substring( i,  i + 1 ) == "%" ) {
			alert("검색어에는 % 를 사용할 수 없습니다.");
			pObj.focus();
			return false;
		}
	}
	return true;
}

function makeInt( val )
{
	for (var i=0; i<val.length; i++) {
		if ( val.charAt(i) != '0' ) {
			return parseInt(val.substring( i, val.length ));
		}
	}
	return 0;
}

function CheckValid(String, space)
{

   var retvalue = false;

   for (var i=0; i<String.length; i++)
   {		//String이 0("" 이나 null)이면 무조건 false
      if (space == true)
      {
         if (String.charAt(i) == ' ')
         {			//String이 0이 아닐때 space가 있어야만 true(valid)
            retvalue = true;
            break;
         }
      } else {
         if (String.charAt(i) != ' ')
         {			//string이 0이 아닐때 space가 아닌 글자가 있어야만 true(valid)
            retvalue = true;
            break;
         }
      }
   }

   return retvalue;
}

function isEmpty(field, error_msg)
{
	// error_msg가 ""이면 alert와 focusing을 하지 않는다
	if(!CheckValid(field.value, false)) 	{
		return true;
	} else {
		return false;
	}
}

function isKorean(str) 
{
	var re = /[a-zA-Z0-9\s~!@#\$%^&\*\(\)_\+\{\}|:"<>\?`\-=\[\]\\;',\.\/]/;
	if (re.test(str))
		return false;
	return true;
}

function isEMail(str)
{
	if ( str.search(/(^\..*)|(.*\.$)/) != -1 || str.search(/\S+@(\S+)\.(\S+)/) == -1 ) {
        alert("전자우편주소의 형식은 '계정@[호스트|도메인]'과 같이 구성되어야 하며,\r\n양쪽에 '.'이 기재되어서는 안됩니다.\r\n\r\n예) webmaster@domain.com");
        return false ;
    }
	return true;
}

// 필드(String) 길이 관련
function strLength(field)
{

   var Length = 0;

   var Nav = navigator.appName;
   var Ver = navigator.appVersion;

   var IsExplorer = false;

   var ch;

   if ( (Nav == 'Microsoft Internet Explorer') && (Ver.charAt(0) >= 4) )
   {
      IsExplorer = true;
   }

   if(IsExplorer)
   {

      for(var i = 0 ; i < field.value.length; i++)
      {

         ch = field.value.charAt(i);

         if ((ch == "\n") || ((ch >= "ㅏ") && (ch <= "히")) ||
             ((ch >="ㄱ") && (ch <="ㅎ")))
		{
	    	Length += 2;
		} else
		{
	    	Length += 1;
       	}

	  }

   }else {
      Length = field.value.length ;
   }

   return Length;
}

function isOutOfRange(field, min, max, error_msg)
{
	if(strLength(field) < min || strLength(field) > max)
	{
		//alert(error_msg);
		//field.focus();
		//field.select();
		return true;
	}
	return false;
}

function isNotExactLength(field, len, error_msg) {
	if(strLength(field) != len) {
		alert(error_msg);
		field.focus();
		field.select();
		return true;
	}
	return false;
}

function isOutOfNumericRange(field, min, max, error_msg) {
	if(field.value < min || field.value > max) {
		alert(error_msg);
		field.focus();
		field.select();
		return true;
	}
	return false;
}

function isNotAlphaNumeric(field,error_msg)
{

   for (var i=0; i < field.value.length; i++)
   {
      if ( ( (field.value.charAt(i) < "0") || (field.value.charAt(i) > "9") ) &&
           ( ( (field.value.charAt(i) < "A") || (field.value.charAt(i) > "Z") ) &&
             ( (field.value.charAt(i) < "a") || (field.value.charAt(i) > "z") ) ) )
	  {
         //alert(error_msg);
		 //field.focus();
		 //field.select();
		 return true;
	   }
   }
   return false;
}

function checkDupID(id)
{
	if(isEmpty(id, "ID를 기입해 주세요!")) return true;
	if(isNotAlphaNumeric(id,"ID는 4~10자 사이의 숫자 및 영문 대소문자로만 기입해 주세요!")) return true;
	//if(isOutOfRange(id,4, 10, "ID는 한글 2자~5자, 영문 4~10자 이내로 기입해 주세요!")) return true;
}

function hide_in(field)
{
	if(field.value == field.defaultValue) field.value = "";
}

function show_out(field)
{
	if(field.value == "") field.value = field.defaultValue;
}

function number_format(amount)
{
	amount = new String(amount);
	var amountLength = amount.length;
	var modulus = amountLength % 3;
	var currencyString = amount.substr(0,modulus);
	for(i=modulus; i<amountLength; i=i+3) {
		if(currencyString != "") 
			currencyString += ",";
		currencyString += amount.substr(i, 3);
	}
	return currencyString;
}

//주어진 값(val)을 소수점이하 num자리수에서 반올림한값을 리턴한다.
function round(val, num)
{
	val = val * Math.pow(10, num - 1);
	val = Math.round(val);
	val = val / Math.pow(10, num - 1);
	return val;
}

/**
 * 주언진 8자리 문자열을 날짜포맷(YYYY-MM-DD or YYYY/MM/DD)로 바꾸어준다.
 *
 * @param	source		변환할 8자리 날짜문자열
 * @param	format		날짜형식
 * @return	ret			변환된 날짜 문자열
 **/
function dateFormat(source, format)
{
	ret = "";
	delimiter = "";

	if (format.indexOf("-") != -1)
		delimiter = "-";
	else if (format.indexOf("/") != -1)
		delimiter = "/";
	else
	{
		alert("입력된 날짜포맷이 잘못되었습니다.");
		return;
	}

	if (source.length == 8)
	{
		ret = source.substring(0, 4) + delimiter + source.substring(4, 6) + delimiter + source.substring(6, 8);
	} else if (source.length == 10)
	{
		ret = source.substring(0, 4) + delimiter + source.substring(5, 7) + delimiter + source.substring(8, 10);
	} else
	{
		alert("입력된 날짜형식이 잘못되었습니다.");
		return;
	}
	return ret;
}

/**
 * 날짜형식이 올바른지 검사
 *
 * @param	astrValue	날짜포맷(yyyymmdd, yyyy/mm/dd, yyyy-mm-dd)
 * @param	astrNotNull:	nn:not null, "": null 허용
 * @return	true/false
 **/
function blnOkDate(astrValue, astrNotNull)
{
	var arrDate;
	
	if (astrValue=='')
	{
		if (astrNotNull == "nn")
			return false;
		else
			return true;
	}else{	
		if (astrValue.indexOf("-") != -1) 
			arrDate = astrValue.split("-");
		else if (astrValue.indexOf("/") != -1) 
			arrDate = astrValue.split("/");
		else
		{
			if (astrValue.length != 8) return false;
			astrValue = astrValue.substring(0,4)+"/"+astrValue.substring(4,6)+"/" +astrValue.substring(6,8);
			arrDate = astrValue.split("/");
		}
	
		if (arrDate.length != 3) return false;		
		
		var chkDate = new Date(arrDate[0] + "/" + arrDate[1] + "/" + arrDate[2]);		
		if (isNaN(chkDate) == true ||
			(arrDate[1] != chkDate.getMonth() + 1 || arrDate[2] != chkDate.getDate())) 
		{
			return false;
		}
	}
	return true;
}

/**
 * 문자열내에 있는 ', "를 \', \" 로변환한다.
 *
 * @param	str	변환할 문자열
 **/
function toValidStr(str)
{
	re1 = /\'/gi;
	re2 = /\"/gi;
	str = str.replace(re1, "\\\'");
	str = str.replace(re2, "\\\""); 
	return str;
}

/**
 * 문자열내에 있는 ', ", &, <, > 문자를 문자코드로 변경
 *
 * @param	str	변환할 문자열
 **/
function toValidCharCode(str)
{
	re1 = /\'/gi;
	re2 = /\"/gi;
	re3 = /&/gi;
	re4 = /</gi;
	re5 = />/gi;
	str = str.replace(re3, "&#038;");
	str = str.replace(re1, "&#039;");
	str = str.replace(re2, "&#034;"); 
	str = str.replace(re4, "&#060;"); 
	str = str.replace(re5, "&#062;");
	return str;
}

function encChar(str)
{
	var temp1 = "@@@@@";
	re1 = /\'/g;
	re2 = /\"/g;
	str = str.replace(re1, temp1);
	return str;
}	

function decChar(str)
{
	re3 = /@@@@@/g;
	str = str.replace(re3, "'");
	return str;
}

function PageNav(intStart, intEnd, intTotal, intPageList, strPrev, strNext, strLink, StrPage) {
	if (intTotal>0) {
		var PageVar = Math.floor(intStart/(intEnd*intPageList));
		var PageVar = Math.floor(intStart/(intEnd*intPageList));
		if (intTotal>intEnd) {
			if (intStart+1>intEnd*intPageList) {
				var pre_start = (PageVar-1)*intEnd*intPageList;
				document.write("<a href='"+StrPage+"?start="+pre_start+strLink+"'>"+strPrev+"</a> ");
			}else{
				document.write(strPrev+" ");
			}
		}else{
				document.write(strPrev+" ");
		}
		for (vj=0; vj<intPageList; vj++) {
			var ln = (PageVar*intPageList+vj)*intEnd;
			var page_num = PageVar*intPageList+vj+1;
			if (ln<intTotal) {
				if (vj>0) {
					document.write(" | ");
				}
				if (ln != intStart) {
					document.write("<a href='"+StrPage+"?start="+ln+strLink+"'>"+page_num+"</a> ");
				} else {
					document.write("<b><font color='#174F17'>"+page_num+"</font></b> ");
				}
			}
		}
		if (intTotal>((PageVar+1)*intEnd*intPageList)) {
			var n_start = (PageVar+1)*intEnd*intPageList;
			document.write("<a href='"+StrPage+"?start="+n_start+strLink+"'>"+strNext+"</a>");
		}else{
			document.write(strNext+" ");
		}
	} else {
		document.write("&nbsp;");
	}
}

function fnFlashObject(path, w, h)
{
	document.write ('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="'+w+'" height="'+h+'"><param name="movie" value="'+path+'"><param name="quality" value="high"><param name=wmode value=transparent><embed src="'+path+'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="'+w+'" height="'+h+'" wmode="transparent"></embed></object>');
}

function trim(str)
{
	return str.replace(/(^\s*)|(\s*$)/g, "");
}

function detectfunckey(e)
{
	var obj=window.event ? event : e;
	if (obj.ctrlKey) return false;
	if (obj.keyCode==17) return false;
}

function resizeCallback()
{
	var ql = jq(window).width();
	jq('#quick_title').mousedown(function() {
		jq('#quick_config').draggable();
	});
	jq('#quick_config').show();
	jq('#quick_config').css('left', ql - 122);
	jq('#quick_config').css('top', 0);
}

function init()
{
	jq(window).resize(resizeCallback);
	resizeCallback();
}

//롤오버
function MM_swapImgRestore() { //v3.0
        var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
        var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
        var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
        if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
        var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
        if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
        for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
        if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
        var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
        if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function tab_view()
{
	var argc = tab_view.arguments;
	var args = tab_view.arguments.length;
	var obj = argc[0];
	for (var i=1; i < args; i++) {
		if (i==1) jq('#' + argc[i]).show();
		else jq('#' + argc[i]).hide();
	}
}

function setClip(str)
{
	window.clipboardData.setData('Text', str);
}


/**
 * 페이지 load시 기본 폼필드 스타일시트 적용
 */
jq(document).ready(function() {
	jq('.int, .num, .txt').focus(function() {
		jq(this).css({'borderColor':'#c4c44a'});
	})
	.blur(function() {
		jq(this).css({'borderColor':'#D1D1D1'});
	});

	var w = jq('.ellipsis').attr('offsetWidth');
	jq('.ellipsis').attr('width',w);
});


window.onload=function(){
	setTimeout(function() { if(window.pageYOffset == 0) { window.scrollTo(1, 0); }}, 100);
}


HIM.vaildator = new Ext.util.MixedCollection(false, function(el){
	return el.key;
});


//정규식 추가시 이부분에 추가하세요. by 이혜진(hjlee@gabia.com 2011-03-29)
HIM.vaildator.addAll([
	{key:'id', regexp:/^[a-zA-Z]{1}[a-zA-Z0-9_-]{3,11}$/, regexpText:xpack[3006]},
	{key:'pw', regexp:/^[a-zA-Z0-9_-]{4,16}$/, regexpText:xpack[1430]},
	{key:'email', regexp:/^[_a-zA-Z0-9-\.]+@[\.a-zA-Z0-9-]+\.[a-zA-Z]+$/, regexpText:xpack[2290]},
	{key:'domain', regexp:/^[a-zA-Z0-9-]{2,63}\.([a-zA-Z0-9-]{2,63}\.){0,1}[a-zA-Z-.]+$/, regexpText:xpack[3006]},
	{key:'alphanum', regexp:/^[a-zA-Z0-9]+$/, regexpText:xpack[1394]},
	{key:'alpha', regexp:/^[a-zA-Z]+$/, regexpText:xpack[1479]},
	{key:'number', regexp:/^[0-9]+$/, regexpText:xpack[1943]}
]);


HIM.Form = {
	getRegExp: function(type) {
		if (HIM.vaildator.containsKey(type)) {
			return HIM.vaildator.item(type).regexp;
		}
		else {
			return type;
		}
	},
	getRegExpText: function(type) {
		if (HIM.vaildator.containsKey(type)) {
			return HIM.vaildator.item(type).regexpText;
		}
		else {
			return type;
		}
	}
}

function validateField(frmName) {
	var el;
	var checkCount=0;
	var checkGroup;
	var valid = true;
	jq('#'+frmName+' [allowBlank="false"], #'+frmName+' [regExp]').each(function(i,e){	
		el = jq(e);
		if (el.attr('allowBlank')=="false" && (  ( el.attr('type')=='checkbox' &&   jq(":checkbox[name='" + el.attr("name") + "']:checked").length == '0'  ) || (  el.attr('type') !='checkbox' && !el.val() )  )  ) {
			if (el.attr('label')) {
				var blankText = xpack[281]+"\n - "+el.attr('label');
			}
			else {
				var blankText = (el.attr('blankText')) ? el.attr('blankText') : xpack[1463];
			}
					
			//var blankText=(el.attr('blankText'))?el.attr('blankText'):'값을 입력해 주세요.';
			validateError(el, blankText);
			valid=false;
			return false;
		}
			
		//체크박스
		if (((el.attr('type')=='checkbox') || (el.attr('type')=='radio') && el.attr('group')!=checkGroup)) {
			checkGroup=el.attr('group');
			checkCount=jq('input[group="'+checkGroup+'"]:checked').length;
			if(!el.attr('blankText'))
			{
				var blankText = el.attr('label');
			}else
			{
				var blankText = el.attr('blankText');
			}
			if (!checkCount) {
				validateError(el, blankText);
				valid=false;
				return false;
			}			
		}
		
		//정규식체크		
		if (el.attr('regExp') && el.val()) {
			var regexp =  HIM.Form.getRegExp(el.attr('regExp'));
			var regexptext = HIM.Form.getRegExpText(el.attr('regExp'));
			if (!el.val().toString().match(regexp)) {
				validateError(el, regexptext);
				valid=false;
				return false;
			}
		}		

		//비밀번호확인체크
		if (el.attr('sync')) {
			var sync = el.attr('sync');
			var el_sync = jq('#'+frmName+' [name="'+sync+'"]').val();
			if (el_sync!=el.val()) {
				validateError(el, el.attr('syncText'));
				valid=false;
				return false;
			}
		}

		el.removeClass('input-invalid');
		valid=true;	
	});
	if (valid) {
		return true;
	}
	else {
		return false;
	}
}

function validateError(el, msg) {	
	el.addClass('input-invalid');
	alert(msg);
	el.focus();
}


HIM.Window = {
	win : new Ext.Window({
        layout:'fit',
        width:400,
		autoScroll :true,
        height:250,
		closeAction:'hide',
		maskDisabled:true,
        plain: false,
		modal:true,
		bufferResize:true,
		resizable:false,		
		baseCls:'him-window'
    }),
	config: {
		width:400,
        height:250
	},
	open: function(url,title, param, cfg, callback){
		var title = (!title)?'HIM Service':title;
		var config = (cfg)?cfg:this.config;
		
		this.win.setTitle(title);
		this.win.show();
		
		param = (!param)?{}:param;
		this.win.setHeight(config.height);
		this.win.setWidth(config.width);
		
		this.load(url,param,config.height, callback);
		
		this.win.center();
		if(Ext.isSafari) {
			var p = this.win.getPosition();
			this.win.setPosition(p[0],(p[1]+27));
		}
		
	},
	load: function(url,param, h, callback){
		this.win.load({
			url:url,
			method:'POST',
			scripts:true,
			params:param,
			text: '<div style="background:transparent url(/skin/_modules/images/loading.gif) no-repeat center;height:'+(h-50)+'px"></div>',
			callback:function(){
				if (typeof(callback) == 'function') {
					eval(callback());
				}
			}
		});
	},
	close: function(){
		Ext.WindowMgr.getActive().hide();
	}
}

HIM.Common = {
	validator: function(el){
		if (!el) return false;
		
		var allowblank = el.dom.getAttribute('allowblank');

		if (allowblank != 'false') return el.getValue();
		if (!el.getValue()) {
			if (el.dom.getAttribute('label')) {
				var blankText = xpack[281]+"\n - "+el.dom.getAttribute('label');
			}
			else {
				var blankText = (el.dom.getAttribute('blankText')) ? el.dom.getAttribute('blankText') : xpack[1463];
			}

			alert(blankText);
			el.addClass('input-invalid');
			el.focus();
			return false;
		}
		else {
			el.removeClass('input-invalid');
			return el.getValue();
		} 
	}
}


HIM.Service = {
	intro: function() {
		
		Ext.Ajax.request({
			url:'/lib/common/common.process.php',
			params:{
				cmd:'intro',
				act:'skip'
			},
			success:function() {
				document.location.reload();
			},
			failure: function() {
				
			}
		})		
	},
	check_jumin: function(it){
		var idtot=0;
		var idadd="234567892345";
		
		for (var i=0; i<12; i++) {
			idtot = idtot+parseInt(it.substring(i,i+1))*parseInt(idadd.substring(i,i+1));
		}
		idtot=11-(idtot%11);
		if (idtot==10) {
			idtot=0;
		} else if(idtot==11) {
			idtot=1;
		}
		if (parseInt(it.substring(12,13))!=idtot) 
			return false;
	
		return true;
	}
}
