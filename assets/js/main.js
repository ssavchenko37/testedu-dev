"use strict";
var _excluded = ["endValue"];
function _objectWithoutProperties(e, t) { if (null == e) return {}; var o, r, i = _objectWithoutPropertiesLoose(e, t); if (Object.getOwnPropertySymbols) { var s = Object.getOwnPropertySymbols(e); for (r = 0; r < s.length; r++) o = s[r], t.includes(o) || {}.propertyIsEnumerable.call(e, o) && (i[o] = e[o]); } return i; }
function _objectWithoutPropertiesLoose(r, e) { if (null == r) return {}; var t = {}; for (var n in r) if ({}.hasOwnProperty.call(r, n)) { if (e.includes(n)) continue; t[n] = r[n]; } return t; }
function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }
function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _iterableToArray(r) { if ("undefined" != typeof Symbol && null != r[Symbol.iterator] || null != r["@@iterator"]) return Array.from(r); }
function _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function _classCallCheck(a, n) { if (!(a instanceof n)) throw new TypeError("Cannot call a class as a function"); }
function _defineProperties(e, r) { for (var t = 0; t < r.length; t++) { var o = r[t]; o.enumerable = o.enumerable || !1, o.configurable = !0, "value" in o && (o.writable = !0), Object.defineProperty(e, _toPropertyKey(o.key), o); } }
function _createClass(e, r, t) { return r && _defineProperties(e.prototype, r), t && _defineProperties(e, t), Object.defineProperty(e, "prototype", { writable: !1 }), e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }

/* -------------------------------------------------------------------------- */
/*                                    Utils                                   */
/* -------------------------------------------------------------------------- */
var docReady = function docReady(fn) {
	// see if DOM is already available
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', fn);
	} else {
		setTimeout(fn, 1);
	}
};
var resize = function resize(fn) {
	return window.addEventListener('resize', fn);
};
var isIterableArray = function isIterableArray(array) {
	return Array.isArray(array) && !!array.length;
};
var camelize = function camelize(str) {
	var text = str.replace(/[-_\s.]+(.)?/g, function (match, capture) {
		if (capture) {
			return capture.toUpperCase();
		}
		return '';
	});
	return "".concat(text.substr(0, 1).toLowerCase()).concat(text.substr(1));
};
var getData = function getData(el, data) {
	try {
		return JSON.parse(el.dataset[camelize(data)]);
	} catch (e) {
		return el.dataset[camelize(data)];
	}
};

var hasClass = function hasClass(el, className) {
	!el && false;
	return el.classList.value.includes(className);
};
var addClass = function addClass(el, className) {
	el.classList.add(className);
};
var removeClass = function removeClass(el, className) {
	el.classList.remove(className);
};
var getOffset = function getOffset(el) {
	var rect = el.getBoundingClientRect();
	var scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
	var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
	return {
		top: rect.top + scrollTop,
		left: rect.left + scrollLeft
	};
};
function isScrolledIntoView(el) {
	var rect = el.getBoundingClientRect();
	var windowHeight = window.innerHeight || document.documentElement.clientHeight;
	var windowWidth = window.innerWidth || document.documentElement.clientWidth;
	var vertInView = rect.top <= windowHeight && rect.top + rect.height >= 0;
	var horInView = rect.left <= windowWidth && rect.left + rect.width >= 0;
	return vertInView && horInView;
}
var getItemFromStore = function getItemFromStore(key, defaultValue) {
	var store = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : localStorage;
	try {
	  return JSON.parse(store.getItem(key)) || defaultValue;
	} catch (_unused) {
	  return store.getItem(key) || defaultValue;
	}
};
var setItemToStore = function setItemToStore(key, payload) {
	var store = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : localStorage;
	return store.setItem(key, payload);
};
var getStoreSpace = function getStoreSpace() {
	var store = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : localStorage;
	return parseFloat((escape(encodeURIComponent(JSON.stringify(store))).length / (1024 * 1024)).toFixed(2));
};
var utils = {
	docReady: docReady,
	resize: resize,
	isIterableArray: isIterableArray,
	camelize: camelize,
	getData: getData,
	hasClass: hasClass,
	addClass: addClass,
	removeClass: removeClass,
	getItemFromStore: getItemFromStore,
	setItemToStore: setItemToStore,
	// breakpoints: breakpoints,
	// hexToRgb: hexToRgb,
	// rgbaColor: rgbaColor,
	// getColor: getColor,
	// getColors: getColors,
	// getSubtleColors: getSubtleColors,
	// getGrays: getGrays,
	// getOffset: getOffset,
	// isScrolledIntoView: isScrolledIntoView,
	// getBreakpoint: getBreakpoint,
	// setCookie: setCookie,
	// getCookie: getCookie,
	// newChart: newChart,
	// settings: settings,
	// getStoreSpace: getStoreSpace,
	// getDates: getDates,
	// getPastDates: getPastDates,
	// getRandomNumber: getRandomNumber,
};

