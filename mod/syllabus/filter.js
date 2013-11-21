/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function updatefilter(selector,style) {
  var criteria = selector.options[selector.selectedIndex].value;
  var queryStart = document.URL.indexOf("&") + 1;
  var queryEnd   = document.URL.indexOf("#") + 1 || document.URL.length + 1;
  var newQuery = "";
  var FLAG = false;
  if (queryStart === 0) {
     var url = document.URL;
     newQuery = url;
  }
  else {
     var url      = document.URL.slice(0, queryStart -1);
  
  
      var query      = document.URL.slice(queryStart, queryEnd - 1);
      var params  = {};
      var nvPairs = query.replace(/\+/g, " ").split("&");
      var z;
      for (var i=0; i<nvPairs.length; i++) {
        var nv = nvPairs[i].split("=");
        var n  = decodeURIComponent(nv[0]);
        var v  = decodeURIComponent(nv[1]);
        if ( !(n in params) ) {
          params[n] = [];
        }
        params[n].push(nv.length === 2 ? v : null);
        if(n === style) {
            params[n] = criteria;
            FLAG = true;
        }
      }
      newQuery = url;
      for( z in params) {
         if( !(params[z] === undefined)) {
             if(params[z] != ""){
    //             console.log(params[z]);
                 newQuery = newQuery + "&" + z + "=" + params[z];
             }
         }
      }
      
      //window.location.assign(newQuery);
     
  }
 /* 
  console.log("url = "+url);
  console.dir(params);
  console.log("qstart = "+queryStart);
  console.log("newQ = "+newQuery);
  console.log(url+ "&"+ style +"=" + criteria);
  */
  if(FLAG === true){
      window.location = newQuery;
  }
  else {
      window.location = newQuery + "&" + style +"=" + criteria;
  }
  
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
  }