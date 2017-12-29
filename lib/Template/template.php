<?php
require 'template.class.php';

$template = Template::getInstance(); //使用单件模式实例化模板类
$template->setOptions($cfgTpl); //设置模板参数
//include($template->getfile('index'));