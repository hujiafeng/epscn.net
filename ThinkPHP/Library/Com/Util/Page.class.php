<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// |         lanfengye <zibin_5257@163.com>
// +----------------------------------------------------------------------
namespace Com\Util;
class Page {

    private $Page_size; //每页显示的条目数
    private $Total_Size; //总条目数
    private $Current_page; //当前被选中的页
    private $List_Page; //每次显示的页数  默认列表每页显示行数
    private $Total_Pages=20; //总页数
    private $Page_tpl = array(); // 分页模板
    private $PageParam;
    private $PageLink;
    private $Static;
     // 起始行数
    public $firstRow;
    public $listRows;

     //Page([总记录数=1]，   [分页大小=20]，     [当前页=1]，         [显示页数=6]，     [分页参数='page'],      [分页链接=当前页面],[是否静态=FALSE])
    function __construct($Total_Size = 1, $Page_Size = 20, $Current_Page = 1, $List_Page = 6, $PageParam = 'page', $PageLink = '', $Static = FALSE) {
        $this->Page_size = intval($Page_Size);
        $this->Total_Size = intval($Total_Size);
        if (!$Current_Page) {
            $this->Current_page = 1;
        } else {
            $this->Current_page = intval($Current_Page);
        }
        //总分页数
        $this->Total_Pages = ceil($Total_Size / $Page_Size);
        //一次显示多少个链接
        $this->List_Page = intval($List_Page);
        //接收分页参数的标识符
        $this->PageParam = $PageParam;
        //当前页面地址，当需要生成静态地址，此参数需要给，分页号用{page}
        $this->PageLink = (empty($PageLink) ? $_SERVER ["PHP_SELF"] : $PageLink);
        //是否开启静态
        $this->Static = $Static;
        
        $this->Page_tpl ['default'] = array('Tpl' => '<div class="pager">{first}{prev}{liststart}{list}{listend}{next}{last} 跳转到{jump}页</div>', 'Config' => array());
        
        $this->GetCurrentPage();
        
        $this->listRows = $Page_Size;
        
        $this->firstRow = ($this->Current_page-1)*$this->listRows;
    }

    public function __set($Param, $value) {
        $this->$Param = $value;
    }

    public function __get($Param) {
        return $this->$Param;
    }

    /*
      __destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。
     */

    function __destruct() {
        unset($Page_size); //每页显示的条目数
        unset($Total_Size); //总条目数
        unset($Current_page); //当前被选中的页
        unset($List_Page); //每次显示的页数
        unset($Total_Pages); //总页数
        unset($Page_tpl); // 分页模板
        unset($PageParam); //分页参数，默认page
        unset($PageLink);
        unset($Static);
        unset($firstRow);
        unset($listRows);
    }

    private function UrlParameters($url = array()) {
       foreach ($url as $key => $val) {
            if ($key != $this->PageParam && $key!="_URL_")
			if($val != '')$arg [$key] =  $val;
        }
        $arg[$this->PageParam] =  '*';
		
        if ($this->Static){
            //当启用静态地址，$this->PageLink传入的是array，并且包含两个 index,list
            /*
             * array(
             *    "index"=>"http://www.a.com/192.html",//这种是表示当前是首页，无需加分页1
             *    "list"=>"http://www.a.com/192-{page}.html",//这种表示分页非首页时启用
             * )
             */
            if(is_array($this->PageLink)){
                return str_replace('{$page}', '*', $this->PageLink['list']);
            }else{
                return str_replace('{page}', '*', $this->PageLink);
            }
       }else{
           return str_replace("%2A","*",U("".MODULE_NAME."/".CONTROLLER_NAME."/".ACTION_NAME,$arg));
       }
	   
    }

    public function SetPager($Tpl_Name = 'default', $Tpl = '', $Config = array()) {
        if (empty($Tpl))
            $Tpl = $this->Page_tpl ['default'] ['Tpl'];
        if (empty($Config))
            $Config = $this->Page_tpl ['default'] ['Config'];
	
        $this->Page_tpl [$Tpl_Name] = array('Tpl' => $Tpl, 'Config' => $Config);
    }

    public function show($Tpl_Name = 'default') {
        //当分页数只有1的时候，不显示
        if($this->Total_Pages<=1){
            return;
        }
        return $this->Pager($this->Page_tpl [$Tpl_Name]);
    }

    public function GetCurrentPage() {
        $this->Current_page = ($_GET [$this->PageParam] <= intval($this->Total_Pages) ? ($_GET [$this->PageParam] < 1 ? 1 : intval($_GET [$this->PageParam])) : intval($this->Total_Pages));
    }

