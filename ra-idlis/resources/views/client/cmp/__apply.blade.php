<head>
	<title>Apply | {{isset($curUser) ? $curUser->facilityname :'Current User'}}</title>
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
			.hide-div {
				display: none;
			}
			.col-border-right > div {
				border-right: 0px !important;
				border-bottom: 1px solid !important;
			}
			.col-border-right > div:last-child {
				border-right: 0px !important;
				border-bottom: 0px !important;
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
		.col-border-right > div {
			border-right: 1px solid;
			border-bottom: 0px;
		}
		.col-border-right > div:last-child {
			border: 0;
		}
	</style>
	<script type="text/javascript">
		"use strict";
		var clArr = [], owArr = [];
		var clDesc = "", owDesc = "";
		function __chApt(clVal) {
			var arrClr = ['bg-info', 'bg-warning', 'bg-danger', 'bg-success'];
			for(var i = 0; i < document.getElementsByName('__hfaci').length; i++) {
				for(var j = 0; j < arrClr.length; j++) {
					document.getElementsByName('__hfaci')[i].classList.remove(arrClr[j]);
				}
				if(clVal != '') {
					if(document.getElementsByName('__hfaci')[i].classList.contains(clVal)) {
						if(document.getElementsByName('__hfaci')[i].classList.contains(clVal+'_0')) {
							document.getElementsByName('__hfaci')[i].classList.add(arrClr[1]);
							document.getElementsByName('__hfaci')[i].setAttribute('onclick', 'window.location.href = "{{asset('/client/apply/view/')}}/'+document.getElementsByName('__hfaci')[i].id+'";');
						} else if(document.getElementsByName('__hfaci')[i].classList.contains(clVal+'_1')) {
							document.getElementsByName('__hfaci')[i].classList.add(arrClr[2]);
							document.getElementsByName('__hfaci')[i].setAttribute('onclick', 'window.location.href = "{{asset('/client/apply/new/')}}/'+document.getElementsByName('__hfaci')[i].id+'";');
						} else if(document.getElementsByName('__hfaci')[i].classList.contains(clVal+'_2 ')) {
							document.getElementsByName('__hfaci')[i].classList.add(arrClr[3]);
							document.getElementsByName('__hfaci')[i].setAttribute('onclick', 'window.location.href = "{{asset('/client/apply/view/')}}/'+document.getElementsByName('__hfaci')[i].id+'";');
						} else {
							document.getElementsByName('__hfaci')[i].classList.add(arrClr[0]);
							document.getElementsByName('__hfaci')[i].setAttribute('onclick', 'window.location.href = "{{asset('/client/apply/new/')}}/'+document.getElementsByName('__hfaci')[i].id+'";');
						}
					} else {
						document.getElementsByName('__hfaci')[i].classList.add(arrClr[0]);
						document.getElementsByName('__hfaci')[i].setAttribute('onclick', 'window.location.href = "{{asset('/client/apply/new/')}}/'+document.getElementsByName('__hfaci')[i].id+'";');
					}
				} else {
					document.getElementsByName('__hfaci')[i].classList.add(arrClr[0]);
					document.getElementsByName('__hfaci')[i].removeAttribute('onclick');
				}
			}
		}
		function __chCl(owVal, clVal) {
			if(owVal == null || owVal == "" || owVal == undefined) {
				document.getElementsByName('owTbl')[0].innerHTML = '<option hidden selected disabled value>Select Ownership</option>';
				for(var i = 0; i < owArr.length; i++) {
					document.getElementsByName('owTbl')[0].innerHTML += '<option value="'+owArr[i]["ocid"]+'">'+owArr[i]["ocdesc"]+'</option>';
				}
				document.getElementsByName('owTbl')[0].removeAttribute('hidden');
				document.getElementsByName('owTbl')[1].setAttribute('hidden', true);

				document.getElementsByName('clTbl')[0].innerHTML = '<option hidden selected disabled value>Select Class</option>';
				document.getElementsByName('clTbl')[0].removeAttribute('hidden');
				document.getElementsByName('clTbl')[1].setAttribute('hidden', true);
			} else {
				document.getElementsByName('owTbl')[0].removeAttribute('hidden'); document.getElementsByName('owTbl')[1].setAttribute('hidden', true); document.getElementsByName('clTbl')[0].removeAttribute('hidden'); document.getElementsByName('clTbl')[1].setAttribute('hidden', true); var clBol = true;
				for(var i = 0; i < owArr.length; i++) {
					if(owVal == owArr[i]["ocid"]) {
						document.getElementsByName('owTbl')[0].selectedIndex = (i + 1);
						if(owArr[i]["oc_getDesc"] == 1) {
							document.getElementsByName('owTbl')[1].removeAttribute('hidden');
							document.getElementsByName('owTbl')[0].setAttribute('hidden', true);
							document.getElementsByName('clTbl')[1].removeAttribute('hidden');
							document.getElementsByName('clTbl')[0].setAttribute('hidden', true);
							document.getElementsByName('owTbl')[1].value = ((owDesc != "") ? owDesc : "");
							document.getElementsByName('clTbl')[1].value = ((clDesc != "") ? clDesc : "");
							clBol = false;
						}
					}
				}
				document.getElementsByName('clTbl')[0].innerHTML = '<option hidden selected disabled value>Select Class</option>';
				for(var i = 0; i < clArr.length; i++) {
					if(clArr[i]['ocid'] == owVal) {
						document.getElementsByName('clTbl')[0].innerHTML += '<option value="'+clArr[i]['classid']+'">'+clArr[i]['classname']+'</option>';
					}
				}
				if(document.getElementsByName('clTbl')[0].options.length > 1) {
					document.getElementsByName('clTbl')[0].selectedIndex = 1;
				}
			}

			if(clVal != null || clVal != undefined || clVal != "") {
				document.getElementsByName('clTbl')[0].removeAttribute('hidden'); document.getElementsByName('clTbl')[1].setAttribute('hidden', true); var clBol = true;
				for(var i = 0; i < document.getElementsByName('clTbl')[0].options.length; i++) {
					if(clVal == document.getElementsByName('clTbl')[0].options[i].value) {
						document.getElementsByName('clTbl')[0].selectedIndex = i;
					}
				}
			}
		}
	</script>
</head>