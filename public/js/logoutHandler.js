function logoutHandler(json) {

    $.logger.info(json);
    utils.initWorkarea();
    $.createWindow({body: json.message});

}
