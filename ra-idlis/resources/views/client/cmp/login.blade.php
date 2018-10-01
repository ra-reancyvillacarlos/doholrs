<head>
	<title>Department of Health | {{isset($curUser) ? $curUser->facilityname :'Integrated DOH Licensing Information System'}}</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<style type="text/css">
		@media only screen and (max-width: 767px) {
			#__register {
				order: 1;
				-webkit-order: 1;
			}
			#__steps {
				order: 2;
				-webkit-order: 2;
			}
		}
		body {
		    font: 16px/26px 'Roboto', Arial, Tahoma, sans-serif;
		}
		.footer-bottom {
		    background: linear-gradient(to bottom left,#228B22, #84bd82);
		    min-height: 30px;
		    width: 100%;
		}
		.design {
		    color: #fff;
		    line-height: 30px;
		    min-height: 30px;
		    padding: 7px 0;
		    text-align: right;
		}
		.design a {
		    color: #fff;
		}
		.copyright {
		    color: #fff;
		    line-height: 30px;
		    min-height: 30px;
		    padding: 7px 0;
		}
	</style>
	<script type="text/javascript">
		"use strict";
		var curName = ""; var curNum = 0, pCurNum = 0;
		var bAds = [], cAds = [], pAds = [], rAds = [];
		function nextGroup(indOf) {
			curNum = (((curNum + indOf) > -1) ? (((curNum + indOf) < document.getElementsByName(curName).length) ? (curNum + indOf) : curNum) : curNum);
			if(curName != "") {
				for(var i = 0; i < document.getElementsByName(curName).length; i++) {
					document.getElementsByName(curName)[i].setAttribute('hidden', true);
				}
				document.getElementsByName(curName)[curNum].removeAttribute('hidden');
			}
			if(curNum < 1) {
				document.getElementById('btnprev').setAttribute('hidden', true);
				document.getElementById('btnnext').removeAttribute('hidden');
				document.getElementById('btnproc').setAttribute('hidden', true);
				document.getElementById('btnproc').removeAttribute('form');
			} else if(curNum == (document.getElementsByName(curName).length - 1)) {
				document.getElementById('btnnext').setAttribute('hidden', true);
				document.getElementById('btnprev').removeAttribute('hidden');
				document.getElementById('btnproc').removeAttribute('hidden');
				document.getElementById('btnproc').setAttribute('form', 'reg_form');
			} else {
				document.getElementById('btnprev').removeAttribute('hidden');
				document.getElementById('btnnext').removeAttribute('hidden');
				document.getElementById('btnproc').setAttribute('hidden', true);
				document.getElementById('btnproc').removeAttribute('form');
			}
			nextPrg(curNum);
		}
		function nextPrg(cNum) {
			var pNum = Math.round(((100/(document.getElementsByName(curName).length - 1)) * cNum));
			if(pCurNum < pNum) {
				for(var i = pCurNum; i <= pNum; i++) {
					document.getElementById('progress_id').style.width = i+'%';
					document.getElementById('progress_id').setAttribute('aria-valuenow', i+'px');
					document.getElementById('progress_id').innerHTML = i+'%';
				}
			} else {
				for(var i = pCurNum; i >= pNum; i--) {
					document.getElementById('progress_id').style.width = i+'%';
					document.getElementById('progress_id').setAttribute('aria-valuenow', i+'px');
					document.getElementById('progress_id').innerHTML = i+'%';
				}
			}
			pCurNum = pNum;
		}
		function chAdUser(indOf, colCur) {
			var curSel = document.getElementsByClassName('adUser')[indOf];
			var curId = ""; var arrDt = [rAds, pAds, cAds, bAds]; var curArr = arrDt[indOf];
			var intOf = 0;
			if(indOf > 0) {
				var divSel = document.getElementsByClassName('adUser')[(indOf - 1)];
				curId = divSel.options[divSel.selectedIndex].value;
			}
			for(var i = (indOf + 1); i < document.getElementsByClassName('adUser').length; i++) {
				document.getElementsByClassName('adUser')[i].innerHTML = "<option value hidden disabled selected>Select</option>";
			}
			curSel.innerHTML = "<option value hidden disabled selected>Select</option>";
			while(intOf < curArr.length) {
				if(colCur.length > 2) {
					if(curArr[intOf][colCur[2]] == curId) {
						curSel.innerHTML += '<option id="'+curArr[intOf][colCur[2]]+'" value="'+curArr[intOf][colCur[0]]+'">'+curArr[intOf][colCur[1]]+'</option>';
					}
				} else {
					curSel.innerHTML += '<option value="'+curArr[intOf][colCur[0]]+'">'+curArr[intOf][colCur[1]]+'</option>';
				}
				intOf++
			}
		}
	</script>
</head>