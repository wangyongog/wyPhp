(function(g, t, e) {
	function a(t, e) {
		this.el = t;
		this.options = {
			pageNo: e.initPageNo || 1,
			totalPages: e.totalPages || 1,
			totalCount: e.totalCount || "",
			slideSpeed: e.slideSpeed || 0,
			jump: e.jump || false,
			callback: e.callback || function() {}
		};
		this.init()
	}
	a.prototype = {
		constructor: a,
		init: function() {
			this.createDom();
			this.bindEvents()
		},
		createDom: function() {
			var t = this,
				e = "",
				a = "",
				n = "",
				s = 60,
				i = t.options.totalPages,
				o = 0;
			i > 5 ? o = 5 * s : o = i * s;
			for(var l = 1; l <= t.options.totalPages; l++) {
				l != 1 ? e += "<li>" + l + "</li>" : e += '<li class="sel-page">' + l + "</li>"
			}
			t.options.jump ? a = '<input type="text" placeholder="1" class="jump-text" id="jumpText"><button type="button" class="jump-button" id="jumpBtn">跳转</button>' : a = "";
			n = '<button type="button" id="firstPage" class="turnPage first-page">首页</button>' + '<button class="turnPage" id="prePage">上一页</button>' + '<div class="pageWrap" style="width:' + o + 'px">' + '<ul id="pageSelect" style="transition:all ' + t.options.slideSpeed + 'ms">' + e + "</ul></div>" + '<button class="turnPage" id="nextPage">下一页</button>' + '<button type="button" id="lastPage" class="last-page">尾页</button>' + a + '<p class="total-pages">共&nbsp;' + t.options.totalPages + "&nbsp;页</p>" + '<p class="total-count">' + t.options.totalCount + "</p>";
			t.el.html(n)
		},
		bindEvents: function() {
			var e = this,
				a = g("#pageSelect"),
				n = a.children(),
				s = n[0].offsetWidth,
				i = e.options.totalPages,
				o = e.options.pageNo,
				l = 0,
				p = g("#prePage"),
				c = g("#nextPage"),
				u = g("#firstPage"),
				r = g("#lastPage"),
				t = g("#jumpBtn"),
				d = g("#jumpText");
			p.on("click", function() {
				o--;
				if(o < 1) o = 1;
				f(o)
			});
			c.on("click", function() {
				o++;
				if(o > n.length) o = n.length;
				f(o)
			});
			u.on("click", function() {
				o = 1;
				f(o)
			});
			r.on("click", function() {
				o = i;
				f(o)
			});
			t.on("click", function() {
				var t = parseInt(d.val().replace(/\D/g, ""));
				if(t && t >= 1 && t <= i) {
					o = t;
					f(o);
					d.val(t)
				}
			});
			n.on("click", function() {
				o = g(this).index() + 1;
				f(o)
			});

			function f(t) {
				n.removeClass("sel-page").eq(t - 1).addClass("sel-page");
				if(i <= 5) {
					e.options.callback(t);
					return false
				}
				if(t >= 3 && t <= i - 2) l = (t - 3) * s;
				if(t == 2 || t == 1) l = 0;
				if(t > i - 2) l = (i - 5) * s;
				a.css("transform", "translateX(" + -l + "px)");
				t == 1 ? u.attr("disabled", true) : u.attr("disabled", false);
				t == 1 ? p.attr("disabled", true) : p.attr("disabled", false);
				t == i ? r.attr("disabled", true) : r.attr("disabled", false);
				t == i ? c.attr("disabled", true) : c.attr("disabled", false);
				e.options.callback(t)
			}
			f(e.options.pageNo)
		}
	};
	g.fn.paging = function(t) {
		return new a(g(this), t)
	}
})(jQuery, window, document);