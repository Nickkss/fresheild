// 상단 메뉴부분
 
var initialtab=[, "sc"];
 
var turntosingle=0 //0 for no (default), 1 for yes
var disabletablinks=0 //0 for no (default), 1 for yes
 
var previoustab=""
 
if (turntosingle==1)
document.write('<style type="text/css">\n#tabcontentcontainer{display: none;}\n</style>')
 
function expandcontent(cid, aobject){
if (disabletablinks==1)
aobject.onclick=new Function("return false")
if (document.getElementById && turntosingle==0){
highlighttab(aobject)
 
if (previoustab!="")
document.getElementById(previoustab).style.display="none"
if (cid!=""){
document.getElementById(cid).style.display="block"
previoustab=cid
}
}
}
 
function highlighttab(aobject){
if (typeof tabobjlinks=="undefined")
collectmenu()
for (i=0; i<tabobjlinks.length; i++)
tabobjlinks[i].className="";
aobject.className="current";
}
 
function collectmenu(){
var tabobj=document.getElementById("menu")
tabobjlinks=tabobj.getElementsByTagName("A")
}
 
function do_onload(){
collectmenu()
expandcontent(initialtab[1], tabobjlinks[initialtab[0]-1])
}
