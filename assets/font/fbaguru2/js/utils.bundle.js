Array.prototype.toTop=function(t){var r;if(t<=0||t>=this.length)return!1;r=this[t];for(var i=t;i>0;i--)this[i]=this[i-1];return this[0]=r,!0};