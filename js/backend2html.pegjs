{
var backend2html = {};
backend2html.tagStack = [];
}

post
 = items:postItem*
 {
 	var result = items.join("");
    while(backend2html.tagStack.length > 0) {
    	result += "</" + backend2html.tagStack.pop() + ">";
    }
    return result;
 }
 
postItem
 = url
 / totoz
 / bigorno
 / norloge
 / atag
 / openTag
 / closeTag
 / xmlSpecialChar
 / .
 
xmlSpecialChar
 = (lt / gt / amp / quot / apos)
 
lt
 = "<"
 { return "&lt;"; }
 
gt
 = ">"
 { return "&gt;"; }
 
amp
 = "&"
 { return "&amp;"; }

quot
 = '"'
 { return "&quot;"; }
 
apos
 = "'"
 { return "&apos;"; }
 
url
 = protocol:$((("http" "s"?) / "ftp") "://") url:(xmlSpecialChar / [^ \t\r\n])+
 { return [].concat('<a href="', protocol, url.join(""), '" target="_blank"></a>').join("");}

openTag
 = "<" tag:validFormatTag ">"
 {
 	backend2html.tagStack.push(tag);
    console.log("push " + tag);
 	return "<" + tag + ">";
 }

closeTag
 = "</" tag:validFormatTag ">"
 {
 	var result = "";
 	for(;;) {
      var poppedTag = backend2html.tagStack.pop();
      if(poppedTag == undefined) {
      	break;
      }
      if( poppedTag == tag) {
      	result += "</" + tag + ">";
        break;
      } else {
      	result += "</" + poppedTag + ">";
      }
    }
    return result;
 }

validFormatTag
 = ("b" / "i" / "s" / "u" / "tt")

invalidOpenTag
 = "<" tag:invalidTag ">"
 { return "&lt" + tag; + "&gt"; }

invalidCloseTag
 = "</" tag:invalidTag ">"
 { return  "&lt/" + tag; + "&gt";; }
 
invalidTag
 = [A-Za-z] (xmlSpecialChar / [^>])*

atag
 = "<a" attributes:tagAttributes ">" [^<]* "</a>"
 { 
   if(attributes.href) {
      return "<url>" + attributes.href + "</url>";
   }
 }
 
tagAttributes
 = attributes:(separator:" " attribute:tagAttribute { return attribute;})*
 {  var result = {};
 	for(var a in attributes) {
    	result[attributes[a].name] = attributes[a].value;
    }
 	return result;
 }

tagAttribute
 = name:$[a-z]+ value:("=\"" value:$[^"]* "\"" {return value;} )?
 {return { name: name, value: value}}

norloge
 = n:(fullNorloge / normalNorloge / shortNorloge)
 { return '<time>' + n +'</time>'}

fullNorloge
 = y: norlogeYear "-" m: norlogeMonth "-" d:norlogeDay "T" nn:normalNorloge
 { return y + "-" + m + "-" + d + "T" + nn; }
 
norlogeYear
 = digits: [0-9]+
 { return digits.join(""); }
 
norlogeMonth
 = first: [0-1] last: [0-9]
 { return first + last; }

norlogeDay
 = first: [0-3] last: [0-9]
 { return first + last; }

normalNorloge
 = sn:shortNorloge ":" s:norlogeSeconds
 { return sn + ":" + s; }
 
shortNorloge
 = h:norlogeHours ":" m:norlogeMinutes
 { return h + ":" + m; }

norlogeHours
 = first: [0-2] last: [0-3]
 { return first + last; }
 
norlogeMinutes
 = first: [0-5] last: [0-9]
 { return first + last; }
 
norlogeSeconds
 = first: [0-5] last: [0-9]
 { return first + last; }

bigorno
 = whitespaces bigorno:[a-zA-Z0-9-_]+ "<" &(whitespaces / [<[])
 { return [].concat('<cite>', bigorno,'</cite>').join("")}

totoz
  = first:"[:" totoz:[^\]]+ third:"]"
  { var totozId = totoz.join(""); 
  return '<img src="https://totoz.eu/img/' + totozId + '">'; }
  
whitespaces
 = inputStart / [ \t\r\n] / ! .

inputStart
 = & { return location().start.offset == 0; }