    public function Pager($Page_tpl = '') {
        if (empty($Page_tpl))
            $Page_tpl = $this->Page_tpl ['default'];
        $cfg = array('recordcount' => intval($this->Total_Size), 'pageindex' => intval($this->Current_page), 'pagecount' => intval($this->Total_Pages), 'pagesize' => intval($this->Page_size), 'listlong' => intval($this->List_Page), 'listsidelong' => 2, 'list' => '*', 'currentclass' => 'current', 'link' => $this->UrlParameters($_GET), 'first' => '&laquo;', 'prev' => '&#8249;', 'next' => '&#8250;', 'last' => '&raquo;', 'more' => '...', 'disabledclass' => 'disabled', 'jump' => 'input', 'jumpplus' => '', 'jumpaction' => '', 'jumplong' => 50);
        if (!empty($Page_tpl ['Config'])) {
            foreach ($Page_tpl ['Config'] as $key => $val) {
                if (array_key_exists($key, $cfg))
                    $cfg [$key] = $val;
            }
        }
        $tmpStr = $Page_tpl ['Tpl'];
        $pStart = $cfg ['pageindex'] - (($cfg ['listlong'] / 2) + ($cfg ['listlong'] % 2)) + 1;
        $pEnd = $cfg ['pageindex'] + $cfg ['listlong'] / 2;
        if ($pStart < 1) {
            $pStart = 1;
            $pEnd = $cfg ['listlong'];
        }
        if ($pEnd > $cfg ['pagecount']) {
            $pStart = $cfg ['pagecount'] - $cfg ['listlong'] + 1;
            $pEnd = $cfg ['pagecount'];
        }
        if ($pStart < 1)
            $pStart = 1;
        for ($i = $pStart; $i <= $pEnd; $i++) {
            if ($i == $cfg ['pageindex']){
                $pList .= '<span class="' . $cfg ['currentclass'] . '" >' . str_replace('*', $i, $cfg ['list']) . '</span> ';
            }else{
                //此处是为了照顾静态地址生成时，第一页不显示当前分页1，启用该方法，静态地址需要$this->PageLink传入的是array，并且包含两个 index,list。index是首页
                //事例用法  new Page(50,5,2,6,"page",array("index"=>"http://www.a.com/192.html","list"=>"http://www.a.com/192-{page}.html",),true);
                if($this->Static && $i==1){
                    $pList .= ' <a href="' . $this->PageLink['index'] . '"> ' . str_replace('*', $i, $cfg ['list']) . '</a> ';
                }else{
                    $pList .= ' <a href="' . str_replace('*', $i, $cfg ['link']) . '"> ' . str_replace('*', $i, $cfg ['list']) . '</a> ';
                }
            }
        }
        if ($cfg ['listsidelong'] > 0) {
            if ($cfg ['listsidelong'] < $pStart) {
                for ($i = 1; $i <= $cfg ['listsidelong']; $i++) {
                    $pListStart .= '<a href="' . str_replace('*', $i, $cfg ['link']) . '">' . str_replace('*', $i, $cfg ['list']) . '</a> ';
                }
                $pListStart .= ($cfg ['listsidelong'] + 1) == $pStart ? '' : $cfg ['more'] . ' ';
            } else {
                if ($cfg ['listsidelong'] >= $pStart && $pStart > 1) {
                    for ($i = 1; $i <= ($pStart - 1); $i++) {
                        $pListStart .= '<a href="' . str_replace('*', $i, $cfg ['link']) . '">' . str_replace('*', $i, $cfg ['list']) . '</a> ';
                    }
                }
            }
            if (($cfg ['pagecount'] - $cfg ['listsidelong']) > $pEnd) {
                $pListEnd = ' ' . $cfg ['more'] . $pListEnd;
                for ($i = (($cfg ['pagecount'] - $cfg ['listsidelong']) + 1); $i <= $cfg ['pagecount']; $i++) {
                    $pListEnd .= ' <a href="' . str_replace('*', $i, $cfg ['link']) . '"> ' . str_replace('*', $i, $cfg ['list']) . ' </a> ';
                }
            } else {
                if (($cfg ['pagecount'] - $cfg ['listsidelong']) <= $pEnd && $pEnd < $cfg ['pagecount']) {
                    for ($i = ($pEnd + 1); $i <= $cfg ['pagecount']; $i++) {
                        $pListEnd .= ' <a href="' . str_replace('*', $i, $cfg ['link']) . '"> ' . str_replace('*', $i, $cfg ['list']) . ' </a> ';
                    }
                }
            }
        }
        //上一页 首页
        if ($cfg ['pageindex'] > 1) {
            if($this->Static){
                $pFirst = ' <a href="' . $this->PageLink['index']. '">' . $cfg ['first'] . '</a> ';//首页
            }else{
                $pFirst = ' <a href="' . str_replace('*', 1, $cfg ['link']). '">' . $cfg ['first'] . '</a> ';//首页
            }
            if($this->Static && ($cfg ['pageindex'] - 1)==1){
                $pPrev = ' <a href="' . $this->PageLink['index'] . '">' . $cfg ['prev'] . '</a> ';//上一页
            }else{
                $pPrev = ' <a href="' . str_replace('*', $cfg ['pageindex'] - 1, $cfg ['link']) . '">' . $cfg ['prev'] . '</a> ';
            }
        } 
        //下一页，尾页
        if ($cfg ['pageindex'] < $cfg ['pagecount']) {
            $pLast = ' <a href="' . str_replace('*', $cfg ['pagecount'], $cfg ['link']) . '">' . $cfg ['last'] . '</a> ';
            $pNext = ' <a href="' . str_replace('*', $cfg ['pageindex'] + 1, $cfg ['link']) . '">' . $cfg ['next'] . '</a> ';
        }
        
        //快捷跳转方式
        switch (strtolower($cfg ['jump'])) {
            case 'select' :
                $pJumpValue = 'this.value';
                $pJump = ' <input type="text" size="3" title="请输入要跳转到的页数并回车"' . (($cfg ['jumpplus'] == '') ? '' : ' ' . $cfg ['jumpplus']);
                $pJump .= ' onkeydown="javascript:if(event.charCode==13||event.keyCode==13){if(!isNaN(' . $pJumpValue . ')){';
                $pJump .= ($cfg ['jumpaction'] == '' ? ((strtolower(substr($cfg ['link'], 0, 11)) == 'javascript:') ? str_replace('*', $pJumpValue, substr($cfg ['link'], 12)) : " document.location.href='" . str_replace('*', '\'+' . $pJumpValue . '+\'', $cfg ['link']) . '\';') : str_replace("*", $pJumpValue, $cfg ['jumpaction']));
                $pJump .= '}return false;}" />';
                break;
            case 'input' :
                $pJumpValue = "this.options[this.selectedIndex].value";
                $pJump = '<select ' . ($cfg ['jumpplus'] == '' ? ' ' . $cfg ['jumpplus'] . ' onchange="javascript:' : $cfg ['jumpplus']);
                $pJump .= ($cfg ['jumpaction'] == '' ? ((strtolower(substr($cfg ['link'], 0, 11)) == 'javascript:') ? str_replace('*', $pJumpValue, substr($cfg ['link'], 12)) : " document.location.href='" . str_replace('*', '\'+' . $pJumpValue . '+\'', $cfg ['link']) . '\';') : str_replace("*", $pJumpValue, $cfg ['jumpaction']));
                $pJump .= '" title="请选择要跳转到的页数"> ';
                if ($cfg ['jumplong'] == 0) {
                    for ($i = 0; $i <= $cfg ['pagecount']; $i++) {
                        $pJump .= '<option value="' . $i . '"' . (($i == $cfg ['pageindex']) ? ' selected="selected"' : '') . ' >' . $i . '</option> ';
                    }
                } else {
                    $pJumpLong = intval($cfg ['jumplong'] / 2);
                    $pJumpStart = ((($cfg ['pageindex'] - $pJumpLong) < 1) ? 1 : ($cfg ['pageindex'] - $pJumpLong));
                    $pJumpStart = ((($cfg ['pagecount'] - $cfg ['pageindex']) < $pJumpLong) ? ($pJumpStart - ($pJumpLong - ($cfg ['pagecount'] - $cfg ['pageindex'])) + 1) : $pJumpStart);
                    $pJumpStart = (($pJumpStart < 1) ? 1 : $pJumpStart);
                    $j = 1;
                    for ($i = $pJumpStart; $i <= $cfg ['pageindex']; $i++, $j++) {
                        $pJump .= '<option value="' . $i . '"' . (($i == $cfg ['pageindex']) ? ' selected="selected"' : '') . '>' . $i . '</option> ';
                    }
                    $pJumpLong = $cfg ['pagecount'] - $cfg ['pageindex'] < $pJumpLong ? $pJumpLong : $pJumpLong + ($pJumpLong - $j) + 1;
                    $pJumpEnd = $cfg ['pageindex'] + $pJumpLong > $cfg ['pagecount'] ? $cfg ['pagecount'] : $cfg ['pageindex'] + $pJumpLong;
                    for ($i = $cfg ['pageindex'] + 1; $i <= $pJumpEnd; $i++) {
                        $pJump .= '<option value="' . $i . '">' . $i . '</option> ';
                    }
                }
                $pJump .= '</select>';
                break;
        }
        $patterns = array('/{recordcount}/', '/{pagecount}/', '/{pageindex}/', '/{pagesize}/', '/{list}/', '/{liststart}/', '/{listend}/', '/{first}/', '/{prev}/', '/{next}/', '/{last}/', '/{jump}/');
        $replace = array($cfg ['recordcount'], $cfg ['pagecount'], $cfg ['pageindex'], $cfg ['pagesize'], $pList, $pListStart, $pListEnd, $pFirst, $pPrev, $pNext, $pLast, $pJump);
        $tmpStr = chr(13) . chr(10) . preg_replace($patterns, $replace, $tmpStr) . chr(13) . chr(10);
        unset($cfg);
        return $tmpStr;
    }

}
