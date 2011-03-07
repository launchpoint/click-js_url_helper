  function build_url(url,args)
  {
    res = $.url.parse(url);
    $.extend(res['params'], args);
    return $.url.build(res);
  }
  
  function _generate_url(path, max_args, args, is_ssl_required, qs, use_ssl, host)
  {
    args = Array.prototype.slice.call(args);
    if(args.length>0 && args[args.length-1] instanceof Object) qs = $.extend(qs,args.pop());
    if(args.length > max_args)
    {
      alert('Wrong number of arguments for: ' + path);
      return;
    }
    
    if(getParameterByName('__session_id')!="")
    {
      qs['__session_id'] = getParameterByName('__session_id');
    }
    
    path = '/'+path;
    if (ROOT_VPATH !='') path = ROOT_VPATH+path;
    
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
  }      
