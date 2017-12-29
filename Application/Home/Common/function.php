<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/9/12
 * Time: 14:15
 */
/**
 * ���ܽ���
 * @param type $string ���� �� ����
 * @param type $operation DECODE��ʾ����,������ʾ����
 * @param type $key �ܳ�
 * @param type $expiry ������Ч��
 * @return string
 * @time 2014/02/29
 */
function authcode($string, $operation = 'DECODE', $key = 'apps', $expiry = 0)
{
    // ��̬�ܳ׳��ȣ���ͬ�����Ļ����ɲ�ͬ���ľ���������̬�ܳ�
    $ckey_length = 4;
    // �ܳ�
    $key = md5(($key ? $key : C("AUTHCODE")));
    // �ܳ�a�����ӽ���
    $keya = md5(substr($key, 0, 16));
    // �ܳ�b��������������������֤
    $keyb = md5(substr($key, 16, 16));
    // �ܳ�c���ڱ仯���ɵ�����
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
    // ����������ܳ�
    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);
    // ���ģ�ǰ10λ��������ʱ���������ʱ��֤������Ч�ԣ�10��26λ��������$keyb(�ܳ�b)������ʱ��ͨ������ܳ���֤����������
    // ����ǽ���Ļ�����ӵ�$ckey_lengthλ��ʼ����Ϊ����ǰ$ckey_lengthλ���� ��̬�ܳף��Ա�֤������ȷ
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // �����ܳײ�
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // �ù̶����㷨�������ܳײ�����������ԣ�����ܸ��ӣ�ʵ���϶Բ������������ĵ�ǿ��
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // ���ļӽ��ܲ���
    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // ���ܳײ��ó��ܳ׽��������ת���ַ�
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if ($operation == 'DECODE') {
        // substr($result, 0, 10) == 0 ��֤������Ч��
        // substr($result, 0, 10) - time() > 0 ��֤������Ч��
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) ��֤����������
        // ��֤������Ч�ԣ��뿴δ�������ĵĸ�ʽ
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        // �Ѷ�̬�ܳױ������������Ҳ��Ϊʲôͬ�������ģ�������ͬ���ĺ��ܽ��ܵ�ԭ��
        // ��Ϊ���ܺ�����Ŀ�����һЩ�����ַ������ƹ��̿��ܻᶪʧ��������base64����
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}