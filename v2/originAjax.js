
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


//-----------------

	//origin :  output is js code
	//문제: origin으로 설정된 사이트가 외부 사이트와 데이터를 주고 받지 못할때. ($.get, $.post, $.ajax $.load를 사용할수 없음) //js주입
	//해결: get방식으로 모든 데이터를 서버에 전송하고 조건에 따라 실행후의 결과를 js방식으로 리턴해서 클라이언트에서 바로실행하게 함

	//주의: 전역변수에 let가 없어야 함.
	//실행1: $("#resultBox").html('<script src="bulkdata.php?m=3" ></script>');//스크랩드 수정
	//실행2: $.getScript("bulkdata.php?m=3");//jquery비동기 요청
	//originAjax('bulkdata.php?m=5', {mode:'searchId', id:'leecojo'})
	//originAjax('savefile_origin.php',  {mode:'searchId', id:'leecoo'}, function(){ console.log(res); });

