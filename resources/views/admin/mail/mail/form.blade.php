<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{!! $title !!}</h2>

        <div>
            
            Xin chào
            @if(isset($level))
                @if($level == 1)
                    {!! 'Admin ' !!}
                @elseif($level == 2) 
                    {!! 'Editor ' !!}
                @elseif($level == 3)
                    {!! 'Member ' !!}
                @else
                @endif
            @endif
            <strong>{!! isset($user) ? $user : '' !!}</strong>!
            <br/>
        	{!! $content !!}
        	<br/>
            <strong>Cảm ơn bạn đã sử dụng dịch vụ của Blog Toán.</strong>
        </div>

    </body>
</html>