function confirmurl(url,message) {
	if(confirm(message)) redirect(url);
}
function redirect(url) {
	location.href = url;
}
//滚动条
$(function(){
	//$(":text").addClass('input-text');
})

/**
 * 全选checkbox,注意：标识checkbox id固定为为check_box
 * @param string name 列表check名称,如 uid[]
 */
function selectall(name) {
	
	if ($("#check_box").attr("checked")==false) {
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	} else {
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	}
}
function selectall2(name) {
	$("#check_btn").click(function(){
		$("input[name='"+name+"']").each(function() {
			this.checked=true;
		});
	});
}
function selectall3(name) {
	$("#check_btn_no").click(function(){
		$("input[name='"+name+"']").each(function() {
			this.checked=false;
		});
	});
}

function openwinx(url,name,w,h) {
	if(!w) w=screen.width-4;
	if(!h) h=screen.height-95;
    window.open(url,name,"top=100,left=400,width=" + w + ",height=" + h + ",toolbar=no,menubar=no,scrollbars=yes,resizable=yes,location=no,status=no");
}
//弹出对话框
function omnipotent(id, linkurl, title, close_type, w, h) {
    if (!w) w = 700;
    if (!h) h = 500;
    art.dialog.open(linkurl, {
        id: id,
        title: title,
        width: w,
        height: h,
        lock: true,
        button: [{
            name: '确定',
            callback: function () {
                if (close_type == 1) {
                    return true;
                } else {
                    var d = this.iframe.contentWindow;
                    var form = d.document.getElementById('dosubmit');
                    form.click();
                }
                return false;
           },
		   focus: true
        }]
    });
    void(0);
}

function show_detail(name,url) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'\'+name+\'',id:'edit',iframe:'\'+url+\'',width:'1000',height:'500'}, function(){var d = window.top.art.dialog({id:'edit'}).data.iframe;var form = d.document.getElementById('dosubmit');form.click();return false;});
} 
function show_detail2(name,url) {
	//window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'\'+name+\'',id:'edit2',iframe:'\'+url+\'',width:'1000',height:'500'},function(){window.top.art.dialog({id:'edit2'}).close()});
} 
function show_detail3(name,url) {
	window.top.art.dialog({id:'edit'}).close();
	window.top.art.dialog({title:'\'+name+\'',id:'edit',iframe:'\'+url+\'',width:'500',height:'300'});
} 