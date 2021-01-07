"use strict";!function(e,t){"function"==typeof define&&define.amd?define(t):"object"==typeof exports?module.exports=t():e.ResizeSensor=t()}("undefined"!=typeof window?window:this,function(){if("undefined"==typeof window)return null;var e="undefined"!=typeof window&&window.Math==Math?window:"undefined"!=typeof self&&self.Math==Math?self:Function("return this")(),t=e.requestAnimationFrame||e.mozRequestAnimationFrame||e.webkitRequestAnimationFrame||function(t){return e.setTimeout(t,20)};function n(e,t){var n=Object.prototype.toString.call(e),i="[object Array]"===n||"[object NodeList]"===n||"[object HTMLCollection]"===n||"[object Object]"===n||"undefined"!=typeof jQuery&&e instanceof jQuery||"undefined"!=typeof Elements&&e instanceof Elements,o=0,r=e.length;if(i)for(;o<r;o++)t(e[o]);else t(e)}function i(e){if(!e.getBoundingClientRect)return{width:e.offsetWidth,height:e.offsetHeight};var t=e.getBoundingClientRect();return{width:Math.round(t.width),height:Math.round(t.height)}}function o(e,t){Object.keys(t).forEach(function(n){e.style[n]=t[n]})}var r=function(e,s){function d(){var e,t,n=[];this.add=function(e){n.push(e)},this.call=function(i){for(e=0,t=n.length;e<t;e++)n[e].call(this,i)},this.remove=function(i){var o=[];for(e=0,t=n.length;e<t;e++)n[e]!==i&&o.push(n[e]);n=o},this.length=function(){return n.length}}function a(e,n){if(e)if(e.resizedAttached)e.resizedAttached.add(n);else{e.resizedAttached=new d,e.resizedAttached.add(n),e.resizeSensor=document.createElement("div"),e.resizeSensor.dir="ltr",e.resizeSensor.className="resize-sensor";var r={pointerEvents:"none",position:"absolute",left:"0px",top:"0px",right:"0px",bottom:"0px",overflow:"hidden",zIndex:"-1",visibility:"hidden",maxWidth:"100%"},s={position:"absolute",left:"0px",top:"0px",transition:"0s"};o(e.resizeSensor,r);var a=document.createElement("div");a.className="resize-sensor-expand",o(a,r);var c=document.createElement("div");o(c,s),a.appendChild(c);var f=document.createElement("div");f.className="resize-sensor-shrink",o(f,r);var h=document.createElement("div");o(h,s),o(h,{width:"200%",height:"200%"}),f.appendChild(h),e.resizeSensor.appendChild(a),e.resizeSensor.appendChild(f),e.appendChild(e.resizeSensor);var u,l,p=window.getComputedStyle(e),v=p?p.getPropertyValue("position"):null;"absolute"!==v&&"relative"!==v&&"fixed"!==v&&(e.style.position="relative");var m=i(e),z=0,w=0,g=!0,y=0,S=function(){if(g){if(0===e.offsetWidth&&0===e.offsetHeight)return void(y||(y=t(function(){y=0,S()})));g=!1}var n,i;n=e.offsetWidth,i=e.offsetHeight,c.style.width=n+10+"px",c.style.height=i+10+"px",a.scrollLeft=n+10,a.scrollTop=i+10,f.scrollLeft=n+10,f.scrollTop=i+10};e.resizeSensor.resetSensor=S;var b=function(){l=0,u&&(z=m.width,w=m.height,e.resizedAttached&&e.resizedAttached.call(m))},x=function(){m=i(e),(u=m.width!==z||m.height!==w)&&!l&&(l=t(b)),S()},A=function(e,t,n){e.attachEvent?e.attachEvent("on"+t,n):e.addEventListener(t,n)};A(a,"scroll",x),A(f,"scroll",x),t(S)}}n(e,function(e){a(e,s)}),this.detach=function(t){r.detach(e,t)},this.reset=function(){e.resizeSensor.resetSensor()}};if(r.reset=function(e){n(e,function(e){e.resizeSensor.resetSensor()})},r.detach=function(e,t){n(e,function(e){e&&(e.resizedAttached&&"function"==typeof t&&(e.resizedAttached.remove(t),e.resizedAttached.length())||e.resizeSensor&&(e.contains(e.resizeSensor)&&e.removeChild(e.resizeSensor),delete e.resizeSensor,delete e.resizedAttached))})},"undefined"!=typeof MutationObserver){var s=new MutationObserver(function(e){for(var t in e)if(e.hasOwnProperty(t))for(var n=e[t].addedNodes,i=0;i<n.length;i++)n[i].resizeSensor&&r.reset(n[i])});document.addEventListener("DOMContentLoaded",function(e){s.observe(document.body,{childList:!0,subtree:!0})})}return r});

