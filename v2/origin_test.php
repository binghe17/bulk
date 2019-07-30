<?php 

	//origin :  output is js code
	//문제: origin으로 설정된 사이트가 외부 사이트와 데이터를 주고 받지 못할때. ($.get, $.post, $.ajax $.load를 사용할수 없음) //js주입
	//해결: get방식으로 모든 데이터를 서버에 전송하고 조건에 따라 실행후의 결과를 js방식으로 리턴해서 클라이언트에서 바로실행하게 함

	//주의: 전역변수에 let가 없어야 함.
	//실행1: $("#resultBox").html('<script src="https://waterplay.kr/addonshop_event/bulk/datas/bulkdata.php?m=3" ></script>');//스크랩드 수정
	//실행2: $.getScript("https://waterplay.kr/addonshop_event/bulk/datas/bulkdata.php?m=3");//jquery비동기 요청
	//originAjax('https://waterplay.kr/addonshop_event/bulk/datas/bulkdata.php?m=5', {mode:'searchId', id:'leecojo'})
	//originAjax('https://waterplay.kr/addonshop_event/bulk/savefile_origin.php',  {mode:'searchId', id:'leecoo'}, function(){ console.log(res); });

	//예제
	// echo <<<xxxxxxxxxx
	// //JSCODE
	// xxxxxxxxxx;

if(isset($_GET['m'])){
if($_GET['m'] == 1){//-------------테스트 출력
echo <<<xxxxxxxxxx
res = 111;
console.log(res, '-----test m=1----');
xxxxxxxxxx;
die();
}


else if($_GET['m'] == 2){//--------------테스트 출력 (php변수 포함)
echo <<<xxxxxxxxxx
console.log("bbb222", {$_GET['m']});
xxxxxxxxxx;
die();
}


else if($_GET['m'] == 3){//--------------\\r, \\n, \t, \\t, \', \\', \", \\", \\\,  모든 글자체 전송가능함
$filename = basename(__FILE__);
echo <<<xxxxxxxxxx
var param = serialize({
	m:4,
	foo: "hi th bar['blah'] eraaa+aa&bar=bb 한글,中文测试,abc ,/,  -\\\-,  -\\n-, =\\t= \\' \\" ---++++=== ",
	bar: {
		blah: 123,
		quux: [1, 2, {a:"1111"}]
	}
})
data = '{$filename}?'+ param;
$.getScript(data);//비동기실행
// console.log(data);

// var b =originUrl('originAjax.php', {m:2});
// console.log(b);
xxxxxxxxxx;
}


else if($_GET['m'] == 4){//--------------클라이언트에서 보낸 모든 데이터(object) 출력
$json = json_encode( $_GET, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
echo <<<xxxxxxxxxx
console.log(`$json`);
xxxxxxxxxx;
die();
}


else if($_GET['m'] == 5){//--------------페이지 리다이렉트 완료후 반환값 보기
unset($_GET['m']); 
$json = json_encode( $_GET, JSON_UNESCAPED_UNICODE);
echo <<<xxxxxxxxxx
//  var param = serialize($json);
// url = 'https://waterplay.kr/addonshop_event/bulk/savefile_origin.php?'+ param;
// // console.log(url)
// $.getScript(url , function(){
// 	console.log(res );//전역변수res
// });//비동기실행


originAjax('https://waterplay.kr/addonshop_event/bulk/savefile_origin.php', $json, function(){
	console.log(res ) //전역변수res
});
xxxxxxxxxx;
die();
}
}



//----------include
echo <<<xxxxxxxxxx
//-------------------------------------JS정의
//완전한 요청주소
function originAjax(url, data, callback){
	url = originUrl(url, data);
	$.getScript(url , callback);//비동기실행
}

//url주소 만들기 //url + param
function originUrl(url, data){
	if(data == null) return url;
	else {
		if(url.indexOf('?') > 0) return url + '&'+ serialize(data);
		else return url +'?'+ serialize(data);
	}
}

//objcet를 url param형태로 전환
function serialize(obj, prefix) {
	var str = [], p;
	for (p in obj) {
		if (obj.hasOwnProperty(p)) {
			var k = prefix ? prefix + "[" + p + "]" : p,
			v = obj[p];
			str.push((v !== null && typeof v === "object") ? serialize(v, k) : encodeURIComponent(k) + "=" + encodeURIComponent(v));
		}
	}
	// return decodeURIComponent(str.join("&"));
	return str.join("&");
}
//---------------------------------------//
xxxxxxxxxx;

