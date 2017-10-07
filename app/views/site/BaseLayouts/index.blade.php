<!DOCTYPE html>
<html lang="vi">
<head>
	{{CGlobal::$extraMeta}}
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
	<link rel="shortcut icon" href="{{Config::get('config.WEB_ROOT')}}assets/frontend/img/favicon.ico" type="image/vnd.microsoft.icon">

	{{ HTML::style('assets/frontend/css/site.css'); }}
	{{ HTML::script('assets/js/jquery.2.1.1.min.js', array(), Config::get('config.SECURE')) }}

	{{CGlobal::$extraHeaderCSS}}
	{{CGlobal::$extraHeaderJS}}
	
    <script type="text/javascript">
        var WEB_ROOT = "{{url('', array(), Config::get('config.SECURE'))}}";
        var DEVMODE = "{{Config::get('config.DEVMODE')}}";
        var COOKIE_DOMAIN = "{{Config::get('config.DOMAIN_COOKIE_SERVER')}}";
    </script>
    
    @if(Config::get('config.DEVMODE') == false)
        <meta name="google-site-verification" content="b71v5Ru4Ajs2e9RwaLDzECAyF3y7RhPX680ixfPpY3I" />
		<script type="text/javascript">
		/* <![CDATA[ */
		var google_conversion_id = 855355338;
		var google_custom_params = window.google_tag_params;
		var google_remarketing_only = true;
		/* ]]> */
		</script>
		<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
		</script>
		<noscript>
		<div style="display:inline;">
		<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/855355338/?guid=ON&amp;script=0"/>
		</div>
		</noscript>
    @endif
</head>
<body>
<div id="wrapper">
	@if(isset($header))
	<div id="header">
		{{$header}}
	</div>
	@endif
	 
	<div id="content">
		<div class="line-content">
			<div class="container">
				<div class="wraps">
					@if(isset($slider))
						{{$slider}}
					@endif
					<div class="line">
						@if(isset($left))
							{{$left}}
						@endif

						@if(isset($content))
							{{$content}}
						@endif

						@if(isset($right))
							{{$right}}
						@endif
					</div>
					@if(isset($eduBottom))
					<div class="line">
						{{$eduBottom}}
					</div>
					@endif
					@if(isset($imagesVideoBottom))
					<div class="line">
						{{$imagesVideoBottom}}
					</div>
					@endif
					@if(isset($sliderPartnerBottom))
					<div class="line">
						{{$sliderPartnerBottom}}
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	@if(isset($footer))
	<div id="footer">
		{{$footer}}
	</div>
	@endif
</div>
{{CGlobal::$extraFooterCSS}}
{{CGlobal::$extraFooterJS}}
</body>
</html>