!function(e,t){"function"==typeof define&&define.amd?define(["./ResizeSensor.js"],t):"object"==typeof exports?module.exports=t(require("./ResizeSensor.js")):(e.ElementQueries=t(e.ResizeSensor),e.ElementQueries.listen())}("undefined"!=typeof window?window:this,function(e){var t=function(){var t,n={},i=[];function r(e){e||(e=document.documentElement);var t=window.getComputedStyle(e,null).fontSize;return parseFloat(t)||16}function s(e,t){var n=t.split(/\d/),i=n[n.length-1];switch(t=parseFloat(t),i){case"px":return t;case"em":return t*r(e);case"rem":return t*r();case"vw":return t*document.documentElement.clientWidth/100;case"vh":return t*document.documentElement.clientHeight/100;case"vmin":case"vmax":var s=document.documentElement.clientWidth/100,o=document.documentElement.clientHeight/100;return t*(0,Math["vmin"===i?"min":"max"])(s,o);default:return t}}function o(e,t){var i,r,o,a,l,u,d,m;this.element=e;var c=["min-width","min-height","max-width","max-height"];this.call=function(){for(i in o=function(e){if(!e.getBoundingClientRect)return{width:e.offsetWidth,height:e.offsetHeight};var t=e.getBoundingClientRect();return{width:Math.round(t.width),height:Math.round(t.height)}}(this.element),u={},n[t])n[t].hasOwnProperty(i)&&(r=n[t][i],a=s(this.element,r.value),l="width"===r.property?o.width:o.height,m=r.mode+"-"+r.property,d="","min"===r.mode&&l>=a&&(d+=r.value),"max"===r.mode&&l<=a&&(d+=r.value),u[m]||(u[m]=""),d&&-1===(" "+u[m]+" ").indexOf(" "+d+" ")&&(u[m]+=" "+d));for(var e in c)c.hasOwnProperty(e)&&(u[c[e]]?this.element.setAttribute(c[e],u[c[e]].substr(1)):this.element.removeAttribute(c[e]))}}function a(t,n){t.elementQueriesSetupInformation||(t.elementQueriesSetupInformation=new o(t,n)),t.elementQueriesSensor||(t.elementQueriesSensor=new e(t,function(){t.elementQueriesSetupInformation.call()}))}function l(e,r,s,o){if(void 0===n[e]){n[e]=[];var a=i.length;t.innerHTML+="\n"+e+" {animation: 0.1s element-queries;}",t.innerHTML+="\n"+e+" > .resize-sensor {min-width: "+a+"px;}",i.push(e)}n[e].push({mode:r,property:s,value:o})}function u(e){var t;if(document.querySelectorAll&&(t=e?e.querySelectorAll.bind(e):document.querySelectorAll.bind(document)),t||"undefined"==typeof $$||(t=$$),t||"undefined"==typeof jQuery||(t=jQuery),!t)throw"No document.querySelectorAll, jQuery or Mootools's $$ found.";return t}function d(t){var n=[],i=[],r=[],s=0,o=-1,a=[];for(var l in t.children)if(t.children.hasOwnProperty(l)&&t.children[l].tagName&&"img"===t.children[l].tagName.toLowerCase()){n.push(t.children[l]);var u=t.children[l].getAttribute("min-width")||t.children[l].getAttribute("data-min-width"),d=t.children[l].getAttribute("data-src")||t.children[l].getAttribute("url");r.push(d);var m={minWidth:u};i.push(m),u?t.children[l].style.display="none":(s=n.length-1,t.children[l].style.display="block")}function c(){var e,l=!1;for(e in n)n.hasOwnProperty(e)&&i[e].minWidth&&t.offsetWidth>i[e].minWidth&&(l=e);if(l||(l=s),o!==l)if(a[l])n[o].style.display="none",n[l].style.display="block",o=l;else{var u=new Image;u.onload=function(){n[l].src=r[l],n[o].style.display="none",n[l].style.display="block",a[l]=!0,o=l},u.src=r[l]}else n[l].src=r[l]}o=s,t.resizeSensorInstance=new e(t,c),c()}var m=/,?[\s\t]*([^,\n]*?)((?:\[[\s\t]*?(?:min|max)-(?:width|height)[\s\t]*?[~$\^]?=[\s\t]*?"[^"]*?"[\s\t]*?])+)([^,\n\s\{]*)/gim,c=/\[[\s\t]*?(min|max)-(width|height)[\s\t]*?[~$\^]?=[\s\t]*?"([^"]*?)"[\s\t]*?]/gim;function h(e){var t,n,i,r;for(e=e.replace(/'/g,'"');null!==(t=m.exec(e));)for(n=t[1]+t[3],i=t[2];null!==(r=c.exec(i));)l(n,r[1],r[2],r[3])}function f(e){var t="";if(e)if("string"==typeof e)-1===(e=e.toLowerCase()).indexOf("min-width")&&-1===e.indexOf("max-width")||h(e);else for(var n=0,i=e.length;n<i;n++)1===e[n].type?-1!==(t=e[n].selectorText||e[n].cssText).indexOf("min-height")||-1!==t.indexOf("max-height")?h(t):-1===t.indexOf("min-width")&&-1===t.indexOf("max-width")||h(t):4===e[n].type?f(e[n].cssRules||e[n].rules):3===e[n].type&&e[n].styleSheet.hasOwnProperty("cssRules")&&f(e[n].styleSheet.cssRules)}var p=!1;this.init=function(){var n="animationstart";void 0!==document.documentElement.style.webkitAnimationName?n="webkitAnimationStart":void 0!==document.documentElement.style.MozAnimationName?n="mozanimationstart":void 0!==document.documentElement.style.OAnimationName&&(n="oanimationstart"),document.body.addEventListener(n,function(t){var n=t.target,r=n&&window.getComputedStyle(n,null),s=r&&r.getPropertyValue("animation-name");if(s&&-1!==s.indexOf("element-queries")){n.elementQueriesSensor=new e(n,function(){n.elementQueriesSetupInformation&&n.elementQueriesSetupInformation.call()});var o=window.getComputedStyle(n.resizeSensor,null).getPropertyValue("min-width");o=parseInt(o.replace("px","")),a(t.target,i[o])}}),p||((t=document.createElement("style")).type="text/css",t.innerHTML="[responsive-image] > img, [data-responsive-image] {overflow: hidden; padding: 0; } [responsive-image] > img, [data-responsive-image] > img {width: 100%;}",t.innerHTML+="\n@keyframes element-queries { 0% { visibility: inherit; } }",document.getElementsByTagName("head")[0].appendChild(t),p=!0);for(var r=0,s=document.styleSheets.length;r<s;r++)try{document.styleSheets[r].href&&0===document.styleSheets[r].href.indexOf("file://")&&console.warn("CssElementQueries: unable to parse local css files, "+document.styleSheets[r].href),f(document.styleSheets[r].cssRules||document.styleSheets[r].rules||document.styleSheets[r].cssText)}catch(e){}!function(){for(var e=u()("[data-responsive-image],[responsive-image]"),t=0,n=e.length;t<n;t++)d(e[t])}()},this.findElementQueriesElements=function(e){!function(e){var t=u(e);for(var i in n)if(n.hasOwnProperty(i))for(var r=t(i,e),s=0,o=r.length;s<o;s++)a(r[s],i)}(e)},this.update=function(){this.init()}};t.update=function(){t.instance.update()},t.detach=function(e){e.elementQueriesSetupInformation?(e.elementQueriesSensor.detach(),delete e.elementQueriesSetupInformation,delete e.elementQueriesSensor):e.resizeSensorInstance&&(e.resizeSensorInstance.detach(),delete e.resizeSensorInstance)},t.init=function(){t.instance||(t.instance=new t),t.instance.init()};return t.findElementQueriesElements=function(e){t.instance.findElementQueriesElements(e)},t.listen=function(){!function(e){if(document.addEventListener)document.addEventListener("DOMContentLoaded",e,!1);else if(/KHTML|WebKit|iCab/i.test(navigator.userAgent))var t=setInterval(function(){/loaded|complete/i.test(document.readyState)&&(e(),clearInterval(t))},10);else window.onload=e}(t.init)},t});
