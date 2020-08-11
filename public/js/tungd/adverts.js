function changePublish(id, val) {
    $.get("/admin/index.php?section=adverts&f=changePublish", {id: id, val : val, ajax : 1}, function(data) {
        $("#pub" + id).html(data);
    });
}