(()=>{-1!==location.href.indexOf("setting")&&-1!==location.href.indexOf("://keepa.com")&&(location.href="https://keepa.com/");try{setTimeout((()=>{let e=document.getElementById("myInput1").value;e=JSON.parse(e).token,chrome.runtime.sendMessage({data:e,action:"importkeepa",href:"https://keepa.com/extension"}),chrome.runtime.sendMessage({data:e,action:"importkeepa",href:"https://keepa.com/"})}),3e3)}catch(e){}})();