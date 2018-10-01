<head>
	<title>Payment | {{isset($curUser) ? $curUser->facilityname :'Current User'}}</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<style type="text/css">
		@media only screen and (max-width: 767px) {
			.navbar-nav {
				flex-direction: column;
				text-align: center;
			}
		}
		body {
		    font: 16px/26px 'Roboto', Arial, Tahoma, sans-serif;
		}
		.card-body-icon {
			position: absolute;
			z-index: 0;
			top: -1.25rem;
			right: -1rem;
			opacity: 0.4;
			font-size: 5rem;
			-webkit-transform: rotate(15deg);
			transform: rotate(15deg);
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
		var arrChg = [], arrDesc = [], arrAmt = [];
		function _addCh(arrRec) {
			var indOf = arrChg.indexOf(arrRec[0]);
			if(indOf < 0) {
				arrChg.push(arrRec[0]);
				arrDesc.push(arrRec[1]);
				arrAmt.push(arrRec[2]);
			}
			 _loadCh();
		}
		function _loadCh() {
			if(arrChg.length > 0) {
				document.getElementById('tBody').innerHTML = ''; var _total = 0;
				for(var i = 0; i < arrChg.length; i++) {
					document.getElementById(arrChg[i]).classList.remove('fa-plus-circle'); document.getElementById(arrChg[i]).classList.add('fa-check-circle'); _total = _total +(parseInt(arrAmt[i]));
					document.getElementById('tBody').innerHTML += '<tr> <td>'+arrDesc[i]+'</td><td>&#8369; '+arrAmt[i]+'</td><td><i class="fa fa-times-circle" style="cursor: pointer;" onclick="_delCh(\''+arrChg[i]+'\')"></i></td> <input type="hidden" name="chgapp_id[]" value="'+arrChg[i]+'"><input type="hidden" name="desc[]" value="'+arrDesc[i]+'"><input type="hidden" name="amt[]" value="'+arrAmt[i]+'"></tr>';
				}
				document.getElementById('tlPayment').innerHTML = _total;
			} else {
				document.getElementById('tBody').innerHTML = '<tr> <td colspan="3">None</td> </tr>';
				document.getElementById('tlPayment').innerHTML = '0';
			}
		}
		function _delCh(inOf) {
			var indOf = arrChg.indexOf(inOf);
			if(indOf > -1) {
				document.getElementById(arrChg[indOf]).classList.add('fa-plus-circle');
				document.getElementById(arrChg[indOf]).classList.remove('fa-check-circle');
				arrChg.splice(indOf, 1);
				arrDesc.splice(indOf, 1);
				arrAmt.splice(indOf, 1);
			}
			_loadCh();
		}
		function _nxtCh(inOf) {
			for(var i = 0; i < document.getElementsByClassName('pp1').length; i++) {
				document.getElementsByClassName('pp1')[i].setAttribute('hidden', true);
			}
			document.getElementsByClassName('pp1')[inOf].removeAttribute('hidden');
		}
		function _fWalkIn(bool) {
			if(bool == true) {
				document.getElementById('_fWlkBtn').setAttribute('form', '_fWlk');
			} else {
				document.getElementById('_fWlkBtn').removeAttribute('form');
			}
		}
		function _getFooter() {
			var _newFootHeight = (document.body.clientHeight - (document.getElementsByTagName('nav')[0].clientHeight + document.getElementsByClassName('container')[0].clientHeight)) - document.getElementById('_footBottom').clientHeight;
			document.getElementById('_footBottom').style.marginTop = _newFootHeight + 'px';
		}
	</script>
</head>