var event = new (require('events').EventEmitter)
  , socketIO = require('socket.io').listen(2313) 
  , extend = require('util')._extend 
  ; 

/*
 * 1. 메인 채팅방을 기본으로 접속
 * 2. 방기능을 만들면 여러개로 증설하면 만들수있게 해야함.
 * 3. 광고의 경우 DB 에서 가져와 뿌리는걸로
 * 4. 모든메세지를 DB 에 기록
 */

socketIO.sockets.on('connection', function (socket) {
     
    var nickname = 'GUEST' + Math.floor(Math.random() * 1000)
      //, ipAddress = socket.request.connection.remoteAddress
      //, userAgent = socket.request.headers['user-agent']
      , sessionId = socket.id
      , query = socket.handshake.query
      , roomId = query['r'] || 'default'
      ;
      
    socket.join(roomId);
    
    socket.on('usermessage', function (data) {
        
        data = extend(data, { 'sender_id' : sessionId
                            , 'creation_date' : new Date()
                            , 'nickname' : nickname });
        
        socket.broadcast.to(roomId).emit('usermessage', data);
        socket.emit('usermessage', extend(data, { 'me' : true })); 
    });
});