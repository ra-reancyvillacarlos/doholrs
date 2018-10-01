<head>
	<title>Evaluation | {{isset($curUser) ? $curUser->facilityname :'Current User'}}</title>
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
	</script>
</head>