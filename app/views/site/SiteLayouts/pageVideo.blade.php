<div class="col-lg-6 col-md-6 col-sm-12 contact col-middle w43">
	<h1 class="title-path"><a href="{{URL::route('site.pageVideo')}}" title="Video">Video</a></h1>
	<div class="list-library">
		@if(isset($arrItem) && sizeof($arrItem) > 0)
			<div class="row page-list-library">
				@foreach($arrItem as $k=>$item)
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
	<div class="show-box-paging" style="margin-top:20px; ">
		<div class="showListPage">
			{{$paging}}
		</div>
	</div>
</div>