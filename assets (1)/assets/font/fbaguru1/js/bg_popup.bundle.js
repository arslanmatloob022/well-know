(()=>{var e={824:e=>{function o(e,o,t){t.indexOf("https://");return"."===e.substr(0,1)&&(e=e.substring(1)),"https://"+e+o}function t(e,o,t,n){chrome.cookies.remove({url:e,name:o})}var n={get:function(e,o){return void 0!==n[preferences.copyCookiesType]&&e.length>0?n[preferences.copyCookiesType](e,o):void 0},netscape:function(e,o){var t="";t+="# Netscape HTTP Cookie File\n",t+="# http://curl.haxx.se/rfc/cookie_spec.html\n",t+="# This file was generated by EditThisCookie\n",void 0!==o&&(t+="# URL: "+o+"\n");for(var n=0;n<e.length;n++)cookie=e[n],t+=cookie.domain+"\t"+(!cookie.hostOnly).toString().toUpperCase()+"\t"+cookie.path+"\t"+cookie.secure.toString().toUpperCase()+"\t"+(cookie.expirationDate?Math.round(cookie.expirationDate):"0")+"\t"+cookie.name+"\t"+cookie.value+(n===e.length-1?"":"\n");return t},json:function(e,o){var t="";t+="[\n";for(var n=0;n<e.length;n++)cookie=e[n],cookie.id=n+1,t+=JSON.stringify(cookie,null,4),n<e.length-1&&(t+=",\n");return t+="\n]"},semicolonPairs:function(e,o){var t="";t+="// Semicolon separated Cookie File\n",t+="// This file was generated by EditThisCookie\n",t+="// Details: http://www.ietf.org/rfc/rfc2109.txt\n",t+="// Example: http://www.tutorialspoint.com/javascript/javascript_cookies.htm\n",void 0!==o&&(t+="// URL: "+o+"\n");for(var n=0;n<e.length;n++)cookie=e[n],t+=cookie.name+"="+cookie.value+";";return t},lpw:function(e,o){var t="";t+="// Semicolon separated Cookie File\n",t+="// This file was generated by EditThisCookie\n",t+="// Details: http://www.cookiecentral.com/faq/#3.5\n",t+="// Example: http://www.tutorialspoint.com/javascript/javascript_cookies.htm\n",void 0!==o&&(t+="// URL: "+o+"\n");for(var n=0;n<e.length;n++)cookie=e[n],t+="Set-Cookie3: "+cookie.name+"="+cookie.value+'; path="/"; domain='+cookie.domain+'; path_spec; expires="'+(cookie.expirationDate?cookie.expirationDate:"0")+'"; version=0\n';return t}};e.exports={deleteAll:function(e,n){for(var r=0;r<e.length;r++){var i=e[r];t(o(i.domain,i.path,n),i.name,i.storeId)}},cookieForCreationFromFullCookie:function(e){var o={};return o.url="http"+(e.secure?"s":"")+"://"+e.domain+e.path,o.name=e.name,o.value=e.value,e.hostOnly||(o.domain=e.domain),o.path=e.path,o.secure=e.secure,o.httpOnly=e.httpOnly,e.session||(o.expirationDate=e.expirationDate),o.storeId=e.storeId,o},compareCookies:function(e,o){try{if(e.name!==o.name)return!1;if(e.value!==o.value)return!1;if(e.path!==o.path)return!1;if(e.secure!==o.secure)return!1;if(e.httpOnly!==o.httpOnly)return!1;var t=!(!o.hostOnly&&void 0!==o.domain);if(t!==!(!e.hostOnly&&void 0!==e.domain))return!1;if(!t&&e.domain!==o.domain)return!1;var n=!(!o.session&&void 0!==o.expirationDate);if(n!==!(!e.session&&void 0!==e.expirationDate))return!1;if(!1===n&&e.expirationDate!==o.expirationDate)return!1}catch(e){return console.error(e.message),!1}return!0},cookiesToString:n}}},o={};function t(n){var r=o[n];if(void 0!==r)return r.exports;var i=o[n]={exports:{}};return e[n](i,i.exports,t),i.exports}t.n=e=>{var o=e&&e.__esModule?()=>e.default:()=>e;return t.d(o,{a:o}),o},t.d=(e,o)=>{for(var n in o)t.o(o,n)&&!t.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:o[n]})},t.o=(e,o)=>Object.prototype.hasOwnProperty.call(e,o),(()=>{"use strict";var e=t(824);const{cookieForCreationFromFullCookie:o,compareCookies:n}=t(824);function r(o){chrome.cookies.getAll({domain:o},(function(t){(0,e.deleteAll)(t,o)}))}var i;chrome.runtime.onMessage.addListener((function(e,t,n){"CheckCompanionExtension"!=e.action&&(e.href&&open("loading.html?open="+e.href),"import"==e.action?(!function(e){e.data.includes("helium10.com")?(r("members.helium10.com"),r("helium10.com"),r("bing.com"),r("doubleclick.com"),r("linkedin.com"),r("ads.linkedin.com"),r("ct.pinterest.com"),r("t.co"),r("clarity.ms"),r("www.clarity.ms"),r("trychameleon.com")):e.data.includes("junglescout.com")&&(r("junglescout.com"),r("members.junglescout.com"))}(e),setTimeout((()=>{!function(e){try{var t=JSON.parse(e);"[object Object]"===Object.prototype.toString.apply(t)&&(t=[t]);for(var n=0;n<t.length;n++)try{var r=t[n];"."==r.domain[0]&&(r.domain=r.domain.substr(1,r.domain.length-1));var i=o(r);chrome.cookies.set(i)}catch(e){return void console.error(e)}}catch(e){return void console.error(e)}}(e.data)}),300)):"deleteAll"==e.action?r(e.url):"importkeepa"==e.action&&chrome.cookies.set({name:"token",url:e.href,value:e.data},(function(e){})))})),chrome.runtime.onMessageExternal.addListener((function(e,o,t){return e&&e.message&&"version"==e.message&&t({extName:"toolshub"}),!0})),chrome.management.getSelf((function(e){i=new URL(e.homepageUrl).hostname,console.log("origin",i)})),chrome.tabs.query({windowType:"normal"},(function(e){console.log("reloadAllTabs",e,i);for(var o=0;o<e.length;o++)(e[o].url.includes("helium10.com")||e[o].url.includes(i))&&chrome.tabs.update(e[o].id,{url:e[o].url})})),chrome.management.getSelf((function(e){chrome.runtime.setUninstallURL(e.homepageUrl)})),chrome.storage.onChanged.addListener((function(e,o){let t=!1,n="",r=!1,i="";e.junglescoutClose&&e.junglescoutClose.newValue&&(t=!0,n={scanunlimitedClose:!1}),e.scanunlimitedClose&&e.scanunlimitedClose.newValue&&(r=!0,n={junglescoutClose:!1}),(t||r)&&chrome.storage.local.get(["scanunlimitedURL","junglescoutURL"],(function(e){if(t&&(i=e.junglescoutURL),r&&(i=e.scanunlimitedURL),i){let e=0,o=setInterval((()=>{e++,chrome.tabs.query({active:!0},(function(t){t[0].url.includes(i)?(console.log("match found"),open(i),chrome.tabs.remove(t[0].id),chrome.storage.local.set(n),clearInterval(o)):e>30&&(chrome.storage.local.set(n),clearInterval(o))}))}),1e3)}}))}))})()})();