<?

global $__routes;
$js = array();
$js[] = eval_php($this_module_fpath."/templates/url_helper.php", $js_url_helper_settings);
foreach($__routes as $url_generator_name=>$data)
{
  $path_js = j($data['path']);
  $keys_count = count($data['keys']);
  $is_ssl_required = $data['is_ssl_required'] ? 'true' : 'false';
  $args = join(', ', $data['keys']);
  $js[] = <<<JS
  url_helper.{$url_generator_name}_url = function ($args)
  {
    return url_helper.generate_url('$path_js', $keys_count, arguments, $is_ssl_required);
  };
JS;
}
$js = join(";\n",$js);
file_put_contents($this_module_cache_fpath."/helpers.js", $js);
