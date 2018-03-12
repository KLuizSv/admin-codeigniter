/*
class Comet = new Class({
    timestamp : 0,
    url : backend_url + 'dashboard/chat',
    noerror : true,
    
    initialize : function() {       
    },
    
    connect : function() {
        var self = this;
        
        this.ajax = new Request.JSON({
            url : self.url,
            method : 'get',
            onSuccess : function(transport) {
                self.timestamp = transport.timestamp;
                self.handleResponse(transport);
            },
            
            onComplete : function(transport) {
                if (!self.noerror) {
                    setTimeout(function(){ 
                        self.connect() 
                        }, 5000);
                } else {
                    self.connect();
                    self.noerror = false;
                }
            
            }
        }).send('timestamp=' + self.timestamp);
        
        this.ajax.comet = this;
    },
    
    disconnect: function(){ 
    },
    
    handleResponse: function(response) {
        $('content').innerHTML += '' + response.msg + '';
    },
    
    doRequest: function(request){
        new Request({
            url : this.url,
            method: 'get'
        }).send('msg=' + request);
    }
});
*/