/* -------------------------------------------------------------------------- */
/*                                  Detector                                  */
/* -------------------------------------------------------------------------- */

var detectorInit = function detectorInit() {
	var _window = window,
		is = _window.is;
	if (_window.is !== undefined) {
		var html = document.querySelector('html');
		is.opera() && addClass(html, 'opera');
		is.mobile() && addClass(html, 'mobile');
		is.firefox() && addClass(html, 'firefox');
		is.safari() && addClass(html, 'safari');
		is.ios() && addClass(html, 'ios');
		is.iphone() && addClass(html, 'iphone');
		is.ipad() && addClass(html, 'ipad');
		is.ie() && addClass(html, 'ie');
		is.edge() && addClass(html, 'edge');
		is.chrome() && addClass(html, 'chrome');
		is.mac() && addClass(html, 'osx');
		is.windows() && addClass(html, 'windows');
		navigator.userAgent.match('CriOS') && addClass(html, 'chrome');
	}
};

/* -------------------------------------------------------------------------- */
/*                               Navbar Vertical                              */
/* -------------------------------------------------------------------------- */

var handleNavbarVerticalCollapsed = function handleNavbarVerticalCollapsed() {
	var Selector = {
		HTML: 'html',
		NAVBAR_VERTICAL_TOGGLE: '.navbar-vertical-toggle',
		NAVBAR_VERTICAL_COLLAPSE: '.navbar-vertical .navbar-collapse',
		ECHART_RESPONSIVE: '[data-echart-responsive]'
	};
	var Events = {
		CLICK: 'click',
		MOUSE_OVER: 'mouseover',
		MOUSE_LEAVE: 'mouseleave',
		NAVBAR_VERTICAL_TOGGLE: 'navbar.vertical.toggle'
	};
	var ClassNames = {
		NAVBAR_VERTICAL_COLLAPSED: 'navbar-vertical-collapsed',
		NAVBAR_VERTICAL_COLLAPSED_HOVER: 'navbar-vertical-collapsed-hover'
	};
	var navbarVerticalToggle = document.querySelector(Selector.NAVBAR_VERTICAL_TOGGLE);
	var html = document.querySelector(Selector.HTML);
	var navbarVerticalCollapse = document.querySelector(Selector.NAVBAR_VERTICAL_COLLAPSE);

	if (utils.getItemFromStore('isNavbarVerticalCollapsed')) {
		document.querySelector(Selector.HTML).classList.add(ClassNames.NAVBAR_VERTICAL_COLLAPSED);
	}

	if (navbarVerticalToggle) {
		navbarVerticalToggle.addEventListener(Events.CLICK, function (e) {
			navbarVerticalToggle.blur();
			html.classList.toggle(ClassNames.NAVBAR_VERTICAL_COLLAPSED);
			// Set collapse state on localStorage
			var isNavbarVerticalCollapsed = utils.getItemFromStore('isNavbarVerticalCollapsed');
			utils.setItemToStore('isNavbarVerticalCollapsed', !isNavbarVerticalCollapsed);
			var event = new CustomEvent(Events.NAVBAR_VERTICAL_TOGGLE);
			e.currentTarget.dispatchEvent(event);
		});
	}

	if (navbarVerticalCollapse) {
		navbarVerticalCollapse.addEventListener(Events.MOUSE_OVER, function () {
			if (utils.hasClass(html, ClassNames.NAVBAR_VERTICAL_COLLAPSED)) {
				html.classList.add(ClassNames.NAVBAR_VERTICAL_COLLAPSED_HOVER);
			}
		});
		navbarVerticalCollapse.addEventListener(Events.MOUSE_LEAVE, function () {
			if (utils.hasClass(html, ClassNames.NAVBAR_VERTICAL_COLLAPSED_HOVER)) {
				html.classList.remove(ClassNames.NAVBAR_VERTICAL_COLLAPSED_HOVER);
			}
		});
	}
  };

