var URL = document.location.origin;//http://canets.dev/js/img/ripple.gif
function validateCreateTX() {
    var ngaylamtrongtuan = $('.ngaylamtrongtuan:checked').size();
    var viecphailam = $('.viecphailam:checked').size();
    var lat = $('#lat').val();
    var long = $('#long').val();
    if (!ngaylamtrongtuan || !viecphailam || !lat || !long) {
        alert('vui lòng kiểm tra lại thông tin: ngày làm trong tuần, việc phải làm, latitude, longtitude');
        return false;
    }
}
$(document).ready(function(){
    $('#use_select2').select2();
    $('.hide_show_chuyenkhoan').click(function(){
        $('#ttchuyenkhoan').toggle(1000);
    });

    $('input.onoffgvthuongxuyen').click(function(){
        var customer_id = $(this).val();
        processBlock();
        $.ajax({
            type: 'POST',
            url: URL + '/secret/onoffgvthuongxuyen',
            data: {'customer_id': customer_id},
            success: function(data) {
                $.unblockUI();
                if (data['status']) {
                    $.notify(data['message'], 'success');
                }
            },
            error: function() {
                console.log('Ajax Fail');
            }
        });
    });

    $('.re-active').click(function(){
        var active = $(this).data('id');
        processBlock();
        $.ajax({
            type: 'POST',
            url: URL + '/secret/active',
            data: {'active': active},
            success: function(data) {
                $('tr#' + active).remove();
                $.unblockUI();
                if (data['status']) {
                    $.notify('Good job, Re-active success', 'success');
                }
            },
            error: function() {
                console.log('Ajax Fail');
            }
        });
    });
    /* Active */
    $('.active_user').click(function(){
        var active = $(this).data('id');
        processBlock();
        $.ajax({
            type: 'POST',
            url: URL + '/secret/active',
            data: {'active': active},
            success: function(data) {
                $('#row_' + active).removeClass('active_user').removeClass('label-warning').addClass('label-success').text('Active');
                $.unblockUI();
                if (data['status']) {
                    $.notify('Good job, Active success', 'success');
                }
            },
            error: function() {
                console.log('Ajax Fail');
            }
        });
    });

    /*Update phi giup viec 1 lan */
    $(document).on('click', '#edit_gv1lan', function() {
        $(this).remove();
        $('.luonggiupviec1lan').prop('readonly', false);
        $('td#td_gv1lan').html('<button class="btn btn-primary btn-sm" id="save_gv1lan">Save</button>');
    });

    $(document).on('click', '#save_gv1lan', function() {
        processBlock();
        var lgvmlan = [];
        $('.luonggiupviec1lan').each(function(i) {
            var item = {};
            item ["key"] = $(this).data('hours');
            item ["value"] = $(this).val();
            lgvmlan.push(item);
        });
        $.ajax({
            type : 'POST',
            url : URL + '/secret/updateluonggv1lan',
            data: {info : lgvmlan},
            success: function(data){
                console.log(data['status']);
                if (data['status']) {
                    $.notify('Good job, Update cost success', 'success');
                    $.unblockUI();
                    $('.luonggiupviec1lan').prop('readonly', true);
                    $('td#td_gv1lan').html('<button class="btn btn-warning btn-sm" id="edit_gv1lan">Edit</button>');
                }
            }
        });
    });
    /*End update*/
    /*Thuong xuyen*/
    $(document).on('click', '#edit_gvthuongxuyen', function() {
        $(this).remove();
        $('#luong1h_thuongxuyen').prop('readonly', false);
        $('td#td_gvthuongxuyen').html('<button class="btn btn-primary" id="save_gvthuongxuyen">Save</button>');
    });

    $(document).on('click', '#save_gvthuongxuyen', function() {
        processBlock();
        var luong1h_thuongxuyen = $('#luong1h_thuongxuyen').val();
       
        $.ajax({
            type : 'POST',
            url : URL + '/secret/updateluonggvthuongxuyen',
            data: {info : luong1h_thuongxuyen},
            success: function(data){
                console.log(data['status']);
                if (data['status']) {
                    $.notify('Good job, Update salary monthly success', 'success');
                    $.unblockUI();
                    $('#luong1h_thuongxuyen').prop('readonly', true);
                    $('td#td_gvthuongxuyen').html('<button class="btn btn-warning" id="edit_gvthuongxuyen">Edit</button>');
                } else {
                    $.notify('Error on server', 'error');
                }
            },
            error: function() {
                $.unblockUI();
                $.notify('Ajax error', 'error');
            }
        });
    });

    /*End */
    /*Start*/
    
    $(document).on('click', '#edit_ttchuyenkhoan', function() {
        $(this).remove();
        $('.ttck').prop('readonly', false);
        $('td#td_thongtinchuyenkhoan').html('<button class="btn btn-primary" id="save_ttchuyenkhoan">Save</button>');
    });

    $(document).on('click', '#save_ttchuyenkhoan', function() {
        processBlock();
        var thongtinchuyenkhoan = [];
        $('.cactaikhoan').each(function(i) {
            var item = {};
            item ["nganhang"] = $(this).find('input.nganhang').val();
            item ["chutaikhoan"] = $(this).find('input.chutaikhoan').val();
            item ["sotaikhoan"] = $(this).find('input.sotaikhoan').val();
            item ["noidungchuyen"] = $(this).find('input.noidungchuyen').val();
            thongtinchuyenkhoan.push(item);
        });
        $.ajax({
            type : 'POST',
            url : URL + '/secret/updatethongtinchuyenkhoan',
            data: {info : thongtinchuyenkhoan},
            success: function(data){
                console.log(data['status']);
                if (data['status']) {
                    $.notify('Good job, Update salary monthly success', 'success');
                    $.unblockUI();
                    $('.luonggiupviecthuongxuyen').prop('readonly', true);
                    $('td#td_thongtinchuyenkhoan').html('<button class="btn btn-warning" id="edit_ttchuyenkhoan">Edit</button>');
                } else {
                    $.notify('Error on server', 'error');
                }
            },
            error: function() {
                $.unblockUI();
                $.notify('Ajax error', 'error');
            }
        });
    });
    /*End*/
});
function processBlock(){
    $.blockUI({ message: '<h3><img width="50px" height="50px" src=' + URL + "/public/js/img/ripple.gif" + '>  Waiting...</h3>' }); 
}