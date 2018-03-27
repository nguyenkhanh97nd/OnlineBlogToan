<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{!! $title !!}</h2>

        <div>
        	Admin thông báo bạn vừa tạo một bài viết mới trên <strong>Blog Toán</strong>.
        	<br/>
            @if($status == 0)
                Bài viết <strong>{!! $post_name !!}</strong> đang chờ phê duyệt.
            @else
                Bài viết <strong>{!! $post_name !!}</strong> đã được đăng tải.
                <br/>
                Đây là link bài viết:
                {!! URL::to($subcategory.'/'.$slug) !!}
            @endif
        	<br/>
            Cảm ơn bạn đã đóng góp vì cộng đồng học sinh cả nước.
        </div>

    </body>
</html>