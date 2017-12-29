<?php
/**
 * 分页类
 * $sql = "select name from table limit 10";
 * $page = new Page($sql);
 * $sql=$page->StartPage();
 * $qy = mysql_query($sql);
 * while($rs = mysql_fetch_array($qy)){
 * echo $rs[1];
 * }
 * echo $page->EndPage();
 */
class Page {
	var $PageSize = 10; // 每页记录数
	var $TotalPage; // 总页数
	var $NowPage; // 当前第几页
	var $RecordNum; // 记录总数
	var $QueryString; // 查询语句
	var $pgo;
	var $anchor;
	var $prevStr;
	var $nextStr;
	function __construct($sql) {
		global $mysqli;
		if (! $mysqli->ping ()) {
			echo "Please check your database link";
			exit ();
		}
		if (trim ( $sql ) != "") {
			if (preg_match ( "/limit/", $sql )) {
				list ( $sql, $limit ) = explode ( "limit", $sql );
			} else if (preg_match_all ( "/LIMIT/", $sql, $matchs )) {
				$p_l_cnt = count ( $matchs [0] );
				if ($p_l_cnt > 1) {
					$page_arr = explode ( "LIMIT", $sql );
					for($pi=0;$pi<$p_l_cnt;$pi++){
						if($new_page_arr[0]) $new_page_arr[0] .=" LIMIT ";
						$new_page_arr[0] .=$page_arr[$pi];
					}
					$new_page_arr[1]=$page_arr[$p_l_cnt];
					//print_r($new_page_arr);
					list ( $sql, $limit ) = $new_page_arr;
				} else
					list ( $sql, $limit ) = explode ( "LIMIT", $sql );
				//echo $sql;
			}
			if (isset ( $limit )) {
				list ( $cnt1, $cnt2 ) = explode ( ",", $limit );
				if (! empty ( $cnt2 )) {
					$this->PageSize = $cnt2;
				} elseif (! empty ( $cnt1 )) {
					$this->PageSize = $cnt1;
				}
			}
			$this->QueryString = $sql;
			unset ( $cnt1, $cnt2 );
		}
	}
	function InitSet($prevStr = "上一页", $nextStr = "下一页") {
		$this->prevStr = $prevStr;
		$this->nextStr = $nextStr;
	}
	
	// 获取相应规定数目的记录并计算出总记录数，总页数等参数
	function StartPage() {
		global $mysqli;
		$this->InitSet ();
		$Result = $mysqli->query ( $this->QueryString );
		if (! is_object ( $Result )) {
			echo $mysqli->error;
			exit ();
		}
		$this->RecordNum = $Result->num_rows;
		$this->TotalPage = ceil ( $this->RecordNum / $this->PageSize );
		// 获取url中传过来的当前页数，保证其为整数值
		if (isset ( $_REQUEST ['page'] )) {
			$this->NowPage = intval ( $_REQUEST ['page'] );
		}
		if ($this->NowPage <= 0) {
			$this->NowPage = 1;
		} elseif ($this->NowPage > $this->TotalPage) {
			$this->NowPage = $this->TotalPage;
		}
		$OffSet = $this->PageSize * ($this->NowPage - 1);
		if ($OffSet < 0)
			$OffSet = 0;
		$sql = $this->QueryString . " LIMIT " . $OffSet . "," . $this->PageSize;
		return $sql;
	}
	
	// 显示翻页按扭,当总页数小于每页记录数时不显示分页, $z为命名锚记如#box
	function EndPage($x = 2, $y = 1, $z = '',$j='') {
		$this->anchor = $z;
		if ($y == 1) {
			$pgfl = "page-floatR";
			$this->pgo = "right0";
		} elseif ($y == 2) {
			$pgfl = "page-floatL";
			$this->pgo = "left0";
		} else {
			$pgfl = "page-floatC";
			$this->pgo = "right50";
		}
		$FirstPage = 1;
		$PrevPage = $this->NowPage - 1;
		$NextPage = $this->NowPage + 1;
		$LastPage = $this->TotalPage;
		if ($this->RecordNum > $this->PageSize) {
			$ReturnStr = "<div class=\"pagination\"><div class=\"$pgfl\">";
			$ReturnStr .= $this->ToPage ( $PrevPage, $this->prevStr, 'prev' );
			$ReturnStr .= $this->DisPageNum ( $x );
			$ReturnStr .= $this->ToPage ( $NextPage, $this->nextStr, 'next' );
			if($j==1){
				$ReturnStr .= "&nbsp; 跳到：<input style=\"width:35px;\" name=\"topage\" id=\"topage\" onkeypress=\"
					if(event.keyCode==13){
					window.location=window.location.protocol+'//'+window.location.host+window.location.pathname+'?page='+$('#topage').val()}\"/>";
			}
			$ReturnStr .= "</div></div>";
		} else {
			$ReturnStr = '&nbsp;';
		}
		return $ReturnStr;
	}
	
