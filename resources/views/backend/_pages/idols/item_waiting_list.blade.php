@extends('backend._layouts.admin')
@section('main')
<div class="row panel item-waiting-list">
    <div class="text-waining-list">一度変更した画像や達成pt数は、やむを得ない場合を除き、変更しない様お願いいたします。</div>
    @if(count($getData['itemwaitings']) > 0)
    @foreach ($getData['itemwaitings'] AS $k => $item)
    <div class="itemwaiting-item">
        <div class="header-item">
            <span class="item-id">{{($k + 1)}}</span>
            <div class="btn-edit-item"><a href="{{URL::to('admin/idols/edititemwaiting?id='.$item->id.'&id_idol='.$getData['id_idol'])}}" title="Edit"><i class="fa fa-edit fa-2x"></i></a></div>
        </div>
        <div class="image-item">
            <img src="{{URL::to('/').'/'.$item->image}}" />
        </div>
        <div class="zeni-item">達成pt: <span>{{$item->zeni}}</span></div>
    </div>
    @endforeach
    @endif
    <div class="itemwaiting-item add-item-waiting">
        <div class="image-item">
            <a href="{{URL::to('admin/idols/edititemwaiting?id_idol='.$getData['id_idol'])}}">
                <img src="{{URL::to('/')}}/public/templates/backend/img/icon_add_item_waiting.jpg" />
            </a>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
</div>
@stop