/* -------------------------------------------------------------------------- */
/*                            Theme Initialization                            */
/* -------------------------------------------------------------------------- */
docReady(detectorInit);
docReady(handleNavbarVerticalCollapsed);

/* ---------------------------- ^navbarVerticalNav ---------------------------------------------- */
const navbarVerticalHighlight = () => {
	const nav = document.getElementById('navbarVerticalNav');
	if (nav === null) return
	const nav_items = nav.getElementsByClassName('nav-link')
	if (nav_items.length) {
		for (let item of nav_items) {
			if (!item.classList.contains('dropdown-indicator')) {
				if (item.href.split('/')[3] === pathlast) {
					item.classList.add('active');
				}
			}
		}
	}

}
docReady(navbarVerticalHighlight);
/* ---------------------------- /navbarVerticalNav ---------------------------------------------- */

const periodCtrl = () => {
	const sheet_period = document.getElementById('sheet_period')
	if (sheet_period === null) return;
	sheet_period.addEventListener('input', (e) => {
		e.target.closest('FORM').submit();
	});
}
docReady(periodCtrl);

const infoHandler = () => {
	const info_box = document.getElementById('InfoInTop')
	if (info_box === null) return;
		document.body.addEventListener('click', () => {
		info_box.remove();
	});
}
docReady(infoHandler);

const removeTrHighlight = () => {
	const rows = document.getElementsByClassName('table-success');
	if (rows) {
		for (let tr of rows) {
			if (tr.classList.contains('rws')) {
				tr.addEventListener('mouseenter', (e) => {
					e.target.classList.remove('table-success')
				});
			}
		}
	}
}
docReady(removeTrHighlight);

const imagePreview = () => {
	const ava_wrap = document.getElementsByClassName('ava__file')[0];
	if (ava_wrap) {
		const ava_file = ava_wrap.getElementsByTagName('INPUT')[0];
		ava_file.addEventListener('input', (e) => {
			const imagefile = e.target.files[0];
			var imagetype = imagefile.type;
			var imageTypes = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
			if (imageTypes.indexOf(imagetype) == -1) {
				//display error
				e.target.empty();
				return false;
			} else {
				const reader = new FileReader();
				reader.onload = function(e) {
					document.getElementsByClassName('ava__image')[0].getElementsByTagName('IMG')[0].src = e.target.result;
				};
				reader.readAsDataURL(imagefile);
			}

		});
	}
}

const tsasideClose = () => {
	const tsaside = document.getElementById('tsaside');
	if (tsaside === null) return;
	tsaside.addEventListener('click', (e) => {
		if (e.target.classList.contains('dismiss-tsaside') || e.target.classList.contains('tsaside__backdrop')) {
			if (tsaside.classList.contains('show-block1')) {
				if (tsaside.classList.contains('show-block2')) {
					tsaside.classList.remove('show-block2');
				} else {
					tsaside.classList.remove('show-block1');
					setTimeout(() => {
						tsaside.classList.remove('show');
					}, 500);
				}
			}
			
		}	
	});
}
const getViewer = (formData) => {
	let pathname = window.location.pathname;
	const tsaside = document.getElementById('tsaside');
	const block1 = document.getElementById('tsaside-one');
	const block2 = document.getElementById('tsaside-two');
	let viewer_flag = tsaside.classList.contains('show-block1')? 2 : 1;
	let tsasideBody;

	if (viewer_flag === 1) {
		tsasideBody = block1.getElementsByClassName('tsaside__body')[0];
		tsaside.classList.add('show-block1');
		tsaside.classList.add('show');
	}
	if (viewer_flag === 2) {
		tsasideBody = block2.getElementsByClassName('tsaside__body')[0];
		tsaside.classList.add('show-block2');
	}
	fetch('/_core' + pathname + 'ajax/' + formData.get('page') + '.php', {
		method: 'POST',
		body: formData
	})
	.then(r => r.text())
	.then(html => {
		if (viewer_flag === 1) {
			tsasideBody.innerHTML = html;
			imagePreview();
		} else {
			tsasideBody.innerHTML = html;
		}
		if (typeof pageInit === 'function') {
			pageInit();
		}
	});
}
const ctrlBtn = () => {
	const workspace = document.getElementById('workspace');
	if (workspace === null) return;
	workspace.addEventListener('click', (e) => {
		let form = document.getElementById("frm0");
		if (!form) return;
		const formData = new FormData(form);
		let btn = e.target.closest('BUTTON');
		if (!btn) return;
		let ctrl = btn.parentNode;
		if (!ctrl.classList.contains('ctrlBtn')) return;
		formData.append('pid', ctrl.dataset.pid);
		formData.append('mod', btn.dataset.mod);
		formData.append('page', btn.dataset.page);
		formData.append('pre', btn.dataset.pre);
		getViewer(formData);
	});
}
docReady(ctrlBtn);
docReady(tsasideClose);

