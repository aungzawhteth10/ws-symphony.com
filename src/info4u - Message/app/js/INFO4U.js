var INFO4U = INFO4U || {};
INFO4U.session = {};
INFO4U.init = function() {
    
};
INFO4U.updateSession = function(session) {
    INFO4U.session = session;
    webix.storage.session.put('session', session);
};
INFO4U.pageMove = function(page) {
    location.href= "/" + page;
};
INFO4U.errorMessage = function(message) {
    webix.alert({
    title:"",
    ok:"OK",
    type:"alert-error",
    width:350,
    text:message
    });
};
INFO4U.GET = function(url, getData, cb) {
    webix.ajax().get(url, getData, {
        error:function(text, data, xml){
            INFO4U.errorMessage(text);
            INFO4U.AjaxError = true;
            cb(text, data, xml);
        },
        success:function(text, data, xml){
            INFO4U.AjaxError = false;
            cb(text, data, xml);
        }
    });
};
INFO4U.POST = function(url, postData, cb) {
    webix.ajax().post(url, postData, {
        error:function(text, data, xml){
            INFO4U.errorMessage(text);
            INFO4U.AjaxError = true;
            cb(text, data, xml);
        },
        success:function(text, data, xml){
            INFO4U.AjaxError = false;
            cb(text, data, xml);
        }
    });
};
INFO4U.AjaxError = false;
INFO4U.isAjaxError = function() {
    return INFO4U.AjaxError;
};
INFO4U.datatable = {};
INFO4U.datatable.parse = function(ichiranName, parseData) {
    $$(ichiranName).clearAll();
    $$(ichiranName).parse(parseData);
};
