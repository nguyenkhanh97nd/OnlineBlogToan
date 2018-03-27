<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Bạn vừa đăng kí tài khoản tại Blog Toán</h2>

        <div>
        	Cảm ơn đã đăng kí tài khoản tại Blog Toán.
        	<br/>
        	Vui lòng xác nhận tài khoản bằng link bên dưới.
        	<br/>
            {{ URL::to('register/verify/' . $confirmation_code) }}.<br/>

        </div>

    </body>
</html>