const resetFrom = () => {
	const form = document.getElementById('frm0');
	if (form === null) return;
	form.addEventListener('reset', function(e) {
		e.preventDefault();
		this.querySelectorAll('input[type="text"]').forEach(inp => inp.value = '');
		this.querySelectorAll('select').forEach(sel => sel.selectedIndex = 0);
		this.querySelectorAll('input[type="checkbox"], input[type="radio"]').forEach(el => el.checked = false);
		this.submit();
	});
}
docReady(resetFrom);

const questionFiltersHandler = () => {
	const filter_dept = document.getElementById('filter_dept');
	if (filter_dept === null) return;
	const filter_subject = document.getElementById('filter_subject');
	filter_dept.addEventListener("change", function(e) {
		for (let option of filter_subject.options) {
			option.hidden = false;
			if (!option.value.includes(e.target.value + 'S')) {
				option.hidden = true;
			}
		}
	});
}
docReady(questionFiltersHandler);

const filtersHandler = () => {
	const frm = document.getElementById('frm0');
	const filter_names = ["filter_grm","filter_grup","filter_tutor","filter_subject","filter_sem","filter_mdl","filter_daterange"];
	filter_names.forEach((f) => {
		const filter = document.getElementById(f);
		if (filter !== null) {
			filter.addEventListener('input', (e) => {
				frm.submit();
			});
		}
	});
	
	const statuses = document.querySelectorAll('[name="filter_status"]');
	statuses.forEach((s) => {
		s.addEventListener('input', () => {
			frm.submit();
		});
	});
}
docReady(filtersHandler);

const restoreFilters = () => {
	let last;
	const viewButtons = document.getElementsByClassName('get_details');
	if (viewButtons) {
		for(let btn of viewButtons) {
			btn.addEventListener('click', (e) => {
				const data = {};
				document.getElementById('frm0').querySelectorAll('select').forEach(s => data[s.name] = s.value);
				localStorage.setItem('filterValues', JSON.stringify(data));
				localStorage.setItem('getDetails', e.currentTarget.href.split('?')[1]);
			});
		}	
	}

	const savedFilters = localStorage.getItem('filterValues');
	if (savedFilters) {
		const data = JSON.parse(savedFilters);
		document.querySelectorAll('select').forEach(s => {
			if (data[s.name]) {
				s.value = data[s.name];
				if (s.value > 0) {
					last = s;
				}
			}
		});
		if (last !== undefined) {
			last.dispatchEvent(new Event('input', { bubbles: true }));
		}
		localStorage.removeItem('filterValues');
	}

	if (last === undefined) {
		const savedDetails = localStorage.getItem('getDetails');
		if (savedDetails) {
			const details_link = Array.from(viewButtons).find(a => a.href.includes(savedDetails));
			if (details_link) {
				const from_tr = details_link.closest('.rws');
				if (!from_tr) return;
				from_tr.classList.add('table-success');
				from_tr.scrollIntoView({behavior: 'smooth', block: 'center'});
				from_tr.addEventListener('mouseenter', (e) => {
					e.target.classList.remove('table-success');
				});
			}
			localStorage.removeItem('getDetails');
		}
	}
}