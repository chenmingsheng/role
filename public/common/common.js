function requestServer(postJson, urls) {
    var returnData;
    $.ajax({
        type: "post",
        url: urls,
        data: postJson,
        async: false,
        dataType: "json",
        success: function (successData) {
            returnData = successData
        },
        error: function (msg) {

        }
    });
    return returnData
}
$.lante = {
    asynGet: function (url, data, successfn, errorfn) {
        $.ajax({
            type: "GET", async: true, data: data, url: url, dataType: "json", success: function (d) {
                successfn(d)
            }, error: function (e) {
                errorfn(e)
            }
        })
    }, syncGet: function (url, data, successfn, errorfn) {
        $.ajax({
            type: "GET", async: false, data: data, url: url, dataType: "json", success: function (d) {
                successfn(d)
            }, error: function (e) {
                errorfn(e)
            }
        })
    }, asynPost: function (url, data, successfn) {
        $.ajax({
            type: "post", async: true, data: data, url: url, dataType: "json", success: function (d) {
                successfn(d)
            }
        })
    }, syncPost: function (url, data, successfn, errorfn) {
        $.ajax({
            type: "post", async: false, data: data, url: url, dataType: "json", success: function (d) {
                successfn(d)
            }, error: function (e) {
                errorfn(e)
            }
        })
    },
};
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) {
        return unescape(r[2])
    }
    return null
}

/**
 *
 * @param code
 * 无操作弹窗
 */
function cmsal(code,msg){
    if(code==200){
        layer.msg(msg,{time:2000},function(index){
            window.location.href='/admin/';
        });
    }else {
        layer.msg(msg);
    }

}