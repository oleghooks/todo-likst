$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if($('#is_logged').val() === '1')
        setInterval(function() {
            $('main').height($('#app').height() - 105);
            List.Load();

        }, 3000);
});
