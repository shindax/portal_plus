function applyPhoto(id, val) {
    $.get("/admin/index.php?section=contest&f=applyPhoto", {id: id, val : val, ajax : 1}, function(data) {
        $("#_image" + id).html(data);
    });
}

