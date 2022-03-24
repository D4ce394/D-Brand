$(document).ready(function(){
    //Check Admin Password is correct or nah
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        // alert(current_password);
        $.ajax({
            type:'post',
            url:'admin/check-current-password',
            data:{current_password:current_password},
            success:function(resp){
                alert(resp);
            }, error:function(){
                alert('Error');
            }
        })
    })
});