<div class="box-check">
	<h1 class="title-box-check"><a href="{{URL::route('tracuu.traCuuVanBangChungChi')}}" title="Tra cứu văn bằng chứng chỉ">Tra cứu văn bằng chứng chỉ</a></h2>
	<div class="content-box-check">
		<div class="input-ext" id="boxTraCuuVanBangChungChi">
			{{Form::open(array('method' => 'POST', 'id'=>'formTraCuu', 'class'=>'formTraCuu', 'name'=>'formTraCuu'))}}
			<div class="col-lg-4 col-md-4 col-sm-12 ext-items">
				<div class="form-group">
					<label class="control-label">Số hiệu văn bằng, chứng chỉ</label>
					<input id="ipVanBang" name="ipVanBang" class="form-control" type="text" placeholder="- Số hiệu văn bằng, chứng chỉ -">
				</div>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-12 ext-items">
				<div class="form-group">
					<label class="control-label">&nbsp;</label>
					<span id="submitTraCuuVanBangChungChi" class="btn btn-primary btn-ext">Tra cứu</span>
				</div>
				<span class="loading"></span>
			</div>
			{{Form::close()}}
		</div>
		<div class="line-equal">
			<div class="title-equal"><span>Thông tin văn bằng chứng chỉ</span></div>
			<div class="box-list-equal">
				<div class="inputInfo">Nhập số hiệu văn bằng hoặc chứng chỉ.</div>
			</div>
		</div>
	</div>
</div>