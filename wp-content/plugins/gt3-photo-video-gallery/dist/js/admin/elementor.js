!function(t){var e={};function n(i){if(e[i])return e[i].exports;var r=e[i]={i:i,l:!1,exports:{}};return t[i].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=t,n.c=e,n.d=function(t,e,i){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:i})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var i=Object.create(null);if(n.r(i),Object.defineProperty(i,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var r in t)n.d(i,r,function(e){return t[e]}.bind(null,r));return i},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="/",n(n.s=644)}({14:function(t,e,n){var i,r,o={},a=(i=function(){return window&&document&&document.all&&!window.atob},function(){return void 0===r&&(r=i.apply(this,arguments)),r}),s=function(t,e){return e?e.querySelector(t):document.querySelector(t)},l=function(t){var e={};return function(t,n){if("function"==typeof t)return t();if(void 0===e[t]){var i=s.call(this,t,n);if(window.HTMLIFrameElement&&i instanceof window.HTMLIFrameElement)try{i=i.contentDocument.head}catch(t){i=null}e[t]=i}return e[t]}}(),c=null,d=0,u=[],h=n(31);function f(t,e){for(var n=0;n<t.length;n++){var i=t[n],r=o[i.id];if(r){r.refs++;for(var a=0;a<r.parts.length;a++)r.parts[a](i.parts[a]);for(;a<i.parts.length;a++)r.parts.push(y(i.parts[a],e))}else{var s=[];for(a=0;a<i.parts.length;a++)s.push(y(i.parts[a],e));o[i.id]={id:i.id,refs:1,parts:s}}}}function p(t,e){for(var n=[],i={},r=0;r<t.length;r++){var o=t[r],a=e.base?o[0]+e.base:o[0],s={css:o[1],media:o[2],sourceMap:o[3]};i[a]?i[a].parts.push(s):n.push(i[a]={id:a,parts:[s]})}return n}function g(t,e){var n=l(t.insertInto);if(!n)throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");var i=u[u.length-1];if("top"===t.insertAt)i?i.nextSibling?n.insertBefore(e,i.nextSibling):n.appendChild(e):n.insertBefore(e,n.firstChild),u.push(e);else if("bottom"===t.insertAt)n.appendChild(e);else{if("object"!=typeof t.insertAt||!t.insertAt.before)throw new Error("[Style Loader]\n\n Invalid value for parameter 'insertAt' ('options.insertAt') found.\n Must be 'top', 'bottom', or Object.\n (https://github.com/webpack-contrib/style-loader#insertat)\n");var r=l(t.insertAt.before,n);n.insertBefore(e,r)}}function m(t){if(null===t.parentNode)return!1;t.parentNode.removeChild(t);var e=u.indexOf(t);e>=0&&u.splice(e,1)}function v(t){var e=document.createElement("style");if(void 0===t.attrs.type&&(t.attrs.type="text/css"),void 0===t.attrs.nonce){var i=function(){0;return n.nc}();i&&(t.attrs.nonce=i)}return b(e,t.attrs),g(t,e),e}function b(t,e){Object.keys(e).forEach(function(n){t.setAttribute(n,e[n])})}function y(t,e){var n,i,r,o;if(e.transform&&t.css){if(!(o="function"==typeof e.transform?e.transform(t.css):e.transform.default(t.css)))return function(){};t.css=o}if(e.singleton){var a=d++;n=c||(c=v(e)),i=D.bind(null,n,a,!1),r=D.bind(null,n,a,!0)}else t.sourceMap&&"function"==typeof URL&&"function"==typeof URL.createObjectURL&&"function"==typeof URL.revokeObjectURL&&"function"==typeof Blob&&"function"==typeof btoa?(n=function(t){var e=document.createElement("link");return void 0===t.attrs.type&&(t.attrs.type="text/css"),t.attrs.rel="stylesheet",b(e,t.attrs),g(t,e),e}(e),i=T.bind(null,n,e),r=function(){m(n),n.href&&URL.revokeObjectURL(n.href)}):(n=v(e),i=S.bind(null,n),r=function(){m(n)});return i(t),function(e){if(e){if(e.css===t.css&&e.media===t.media&&e.sourceMap===t.sourceMap)return;i(t=e)}else r()}}t.exports=function(t,e){if("undefined"!=typeof DEBUG&&DEBUG&&"object"!=typeof document)throw new Error("The style-loader cannot be used in a non-browser environment");(e=e||{}).attrs="object"==typeof e.attrs?e.attrs:{},e.singleton||"boolean"==typeof e.singleton||(e.singleton=a()),e.insertInto||(e.insertInto="head"),e.insertAt||(e.insertAt="bottom");var n=p(t,e);return f(n,e),function(t){for(var i=[],r=0;r<n.length;r++){var a=n[r];(s=o[a.id]).refs--,i.push(s)}t&&f(p(t,e),e);for(r=0;r<i.length;r++){var s;if(0===(s=i[r]).refs){for(var l=0;l<s.parts.length;l++)s.parts[l]();delete o[s.id]}}}};var _,w=(_=[],function(t,e){return _[t]=e,_.filter(Boolean).join("\n")});function D(t,e,n,i){var r=n?"":i.css;if(t.styleSheet)t.styleSheet.cssText=w(e,r);else{var o=document.createTextNode(r),a=t.childNodes;a[e]&&t.removeChild(a[e]),a.length?t.insertBefore(o,a[e]):t.appendChild(o)}}function S(t,e){var n=e.css,i=e.media;if(i&&t.setAttribute("media",i),t.styleSheet)t.styleSheet.cssText=n;else{for(;t.firstChild;)t.removeChild(t.firstChild);t.appendChild(document.createTextNode(n))}}function T(t,e,n){var i=n.css,r=n.sourceMap,o=void 0===e.convertToAbsoluteUrls&&r;(e.convertToAbsoluteUrls||o)&&(i=h(i)),r&&(i+="\n/*# sourceMappingURL=data:application/json;base64,"+btoa(unescape(encodeURIComponent(JSON.stringify(r))))+" */");var a=new Blob([i],{type:"text/css"}),s=t.href;t.href=URL.createObjectURL(a),s&&URL.revokeObjectURL(s)}},31:function(t,e){t.exports=function(t){var e="undefined"!=typeof window&&window.location;if(!e)throw new Error("fixUrls requires window.location");if(!t||"string"!=typeof t)return t;var n=e.protocol+"//"+e.host,i=n+e.pathname.replace(/\/[^\/]*$/,"/");return t.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,function(t,e){var r,o=e.trim().replace(/^"(.*)"$/,function(t,e){return e}).replace(/^'(.*)'$/,function(t,e){return e});return/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/|\s*$)/i.test(o)?t:(r=0===o.indexOf("//")?o:0===o.indexOf("/")?n+o:i+o.replace(/^\.\//,""),"url("+JSON.stringify(r)+")")})}},517:function(t,e,n){"use strict";(function(t){var i=n(518),r=n(532),o=n(519),a=n(520),s=n(521),l=wp.i18n,c=(l.__,l._n,l.sprintf,Backbone.View.extend({initialize:function(t){this.controller=new i.a(_.extend({ids:t.value.split(","),onChange:t.onChange},this.$el.data())),this.firstLoad=t.firstLoad||!1,this.controllerChangeLength=this.controllerChangeLength.bind(this),this.createList(),this.createAddButton(),this.createClearButton(),this.createStatus(),this.render(),this.controller.load(),this.startTimer=null,this.controller.on("change:length",this.controllerChangeLength),this.startTimer=setTimeout(function(){this.controller.starting=!1,this.status.disableLoading()}.bind(this),1e3)},controllerChangeLength:function(){this.controller.starting?(clearTimeout(this.startTimer),this.startTimer=setTimeout(function(){this.controller.starting=!1,this.firstLoad&&this.controller.saveMedia(),this.status.disableLoading()}.bind(this),1e3)):this.controller.saveMedia()},createList:function(){this.list=new r.a({controller:this.controller})},createAddButton:function(){this.addButton=new o.a({controller:this.controller})},createClearButton:function(){this.clearButton=new a.a({controller:this.controller})},createStatus:function(){this.status=new s.a({controller:this.controller})},render:function(){this.$el.empty().append(t("<div/>",{class:"gt3-controls",html:[this.addButton.el,this.clearButton.el,this.status.el]}),this.list.el)}}));e.a=c}).call(this,n(7))},518:function(t,e,n){"use strict";function i(t){return function(t){if(Array.isArray(t)){for(var e=0,n=new Array(t.length);e<t.length;e++)n[e]=t[e];return n}}(t)||function(t){if(Symbol.iterator in Object(t)||"[object Arguments]"===Object.prototype.toString.call(t))return Array.from(t)}(t)||function(){throw new TypeError("Invalid attempt to spread non-iterable instance")}()}var r=wp.i18n,o=r.__,a=(r._n,r.sprintf,Backbone.Model.extend({defaults:{maxFiles:0,ids:[],forceDelete:!1,length:0,showStatus:!0},initialize:function(t){this.set("ids",_.without(_.map(this.get("ids"),Number),0,-1)),this.set("items",new wp.media.model.Attachments),this.onChange=t.onChange||function(){},this.countItems=this.countItems.bind(this),this.listenTo(this.get("items"),"add remove reset change",this.countItems)},countItems:function(){var t=this.get("items"),e=t.length,n=this.get("maxFiles");this.set("length",e),this.set("full",n>0&&e>=n),this.set("ids",t.collect("id")),this.trigger("render")},isEmpty:function(){return!this.get("length")},load:function(){this.starting=!0,_.isEmpty(this.get("ids"))||(this.get("items").props.set({query:!0,include:this.get("ids"),orderby:"post__in",order:"DESC",type:"image",perPage:-1}),this.get("items").more())},removeItem:function(t){this.get("items").remove(t)},addItems:function(t){var e,n=this.get("items"),r=n.slice();r=(e=r).concat.apply(e,i(t)),n.reset(r)},clearItems:function(){var t=arguments.length>0&&void 0!==arguments[0]&&arguments[0];(t||confirm(o("Are you really want remove all images?","gt3pg_pro")))&&this.get("items").reset()},saveMedia:function(){var t=this.get("items");this.onChange({id_a:t.collect("id"),ids:t.collect("id").join(","),url:t.map(function(t){return t.attributes.sizes&&t.attributes.sizes.large&&t.attributes.sizes.large.url||t.attributes.url}),caption:t.collect("caption"),description:t.collect("description"),title:t.collect("title"),json:t.toJSON().map(function(t){return{alt:t.alt,caption:t.caption,description:t.description,height:t.height,width:t.width,id:t.id,title:t.title,url:t.url,sizes:t.sizes}}),items:t})}}));e.a=a},519:function(t,e,n){"use strict";var i=wp.i18n,r=i.__,o=(i._n,i.sprintf,Backbone.View.extend({className:"gt3-add-media",tagName:"a",events:{click:function(){this._frame&&this._frame.dispose();var t=this,e=wp.media.controller.Library.extend({defaults:_.defaults({query:!0,id:"insert-image",title:r("Select Files","gt3pg_pro"),multiple:"add",library:wp.media.query({post__not_in:this.controller.get("ids"),type:"image"}),type:"image"},wp.media.controller.Library.prototype.defaults)});this._frame=wp.media({button:{text:r("Select","gt3pg_pro")},state:"insert-image",states:[new e]}),this._frame.on("select",function(){t.controller.addItems(t._frame.state().get("selection").models.filter(function(t){return t.get("sizes")}))},this),this._frame.on("open",function(){var e=null;t._frame.on("library:selection:add",function n(){var i=t._frame.state(),r=i.get("library"),o=i.get("selection");o&&o.models&&(_.some(o.models,function(t){return!0===t.get("uploading")})?(clearTimeout(e),e=setTimeout(n.bind(this),100)):r.add(o.models))}.bind(this))}),this._frame.open()}},render:function(){return this.$el.text(r("+ Add Media","gt3pg_pro")),this},initialize:function(t){this.controller=t.controller,this.listenTo(this.controller,"change:full",function(){this.$el.toggle(!this.controller.get("full"))}),this.render()}}));e.a=o},520:function(t,e,n){"use strict";var i=wp.i18n,r=i.__,o=(i._n,i.sprintf,Backbone.View.extend({className:"gt3-clear-media button page-title-action",tagName:"a",events:{click:function(){this.controller.clearItems()}},render:function(){return this.$el.text(r("Clear Gallery","gt3pg_pro")),this},initialize:function(t){this.controller=t.controller,this.render()}}));e.a=o},521:function(t,e,n){"use strict";var i=wp.i18n,r=(i.__,i._n),o=i.sprintf,a=Backbone.View.extend({tagName:"span",className:"gt3-media-status align-center",loading:!0,disableLoading:function(){this.loading=!1,this.$el.removeClass("align-center"),this.render()},initialize:function(t){this.controller=t.controller,this.controller.get("showStatus")||this.$el.hide(),this.listenTo(this.controller,"change:length",this.render),this.render()},render:function(){var t=this.controller.get("length"),e=this.loading?'<span class="spinner"></span>':o(r("%s image selected","%s images selected",t,"gt3pg_pro"),t);return this.$el.html(e),this}});e.a=a},532:function(t,e,n){"use strict";var i=wp.i18n,r=i.__,o=(i._n,i.sprintf,Backbone.View.extend({tagName:"div",className:"gt3-image-item",initialize:function(t){this.controller=t.controller,this.render=this.render.bind(this),this.render(),this.listenTo(this.model,"change",this.render),this.$el.data("id",this.model.cid)},events:{"click .gt3-remove-media":function(t){return t.preventDefault(),t.stopPropagation(),this.controller.removeItem(this.model),!1},"click .gt3-edit-media":function(t){return t.preventDefault(),t.stopPropagation(),this._frame&&this._frame.dispose(),this._frame=wp.media({frame:"edit-attachments",controller:{gridRouter:new wp.media.view.MediaFrame.Manage.Router},library:this.controller.get("items"),model:this.model}),this._frame.resetRoute=function(){},this._frame.open(),!1}},render:function(){var t=Object.assign({},this.model.attributes),e=t.icon;return e="image"===t.type&&t.sizes?t.sizes.thumbnail?t.sizes.thumbnail.url:t.sizes.full.url:t.image&&t.image.src&&t.image.src!==t.icon?t.image.src:t.icon,this.$el.html('\n\t\t<div class="gt3-media-preview" data-id="'.concat(t.id,'" style="background-image: url(').concat(e,')"></div>\n\t\t<div class="gt3-overlay"></div>\n\t\t<div class="gt3-media-bar">\n\t\t\t<a class="gt3-edit-media" title="').concat(r("Edit","gt3pg_pro"),'" href="').concat(t.editLink,'" target="_blank"></a>\n\t\t\t<a href="#" class="gt3-remove-media" title="').concat(r("Remove","gt3pg_pro"),'"></a>\n\t\t</div>')),this}})),a=wp.i18n,s=(a.__,a._n,a.sprintf,Backbone.View.extend({tagName:"div",className:"gt3-media-list",initialize:function(t){this._views={},this.controller=t.controller,this.setEvents(),this.render=this.render.bind(this)},setEvents:function(){this.listenTo(this.controller,"render",this.render)},initSortable:function(){var t=this.controller.get("items");this.$el.sortable({tolerance:"pointer",handle:".gt3-overlay",start:function(t,e){e.item.data("sortableIndexStart",e.item.index())}.bind(this),update:function(e,n){var i=t.at(n.item.data("sortableIndexStart"));t.remove(i,{silent:!0}),t.add(i,{silent:!0,at:n.item.index()}),t.trigger("reset",t),this.controller.saveMedia()}.bind(this)})},render:function(){var t,e=this.controller.get("items");this.$el.empty(),e&&e.length&&e.forEach(function(e,n){t=this._views[e.cid]=new o({model:e,controller:this.controller}),this.$el.append(t.$el)}.bind(this)),this.initSortable()}}));e.a=s},569:function(t,e){window.GT3=window.GT3||{},window.GT3.Editor=window.GT3.Editor||{},window.GT3.Editor.Controls=window.GT3.Editor.Controls||{}},570:function(t,e,n){(function(i){var r,o;function a(t){return(a="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t})(t)}!function(i){"use strict";void 0===(o="function"==typeof(r=i)?r.call(e,n,e,t):r)||(t.exports=o)}(function(){"use strict";if("undefined"==typeof window||!window.document)return function(){throw new Error("Sortable.js requires a window with a document")};var t,e,n,r,o,s,l,c,d,u,h,f,p,g,m,v,b,y,_,w,D,S={},T=/\s+/g,C=/left|right|inline/,x="Sortable"+(new Date).getTime(),E=window,k=E.document,B=E.parseInt,N=E.setTimeout,O=i||E.Zepto,I=E.Polymer,L=!1,A="draggable"in k.createElement("div"),M=!navigator.userAgent.match(/(?:Trident.*rv[ :]?11\.|msie)/i)&&((D=k.createElement("x")).style.cssText="pointer-events:auto","auto"===D.style.pointerEvents),j=!1,R=Math.abs,P=Math.min,U=[],z=[],Y=function(){return!1},X=at(function(t,e,n){if(n&&e.scroll){var i,r,o,a,s,l,h=n[x],f=e.scrollSensitivity,p=e.scrollSpeed,g=t.clientX,m=t.clientY,v=window.innerWidth,b=window.innerHeight;if(d!==n&&(c=e.scroll,d=n,u=e.scrollFn,!0===c)){c=n;do{if(c.offsetWidth<c.scrollWidth||c.offsetHeight<c.scrollHeight)break}while(c=c.parentNode)}c&&(i=c,r=c.getBoundingClientRect(),o=(R(r.right-g)<=f)-(R(r.left-g)<=f),a=(R(r.bottom-m)<=f)-(R(r.top-m)<=f)),o||a||(a=(b-m<=f)-(m<=f),((o=(v-g<=f)-(g<=f))||a)&&(i=E)),S.vx===o&&S.vy===a&&S.el===i||(S.el=i,S.vx=o,S.vy=a,clearInterval(S.pid),i&&(S.pid=setInterval(function(){l=a?a*p:0,s=o?o*p:0,"function"==typeof u&&"continue"!==u.call(h,s,l,t,_,i)||(i===E?E.scrollTo(E.pageXOffset+s,E.pageYOffset+l):(i.scrollTop+=l,i.scrollLeft+=s))},24)))}},30),$=function(t){function e(t,e){return null!=t&&!0!==t||null!=(t=n.name)?"function"==typeof t?t:function(n,i){var r=i.options.group.name;return e?t:t&&(t.join?t.indexOf(r)>-1:r==t)}:Y}var n={},i=t.group;i&&"object"==a(i)||(i={name:i}),n.name=i.name,n.checkPull=e(i.pull,!0),n.checkPut=e(i.put),n.revertClone=i.revertClone,t.group=n};try{window.addEventListener("test",null,Object.defineProperty({},"passive",{get:function(){L={capture:!1,passive:!1}}}))}catch(t){}function F(t,e){if(!t||!t.nodeType||1!==t.nodeType)throw"Sortable: `el` must be HTMLElement, and not "+{}.toString.call(t);this.el=t,this.options=e=st({},e),t[x]=this;var n={group:null,sort:!0,disabled:!1,store:null,handle:null,scroll:!0,scrollSensitivity:30,scrollSpeed:10,draggable:/[uo]l/i.test(t.nodeName)?"li":">*",ghostClass:"sortable-ghost",chosenClass:"sortable-chosen",dragClass:"sortable-drag",ignore:"a, img",filter:null,preventOnFilter:!0,animation:0,setData:function(t,e){t.setData("Text",e.textContent)},dropBubble:!1,dragoverBubble:!1,dataIdAttr:"data-id",delay:0,forceFallback:!1,fallbackClass:"sortable-fallback",fallbackOnBody:!1,fallbackTolerance:0,fallbackOffset:{x:0,y:0},supportPointer:!1!==F.supportPointer};for(var i in n)!(i in e)&&(e[i]=n[i]);for(var r in $(e),this)"_"===r.charAt(0)&&"function"==typeof this[r]&&(this[r]=this[r].bind(this));this.nativeDraggable=!e.forceFallback&&A,H(t,"mousedown",this._onTapStart),H(t,"touchstart",this._onTapStart),e.supportPointer&&H(t,"pointerdown",this._onTapStart),this.nativeDraggable&&(H(t,"dragover",this),H(t,"dragenter",this)),z.push(this._onDragOver),e.store&&this.sort(e.store.get(this))}function V(e,n){"clone"!==e.lastPullMode&&(n=!0),r&&r.state!==n&&(Q(r,"display",n?"none":""),n||r.state&&(e.options.group.revertClone?(o.insertBefore(r,s),e._animate(t,r)):o.insertBefore(r,t)),r.state=n)}function G(t,e,n){if(t){n=n||k;do{if(">*"===e&&t.parentNode===n||ot(t,e))return t}while(t=q(t))}return null}function q(t){var e=t.host;return e&&e.nodeType?e:t.parentNode}function H(t,e,n){t.addEventListener(e,n,L)}function W(t,e,n){t.removeEventListener(e,n,L)}function J(t,e,n){if(t)if(t.classList)t.classList[n?"add":"remove"](e);else{var i=(" "+t.className+" ").replace(T," ").replace(" "+e+" "," ");t.className=(i+(n?" "+e:"")).replace(T," ")}}function Q(t,e,n){var i=t&&t.style;if(i){if(void 0===n)return k.defaultView&&k.defaultView.getComputedStyle?n=k.defaultView.getComputedStyle(t,""):t.currentStyle&&(n=t.currentStyle),void 0===e?n:n[e];e in i||(e="-webkit-"+e),i[e]=n+("string"==typeof n?"":"px")}}function Z(t,e,n){if(t){var i=t.getElementsByTagName(e),r=0,o=i.length;if(n)for(;r<o;r++)n(i[r],r);return i}return[]}function K(t,e,n,i,o,a,s,l,c){t=t||e[x];var d=k.createEvent("Event"),u=t.options,h="on"+n.charAt(0).toUpperCase()+n.substr(1);d.initEvent(n,!0,!0),d.to=o||e,d.from=a||e,d.item=i||e,d.clone=r,d.oldIndex=s,d.newIndex=l,d.originalEvent=c,e.dispatchEvent(d),u[h]&&u[h].call(t,d)}function tt(t,e,n,i,r,o,a,s){var l,c,d=t[x],u=d.options.onMove;return(l=k.createEvent("Event")).initEvent("move",!0,!0),l.to=e,l.from=t,l.dragged=n,l.draggedRect=i,l.related=r||e,l.relatedRect=o||e.getBoundingClientRect(),l.willInsertAfter=s,l.originalEvent=a,t.dispatchEvent(l),u&&(c=u.call(d,l,a)),c}function et(t){t.draggable=!1}function nt(){j=!1}function it(t){for(var e=t.tagName+t.className+t.src+t.href+t.textContent,n=e.length,i=0;n--;)i+=e.charCodeAt(n);return i.toString(36)}function rt(t,e){var n=0;if(!t||!t.parentNode)return-1;for(;t&&(t=t.previousElementSibling);)"TEMPLATE"===t.nodeName.toUpperCase()||">*"!==e&&!ot(t,e)||n++;return n}function ot(t,e){if(t)try{if(t.matches)return t.matches(e);if(t.msMatchesSelector)return t.msMatchesSelector(e)}catch(t){return!1}return!1}function at(t,e){var n,i;return function(){void 0===n&&(n=arguments,i=this,N(function(){1===n.length?t.call(i,n[0]):t.apply(i,n),n=void 0},e))}}function st(t,e){if(t&&e)for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n]);return t}function lt(t){return I&&I.dom?I.dom(t).cloneNode(!0):O?O(t).clone(!0)[0]:t.cloneNode(!0)}function ct(t){return N(t,0)}function dt(t){return clearTimeout(t)}return F.prototype={constructor:F,_onTapStart:function(e){var n,i=this,r=this.el,o=this.options,a=o.preventOnFilter,s=e.type,c=e.touches&&e.touches[0],d=(c||e).target,u=e.target.shadowRoot&&e.path&&e.path[0]||d,h=o.filter;if(function(t){U.length=0;var e=t.getElementsByTagName("input"),n=e.length;for(;n--;){var i=e[n];i.checked&&U.push(i)}}(r),!t&&!(/mousedown|pointerdown/.test(s)&&0!==e.button||o.disabled)&&!u.isContentEditable&&(d=G(d,o.draggable,r))&&l!==d){if(n=rt(d,o.draggable),"function"==typeof h){if(h.call(this,e,d,this))return K(i,u,"filter",d,r,r,n),void(a&&e.preventDefault())}else if(h&&(h=h.split(",").some(function(t){if(t=G(u,t.trim(),r))return K(i,t,"filter",d,r,r,n),!0})))return void(a&&e.preventDefault());o.handle&&!G(u,o.handle,r)||this._prepareDragStart(e,c,d,n)}},_prepareDragStart:function(n,i,r,a){var c,d=this,u=d.el,h=d.options,f=u.ownerDocument;r&&!t&&r.parentNode===u&&(y=n,o=u,e=(t=r).parentNode,s=t.nextSibling,l=r,v=h.group,g=a,this._lastX=(i||n).clientX,this._lastY=(i||n).clientY,t.style["will-change"]="all",c=function(){d._disableDelayedDrag(),t.draggable=d.nativeDraggable,J(t,h.chosenClass,!0),d._triggerDragStart(n,i),K(d,o,"choose",t,o,o,g)},h.ignore.split(",").forEach(function(e){Z(t,e.trim(),et)}),H(f,"mouseup",d._onDrop),H(f,"touchend",d._onDrop),H(f,"touchcancel",d._onDrop),H(f,"selectstart",d),h.supportPointer&&H(f,"pointercancel",d._onDrop),h.delay?(H(f,"mouseup",d._disableDelayedDrag),H(f,"touchend",d._disableDelayedDrag),H(f,"touchcancel",d._disableDelayedDrag),H(f,"mousemove",d._disableDelayedDrag),H(f,"touchmove",d._disableDelayedDrag),h.supportPointer&&H(f,"pointermove",d._disableDelayedDrag),d._dragStartTimer=N(c,h.delay)):c())},_disableDelayedDrag:function(){var t=this.el.ownerDocument;clearTimeout(this._dragStartTimer),W(t,"mouseup",this._disableDelayedDrag),W(t,"touchend",this._disableDelayedDrag),W(t,"touchcancel",this._disableDelayedDrag),W(t,"mousemove",this._disableDelayedDrag),W(t,"touchmove",this._disableDelayedDrag),W(t,"pointermove",this._disableDelayedDrag)},_triggerDragStart:function(e,n){(n=n||("touch"==e.pointerType?e:null))?(y={target:t,clientX:n.clientX,clientY:n.clientY},this._onDragStart(y,"touch")):this.nativeDraggable?(H(t,"dragend",this),H(o,"dragstart",this._onDragStart)):this._onDragStart(y,!0);try{k.selection?ct(function(){k.selection.empty()}):window.getSelection().removeAllRanges()}catch(t){}},_dragStarted:function(){if(o&&t){var e=this.options;J(t,e.ghostClass,!0),J(t,e.dragClass,!1),F.active=this,K(this,o,"start",t,o,o,g)}else this._nulling()},_emulateDragOver:function(){if(_){if(this._lastX===_.clientX&&this._lastY===_.clientY)return;this._lastX=_.clientX,this._lastY=_.clientY,M||Q(n,"display","none");var t=k.elementFromPoint(_.clientX,_.clientY),e=t,i=z.length;if(t&&t.shadowRoot&&(e=t=t.shadowRoot.elementFromPoint(_.clientX,_.clientY)),e)do{if(e[x]){for(;i--;)z[i]({clientX:_.clientX,clientY:_.clientY,target:t,rootEl:e});break}t=e}while(e=e.parentNode);M||Q(n,"display","")}},_onTouchMove:function(t){if(y){var e=this.options,i=e.fallbackTolerance,r=e.fallbackOffset,o=t.touches?t.touches[0]:t,a=o.clientX-y.clientX+r.x,s=o.clientY-y.clientY+r.y,l=t.touches?"translate3d("+a+"px,"+s+"px,0)":"translate("+a+"px,"+s+"px)";if(!F.active){if(i&&P(R(o.clientX-this._lastX),R(o.clientY-this._lastY))<i)return;this._dragStarted()}this._appendGhost(),w=!0,_=o,Q(n,"webkitTransform",l),Q(n,"mozTransform",l),Q(n,"msTransform",l),Q(n,"transform",l),t.preventDefault()}},_appendGhost:function(){if(!n){var e,i=t.getBoundingClientRect(),r=Q(t),a=this.options;J(n=t.cloneNode(!0),a.ghostClass,!1),J(n,a.fallbackClass,!0),J(n,a.dragClass,!0),Q(n,"top",i.top-B(r.marginTop,10)),Q(n,"left",i.left-B(r.marginLeft,10)),Q(n,"width",i.width),Q(n,"height",i.height),Q(n,"opacity","0.8"),Q(n,"position","fixed"),Q(n,"zIndex","100000"),Q(n,"pointerEvents","none"),a.fallbackOnBody&&k.body.appendChild(n)||o.appendChild(n),e=n.getBoundingClientRect(),Q(n,"width",2*i.width-e.width),Q(n,"height",2*i.height-e.height)}},_onDragStart:function(e,n){var i=this,a=e.dataTransfer,s=i.options;i._offUpEvents(),v.checkPull(i,i,t,e)&&((r=lt(t)).draggable=!1,r.style["will-change"]="",Q(r,"display","none"),J(r,i.options.chosenClass,!1),i._cloneId=ct(function(){o.insertBefore(r,t),K(i,o,"clone",t)})),J(t,s.dragClass,!0),n?("touch"===n?(H(k,"touchmove",i._onTouchMove),H(k,"touchend",i._onDrop),H(k,"touchcancel",i._onDrop),s.supportPointer&&(H(k,"pointermove",i._onTouchMove),H(k,"pointerup",i._onDrop))):(H(k,"mousemove",i._onTouchMove),H(k,"mouseup",i._onDrop)),i._loopId=setInterval(i._emulateDragOver,50)):(a&&(a.effectAllowed="move",s.setData&&s.setData.call(i,a,t)),H(k,"drop",i),i._dragStartId=ct(i._dragStarted))},_onDragOver:function(i){var a,l,c,d,u=this.el,g=this.options,m=g.group,y=F.active,_=v===m,D=!1,S=g.sort;if(void 0!==i.preventDefault&&(i.preventDefault(),!g.dragoverBubble&&i.stopPropagation()),!t.animated&&(w=!0,y&&!g.disabled&&(_?S||(d=!o.contains(t)):b===this||(y.lastPullMode=v.checkPull(this,y,t,i))&&m.checkPut(this,y,t,i))&&(void 0===i.rootEl||i.rootEl===this.el))){if(X(i,g,this.el),j)return;if(a=G(i.target,g.draggable,u),l=t.getBoundingClientRect(),b!==this&&(b=this,D=!0),d)return V(y,!0),e=o,void(r||s?o.insertBefore(t,r||s):S||o.appendChild(t));if(0===u.children.length||u.children[0]===n||u===i.target&&function(t,e){var n=t.lastElementChild.getBoundingClientRect();return e.clientY-(n.top+n.height)>5||e.clientX-(n.left+n.width)>5}(u,i)){if(0!==u.children.length&&u.children[0]!==n&&u===i.target&&(a=u.lastElementChild),a){if(a.animated)return;c=a.getBoundingClientRect()}V(y,_),!1!==tt(o,u,t,l,a,c,i)&&(t.contains(u)||(u.appendChild(t),e=u),this._animate(l,t),a&&this._animate(c,a))}else if(a&&!a.animated&&a!==t&&void 0!==a.parentNode[x]){h!==a&&(h=a,f=Q(a),p=Q(a.parentNode));var T=(c=a.getBoundingClientRect()).right-c.left,E=c.bottom-c.top,k=C.test(f.cssFloat+f.display)||"flex"==p.display&&0===p["flex-direction"].indexOf("row"),B=a.offsetWidth>t.offsetWidth,O=a.offsetHeight>t.offsetHeight,I=(k?(i.clientX-c.left)/T:(i.clientY-c.top)/E)>.5,L=a.nextElementSibling,A=!1;if(k){var M=t.offsetTop,R=a.offsetTop;A=M===R?a.previousElementSibling===t&&!B||I&&B:a.previousElementSibling===t||t.previousElementSibling===a?(i.clientY-c.top)/E>.5:R>M}else D||(A=L!==t&&!O||I&&O);var P=tt(o,u,t,l,a,c,i,A);!1!==P&&(1!==P&&-1!==P||(A=1===P),j=!0,N(nt,30),V(y,_),t.contains(u)||(A&&!L?u.appendChild(t):a.parentNode.insertBefore(t,A?L:a)),e=t.parentNode,this._animate(l,t),this._animate(c,a))}}},_animate:function(t,e){var n=this.options.animation;if(n){var i=e.getBoundingClientRect();1===t.nodeType&&(t=t.getBoundingClientRect()),Q(e,"transition","none"),Q(e,"transform","translate3d("+(t.left-i.left)+"px,"+(t.top-i.top)+"px,0)"),e.offsetWidth,Q(e,"transition","all "+n+"ms"),Q(e,"transform","translate3d(0,0,0)"),clearTimeout(e.animated),e.animated=N(function(){Q(e,"transition",""),Q(e,"transform",""),e.animated=!1},n)}},_offUpEvents:function(){var t=this.el.ownerDocument;W(k,"touchmove",this._onTouchMove),W(k,"pointermove",this._onTouchMove),W(t,"mouseup",this._onDrop),W(t,"touchend",this._onDrop),W(t,"pointerup",this._onDrop),W(t,"touchcancel",this._onDrop),W(t,"pointercancel",this._onDrop),W(t,"selectstart",this)},_onDrop:function(i){var a=this.el,l=this.options;clearInterval(this._loopId),clearInterval(S.pid),clearTimeout(this._dragStartTimer),dt(this._cloneId),dt(this._dragStartId),W(k,"mouseover",this),W(k,"mousemove",this._onTouchMove),this.nativeDraggable&&(W(k,"drop",this),W(a,"dragstart",this._onDragStart)),this._offUpEvents(),i&&(w&&(i.preventDefault(),!l.dropBubble&&i.stopPropagation()),n&&n.parentNode&&n.parentNode.removeChild(n),o!==e&&"clone"===F.active.lastPullMode||r&&r.parentNode&&r.parentNode.removeChild(r),t&&(this.nativeDraggable&&W(t,"dragend",this),et(t),t.style["will-change"]="",J(t,this.options.ghostClass,!1),J(t,this.options.chosenClass,!1),K(this,o,"unchoose",t,e,o,g,null,i),o!==e?(m=rt(t,l.draggable))>=0&&(K(null,e,"add",t,e,o,g,m,i),K(this,o,"remove",t,e,o,g,m,i),K(null,e,"sort",t,e,o,g,m,i),K(this,o,"sort",t,e,o,g,m,i)):t.nextSibling!==s&&(m=rt(t,l.draggable))>=0&&(K(this,o,"update",t,e,o,g,m,i),K(this,o,"sort",t,e,o,g,m,i)),F.active&&(null!=m&&-1!==m||(m=g),K(this,o,"end",t,e,o,g,m,i),this.save()))),this._nulling()},_nulling:function(){o=t=e=n=s=r=l=c=d=y=_=w=m=h=f=b=v=F.active=null,U.forEach(function(t){t.checked=!0}),U.length=0},handleEvent:function(e){switch(e.type){case"drop":case"dragend":this._onDrop(e);break;case"dragover":case"dragenter":t&&(this._onDragOver(e),function(t){t.dataTransfer&&(t.dataTransfer.dropEffect="move");t.preventDefault()}(e));break;case"mouseover":this._onDrop(e);break;case"selectstart":e.preventDefault()}},toArray:function(){for(var t,e=[],n=this.el.children,i=0,r=n.length,o=this.options;i<r;i++)G(t=n[i],o.draggable,this.el)&&e.push(t.getAttribute(o.dataIdAttr)||it(t));return e},sort:function(t){var e={},n=this.el;this.toArray().forEach(function(t,i){var r=n.children[i];G(r,this.options.draggable,n)&&(e[t]=r)},this),t.forEach(function(t){e[t]&&(n.removeChild(e[t]),n.appendChild(e[t]))})},save:function(){var t=this.options.store;t&&t.set(this)},closest:function(t,e){return G(t,e||this.options.draggable,this.el)},option:function(t,e){var n=this.options;if(void 0===e)return n[t];n[t]=e,"group"===t&&$(n)},destroy:function(){var t=this.el;t[x]=null,W(t,"mousedown",this._onTapStart),W(t,"touchstart",this._onTapStart),W(t,"pointerdown",this._onTapStart),this.nativeDraggable&&(W(t,"dragover",this),W(t,"dragenter",this)),Array.prototype.forEach.call(t.querySelectorAll("[draggable]"),function(t){t.removeAttribute("draggable")}),z.splice(z.indexOf(this._onDragOver),1),this._onDrop(),this.el=t=null}},H(k,"touchmove",function(t){F.active&&t.preventDefault()}),F.utils={on:H,off:W,css:Q,find:Z,is:function(t,e){return!!G(t,e,t)},extend:st,throttle:at,closest:G,toggleClass:J,clone:lt,index:rt,nextTick:ct,cancelNextTick:dt},F.create=function(t,e){return new F(t,e)},F.version="1.7.0",F})}).call(this,n(7))},571:function(t,e){elementor&&elementor.hooks&&elementor.hooks.addFilter("element/view",function(t,e,n){var i=t,r=e.get("widgetType"),o=e.get("settings"),a=o.toJSON();if(r&&r.indexOf&&-1!==r.indexOf("gt3pg")){var s={select_source:"source",slides:"ids"},l={};i=t.extend({initialize:function(){t.prototype.initialize.apply(this,arguments),Object.keys(s).forEach(function(t){o.unset(t),a[t]&&(l[s[t]]=a[t])}),o.setExternalChange(l)}})}return i})},572:function(t,e,n){var i=n(573);"string"==typeof i&&(i=[[t.i,i,""]]);var r={hmr:!0,transform:void 0,insertInto:void 0};n(14)(i,r);i.locals&&(t.exports=i.locals)},573:function(t,e,n){},644:function(t,e,n){"use strict";n.r(e);n(569),n(570);var i=n(517),r=wp.i18n,o=(r.__,r._n,r.sprintf,elementor.modules.controls.BaseData.extend({onReady:function(){this.onChange=this.onChange.bind(this);var t=this.getControlValue();try{t="number"==typeof(t=JSON.parse(t))?t.toString():t.map(function(t){return t.id}).join(",")}catch(t){}"string"!=typeof t&&(t=t.join&&t.join(",")||""),this.media=new i.a({el:this.$el,value:t,onChange:this.onChange,firstLoad:!1})},onChange:function(t){this.setValue(t&&t.ids||"")}}));elementor.addControlView("gt3pg-pro--gallery",o);n(571),n(572)},7:function(t,e){t.exports=jQuery}});