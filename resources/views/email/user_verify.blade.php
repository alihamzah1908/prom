<html>
<head></head>
<body>
    <div style="background: #fbfbfb;">
        <!--<div>-->
        <!--    <div style="padding: 2% 3%;max-width: 150px;max-height:50px;"></div>-->
        <!--</div>-->
        
        <div style="padding:1%;text-align:center;background: #4190f2;">
            <div style="color:#fff;font-size:20px;font-weight:500;">PROM - Palapa Ring Operation & Maintenance</div>
        </div>
        
        <div style="max-width:560px;margin:auto;padding: 0 3%;">
            <div style="padding: 30px 0; color: #555;line-height: 1.7;">
                <h3>
                    <b>
                        Dear {{$name}}, 
                    </b>
                </h3>
                {{$msg}}
                <br>
            </div>
            
            <br>
             <div style="padding:1%;text-align:center;">
            <a href="{{$verify_url}}">{{$verify_url}}</a><br>
            </div>
            <br>
            <a style="width:100%;" href="{{$verify_url}}">
                <div style="padding:1%;text-align:center;background: #4190f2;">
                    <div style="color:#fff;font-size:15px;font-weight:300;">VERIFY</div>
                </div>
            </a>
            <br>
            <br>
            <div style="padding: 3% 0;line-height: 1.6;"> Thank you, 
                <div style="color: #8c8c8c; font-weight: 400">Sincerely</div>
                <div style="color: #b1b1b1">Admin</div>
            </div>
        </div>
    </div>
    <br><br>
</body>
</html>












