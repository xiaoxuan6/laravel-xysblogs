<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>h5跳转小程序支付demo</title>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.3.2.js"></script>
    <script src="https://alioss.woaap.com/base/jquery.min.js"></script>
    <style>
        .test {
            width: 200px;
            height: 40px;
            line-height: 40px;
            border: 1px solid #333;
            color: #333;
            border-radius: 20px;
            text-align: center;
            margin: 30px auto;
            display: none;
        }
        .ts, .tf {
            border: none;
        }
    </style>
</head>
<body>
<div class="test tp" onclick="getPay()">点击跳转小程序支付</div>
<div class="test ts">支付成功</div>
<div class="test tf">支付失败</div>
<script>
    var apiUrl = {
        dommain: 'http://atest.woaap.com:11007',
        payDemo: '/wechat-pay',
    }
    function getPay() {
        console.log('get pay')
        $.get(apiUrl.dommain+apiUrl.payDemo,{}, function (res) {
            if(0 == res.errcode) {
                var url = `/pages/others/thirdPay/index?timeStamp=${res.data.timStamp}&nonceStr=${res.data.nonceStr}&package=${res.data.package}&paySign=${res.data.paySign}`;
                console.log(url);
                wx.miniProgram.redirectTo({
                    url
                })
            }
        })

    }
    $(function() {
        $.getUrlParam = function (name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r != null) return unescape(r[2]); return null;
        }
        var t = $.getUrlParam('type');
        !t ? $('.tp').show() : (1 == t && $('.ts').show(), 2 == t && $('.tf').show());
    })
</script>
</body>
</html>