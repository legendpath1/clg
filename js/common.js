String.prototype.trim = function() {
	return this.replace(/(?:^\s*)|(?:\s*$)/g, "")
};
function selectAll(a) {
	jQuery(":checkbox[id!='" + a + "']").attr("checked",
			jQuery("#" + a).attr("checked"))
}
function validateUserName(b) {
	var a = /^[0-9a-zA-Z]{6,16}$/;
	if (a.exec(b)) {
		return true
	} else {
		return false
	}
}
function validateUserPss(b) {
	var a = /^[0-9a-zA-Z]{6,16}$/;
	if (!a.exec(b)) {
		return false
	}
	a = /^\d+$/;
	if (a.exec(b)) {
		return false
	}
	a = /^[a-zA-Z]+$/;
	if (a.exec(b)) {
		return false
	}
	a = /(.)\1{2,}/;
	if (a.exec(b)) {
		return false
	}
	return true
}
function validateNickName(b) {
	var a = /^(.){2,8}$/;
	if (a.exec(b)) {
		return true
	} else {
		return false
	}
}
function validateBranch(b) {
	var a = /^(.){2,24}$/;
	if (a.exec(b)) {
		return true
	} else {
		return false
	}
}
function validateInputDate(e) {
	e = e.trim();
	if (e == "" || e == null) {
		return true
	}
	var d = e.split(" ");
	var c = new Array();
	var a = new Array();
	if (d[0].indexOf("-") != -1) {
		c = d[0].split("-")
	} else {
		if (d[0].indexOf("/") != -1) {
			c = d[0].split("/")
		} else {
			if (d[0].toString().length < 8) {
				return false
			}
			c[0] = d[0].substring(0, 4);
			c[1] = d[0].substring(4, 6);
			c[2] = d[0].substring(6, 8)
		}
	}
	if (d[1] == undefined || d[1] == null) {
		d[1] = "00:00:00"
	}
	if (d[1].indexOf(":") != -1) {
		a = d[1].split(":")
	}
	if (c[2] != undefined && (c[0] == "" || c[1] == "")) {
		return false
	}
	if (c[1] != undefined && c[0] == "") {
		return false
	}
	if (a[2] != undefined && (a[0] == "" || a[1] == "")) {
		return false
	}
	if (a[1] != undefined && a[0] == "") {
		return false
	}
	c[0] = (c[0] == undefined || c[0] == "") ? 1970 : c[0];
	c[1] = (c[1] == undefined || c[1] == "") ? 0 : (c[1] - 1);
	c[2] = (c[2] == undefined || c[2] == "") ? 0 : c[2];
	a[0] = (a[0] == undefined || a[0] == "") ? 0 : a[0];
	a[1] = (a[1] == undefined || a[1] == "") ? 0 : a[1];
	a[2] = (a[2] == undefined || a[2] == "") ? 0 : a[2];
	var b = new Date(c[0], c[1], c[2], a[0], a[1], a[2]);
	if (b.getFullYear() == c[0] && b.getMonth() == c[1] && b.getDate() == c[2]
			&& b.getHours() == a[0] && b.getMinutes() == a[1]
			&& b.getSeconds() == a[2]) {
		return true
	} else {
		return false
	}
	return true
}
function JsRound(c, a, b) {
	a = parseInt(a, 10);
	if (a < 0) {
		a = Math.abs(a);
		return Math.round(Number(c) / Math.pow(10, a)) * Math.pow(10, a)
	} else {
		if (a == 0) {
			return Math.round(Number(c))
		}
	}
	c = Math.round(Number(c) * Math.pow(10, a)) / Math.pow(10, a);
	if (b && b == true) {
		var e = "", d = 0;
		c = c.toString();
		if (c.indexOf(".") == -1) {
			c = "" + c + ".0"
		}
		data = c.split(".");
		for (d = data[1].length; d < a; d++) {
			e += "0"
		}
		return "" + c + "" + e
	}
	return c
}
function checkMoney(a) {
	a.value = formatFloat(a.value)
}
function checkWithdraw(c, a, b) {
	c.value = formatFloat(c.value);
	if (parseFloat(c.value) > parseFloat(b)) {
		alert("\u8f93\u5165\u91d1\u989d\u8d85\u51fa\u4e86\u53ef\u7528\u4f59\u989d");
		c.value = b
	}
	jQuery("#" + a).html(changeMoneyToChinese(c.value))
}
function checkOnlineWithdraw(b, a) {
	b.value = formatFloat(b.value);
	if (parseFloat(b.value) > parseFloat(a)) {
		alert("\u63d0\u73b0\u91d1\u989d\u8d85\u51fa\u4e86\u53ef\u63d0\u73b0\u9650\u989d");
		b.value = a;
		b.focus()
	}
}
function checkIntWithdraw(c, a, b) {
	c.value = parseInt(c.value, 10);
	c.value = isNaN(c.value) ? 0 : c.value;
	if (parseFloat(c.value) > parseFloat(b)) {
		alert("\u8f93\u5165\u91d1\u989d\u8d85\u51fa\u4e86\u53ef\u7528\u4f59\u989d");
		c.value = parseInt(b, 10)
	}
	jQuery("#" + a).html(changeMoneyToChinese(c.value))
}
function moneyFormat(b) {
	sign = Number(b) < 0 ? "-" : "";
	b = b.toString().replace(/[^\d.]/g, "");
	b = b.replace(/\.{2,}/g, ".");
	b = b.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
	if (b.indexOf(".") != -1) {
		var c = b.split(".");
		c[0] = c[0].substr(0, 15);
		var a = [];
		for (i = c[0].length; i > 0; i -= 3) {
			a.unshift(c[0].substring(i, i - 3))
		}
		c[0] = a.join(",");
		b = c[0] + "." + (c[1].substr(0, 4))
	} else {
		b = b.substr(0, 15);
		var a = [];
		for (i = b.length; i > 0; i -= 3) {
			a.unshift(b.substring(i, i - 3))
		}
		b = a.join(",") + ".0000"
	}
	return sign + b
}
function formatFloat(a) {
	a = a.replace(/^[^\d]/g, "");
	a = a.replace(/[^\d.]/g, "");
	a = a.replace(/\.{2,}/g, ".");
	a = a.replace(".", "$#$").replace(/\./g, "").replace("$#$", ".");
	if (a.indexOf(".") != -1) {
		var b = a.split(".");
		a = (b[0].substr(0, 15)) + "." + (b[1].substr(0, 2))
	} else {
		a = a.substr(0, 15)
	}
	return a
}
function changeMoneyToChinese(a) {
	var o = new Array("\u96f6", "\u58f9", "\u8d30", "\u53c1", "\u8086",
			"\u4f0d", "\u9646", "\u67d2", "\u634c", "\u7396");
	var l = new Array("", "\u62fe", "\u4f70", "\u4edf");
	var k = new Array("", "\u4e07", "\u4ebf", "\u5146");
	var h = new Array("\u89d2", "\u5206", "\u6beb", "\u5398");
	var d = "\u6574";
	var g = "\u5143";
	var b = 1000000000000000;
	var c;
	var e;
	var j = "";
	var f;
	if (a == "") {
		return ""
	}
	a = parseFloat(a);
	if (a >= b) {
		alert("\u8d85\u51fa\u6700\u5927\u5904\u7406\u6570\u5b57");
		return ""
	}
	if (a == 0) {
		j = o[0] + g + d;
		return j
	}
	a = a.toString();
	if (a.indexOf(".") == -1) {
		c = a;
		e = ""
	} else {
		f = a.split(".");
		c = f[0];
		e = f[1].substr(0, 4)
	}
	if (parseInt(c, 10) > 0) {
		zeroCount = 0;
		IntLen = c.length;
		for (i = 0; i < IntLen; i++) {
			n = c.substr(i, 1);
			p = IntLen - i - 1;
			q = p / 4;
			m = p % 4;
			if (n == "0") {
				zeroCount++
			} else {
				if (zeroCount > 0) {
					j += o[0]
				}
				zeroCount = 0;
				j += o[parseInt(n)] + l[m]
			}
			if (m == 0 && zeroCount < 4) {
				j += k[q]
			}
		}
		j += g
	}
	if (e != "") {
		decLen = e.length;
		for (i = 0; i < decLen; i++) {
			n = e.substr(i, 1);
			if (n != "0") {
				j += o[Number(n)] + h[i]
			}
		}
	}
	if (j == "") {
		j += o[0] + g + d
	} else {
		if (e == "") {
			j += d
		}
	}
	return j
}
function replaceHTML(a) {
	a = a.replace(/[&]/g, "&amp;");
	a = a.replace(/[\"]/g, "&quot;");
	a = a.replace(/[\']/g, "&#039;");
	a = a.replace(/[<]/g, "&lt;");
	a = a.replace(/[>]/g, "&gt;");
	a = a.replace(/[ ]/g, "&nbsp;");
	return a
}
function replaceHTML_DECODE(a) {
	a = a.replace(/&amp;/g, "&");
	a = a.replace(/&quot;/g, '"');
	a = a.replace(/&#039;/g, "'");
	a = a.replace(/&lt;/g, "<");
	a = a.replace(/&gt;/g, ">");
	a = a.replace(/&nbsp;/g, " ");
	return a
}
function copyToClipboard(f, c) {
	txt = jQuery("#" + f).html();
	if (window.clipboardData) {
		window.clipboardData.clearData();
		window.clipboardData.setData("Text", txt)
	} else {
		if (navigator.userAgent.indexOf("Opera") != -1) {
			window.location = txt
		} else {
			if (window.netscape) {
				try {
					netscape.security.PrivilegeManager
							.enablePrivilege("UniversalXPConnect")
				} catch (h) {
					alert("\u60a8\u7684firefox\u5b89\u5168\u9650\u5236\u9650\u5236\u60a8\u8fdb\u884c\u526a\u8d34\u677f\u64cd\u4f5c\uff0c\u8bf7\u5728\u5730\u5740\u680f\u4e2d\u8f93\u5165\u201cabout:config\u201d\u5c06\u201csigned.applets.codebase_principal_support\u201d\u8bbe\u7f6e\u4e3a\u201ctrue\u201d\u4e4b\u540e\u91cd\u8bd5");
					return false
				}
				var d = Components.classes["@mozilla.org/widget/clipboard;1"]
						.createInstance(Components.interfaces.nsIClipboard);
				if (!d) {
					return
				}
				var k = Components.classes["@mozilla.org/widget/transferable;1"]
						.createInstance(Components.interfaces.nsITransferable);
				if (!k) {
					return
				}
				k.addDataFlavor("text/unicode");
				var j = new Object();
				var g = new Object();
				var j = Components.classes["@mozilla.org/supports-string;1"]
						.createInstance(Components.interfaces.nsISupportsString);
				var b = txt;
				j.data = b;
				k.setTransferData("text/unicode", j, b.length * 2);
				var a = Components.interfaces.nsIClipboard;
				if (!d) {
					return false
				}
				d.setData(k, null, a.kGlobalClipboard)
			}
		}
	}
	if (c) {
		alert(c + " \u590d\u5236\u6210\u529f")
	}
}
function SetCookie(b, c, a) {
	var d = new Date();
	d.setTime(d.getTime() + (a * 1000));
	document.cookie = b + "=" + escape(c) + ";expires=" + d.toUTCString()
}
function getCookie(b) {
	var a = document.cookie.match(new RegExp("(^| )" + b + "=([^;]*)(;|$)"));
	if (a != null) {
		return unescape(a[2])
	}
	return null
}
function delCookie(a) {
	var c = new Date();
	c.setTime(c.getTime() - 1);
	var b = getCookie(a);
	if (b != null) {
		document.cookie = a + "=" + b + ";expires=" + c.toGMTString()
	}
}
function addItem(d, c, a) {
	var b = new Option(c, a);
	d.options.add(b)
}
function SelectItem(d, c) {
	var b = d.options.length;
	for ( var a = 0; a < b; a++) {
		if (d.options[a].value == c) {
			d.options[a].selected = true;
			return true
		}
	}
}
var TimeCountDown = function(e, b, f) {
	var g = parseInt(b, 10);
	function a(h) {
		return Number(h) < 10 ? "" + 0 + Number(h) : Number(h)
	}
	function d(h) {
		return h > 0 ? {
			day : Math.floor(h / 86400),
			hour : Math.floor(h % 86400 / 3600),
			minute : Math.floor(h % 3600 / 60),
			second : Math.floor(h % 60)
		} : {
			day : 0,
			hour : 0,
			minute : 0,
			second : 0
		}
	}
	var c = window.setInterval(function() {
		if (g <= 0) {
			clearInterval(c);
			if (f && typeof (f) == "function") {
				f()
			}
		}
		var h = d(g--);
		document.getElementById(e).innerHTML = ""
				+ (h.day > 0 ? h.day + "\u5929 " : "")
				+ (h.hour > 0 ? a(h.hour) + ":" : "") + a(h.minute) + ":"
				+ a(h.second)
	}, 1000)
};
function fastData() {
	if (typeof (window.top.frames.leftframe) != "object") {
		return true
	}
	var $lf = $("#leftusermoney", window.top.frames.leftframe.document);
	$.ajax( {
		type : "POST",
		url : "/default_getfastdata.php",
		timeout : 9000,
		success : function(data) {
			var partn = /<(.*)>.*<\/\1>/;
			if (partn.exec(data)) {
				return false
			}
			eval("data=" + data + ";");
			if (data.money != "empty") {
				var dd = moneyFormat(data.money);

				dd = dd.substring(0, (dd.length - 2));
				$lf.html(dd)
			}
			return true
		}
	})
};
