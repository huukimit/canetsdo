<?php
$list_param = \Route::current()->parameters();
$cms = isset($list_param['cmd']) ? $list_param['cmd'] : '';
?>
{!! $extraFooterJS !!}
@if($cms == 'editprofile')
<script type="text/javascript">
    $(document).ready(function () {
        bannerUpload();
        avatarUpload();
        $("#edit_idoladmin").validate().settings.ignore = ".cr-slider";
    });
</script>
@endif
@if($cms == 'addmember')
<script type="text/javascript">
    $(document).ready(function () {
        memberUpload();
        $("#add_member_idol").validate().settings.ignore = ".cr-slider";
    });
</script>
@endif
@if($cms == 'editmember')
<script type="text/javascript">
    $(document).ready(function () {
        var number_member = $("#number_member").val();
        for (var i = 0; i < number_member; i++) {
            editMemberUpload(i);
        }
        $("#edit_member_idol").validate().settings.ignore = ".cr-slider";
    });
</script>
@endif
@if($cms == 'edititemwaiting')
<script type="text/javascript">
    $(document).ready(function () {
        itemwaitingUpload();
        $("#edit_item_waiting").validate().settings.ignore = ".cr-slider";
    });
</script>
@endif
@if($cms == 'editgift')
<script type="text/javascript">
    $(document).ready(function () {
        giftUpload();
        $("#edit_item_waiting").validate().settings.ignore = ".cr-slider";
    });
</script>
@endif
{!! $extraFooter !!}