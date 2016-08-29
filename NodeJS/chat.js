var event = new (require('events').EventEmitter)
  , socketIO = require('socket.io').listen(2313) 
  , extend = require('util')._extend 
  ; 

/*
 * 1. ���� ä�ù��� �⺻���� ����
 * 2. ������ ����� �������� �����ϸ� ������ְ� �ؾ���.
 * 3. ������ ��� DB ���� ������ �Ѹ��°ɷ�
 * 4. ���޼����� DB �� ���
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