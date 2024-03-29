(function(e) {
	var m = function(p, o) {
		return (p << o) | (p >>> (32 - o));
	};
	var a = function(s, p) {
		var u, o, r, t, q;
		r = (s & 2147483648);
		t = (p & 2147483648);
		u = (s & 1073741824);
		o = (p & 1073741824);
		q = (s & 1073741823) + (p & 1073741823);
		if (u & o) {
			return (q ^ 2147483648 ^ r ^ t);
		}
		if (u | o) {
			if (q & 1073741824) {
				return (q ^ 3221225472 ^ r ^ t);
			} else {
				return (q ^ 1073741824 ^ r ^ t);
			}
		} else {
			return (q ^ r ^ t);
		}
	};
	var n = function(o, q, p) {
		return (o & q) | ((~o) & p);
	};
	var l = function(o, q, p) {
		return (o & p) | (q & (~p));
	};
	var j = function(o, q, p) {
		return (o ^ q ^ p);
	};
	var i = function(o, q, p) {
		return (q ^ (o | (~p)));
	};
	var g = function(q, p, v, u, o, r, t) {
		q = a(q, a(a(n(p, v, u), o), t));
		return a(m(q, r), p);
	};
	var c = function(q, p, v, u, o, r, t) {
		q = a(q, a(a(l(p, v, u), o), t));
		return a(m(q, r), p);
	};
	var h = function(q, p, v, u, o, r, t) {
		q = a(q, a(a(j(p, v, u), o), t));
		return a(m(q, r), p);
	};
	var d = function(q, p, v, u, o, r, t) {
		q = a(q, a(a(i(p, v, u), o), t));
		return a(m(q, r), p);
	};
	var f = function(r) {
		var v;
		var q = r.length;
		var p = q + 8;
		var u = (p - (p % 64)) / 64;
		var t = (u + 1) * 16;
		var w = Array(t - 1);
		var o = 0;
		var s = 0;
		while (s < q) {
			v = (s - (s % 4)) / 4;
			o = (s % 4) * 8;
			w[v] = (w[v] | (r.charCodeAt(s) << o));
			s++;
		}
		v = (s - (s % 4)) / 4;
		o = (s % 4) * 8;
		w[v] = w[v] | (128 << o);
		w[t - 2] = q << 3;
		w[t - 1] = q >>> 29;
		return w;
	};
	var b = function(r) {
		var q = "", o = "", s, p;
		for (p = 0; p <= 3; p++) {
			s = (r >>> (p * 8)) & 255;
			o = "0" + s.toString(16);
			q = q + o.substr(o.length - 2, 2);
		}
		return q;
	};
	var k = function(p) {
		p = p.replace(/\x0d\x0a/g, "\x0a");
		var o = "";
		for ( var r = 0; r < p.length; r++) {
			var q = p.charCodeAt(r);
			if (q < 128) {
				o += String.fromCharCode(q);
			} else {
				if ((q > 127) && (q < 2048)) {
					o += String.fromCharCode((q >> 6) | 192);
					o += String.fromCharCode((q & 63) | 128);
				} else {
					o += String.fromCharCode((q >> 12) | 224);
					o += String.fromCharCode(((q >> 6) & 63) | 128);
					o += String.fromCharCode((q & 63) | 128);
				}
			}
		}
		return o;
	};
	e.extend( {
		md5 : function(o) {
			var v = Array();
			var G, H, p, u, F, Q, P, N, K;
			var D = 7, B = 12, z = 17, w = 22;
			var O = 5, L = 9, J = 14, I = 20;
			var t = 4, s = 11, r = 16, q = 23;
			var E = 6, C = 10, A = 15, y = 21;
			o = k(o);
			v = f(o);
			Q = 1732584193;
			P = 4023233417;
			N = 2562383102;
			K = 271733878;
			for (G = 0; G < v.length; G += 16) {
				H = Q;
				p = P;
				u = N;
				F = K;
				Q = g(Q, P, N, K, v[G + 0], D, 3614090360);
				K = g(K, Q, P, N, v[G + 1], B, 3905402710);
				N = g(N, K, Q, P, v[G + 2], z, 606105819);
				P = g(P, N, K, Q, v[G + 3], w, 3250441966);
				Q = g(Q, P, N, K, v[G + 4], D, 4118548399);
				K = g(K, Q, P, N, v[G + 5], B, 1200080426);
				N = g(N, K, Q, P, v[G + 6], z, 2821735955);
				P = g(P, N, K, Q, v[G + 7], w, 4249261313);
				Q = g(Q, P, N, K, v[G + 8], D, 1770035416);
				K = g(K, Q, P, N, v[G + 9], B, 2336552879);
				N = g(N, K, Q, P, v[G + 10], z, 4294925233);
				P = g(P, N, K, Q, v[G + 11], w, 2304563134);
				Q = g(Q, P, N, K, v[G + 12], D, 1804603682);
				K = g(K, Q, P, N, v[G + 13], B, 4254626195);
				N = g(N, K, Q, P, v[G + 14], z, 2792965006);
				P = g(P, N, K, Q, v[G + 15], w, 1236535329);
				Q = c(Q, P, N, K, v[G + 1], O, 4129170786);
				K = c(K, Q, P, N, v[G + 6], L, 3225465664);
				N = c(N, K, Q, P, v[G + 11], J, 643717713);
				P = c(P, N, K, Q, v[G + 0], I, 3921069994);
				Q = c(Q, P, N, K, v[G + 5], O, 3593408605);
				K = c(K, Q, P, N, v[G + 10], L, 38016083);
				N = c(N, K, Q, P, v[G + 15], J, 3634488961);
				P = c(P, N, K, Q, v[G + 4], I, 3889429448);
				Q = c(Q, P, N, K, v[G + 9], O, 568446438);
				K = c(K, Q, P, N, v[G + 14], L, 3275163606);
				N = c(N, K, Q, P, v[G + 3], J, 4107603335);
				P = c(P, N, K, Q, v[G + 8], I, 1163531501);
				Q = c(Q, P, N, K, v[G + 13], O, 2850285829);
				K = c(K, Q, P, N, v[G + 2], L, 4243563512);
				N = c(N, K, Q, P, v[G + 7], J, 1735328473);
				P = c(P, N, K, Q, v[G + 12], I, 2368359562);
				Q = h(Q, P, N, K, v[G + 5], t, 4294588738);
				K = h(K, Q, P, N, v[G + 8], s, 2272392833);
				N = h(N, K, Q, P, v[G + 11], r, 1839030562);
				P = h(P, N, K, Q, v[G + 14], q, 4259657740);
				Q = h(Q, P, N, K, v[G + 1], t, 2763975236);
				K = h(K, Q, P, N, v[G + 4], s, 1272893353);
				N = h(N, K, Q, P, v[G + 7], r, 4139469664);
				P = h(P, N, K, Q, v[G + 10], q, 3200236656);
				Q = h(Q, P, N, K, v[G + 13], t, 681279174);
				K = h(K, Q, P, N, v[G + 0], s, 3936430074);
				N = h(N, K, Q, P, v[G + 3], r, 3572445317);
				P = h(P, N, K, Q, v[G + 6], q, 76029189);
				Q = h(Q, P, N, K, v[G + 9], t, 3654602809);
				K = h(K, Q, P, N, v[G + 12], s, 3873151461);
				N = h(N, K, Q, P, v[G + 15], r, 530742520);
				P = h(P, N, K, Q, v[G + 2], q, 3299628645);
				Q = d(Q, P, N, K, v[G + 0], E, 4096336452);
				K = d(K, Q, P, N, v[G + 7], C, 1126891415);
				N = d(N, K, Q, P, v[G + 14], A, 2878612391);
				P = d(P, N, K, Q, v[G + 5], y, 4237533241);
				Q = d(Q, P, N, K, v[G + 12], E, 1700485571);
				K = d(K, Q, P, N, v[G + 3], C, 2399980690);
				N = d(N, K, Q, P, v[G + 10], A, 4293915773);
				P = d(P, N, K, Q, v[G + 1], y, 2240044497);
				Q = d(Q, P, N, K, v[G + 8], E, 1873313359);
				K = d(K, Q, P, N, v[G + 15], C, 4264355552);
				N = d(N, K, Q, P, v[G + 6], A, 2734768916);
				P = d(P, N, K, Q, v[G + 13], y, 1309151649);
				Q = d(Q, P, N, K, v[G + 4], E, 4149444226);
				K = d(K, Q, P, N, v[G + 11], C, 3174756917);
				N = d(N, K, Q, P, v[G + 2], A, 718787259);
				P = d(P, N, K, Q, v[G + 9], y, 3951481745);
				Q = a(Q, H);
				P = a(P, p);
				N = a(N, u);
				K = a(K, F);
			}
			var M = b(Q) + b(P) + b(N) + b(K);
			return M.toLowerCase();
		}
	});
})(jQuery);