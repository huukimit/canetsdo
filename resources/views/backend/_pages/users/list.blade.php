@extends('backend._layouts.admin')

@section('main')
<div class="panel list_idol">
    <div class="panel-body">
        @if(count($getData['list']) > 0)
        <input type="hidden" id="min" name="min">
        <input type="hidden" id="max" name="max" value="{{count($getData['list'])}}">
        <div id="range-show-item">
            <div id="range-step-item"></div>
            <label class="label-item"><span id="current_item">1</span>/{{count($getData['list'])}}</label>
        </div>
        @endif
        <table id="{{$getData['table_id']}}" class="table table-striped mydatatables" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">No</th>
                    <th class="no-sort">ID</th>
                    <th class="no-sort">ユーザーイメージ</th>
                    <th>情報</th>
                    <th>購入ポイント</th>
                    <th class="no-sort">状態</th>
                    <th>登録日</th>
                    <th class="no-sort">アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach($getData['list'] as $k_ => $list)
                <tr class="{{$list->status == 0 ? 'table-danger' : ''}}">
                    <td>{{$k_+1}}</td>
                    <td>{{$list->id}}</td>
                    <td><img src="{{$list->avatar != '' ? URL::to('/').'/'.$list->avatar : URL::to('/').'/public/uploads/default/avatar.png'}}" width="100px" height="100px" class="img-circle avatar_border"></td>
                    <td>
                        <a href="{{URL::to('admin/users/detail?id='.$list->id)}}" class="user-info">
                            ユーザID: {{$list->username}}<br />
                            ニックネーム: {{$list->nickname}}<br />
                            メールアドレス: {{$list->email}}<br />
                            所持pt: {{$list->point}}<br /> <!--So zeni hien tai-->
                            消費pt: {{$list->use_zeni}}<br /> <!--So zeni da dung -->
                        </a>
                    </td>
                    <td>{{$list->all_zeni}}</td>
                    <td>{{$list->status == 1 ? 'アクティブ' : 'ブロック'}}</td>
                    <td>{{date('Y/m/d', strtotime($list->created_at))}}</td>
                    <td>
                        <a style="float: left;margin-top: 2px;" href="{{route('AminPost', ['users', 'edit'])}}?id={{$list->id}}" title="Edit"><i class="fa fa-edit fa-2x"></i></a>
                        <a style="float: left;" href="javascript:void(0)" data="{{route('AminPost', ['users' , 'delete'])}}?id={{$list->id}}" title="Delete" class="delete_user"><i class="fa fa-trash fa-2x"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        /**
         * data tables trang users list
         */
        var table = $('#list_user').DataTable({
            bInfo: false,
            "order": [],
            columnDefs: [
                {targets: 'no-sort', orderable: false}
            ],
            "language": {
                "url": BASE_URL + "/public/templates/backend/js/japanese.json"
            }
        });
        var max = parseInt($("#max").val());
        $("#range-step-item").noUiSlider({
            start: [0],
            connect: 'lower',
            step: 1,
            range: {
                'min': [0],
                'max': [max]
            },
            format: wNumb({
                decimals: 0
            })
        }).on('change', function (event, values) {
            $("#min").val(values);
            $("#current_item").text(values);
            table.draw();
        });
    });
</script>
@stop