var <?=$namespace?> = {
  init: function(args)
  {
    <?=$namespace?>.prefs = args;    
    $.each(args, function(i,v) {
      if(typeof(<?=$namespace?>.i)=='undefined')
      {
        <?=$namespace?>.i = v;
      }
    });
  },
  
  build_url: function(url,args)
  {
    res = $.url.parse(url);
    $.extend(res['params'], args);
    return $.url.build(res);
  },
  
  _generate_url: function(path, max_args, args, is_ssl_required, qs, use_ssl, host)
  {
    args = Array.prototype.slice.call(args);
    if(args.length>0 && args[args.length-1] instanceof Object) qs = $.extend(qs,args.pop());
    if(args.length > max_args)
    {
      alert('Wrong number of arguments for: ' + path);
      return;
    }
    
    if(<?=$namespace?>.getParameterByName('__session_id')!="")
    {
      qs['__session_id'] = <?=$namespace?>.getParameterByName('__session_id');
    }
    
    path = '/'+path;
    if (<?=$namespace?>.root_vpath !='') path = <?=$namespace?>.root_vpath+path;
    
    for(i=0;i<args.length;i++)
    {
      val = $.URLEncode(args[i]);
      path = path.replace(/:[^\/]+/, val);
    }
    
    res = {};
    
    res['protocol'] = is_ssl_required && use_ssl ? 'https' : 'http';
    res['params'] = qs;
    res['host'] = host;
    res['path'] = path;
    url = $.url.build(res);
    
    return url;
  },      
  
  getParameterByName: function( name )
  {
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( window.location.href );
    if( results == null )
      return "";
    else
      return decodeURIComponent(results[1].replace(/\+/g, " "));
  },
  
  this_url: function(args)
  {
    url = <?=$namespace?>.prefs.current_url;
    return <?=$namespace?>.build_url(url,args);
  }
  ,
  home_url: function(args)
  {
    url = <?=$namespace?>.prefs.home_url;
    return <?=$namespace?>.build_url(url,args);
  },
  
  generate_url: function(path, max_args, args, is_ssl_required)
  {
    qs = {}
    if(<?=$namespace?>.session_id)
    {
      qs['__session_id'] = <?=$namespace?>.session_id;
    }
        
    return <?=$namespace?>._generate_url(
      path,
      max_args,
      args,
      is_ssl_required,
      qs,
      <?=$namespace?>.use_ssl,
      <?=$namespace?>.http_host
    );
  },
};
