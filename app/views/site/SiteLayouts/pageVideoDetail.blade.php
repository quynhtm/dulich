<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h2 class="title-path"><a href="{{URL::route('site.pageVideo')}}" title="Video">Video</a></h2>
	<h1 class="title-view">{{stripslashes($item->video_name)}}</h1>
	<div class="list-library-ext">
		@if(isset($item) && sizeof($item) > 0)
			<div class="page-list-library">
                <?php
                $_video = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $item->video_link);
                $embed = '<iframe width="100%" height="400" src="'.$_video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
                echo $embed;
                ?>
			</div>
			@if($item->video_content != '')
				<div class="library-intro">
					{{stripslashes($item->video_content)}}
				</div>
			@endif
		@endif
	</div>
	<div class="line">
		<div class="title-same">Video khác</div>
		@if(isset($newsSame) && sizeof($newsSame) > 0)
			<div class="row page-list-same">
				@foreach($newsSame as $k=>$item)
					<div class="col-lg-6 col-sm-6 item-video w48">
						<a title="{{$item->video_name}}" href="{{FunctionLib::buildLinkDetailVideo($item->video_name, $item->video_id)}}">
							<div>
                                <?php
                                $_video = str_replace('https://www.youtube.com/watch?v=', 'https://www.youtube.com/embed/', $item->video_link);
                                $embed = '<iframe width="100%" height="250" src="'.$_video.'?rel=0" frameborder="0" allowfullscreen></iframe>';
                                echo $embed;
                                ?>
							</div>
							<div class="titleL">{{stripslashes($item->video_name)}}</div>
						</a>
					</div>
				@endforeach
			</div>
		@endif
	</div>
</div>