toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "3000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

$("#loggeduser").on("click", function () {
    toastr["success"]("안녕하세요!", "로그인됨");
});

$("#exp").on("click", function () {
    toastr["success"]("방명록에 댓글을 남기시면 개당 500EXP ~ 800EXP의 경험치를 드려요!", "EXP");
});

$("#logout").on("click", function () {
    Swal.fire({
        title: "정말로 로그아웃 하실건가요?",
        text: "원하신다면 언제든지 다시 로그인하세요!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '로그아웃 진행',
        cancelButtonText: '취소'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'See you soon!',
                '로그아웃 되었습니다.',
                'success'
            ).then(() => location.href = "/id/logout/logoutProcess.php");
        }
    });
});