<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Ödeme Sayfası - {{ getFunction("site") }}</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/' . getFunction('favicon')) }}">
</head>
<body>

<div style="width: 100%;margin: 0 auto;display: table;">


    @if($gateway == "paytr")<script src="https://www.paytr.com/js/iframeResizer.min.js"></script> @endif




    <iframe src="{{ $pos_request->iframesrc }}" id="@if($gateway == "paytr")paytriframe @endif" frameborder="0" scrolling="no" style="width: 100%;"></iframe>

        @if($gateway == "paytr")<script>iFrameResize({},'#paytriframe');</script>@endif

</div>

<br><br>
</body>
</html>
