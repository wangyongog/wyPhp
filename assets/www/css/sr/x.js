var X = {};

X.code = {
    argument: "301",
    loseSecurityCode: "302",
    unauthorized: "405",
    nameUnsettled: "407",
    notifyInterval: "601",
    schemeError: "700",
    balanceShortage: "800",
    rebate: "801",
    system: "900"
};

X.util = {
    strLen:function strLen(s) {
        if(!s)return 0;
        return s.replace(/[^\x00-\xff]/g, "**").length
    }
};

X.valid = {
    isNumber: function (data, isPositive) {
        return isPositive ? /^\d+(\.\d{1,})?$/.test(data) && parseFloat(data) > 0 : /^(-)?\d+(\.\d{1,})?$/.test(data);
    },
    isMoney: function (data, isPositive) {
        return isPositive ? /^\d+(\.\d{1,2})?$/.test(data) && parseFloat(data) > 0 : /^(-)?\d+(\.\d{1,2})?$/.test(data);
    },
    isInt: function (data, isPositive) {
        return isPositive ? /^\d+$/.test(data) && parseInt(data, 10) > 0 : /^(-)?\d+$/.test(data);
    },
    isIdentityNumber: function (number) {
        if ($.trim(number) == '' || !/^[0-9]{17}[0-9X]$/.test(number)) {
            return false;
        }
        var weights = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        var parityBits = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2");
        var power = 0;
        for (var i = 0; i < 17; i++) {
            power += parseInt(number.charAt(i), 10) * weights[i];
        }
        return parityBits[power % 11] == number.substr(17);
    },
    isMobile: function (mobile) {
        return mobile && /^1[3|5|8]\d{9}$/.test(mobile);
    },
    isEmail: function (email) {
        return email && /^[0-9a-zA-Z_\-]+@[0-9a-zA-Z_\-]+\.\w{1,5}(\.\w{1,5})?$/.test(email);
    },
    isBankCard: function (cardNumber) {
        return cardNumber && /^\d{16,30}$/.test(cardNumber);
    },
    isChinaName: function (name) {
        return name && $.trim(name).length >= 2 && !/^.*\\d{1,}.*$/.test(name);
    },
    isImg: function (filename) {
        var imgs = ['.png', '.bmp', '.jpg', '.jpeg', '.gif'];
        for (var i = 0; i < imgs.length; i++) {
            if ($.trim(filename).toLowerCase().endsWith(imgs[i]))
                return true;
        }
        return false;
    },
    isPwdValid: function (pwd) {
        if ($.trim(pwd).length < 6) {
            return {valid: false, msg: "密码必须由6-16个字符组成"};
        } else if ($.trim(pwd).length > 16) {
            return {valid: false, msg: "密码必须由6-16位字符组成"};
        } else {
            if (/^\d+$/.test(pwd)) {
                return {valid: false, msg: "密码不能全为数字"};
            }
        }
        return {valid: true, msg: ''};
    },
    isWithdrawPwdValid: function (pwd) {
        if ($.trim(pwd).length != 6) {
            return {valid: false, msg: "密码必须由6个数字组成"};
        }
        if (!/^\d+$/.test(pwd)) {
            return {valid: false, msg: "密码不能全为数字"};
        }
        return {valid: true, msg: ''};
    },
    isUsernameValid: function (username) {
        username = $.trim(username);
        if (username == '') {
            return {valid: false, msg: '用户名不能为空'};
        } else {
            if (X.util.strLen(username) > 16 || X.util.strLen(username) < 4) {
                return {valid: false, msg: "用户名为4-16个字符，中文算2个字符"};
            }
            if (!/^[0-9a-zA-Z_\u4e00-\u9fa5]+$/.test(username)) {
                return {valid: false, msg: '用户名为4-16位字母、数字、下划线或中文'};
            }
            if (X.valid.isMobile(username)) {
                return {valid: false, msg: '用户名不能是手机'};
            }
            if (X.valid.isEmail(username)) {
                return {valid: false, msg: "用户名不能是邮箱"};
            }
            if (/.*?(\d+).*?/.test(username) && X.valid.isMobile(RegExp.$1)) {
                return {valid: false, msg: '用户名不能包含手机'};
            }
        }
        return {valid: true, msg: ''};
    }
};

(function () {
    function isType(type) {
        return function (obj) {
            return Object.prototype.toString.call(obj) == "[object " + type + "]"
        }
    }

    var isObject = isType("Object");
    var isString = isType("String");
    var isNumber = isType("Number");
    var isDate = isType("Date");
    var isArray = Array.isArray || isType("Array");
    var isFunction = isType("Function");
    var isUndefined = isType("Undefined");
    var log = function () {
        if (X.debug) {
            console.log.apply(console, arguments);
        }
    };
    X.log = log,
        X.isObject = isObject,
        X.isString = isString,
        X.isNumber = isNumber,
        X.isDate = isDate,
        X.isArray = isArray,
        X.isFunction = isFunction,
        X.isUndefined = isUndefined;

})();

