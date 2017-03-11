@extends('backend._layouts.admin')
@section('main')
<div class="panel list_idol">
    <br>
    <a style="margin:10px 0px 0px 10px" href="{{URL::to('admin/newidol')}}" class="btn btn-primary btn-labeled fa fa-plus-circle">新規アイドル登録</a>
    <div class="panel-body">
        <table id="{{$getData['table_id']}}" class="table table-striped mydatatables" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th class="no-sort">No.</th>
                    <th class="no-sort">名前</th>
                    <th class="no-sort">メール</th>
                    <th class="no-sort">アクティブ</th>
                    <th class="no-sort">行動</th>
                </tr>
            </thead>
            <tbody>
                @if(count($getData['list']) > 0)
                @foreach($getData['list'] as $k_ => $list)
                <tr>
                    <td><a href="{{URL::to('admin/idols/dashboard?id_idol='.$list->id)}}" class="user-info">{{$k_+1}}</a></td>
                    <td><a href="{{URL::to('admin/idols/dashboard?id_idol='.$list->id)}}" class="user-info">{{$list->nickname}}</a></td>
                    <td>
                        <a href="{{URL::to('admin/idols/dashboard?id_idol='.$list->id)}}" class="user-info">
                            {{$list->email}}
                        </a>
                    </td>
                    <td>
                        {{$list->status == 1 ? 'アクティブ' : 'ブロック'}}
                    </td>
                    <td>
                        <a href="{{URL::to('admin/newidol?id='.$list->id)}}" title="Edit"><i class="fa fa-edit fa-2x"></i></a>
                        <a href="javascript:void(0)" data="{{URL::to('admin/idols/deleteidol?id='.$list->id)}}" title="Delete" class="delete_idol"><i class="fa fa-trash fa-2x"></i></a>
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
    });
</script>
@stop