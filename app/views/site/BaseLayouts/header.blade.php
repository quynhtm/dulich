<div class="head-banner">
	<div class="container">
		<div class="flash">
			@if($logo != '')
				<img src="{{$logo}}" alt="Logo" />
			@else
				@if(sizeof($arrBannerHead) > 0)
                    <?php $i=0; ?>
					@foreach($arrBannerHead as $item)
                        <?php $i++; ?>
						@if($i == 1)
							@if($item->banner_image != '')
								<img src="{{ThumbImg::thumbImageBannerNormal($item->banner_id,$item->banner_parent_id, $item->banner_image, CGlobal::sizeImage_1000,CGlobal::sizeImage_200, $item->banner_name,true,true)}}" alt="{{$item->banner_name}}" />
							@endif
						@endif
					@endforeach
				@endif
			@endif
			<!--
			<div class="language">
				<a class="vi class=" href="?lang=vi"></a>
				<a class="en class=" href="?lang=en"></a>
				<div class="toggle-menu" id="toggle-menu">
					<i class="fa fa-th-list"></i>
				</div>
			</div>
			-->
			<a href="http://cdsptw.edu.vn" target="_blank" style="font-size:18px; position: absolute;right: 0;bottom: 0px;background: #dc7458;color: #fff;padding: 2px 10px;display: inline-block;">Phiên bản cũ</a>
	    </div>
		<div class="bg-menu">
			<ul class="menu">
				@if($departmentId > 0)
					<li><a class="aline" href="{{URL::route('site.home')}}"><i class="fa fa-home icon-home"></i></a></li>
					@if(sizeof($itemDepartment) > 0)
					<li><a class="aline" href="{{FunctionLib::buildLinkCategoryDepartment($itemDepartment['department_alias'], $itemDepartment['department_name'], $itemDepartment['department_id'])}}">Trang chủ</a></li>
					@endif
				@else
					<li><a class="aline" href="{{URL::route('site.home')}}">Trang chủ</a></li>
				@endif
				@if(!empty($menuCategoriessAll))
					<?php $i=1; ?>
					@foreach($menuCategoriessAll as $cat)
						@if($i <= $numCategory)
							@if($cat['category_show_top'] == CGlobal::status_show && $cat['category_parent_id'] == CGlobal::status_hide)
								@if($cat['category_depart_id'] == $departmentId)
									<?php $i++; ?>
									<li><a class="aline @if(isset($catid) && $catid == $cat['category_id']) act @endif" @if($cat['category_link'] != '')href="{{$cat['category_link']}}" target="_blank" @else href="{{FunctionLib::buildLinkCategory($cat['category_id'], $cat['category_name'])}}" @endif title="{{$cat['category_name']}}">{{$cat['category_name']}}</a>
                                        <?php $s = 0; ?>
										@foreach($menuCategoriessAll as $sub)
											@if($sub['category_parent_id'] == $cat['category_id'] && $sub['category_show_top'] == CGlobal::status_show && $sub['category_depart_id'] == $departmentId)
												<?php $s++; ?>
											@endif
										@endforeach
										@if($s > 0)
										<ul class="menu-sub">
											@foreach($menuCategoriessAll as $sub)
												@if($sub['category_parent_id'] == $cat['category_id'] && $sub['category_show_top'] == CGlobal::status_show && $sub['category_depart_id'] == $departmentId)
													<li><a @if($sub['category_link'] != '')href="{{$sub['category_link']}}" target="_blank" @else href="{{FunctionLib::buildLinkCategory($sub['category_id'], $sub['category_name'])}}" @endif title="{{$sub['category_name']}}">{{$sub['category_name']}}</a>
														<?php $t = 0; ?>
														@foreach($menuCategoriessAll as $three)
															@if($three['category_parent_id'] == $sub['category_id'] && $three['category_show_top'] == CGlobal::status_show && $three['category_depart_id'] == $departmentId)
                                                                <?php $t++; ?>
															@endif
														@endforeach
														@if($t > 0)
														<ul class="menu-three">
															@foreach($menuCategoriessAll as $three)
																@if($three['category_parent_id'] == $sub['category_id'] && $three['category_show_top'] == CGlobal::status_show && $three['category_depart_id'] == $departmentId)
																<li><a @if($three['category_link'] != '')href="{{$three['category_link']}}" target="_blank" @else href="{{FunctionLib::buildLinkCategory($three['category_id'], $three['category_name'])}}" @endif title="{{$three['category_name']}}">{{$three['category_name']}}</a></li>
																@endif
															@endforeach
														</ul>
														@endif
													</li>
												@endif
											@endforeach
										</ul>
										@endif
									</li>
								@endif
							@endif
						@endif
					@endforeach
				@endif
				<li><a href="{{URL::route('site.pageContact')}}" title="Liên hệ">Liên hệ</a></li>
			</ul>
		</div>
	</div>
</div>