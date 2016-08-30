<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <meta name="Viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, width=device-width"/>
        
        <title>환영합니다.</title>
         
        <link href="/asset/style/normalize.css" rel="stylesheet" type="text/css"/>
        <link href="/asset/style/customize.css" rel="stylesheet" type="text/css"/>
        <link href="/asset/style/addons.css" rel="stylesheet" type="text/css"/> 

        <script src="/asset/script/commons.js"></script>
        <script src="https://cdn.socket.io/socket.io-1.2.0.js"></script>
        <script src="http://code.jquery.com/jquery-1.11.1.js"></script>
        
        <style type="text/css">
            
            html,
            body {
                font-size: 12px;
                overflow:hidden;
                width: 100%;
                height: 100%;
            }
            
            ul { 
                list-style: none;
            } 
            
            #chatWrap { 
                position: relative;
                background-color: #e9ecef; 
                padding: 45px 0 80px;
                height: 100%;
                box-sizing: border-box; 
            }
            
            #recvChat {
                position: relative; 
                height: 100%;
            }
             
            #recvMessage {
                height: 100%;
                
                padding: 0;
                margin: 0;  
                
                overflow-x: hidden;
                overflow-y: scroll;
                
                list-style: none;
            }
            
            #recvMessage > li {
                margin: 40px 10px 8px 0;
            }
            
            #recvChat li li { 
                clear: left;
                float: left; 
                margin: 3px 0;
                position: relative;
            }
            
            #recvChat .chatMe li {
                clear: right;
                float: right;
            }
            
            #recvChat .chatDate {
                font-size: 11px;
                color: #929ea5;
                white-space: nowrap;
                position: absolute; 
                bottom: 0;
                left: 100%;
                margin-left: 8px;
            }
            
            #recvChat .chatNick {
                display: none;
                position: absolute;
                bottom: 100%;
                left: 0;
                font-weight: bold;
                margin-bottom: 5px;
                font-size: 12px;
                color: 12px;
            }
            
            #recvChat ul ul li:first-child .chatNick {
                display: block;
            }
            
            #recvChat .chatMessage {  
                position: relative;
                border-radius: 4px;
                font-size: 15px;
                color: #000;
                display: inline-block;
                max-width: 300px; 
                padding: 9px 11px 10px;
                background: white; 
                text-align: left;
                word-wrap: break-word; 
                box-shadow: 0 1px 0 0 rgba(0, 0, 0, 0.09);
            }
            
            #recvChat .chatMe .chatNick {
                left: auto;
                right: 0;
            }
            
            #recvChat .chatMe .chatDate { 
                left: auto;
                right: 100%;
                margin-right: 8px;
                margin-left: 0;
            }
            
            #recvChat .chatMe .chatMessage { 
                background-color: rgb(255, 236, 66);
            }
            
            #sendChat { 
                position: relative;
                border: 1px solid #bad1d8;
                border-radius: 2px;
                background-color: white;  
                height: 60px;
                margin: 10px;
                box-sizing: border-box;
            }
             
            #sendChat textarea {
                height: 100%;
                width: 100%;
                background-color: white;
                color: black;
                font-size: 15px;
                outline: 0px none; 
                border: 0px none;   
                padding: 5px 65px 5px 5px;
            }
            
            #sendChat button {
                position: absolute;
                top: 0;
                right: 0;
                width: 60px;
                height: 100%;
                overflow: hidden;
                color: #505050;
                background-color: rgb(255, 236, 66);
                border: 0px none;
                border-left: 1px solid rgb(235, 214, 23);
                border-top-right-radius: 1px;
                border-bottom-right-radius: 1px;
                font-size: 15px;
            } 
        </style>
        
        <script type="text/javascript">
            $(function () {
                 
                var socket = io.connect(':2313/?r=default');

                socket.on('usermessage', function (data) {    

                    if ( $('#recvMessage > li:last-child').data('sender') != data['sender_id']) {
                        $('<li class="clearFix"><ul></ul></li>').data('sender', data['sender_id']).appendTo('#recvMessage');
                    }
                   
                    $('<li></li>').appendTo('#recvMessage > li:last-child ul');

                    $('<span></span>').addClass('chatNick removeSelect').text(data['nickname']).appendTo('#recvMessage > li:last-child li:last-child')
                    $('<span></span>').addClass('chatMessage').text(data['message']).appendTo('#recvMessage > li:last-child li:last-child');
                    $('<span></span>').addClass('chatDate removeSelect').text(new Date(data['creation_date']).toSimpleKorStyle()).appendTo('#recvMessage > li:last-child li:last-child');

                    if (data['me'] == true) {
                        $('#recvMessage > li:last-child').addClass('chatMe');
                    } 
                    
                    var scrollHeight = $('#recvMessage').get(0).scrollHeight;

                    $('#recvMessage').scrollTop(scrollHeight); 
                }); 
                
                $('#sendChat button').click(function () { 
                    var message = $('#sendChat textarea').val().trim();
                    
                    if (message.length <= 0) {
                        $('#sendChat textarea').val('');
                        return true;
                    }
                    
                    var data = {}; 
                    data['message'] = message;
                     
                    socket.emit('usermessage', data);
                    
                    $('#sendChat textarea').val('').focus();
                    
                    return false;
                })
                
                $('#sendChat textarea').keypress(function (event) {
                    
                    if (event.key == 'Enter' && ! event.shiftKey) {
                        $('#sendChat button').click();
                        return false;
                    }
                    
                    return true;
                });
            });
        </script> 
        
        <style type="text/css">
            #navBar {
                display: block;
                position: absolute;
                top: 0;
                left: 0;

                width: 100%;
                height: 45px;
                border-bottom: 1px solid #dedede;
                box-sizing: border-box;

                background: white;
            }
            
            #navBar h1 {
                line-height: 45px;
                font-size: 22px;
                font-weight: normal;
                text-align: center;
                margin: 0;  
            }
            
            #navDrawerState {
                display: none;
            }

            #navDrawerState ~ #chatWrap { 
                margin-right: 240px;
            } 
            
            #navDrawerButton {
                position: absolute;
                top: 0;
                left: -25px;
                margin-top: 5px;
                margin-left: -10px;
                display: none;
                cursor: pointer;
                width: 25px;
                height: 35px; 
            }
            
            #navDrawerButton span {
                position: absolute;
                top: 0;
                left: 0;
                background: #8c8c8c;
                display: block;
                width: 100%;
                height: 2px;
                border-radius: 4px;
                margin-top: -1px;
                -webkit-transform: translate3d(0, 0, 0);
                -webkit-transition: all 0.6s ease;
                transition: all 0.6s ease;
            }
            
            #navDrawerButton span:nth-child(1) { top: 25% }
            #navDrawerButton span:nth-child(2) { top: 50% }
            #navDrawerButton span:nth-child(3) { top: 75% }
             
            #navDrawerState:checked ~ #chatWrap #navDrawerButton span {
                top: 50%; 
                transform: rotate(-45deg); 
                -ms-transform: rotate(-45deg);
                background: white;
            }
            
            #navDrawerState:checked ~ #chatWrap #navDrawerButton span:last-child { 
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            #navDrawerBackground {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9000;
                display: none;
                background: rgba(0,0,0,0.7);
            }
 
            #navDrawer{ 
                position: absolute;
                top: 0;
                right: -240px;
                width: 240px;
                height: 100%;   
                background-color: white;
                z-index: 9999;
                -webkit-transform: translate3d(0, 0, 0);
                -webkit-transition: right 0.4s ease; 
                transition: right 0.4s ease; 
            }
            
            @media handheld, only screen and (max-width: 768px) {
                
            #navDrawerState ~ #chatWrap { 
                margin-right: 0;
            }
 
            #navDrawerButton {
                display: block;
            }
            
            #navDrawerState:checked ~ #chatWrap #navDrawerBackground {
                display: block;
            }
            
            #navDrawerState:checked ~ #chatWrap #navDrawer {
                right: 0;
            }
            
            }

        </style>
    </head>
    <body> 
        <input type="checkbox" id="navDrawerState"/>
        <div id="chatWrap">
            
            <div id="navBar">
                <h1>채팅</h1> 
            </div>
             
            <div id="recvChat">
                <ul id="recvMessage">
                    <!-- 메세지 목록 -->
                </ul> 
            </div>
            
            <div id="sendChat"> 
                <textarea autofocus="autofocus"></textarea> 
                <button>전송</button>
            </div>
            
            <div id="navDrawerBackground"></div>
            <div id="navDrawer">
                <label for="navDrawerState" id="navDrawerButton">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                
                <div>
                    내용
                </div>
            </div>
        </div> 
    </body>
</html>