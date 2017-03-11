@extends('backend._layouts.admin')

@section('main')
<div class="panel list_idol">
    <br>
    <a style="margin:10px 0px 0px 10px" href="{{URL::to('admin/idols/edit')}}" class="btn btn-primary btn-labeled fa fa-plus-circle">アイドル登録</a>
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
                    <th class="no-sort">プロファイル画像</th>
                    <th>情報</th>
                    <th class="no-sort">状態</th>
                    <th>登録日</th>
                    <th class="no-sort">アクション</th>
                </tr>
            </thead>
            <tbody>
                @if(count($getData['list']) > 0)
                @foreach($getData['list'] as $k_ => $list)
                <?php
                $listMember = App\Models\Idol\Members::getListMemberOfTeamByUserID($list->id);
                ?>
                <tr class="{{$list->status == 2 ? 'table-block-idol' : ''}}">
                    <td>{{$k_+1}}</td>
                    <td>{{$list->id}}</td>
                    <td><img src="{{$list->avatar != '' ? URL::to('/').'/'.$list->avatar : URL::to('/').'/public/uploads/default/avatar.png'}}" width="100px" height="100px" class="img-circle avatar_border"></td>
                    <td>
                        <a href="{{URL::to('admin/idols/detail?id='.$list->id)}}" class="user-info">
                            @if($list->nickname != '')
                            グループ名: {{$list->nickname}}<br />
                            @elseif(count($listMember) > 0 && isset($listMember[0]['fullname']))
                            名前: {{$listMember[0]['fullname']}}<br />
                            @endif
                            活動地域: {{$list->action_location}}<br />
                            電話番号: {{$list->phone}}<br />
                            メールアドレス: {{$list->email}}<br />
                            タイプ: {{count($listMember) > 1 ? 'グループ' : 'ソロ'}}<br />
                        </a>
                    </td>
                    <td>
                        @if($list->status == 0)
                        <a href="{{route('AminPost', ['idols', 'approve'])}}?id={{$list->id}}&status=1" class="btn btn-success">承認する</a>
                        <a href="{{route('AminPost', ['idols', 'approve'])}}?id={{$list->id}}&status=2" class="btn btn-danger">拒否する</a>
                        @else
                        <?php
                        if ($list->status == 1) {
                            echo 'アクティブ';
                        } else if ($list->status == 2) {
                            echo '拒否する';
                        }
                        ?>
                        @endif
                    </td>
                    <td>
                        {{date('Y/m/d', strtotime($list->created_at))}}
                    </td>
                    <td>
                        <a href="{{route('AminPost', ['idols', 'edit'])}}?id={{$list->id}}" title="Edit"><i class="fa fa-edit fa-2x"></i></a>
                        <a href="javascript:void(0)" data="{{route('AminPost', ['idols' , 'delete'])}}?id={{$list->id}}" title="Delete" class="delete_idol"><i class="fa fa-trash fa-2x"></i></a>
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
        var table = $('#list_idol').DataTable({
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