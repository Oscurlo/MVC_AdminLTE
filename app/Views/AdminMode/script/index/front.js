$(document).ready(async () => {
    const Config = CONFIG()
    const URL_BACKEND = `${Config.BASE_SERVER}/app/Views/AdminMode/script/index/back.php`

    const $table = $("#table-users")

    $table.DataTable($.extend(DATATABLE_ALL, {
        serverSide: true,
        ajax: `${URL_BACKEND}`
    }))
})