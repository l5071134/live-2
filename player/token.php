<?php
session_start();
require_once '../incs/config.php';
if (!isset($_SESSION[$arrCfg['session-space']]['wowza-token']) || $_SESSION[$arrCfg['session-space']]['wowza-token'] === FALSE) {
	exit();
}
//else continue, set header and output obfuscated token
header('Content-Type: application/javascript');
?>
eval(function(p,a,c,k,e,d){e=function(c){return c.toString(36)};if(!''.replace(/^/,String)){while(c--){d[c.toString(a)]=k[c]||c.toString(a)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('1 3=["\\2\\6\\8\\5\\4\\7\\9\\2\\a\\c"];1 b=3[0];',13,13,'|var|x23|_0xe6c7|x25|x68|x70|x30|x75|x64|x74|thisToken|x32'.split('|'),0,{}))
var _0xe400=["\x30\x20\x31\x3D\x22\x23\x32\x25\x33\x23\x34\x22\x3B","\x7C","\x73\x70\x6C\x69\x74","\x76\x61\x72\x7C\x74\x68\x69\x73\x54\x6F\x6B\x65\x6E\x7C\x70\x75\x68\x7C\x30\x64\x7C\x74\x32","\x72\x65\x70\x6C\x61\x63\x65","","\x5C\x77\x2B","\x5C\x62","\x67"];eval(function (_0x7d3fx1,_0x7d3fx2,_0x7d3fx3,_0x7d3fx4,_0x7d3fx5,_0x7d3fx6){_0x7d3fx5=function (_0x7d3fx3){return _0x7d3fx3;} ;if(!_0xe400[5][_0xe400[4]](/^/,String)){while(_0x7d3fx3--){_0x7d3fx6[_0x7d3fx3]=_0x7d3fx4[_0x7d3fx3]||_0x7d3fx3;} ;_0x7d3fx4=[function (_0x7d3fx5){return _0x7d3fx6[_0x7d3fx5];} ];_0x7d3fx5=function (){return _0xe400[6];} ;_0x7d3fx3=1;} ;while(_0x7d3fx3--){if(_0x7d3fx4[_0x7d3fx3]){_0x7d3fx1=_0x7d3fx1[_0xe400[4]]( new RegExp(_0xe400[7]+_0x7d3fx5(_0x7d3fx3)+_0xe400[7],_0xe400[8]),_0x7d3fx4[_0x7d3fx3]);} ;} ;return _0x7d3fx1;} (_0xe400[0],5,5,_0xe400[3][_0xe400[2]](_0xe400[1]),0,{}));
<?php
//remove token access
unset($_SESSION[$arrCfg['session-space']]['wowza-token']);
?>