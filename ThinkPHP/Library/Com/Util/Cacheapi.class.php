<?php

/* * 缓存更新 * Edit date：20120703
 * Author：旅行者
 */

class Cacheapi {

    protected $db, $fields;

    /**
     * 更新缓存 
     * 方法名
     * 参数
     */
    public function cache($model = '', $param = '') {
        $this->db = M($model);
        if (empty($param)) {
            $this->$model();
        } else {
            $this->$model($param);
        }
    }

    /**
     * 重新生成  Category Model Menu
     */
    public function site() {
        F("Config", M("Config")->getField("varname,value"));
        D("Category")->CategoryCache();
        D("Model")->ModelCache();
        //后台菜单
        D("Menu")->Menucache();
        //数组
        $eMenu = D("Menu")->select();
        foreach ($eMenu as $k => $v) {
            $data[$v['id']] = $v;
        }
        F("eMenu", $data);
        //评论配置缓存
        F("Comments_setting", M("CommentsSetting")->find());
    }

    /*
     * 更新模型缓存方法
     */

    public function sitemodel() {

        $this->fields = LIB_PATH . "Action" . DIRECTORY_SEPARATOR . "Models" . DIRECTORY_SEPARATOR . "fields" . DIRECTORY_SEPARATOR;
        require $this->fields . 'fields.inc.php';

        //更新内容模型数据处理相关类
        $classtypes = array('form', 'input', 'output','update');

        //缓存生成路径
        $cachemodepath = RUNTIME_PATH;

        foreach ($classtypes as $classtype) {
            $cache_data = file_get_contents($this->fields . "content_$classtype.class.php");
            $cache_data = str_replace('}?>', '', $cache_data);
            //循环字段列表，把各个字段的 form.inc.php 文件合并到 缓存 content_form.class.php 文件
            foreach ($fields as $field => $fieldvalue) {
                //检查文件是否存在
                if (file_exists($this->fields . $field . DIRECTORY_SEPARATOR . $classtype . '.inc.php')) {
                    //读取文件，$classtype.inc.php 
                    $ca = file_get_contents($this->fields . $field . DIRECTORY_SEPARATOR . $classtype . '.inc.php');
                    $cache_data .= str_replace(array("<?php", "?>"), "", $ca);
                }
            }
            $cache_data .= "\r\n } \r\n?>";
            //写入缓存
            file_put_contents($cachemodepath . 'content_' . $classtype . '.class.php', $cache_data);
            //设置权限
            chmod($cachemodepath . 'content_' . $classtype . '.class.php', 0777);
            unset($cache_data);
        }
        //推荐位缓存更新
        $this->position();
    }

    /**
     * 生成模型字段缓存 
     */
    public function Model_field() {
        $Mode = F("Model");
        foreach ($Mode as $modelid) {
            $data = $this->db->where(array("modelid" => $modelid['modelid'], "disabled" => 0))->order(" listorder ASC ")->select();
            foreach ($data as $key => $value) {
                $data[$value['field']] = $value;
                unset($data[$key]);
            }
            F("Model_field_" . $modelid['modelid'], $data);
        }
        unset($Mode);
        unset($data);
    }

    /**
     * 生成 Urlrule URL规则缓存 
     */
    public function Urlrule() {
        D("Urlrule")->public_cache_urlrule();
    }
    
    public function position(){
        $data = M("Position")->getField("posid,modelid,catid,name,maxnum,extention,listorder");
        F("Position",$data);
    }

}

?>
