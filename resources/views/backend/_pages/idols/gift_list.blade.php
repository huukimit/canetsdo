@extends('backend._layouts.admin')

@section('main')
<div class="panel list_idol">
    <br>
    <a style="margin:10px 0px 0px 10px" href="{{URL::to('admin/idols/editgift?id_idol='.$getData['id_idol'])}}" class="btn btn-primary btn-labeled fa fa-plus-circle">バッジを追加</a>
    <div class="panel-body">
        <div class="text-waining-list">一度変更した画像や達成pt数は、やむを得ない場合を除き、変更しない様お願いいたします。</div>
        <table id="list_gift" class="table table-striped mydatatables" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">No</th>
                    <th class="no-sort">バッジ画像</th>
                    <th>達成pt</th>
                    <th class="no-sort">アクション</th>
                </tr>
            </thead>
            <tbody>
                @if(count($getData['gifts']) > 0)
                @foreach($getData['gifts'] as $k_ => $list)
                <?php
                $image = $list->image != '' ? URL::to('/') . '/' . $list->image : '';
                $image = $list->image_overwirte != '' ? URL::to('/') . '/' . $list->image_overwirte : $image;
                ?>
                <tr>
                    <td>{{$k_+1}}</td>
                    <td><img src="{{$image != '' ? $image : URL::to('/').'/public/uploads/default/avatar.png'}}" width="100px" height="100px"></td>
                    <td>
                        {{$list->zeni}}
                    </td>
                    <td>
                        <a href="{{URL::to('admin/idols/editgift?id_idol='.$getData['id_idol'].'&id='.$list->id)}}" title="Edit"><i class="fa fa-edit fa-2x"></i></a>
                        @if($k_ < 34)
                        @if($list->is_default == 1 && $list->image_overwirte != '')
                        <a href="javascript:void(0)" data="{{URL::to('admin/idols/deletegift?id_idol='.$getData['id_idol'].'&id='.$list->id)}}" title="Delete" class="delete_gift"><i class="fa fa-trash fa-2x"></i></a>
                        @else
                        <a href="javascript:void(0)" title="Delete" class="delete_gift_disable"><i class="fa fa-trash fa-2x"></i></a>
                        @endif
                        @else
                        <a href="javascript:void(0)" data="{{URL::to('admin/idols/deletegift?id_idol='.$getData['id_idol'].'&id='.$list->id)}}" title="Delete" class="delete_gift"><i class="fa fa-trash fa-2x"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /**
         * data tables trang idols list
         */
        var table = $('#list_gift').DataTable({
            bInfo: false,
            "order": [],
            columnDefs: [
                {targets: 'no-sort', orderable: false}
            ],
            "language": {
                "url": BASE_URL + "/public/templates/backend/js/japanese.json"
            }
        });
    });
</script>
@stop