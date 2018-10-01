<center><h1>DOHOLRS Account Registration</h1></center>
<h3>Hi, {{ $name }}</h3>
<p>Thank you for registering in our website. But, you must first verify your account</p>
<p>Verify your account by clicking the link below</p>
<a href="{{ asset('/register/verify') }}/{{ $token }}">Verify account</a>
<p disabled>Note: <strong>Unverified Accounts</strong> are restricted from logging in</p>
<p>Regards,</p>
<p>DOH Support</p>