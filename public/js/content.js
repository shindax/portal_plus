function changeShowOnMain(id, val) {
    $.get("/admin/index.php?section=articles&f=changeShowOnMain", {id: id, val : val, ajax : 1}, function(data) {
        $("#som" + id).html(data);
    });
}

function changePublish(id, val) {
    $.get("/admin/index.php?section=articles&f=changePublish", {id: id, val : val, ajax : 1}, function(data) {
        $("#pub" + id).html(data);
    });
}

function changeInfocenterPublish(id, val) {
    $.get("/admin/index.php?section=infocenter&f=changePublish", {id: id, val : val, ajax : 1}, function(data) {
        $("#pub" + id).html(data);
    });
}

function infocenterRemoveFile(id, num) {
	if(window.confirm("Вы точно хотите удалить этот файл?")) {
		document.location.href = "/admin/index.php?section=infocenter&f=removeFile&id=" + id + "&num="+ num;
	}
}