(function () {
    //获取当前日期的毫秒数
    function getTime() {
        return getDate().getTime();
    }

    //获取参数对应的时间对象，若没有传参则为当前日期
    function getDate(t) {
        if (t)return new Date(t);
        return new Date();
    }

    //转换成整数
    function toInt(s) {
        return parseInt(s);
    }

    //转换成浮点数
    function toFloat(s) {
        return parseFloat(s);
    }

    //是否是整数
    function isInt(o) {
        return X.isNumber(o) && Math.round(o) == o;
    }

    // 格式化数字，如1234567 --> 1,234,567
    function formatNumber(n) {
        if (!X.isNumber(n)) {
            return n + '';
        }
        var f = n < 0 ? '-' : '',
            s = Math.abs(n) + '',
            i = s.length,
            r = '',
            c = 0;

        while (i-- > 0) {
            c++;
            r = s.charAt(i) + r;
            if (c % 3 === 0 && i !== 0) {
                c = 0;
                r = ',' + r;
            }
        }
        return f + r;
    }

    // 格式化金额，小数点保留
    function money(m, n) {
        var num = m | 0,
            n = n || 2,
            m = m + '',
            i = m.indexOf('.');
        if (n < 1)n = 2;
        if (n > 9) n = 9;
        if (i === -1) {
            return formatNumber(num) + '.' + '0000000000'.substr(0, n);
        } else {
            m = m + '0000000000';
            return formatNumber(num) + (m.substr(i, n + 1));
        }
    }

    // 不够2位，用0填充
    function fill(v) {
        return (v < 10 ? '0' : '') + v;
    }

    //格式化日期
    //value可以为实际日期或者能格式化为日期的字符串
    //pattern Y-M-D h:m:s
    function formatDate(value, pattern) {

        pattern = pattern || 'Y-M-D h:m:s';

        var date = new Date(), hour = date.getTimezoneOffset(), time;
        if (X.isDate(value) && value.getTime) {
            date = value;
        } else if (X.isNumber(value)) {
            time = value + (480 + hour) * 60000;
            date = new Date(time);
        }

        var len = pattern.length,
            ret = pattern;

        for (var i = 0; i < len; i++) {
            switch (pattern.charAt(i)) {
                case 'Y':
                    ret = ret.replace(/Y/g, fill(date.getFullYear()));
                    break;
                case 'y':
                    ret = ret.replace(/y/g, fill(date.getFullYear()).substring(2));
                    break;
                case 'M':
                    ret = ret.replace(/M/g, fill(date.getMonth() + 1));
                    break;
                case 'D':
                    ret = ret.replace(/D/g, fill(date.getDate()));
                    break;
                case 'h':
                    ret = ret.replace(/h/g, fill(date.getHours()));
                    break;
                case 'm':
                    ret = ret.replace(/m/g, fill(date.getMinutes()));
                    break;
                case 's':
                    ret = ret.replace(/s/g, fill(date.getSeconds()));
                    break;
            }
        }
        return ret;
    }

    //缩减数字
    function sketchNumber(n, m) {
        m = m || 0;
        if (n >= 100000000) {
            return (n / 100000000).toFixed(m) + '亿';
        }
        if (n >= 10000) {
            return (n / 10000).toFixed(m) + '万';
        }
        return n;
    }

    //是否为身份证号码
    function isIdentityNumber(number) {
        if ($.trim(number) == '' || !/^[0-9]{17}[0-9X]$/.test(number)) {
            return false;
        }
        var weights = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
        var parityBits = new Array("1", "0", "X", "9", "8", "7", "6", "5", "4", "3", "2");
        var power = 0;
        for (var i = 0; i < 17; i++) {
            power += parseInt(number.charAt(i), 10) * weights[i];
        }
        return parityBits[power % 11] == number.substr(17);
    }

    //是否为手机号码
    function isMobile(mobile) {
        return mobile && /^1[34578]\d{9}$/.test(mobile);
    }

    //是否为电子邮箱
    function isEmail(email) {
        return email && /^[0-9a-zA-Z_\-]+@[0-9a-zA-Z_\-]+\.\w{1,5}(\.\w{1,5})?$/.test(email);
    }

    //是否为银行卡
    function isBankCard(cardNumber) {
        return cardNumber && /^\d{15,30}$/.test(cardNumber);
    }

    //是否为中文名字
    function isChinaName(name) {
        return /^[\u4e00-\u9fa5]{2,}$/.test(name);
    }

    //是否为图片
    function isImg(filename) {
        var imgs = ['.png', '.bmp', '.jpg', '.jpeg', '.gif'];
        for (var i = 0; i < imgs.length; i++) {
            if ($.trim(filename).toLowerCase().endsWith(imgs[i]))
                return true;
        }
        return false;
    }

    function isNum(data, isPositive) {
        return isPositive ? /^\d+(\.\d+)?$/.test(data) && parseFloat(data) > 0 : /^(-)?\d+(\.\d+)?$/.test(data);
    }

    function isMoney(data, isPositive) {
        return isPositive ? /^\d+(\.\d{1,2})?$/.test(data) && parseFloat(data) > 0 : /^(-)?\d+(\.\d{1,2})?$/.test(data);
    }

    function isInteger(data, isPositive) {
        return isPositive ? /^\d+$/.test(data) && parseInt(data, 10) > 0 : /^(-)?\d+$/.test(data);
    }

    function strLen(s) {
        return s.replace(/[^\x00-\xff]/g, "**").length
    }

    function maskName(name) {
        var len = name.length;
        return name.substr(0, len - 1) + '×';

    }

    X.getTime = getTime,
        X.getDate = getDate,
        X.toInt = toInt,
        X.toFloat = toFloat,
        X.isInt = isInt,
        X.formatNumber = formatNumber,
        X.money = money,
        X.fill = fill,
        X.formatDate = formatDate,
        X.sketchNumber = sketchNumber,
        X.strLen = strLen,
        X.isIdentityNumber = isIdentityNumber,
        X.isMobile = isMobile,
        X.isEmail = isEmail,
        X.isBankCard = isBankCard,
        X.isImg = isImg,
        X.isNum = isNum,
        X.isMoney = isMoney,
        X.isInteger = isInteger,
        X.maskName = maskName,
        X.isChinaName = isChinaName;
})();
