function changeContractPublish(id, val) {
    $.get("/admin/index.php?section=contract&f=changePublish", {id: id, val : val, ajax : 1}, function(data) {
        $("#pub" + id).html(data);
    });
}

function contractRemoveFile(id, num) {
	if(window.confirm("Вы точно хотите удалить этот файл?")) {
		//document.location.href = "/admin/index.php?section=contract&f=removeFile&id=" + id + "&num="+ num;
        
        $.get("/admin/index.php?section=contract&f=removeFile", {id: id, num : num, ajax : 1}, function(data) {     
            //console.log(data);
            window.location.reload(true);
            //$(".contract-files-result-div").html(data.);
        });
	}
    
}