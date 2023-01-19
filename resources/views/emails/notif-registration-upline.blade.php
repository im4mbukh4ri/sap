<html>
<body style='background-color:#dddddd;'>
<div style='width:800px;margin:0px auto;'>
    <div style='padding:50px;'>
        <img src='https://smartinpays.com/images/logo/email/img_header_welcome.jpg' style='width:100%;'>
        <img src='https://smartinpays.com/images/logo/email/img_header_welcome02.jpg' style='width:100%;'>
        <p style='margin:0px;padding:25px;background-color:#ffffff;font-family:Arial;'>Hello <b>{{ $user->parent->name }}</b>,<br><br>
            Congratulations to you.<br>Someone has joined Smart In Pays using your referral code. <br><br>Name: <b>{{ $user->name }}</b><br>Email: <b>{{ $user->email }}</b><br>Phone: <b>{{ $user->address->phone }}</b>
            <br><br><br><br><br>Sincerely, <br><br>Smart in Pays (SIP) <br>www.smartinpays.com
        </p>

        <div style='height:48px;background-color:#25aae0;text-align:center;'>
            <p style='margin:0px;color:#ffffff;font-family:Arial;line-height:48px;'>www.smartinpays.com</p>
        </div>

        <p style='margin:0px;padding:25px 0px 0px;font-family:Arial;'> <i>Copyright &copy;2017 Smart in Pays, All rights reserved.</i>
            <br>This is an automated email, please do not reply to this email.
        </p>
    </div>
</div>
</body>
</html>