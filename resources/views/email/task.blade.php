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
            <div style="padding: 3%; background: #fefff1; border: 1px solid #e8deb5; color: #333;">
                <div style="margin:auto; max-width:550px; padding: 3%;">
                    <p>
                        <span style="width: 10%; padding-left: 5%; float:left; ">ID</span>
                        <span style="width: 40%; padding-left: 10%; display: inline-block;"><b>: {{$task->task_uid}}</b></span>
                    </p>
                    <p>
                        <span style="width: 10%; padding-left: 5%; float:left; ">Title</span>
                        <span style="width: 40%; padding-left: 10%;"><b>: {{$task->subject}}</b></span>
                    </p>
                    
                    <p>
                        <span style="width: 10%; padding-left: 5%; float:left; ">Description</span>
                        <span style="width: 40%; padding-left: 10%;"><b>: {{$task->description}}</b></span>
                    </p>
                    
                         <p>
                        <span style="width: 10%; padding-left: 5%; float:left; ">Technician</span>
                        <span style="width: 40%; padding-left: 10%;"><b>: {{$task->getTechnician->name_technician}}</b></span>
                    </p>

                </div>
            </div>
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