	// 创建翻页按扭，并根据$Flag的值来设置按扭是否可用
	// $Page 将要跳转的页数
	// $Msg 跳转按扭名称
	// $Flag 按扭显示类型
	function ToPage($Page, $Msg, $Flag = '') {
		$Url = $this->GetUrl ( $Page );
		$pgo = $this->pgo;
		$UrlStr = "<a class=\"$pgo\" href=\"" . $Url . "\">" . $Msg . "</a>";
		if ($Page < 1 || $Page > $this->TotalPage) {
			$UrlStr = '';
		}
		if ($Page == $this->NowPage) {
			$UrlStr = "<span class=\"page-cur {$pgo}\">" . $Msg . "</span>";
		}
		if ($Flag) {
			if ($this->NowPage <= 1 && $Flag == 'prev') {
				$UrlStr = "<span class=\"page-start {$pgo}\"><span>" . $Msg . "</span></span>";
			}
			if ($this->NowPage >= $this->TotalPage && $Flag == 'next') {
				$UrlStr = "<span class=\"page-end {$pgo}\"><span>" . $Msg . "</span></span>";
			}
			if ($this->NowPage > 1 && $Flag == 'prev') {
				$UrlStr = "<a href=\"" . $Url . "\" class=\"page-prev {$pgo}\"><span>" . $Msg . "</span></a>";
			}
			if ($this->NowPage < $this->TotalPage && $Flag == 'next') {
				$UrlStr = "<a href=\"" . $Url . "\" class=\"page-next {$pgo}\"><span>" . $Msg . "</span></a>";
			}
		}
		return $UrlStr;
	}
	
	// 获取当前的URL，并对将要跳转的URL做修改
	// $Page将要跳转的页数
	function GetUrl($Page) {
		/*if ($_SERVER ['SERVER_PORT'] == 80) {
			
		} else {
			$Url = "https://" . $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];
		}*/
		$host = $_SERVER ['HTTP_HOST'] ? $_SERVER ['HTTP_HOST']:$_SERVER ['SERVER_NAME'];
		if($_SERVER['HTTPS']!= "on"){
			$Url = "http://" . $host . $_SERVER ['REQUEST_URI'];
		}else{
			$Url = "https://" . $host . $_SERVER ['REQUEST_URI'];
		}
		
			
		// 对url做修改，将url中的?page="任何字符" 或者 &page="任何字符" 替换成空
		$Url = preg_replace ( "/\?page=\w*/i", "", $Url );
		$Url = preg_replace ( "/&page=\w*/i", "", $Url );
		if ($Page === 0) {
			return $Url;
		}
		// 判断先前是否已url传值，是则加&page=,否则加?page=
		if (preg_match ( "/\?/", $Url )) {
			$Url = $Url . "&page=" . $Page;
		} else {
			$Url = $Url . "?page=" . $Page;
		}
		$Url .= $this->anchor;
		return $Url;
	}
	
	// 翻页效果，当前页保持前后$x页，如$x=2当前为5的话 1 2 ...3 4 5 6 7 ...8 9
	function DisPageNum($x) {
		if (! isset ( $PageNumString ))
			$PageNumString = '';
		if ($x < 1)
			$x = 1;
		$fix = 1 + $x;
		$PNS = $leftPNS = $rightPNS = '';
		$pgo = $this->pgo;
		$pageBreak = "<span class=\"page-break {$pgo}\">...</span>";
		$Tpg = $this->TotalPage;
		$Npg = $this->NowPage;
		for($i = $Npg - $x; $i <= $Npg + $x; $i ++) {
			$PNS .= $this->ToPage ( $i, $i );
		}
		if ($Npg > $fix) {
			$cha = $Npg - $fix;
			for($i = 1; $i <= $cha; $i ++) {
				if ($i == $fix) {
					$leftPNS .= $pageBreak;
					break;
				}
				$leftPNS .= $this->ToPage ( $i, $i );
			}
		}
		$fix = $Tpg - $x;
		if ($Npg < $fix) {
			$cha = $fix - $Npg;
			for($i = $Tpg - $cha + 1; $i <= $Tpg; $i ++) {
				if ($fix > $i) {
					$rightPNS = $pageBreak;
				} elseif ($fix != $i) {
					$rightPNS .= $this->ToPage ( $i, $i );
				}
			}
		}
		$PageNumString = $leftPNS . $PNS . $rightPNS;
		return $PageNumString;
	}
}
