var WSS = WSS || {};
WSS.session = {};
WSS.init = function() {
    
};
WSS.updateSession = function(session) {
    WSS.session = session;
    webix.storage.session.put('session', session);
};
WSS.pageMove = function(page) {
    location.href= "/" + page;
};
WSS.errorMessage = function(message) {
    webix.alert({
    title:"",
    ok:"OK",
    type:"alert-error",
    width:350,
    text:message
    });
};
WSS.GET = function(url, getData, cb) {
    webix.ajax().get(url, getData, {
        error:function(text, data, xml){
            WSS.errorMessage(text);
            WSS.AjaxError = true;
            cb(text, data, xml);
        },
        success:function(text, data, xml){
            WSS.AjaxError = false;
            cb(text, data, xml);
        }
    });
};
WSS.POST = function(url, postData, cb) {
    webix.ajax().post(url, postData, {
        error:function(text, data, xml){
            WSS.errorMessage(text);
            WSS.AjaxError = true;
            cb(text, data, xml);
        },
        success:function(text, data, xml){
            WSS.AjaxError = false;
            cb(text, data, xml);
        }
    });
};
WSS.AjaxError = false;
WSS.isAjaxError = function() {
    return WSS.AjaxError;
};
WSS.datatable = {};
WSS.datatable.parse = function(ichiranName, parseData) {
    $$(ichiranName).clearAll();
    $$(ichiranName).parse(parseData);
};
