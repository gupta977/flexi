//Build for latest version of wordpress

//Toast or Notification
var FlexiloadPrompt = function (baseNode) {
    var config = {}; // 配置
    config.displayTime = 1690; // 保留时长
    config.shake = true; // 是否晃动
    config.classList = {};

    // 模板
    config.errorModel = document.createElement("div"); // 提示承载DOM
    config.errorModel.classList.add("flexi-promptContent"); // 提示承载DOM样式，不可省略
    config.errorModel.appendChild(document.createElement("div")); // 提示DOM
    config.errorModel.children[0].classList.add("flexi-promptError"); // 提示样式
    config.classList.error = "flexi-promptError"; // 注册提示样式，为switch服务

    config.successModel = document.createElement("div");
    config.successModel.classList.add("flexi-promptContent");
    config.successModel.appendChild(document.createElement("div"));
    config.successModel.children[0].classList.add("flexi-promptSuccess");
    config.classList.success = "flexi-promptSuccess";

    config.warnModel = document.createElement("div");
    config.warnModel.classList.add("flexi-promptContent");
    config.warnModel.appendChild(document.createElement("div"));
    config.warnModel.children[0].classList.add("flexi-promptWarn");
    config.classList.warn = "flexi-promptWarn";

    config.informModel = document.createElement("div");
    config.informModel.classList.add("flexi-promptContent");
    config.informModel.appendChild(document.createElement("div"))
    config.informModel.children[0].classList.add("flexi-promptInform")
    config.classList.inform = "flexi-promptInform";

    var prompt = document.createElement("div"); // 承载提示框的DOM
    prompt.classList.add("flexi-prompt");
    if (baseNode == undefined) {
        baseNode = document.body;
    }
    baseNode.appendChild(prompt);
    baseNode = null;

    // 操作
    var throttle = function (func, delay) { // 节流
        var timer = null;
        return function () {
            var context = this;
            var args = arguments;
            if (!timer) {
                timer = setTimeout(function () {
                    func.apply(context, args);
                    timer = null;
                }, delay);
            }
        }
    }

    var resize = function () { // 窗口resize
        for (var i = 0; i < prompt.children.length; i++) {
            prompt.children[i].style.maxHeight = prompt.children[i].scrollHeight + "px";
        }
    }
    window.addEventListener("resize", throttle(resize, 300));

    var displayPrompt = function (node, isKeep) {
        prompt.appendChild(node);
        setTimeout(function () { //显示
            node.classList.add("flexi-promptShow");
            node.style.maxHeight = node.scrollHeight + "px";
        }, 0);
        if (isKeep) {
            node.classList.add("flexi-promptKeep");
            if (config.shake) {
                node.classList.add("flexi-promptShake");
            }
        } else {
            setTimeout(function () {
                remove(node);
            }, config.displayTime);
        }
    }

    var modify = function (node, modifyContent) {
        node.children[0].innerHTML = "";
        if (typeof (modifyContent) == "object") {
            node.children[0].appendChild(modifyContent);
        } else {
            node.children[0].innerHTML = modifyContent;
        }
        node.style.maxHeight = node.scrollHeight + "px";
    }

    var remove = function (node) {
        node.classList.remove("flexi-promptShow")
        node.classList.add("flexi-promptOut")
        node.style.maxHeight = null;
        setTimeout(function () {
            node.remove()
        }, 1000)
    }

    var clean = function () { // 删除所有prompt
        for (var i = 0; i < prompt.children.length; i++) {
            remove(prompt.children[i])
        }
    }

    var keepOperater = function (node) {
        return {
            "node": node,
            "remove": function () {
                remove(node)
            },
            "modify": function (content) {
                modify(node, content)
            },
            "switch": function (type) {
                if (type in config.classList) {
                    for (var i in config.classList) {
                        node.children[0].classList.remove(config.classList[i]);
                    }
                    node.children[0].classList.add(config.classList[type]);
                } else {
                    console.error("Prompt: Not support type " + type.toString())
                }
            },
            "noShake": function () {
                node.classList.remove("flexi-promptShake");
            },
            "click": function (handle) {
                node.classList.remove("flexi-promptShake");
                node.classList.add("flexi-promptClick");
                node.addEventListener("click", handle)
            }
        }
    }

    // 不同的prompt
    var error = function (content, isKeep) {
        var errorNode = config.errorModel.cloneNode(true);
        modify(errorNode, content);
        displayPrompt(errorNode, isKeep);
        if (isKeep) {
            return keepOperater(errorNode)
        }
    }
    var success = function (content, isKeep) {
        var successNode = config.successModel.cloneNode(true);
        modify(successNode, content);
        displayPrompt(successNode, isKeep);
        if (isKeep) {
            return keepOperater(successNode)
        }
    }
    var warn = function (content, isKeep) {
        var warnNode = config.warnModel.cloneNode(true);
        modify(warnNode, content);
        displayPrompt(warnNode, isKeep);
        if (isKeep) {
            return keepOperater(warnNode)
        }
    }
    var inform = function (content, isKeep) {
        var informNode = config.informModel.cloneNode(true);
        modify(informNode, content)
        displayPrompt(informNode, isKeep)
        if (isKeep) {
            return keepOperater(informNode)
        }
    }
    var pFuncs = {}; // 功能列表
    pFuncs["config"] = config;
    pFuncs["clean"] = clean;
    pFuncs["error"] = error;
    pFuncs["success"] = success;
    pFuncs["inform"] = inform;
    pFuncs["warn"] = warn;
    return pFuncs;

}

//END


jQuery(document).ready(function ($) {
	"use strict";

});

//Set cookie
function flexi_setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
	var expires = "expires=" + d.toUTCString();
	document.cookie = cname + "=" + cvalue + "; " + expires;
}

function flexi_getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for (var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
			c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			return c.substring(name.length, c.length);
		}
	}
	return "";
}

function flexi_download_file(id) {
	alert(id);
	window.location.href = id;
}

//Add parameter to URL
function flexi_updateUrl(url, key, value) {
	if (value !== undefined) {
		value = encodeURI(value);
	}
	var hashIndex = url.indexOf("#") | 0;
	if (hashIndex === -1) hashIndex = url.length | 0;
	var urls = url.substring(0, hashIndex).split('?');
	var baseUrl = urls[0];
	var parameters = '';
	var outPara = {};
	if (urls.length > 1) {
		parameters = urls[1];
	}
	if (parameters !== '') {
		parameters = parameters.split('&');
		for (k in parameters) {
			var keyVal = parameters[k];
			keyVal = keyVal.split('=');
			var ekey = keyVal[0];
			var evalue = '';
			if (keyVal.length > 1) {
				evalue = keyVal[1];
			}
			outPara[ekey] = evalue;
		}
	}

	if (value !== undefined) {
		outPara[key] = value;
	} else {
		delete outPara[key];
	}
	parameters = [];
	for (var k in outPara) {
		parameters.push(k + '=' + outPara[k]);
	}

	var finalUrl = baseUrl;

	if (parameters.length > 0) {
		finalUrl += '?' + parameters.join('&');
	}

	return finalUrl + url.substring(hashIndex);
}


jQuery(document).ready(function () {
	jQuery("#flexi_search").click(function (e) {

		var search_value = jQuery("#search_value").val();
		var cur_url = window.location.href;
		var i = flexi_updateUrl(cur_url, 'search', 'keyword:' + search_value);
		window.location.replace(i);
	});
});