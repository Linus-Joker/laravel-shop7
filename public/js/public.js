$(function () {
    // 刪除提示
    $(".delCheck").submit(function (e) {
        let r = confirm('Do you want to delete this article??');
        if (r == true) {
            alert("Article has been deleted!!");
        } else {
            e.preventDefault();
        }
    });
});
