var generic = {};
var header = {};
header.init = function () {};

var utils = {};
utils.buildURL = function (controller, action, parameters) {
    var strEnd = '';
    if (parameters !== undefined) {
        var iteration = 0;
        for (var key in parameters) {
            if (iteration++) {
                strEnd += "&";
            }
            strEnd += key + "=" + parameters[key];
        }
    }
    var loc = document.location;
    var url = loc.protocol + '//' + loc.host + '/' + controller + ( action != undefined && action.length > 0 ? '/' + action : '');
    return url + "?" + strEnd;
};
utils.array2json = function (arr) {
    var parts = [];
    var is_list = (Object.prototype.toString.apply(arr) === '[object Array]');
    var is_obj = (Object.prototype.toString.apply(arr) === '[object Object]');

    for (var key in arr) {
        var value = arr[key];
        if (value !== null && typeof value == "object") { //Custom handling for arrays
            if (is_list) parts.push(array2json(value));
            /* :RECURSION: */
            if (is_obj) parts.push('"' + key + '"' + ":" + array2json(value));
            else parts[key] = array2json(value);
            /* :RECURSION: */
        } else {
            var str = "";
            if (!is_list) str = '"' + key + '":';

            //Custom handling for multiple data types
            if (typeof value == "number") str += value; //Numbers
            else if (value === false) str += 'false'; //The booleans
            else if (value === true) str += 'true';
            else if (value === null) str += "null";
            else str += '"' + encodeURIComponent(value) + '"'; //All other things

            parts.push(str);
        }
    }
    var json = parts.join(",");

    if (is_list) return '[' + json + ']';//Return numerical JSON
    return '{' + json + '}';//Return associative JSON
}
utils.trim = function (str) {
    return str.replace(/^\s+|\s+$/g, "");
}
utils.clone = function (obj) {
    // Handle the 3 simple types, and null or undefined
    if (null == obj || "object" != typeof obj) return obj;

    // Handle Date
    if (obj instanceof Date) {
        var copy = new Date();
        copy.setTime(obj.getTime());
        return copy;
    }

    // Handle Array
    if (obj instanceof Array) {
        var copy = [];
        for (var i = 0, len = obj.length; i < len; ++i) {
            copy[i] = clone(obj[i]);
        }
        return copy;
    }

    // Handle Object
    if (obj instanceof Object) {
        var copy = {};
        for (var attr in obj) {
            if (obj.hasOwnProperty(attr)) copy[attr] = clone(obj[attr]);
        }
        return copy;
    }

    throw new Error("Unable to copy obj! Its type isn't supported.");
}
utils.displayError = function (text, title) {
    title = title || "Error";
    $("#dialog-message")
        .html(text)
        .dialog({
            modal:true,
            title:title,
            height:"auto",
            width:400,
            buttons:{
                Ok:function () {
                    $(this).dialog("close");
                }
            }
        });
};
utils.displayConfirm = function (text, title, callback) {
    title = title || "Error";
    $("#dialog-message")
        .html(text)
        .dialog({
            modal:true,
            title:title,
            dialogClass:"alert",
            height:"auto",
            width:400,
            buttons:{
                Yes:function () {
                    if (callback) {
                        callback();
                    }
                    $(this).dialog("close");
                },
                No:function () {
                    $(this).dialog("close");
                }
            }
        });
}

var dialog = {};
dialog.display = function (loadUrl) {
    $("#modal").html('<div class="modal-body"><div class="progress progress-striped active"><div class="bar" style="width: 100%;"></div></div></div>').load(loadUrl).modal();
};
dialog.disableSubmit = function () {
    $("#modal").find(".modal-footer .btn").attr("disabled", "disabled");
};
dialog.enableSubmit = function () {
    $("#modal").find(".modal-footer .btn").removeAttr("disabled");
};
dialog.close = function () {
    $("#modal").modal('hide');
};
{
}
dialog.get = function () {
    return $("#modal");
};

var pages = {
    road:{dialog:{}, list:{}, view:{}}
};

pages.road.dialog.init = function () {
    $(".btn-road-submit").click(pages.road.dialog.submit);
};
pages.road.dialog.show = function (roadId) {
    dialog.display(utils.buildURL("road", "dialog", {id_road:roadId}));
};
pages.road.dialog.submit = function () {
    $.post(utils.buildURL("road", "edit"),
        {
            id_road:$("#edit-road-id").val(),
            step:$("#edit-road-step").val(),
            name:$("#edit-road-name").val()
        },
        function (data) {
            if (data.success) {
                dialog.close();
                pages.road.list.load();
            }
            else {
                $("#modal_alert").html(data.message).show();
            }
        },
        'json'
    );
};
pages.road.list.init = function () {
    $(".btn-road-add").click(function () {
        pages.road.dialog.show(0)
    });
    $(".btn-road-edit").click(function () {
        pages.road.dialog.show($(this).data("id"))
    });
};
pages.road.list.load = function () {
    $(".road-list-container").load(utils.buildURL("road", "list"));
};
pages.road.view.init = function () {};

