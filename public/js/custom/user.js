$(document).ready(function() {

    console.log('hwellow x ');
    $('#click').click(function(){

        var id = $(this).attr('value');
        console.log(id);
        var _token =$('meta[name="_token"]').attr('content')
        console.log(_token);

        //bootbox.confirm("Are sure want to delete?", function(result) {
        //    if(result)
        //    {
        //        console.log('YES');
        //      /*  $.ajax({
        //     url:'/myapp/public/admin/users/'+id,
        //     type: 'post',
        //     data: {_method: 'delete', _token :_token},
        //     success: function (data) {
        //     console.log(data);
        //     location.reload();
        //     }
        //     });*/
        //    }
        //
        //});
        var message = "Are sure want to delete?";
        bootbox.confirm(message, function(confirmed) {
            if(confirmed){
console.log('confirmed');
                //callback();
            }
        });
    });
});
