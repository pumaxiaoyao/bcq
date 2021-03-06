﻿@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>游戏商名称(title)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->title}}" placeholder="" id="title" name="title">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">(全部分类中)排序值(sort)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->sort}}" placeholder="" id="sort" name="sort">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>接入费(money)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="money-1" value="1" name="money" @if($obj->money == 1) checked @endif>
					<label for="money-1">有</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="money-2" value="0" name="money" @if($obj->money == 0) checked @endif>
					<label for="money-2">无</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>接入点位 (%)(access_point)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->access_point}}" placeholder="" id="access_point" name="access_point">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属类型(weight)：</label>
			<input type="hidden" name='weight' id="weight">
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				@foreach($category as $key => $val)
					<div class="check-box">
						<input type="checkbox" id="w-{{$val->id}}" value="{{$val->weight}}" name="w" @if($obj->weight & $val->weight) checked @endif>
						<label for="w-{{$val->weight}}">{{$val->gname}}</label>
					</div>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>官方地址(url)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->url}}" placeholder="" id="url" name="url">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>游戏商LOGO(logo)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<div class="uploader-list-container">
					<img class="pointer uplodeimg" onclick="$(this).siblings(':file').click();" src="@if($obj->logo) {{$obj->logo}} @else /admin/image/cover.png @endif" title="点击上传图片" />
					<input type="file" class="hide" accept="image/*" />
					<input type="hidden" name="logo" id="logo" value="{{$obj->logo}}" />
					<div class="@if(!($obj->logo)) hide @endif editImg" onclick="$(this).siblings(':file').click();">编辑</div>
					<div class="uplodeMask hide">图片上传中，请稍后...</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>游戏商简介(brief)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea id="brief" name="brief" type="text/plain">{{$obj->brief}}</textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态(status)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="status-1" value="1" name="status" @if($obj->status == 1) checked @endif>
					<label for="status-1">启用</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="status-2" value="0" name="status" @if($obj->status == 0) checked @endif>
					<label for="status-2">禁用</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="status-3" value="-1" name="status" @if($obj->status == -1) checked @endif>
					<label for="status-3">删除</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="Huialert Huialert-danger hide" id="form_msg"></div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-8 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" id="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>

@include('Admin.common._footer')

<!--请在下方写此页面业务相关的脚本-->
<style>
	#brief{height: 120px;resize: none;width: 100%;}
</style>

<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/admin/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $(".textarea").Huitextarealength({
            minlength:10,
            maxlength:100
        });

        //表单验证
        var ajaxStatus=1;
        $("#form-admin").validate({
            rules:{
                title:{
                    required:true,
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
				if(ajaxStatus==0){return false;}ajaxStatus=0;
                var total = '';
                $('input[name=w]').each(function() {
                    if ($(this).parent().hasClass('checked')) {
                        total = Number($(this).val())+Number(total);
                    }
                });
                $("#weight").val(total);

                $(form).ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: '/{{config('base.admin')}}/gamestore/gamestore_edit/{{$obj->id}}', // 需要提交的 url
                    success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                        // 此处可对 data 作相关处理
                        $("#form_msg").hide().html('');
                        ajaxStatus=1;
                        var index = parent.layer.getFrameIndex(window.name);
                        window.parent.location.reload();
                        parent.layer.close(index);
                    },
                    error: function(data) {
                        var json=JSON.parse(data.responseText);
                        var str = '';
                        $.each(json.errors,function(key,val){
                            str += val + '\r\n';  //到这里终于拿到返回name字段的错误信息了
                        });
                        $("#form_msg").show().html(str);
                        ajaxStatus=1;
                    }
                });
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>