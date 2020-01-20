/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var permission = {
    getPermissibleItem: function ()
    {
        var user_id = $("#adminList").val();
        if ($.trim(user_id) != "")
        {
            $(".global-loader").show();
            $.ajax({
                type: "GET",
                url: baseUrl + 'permission/permissible-item',
                data: {
                    'id': user_id,
                },
                success: function (response)
                {
                    $(".global-loader").hide();
                    $('#permissibleListItem').html(response);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    $(".global-loader").hide();
                    alert(jqXHR.responseText);
                }
            })
        }
    },
    checkUncheckCheckbox: function (id)
    {
        if ($("#chk" + id).is(':checked'))
        {
            //alert("checked");
            $('#module' + id + ' .checkbox input:checkbox').prop('checked', true).iCheck('update');
        }
        else {
            //alert("unchecked");
            $('#module' + id + ' .checkbox input:checkbox').prop('checked', false).iCheck('update');
        }
    },
    checkUncheckItemCheckbox: function (moduleId, id)
    {
        //console.log(moduleId);
        //console.log(id);
        if ($("#itemChk" + id).is(':checked'))
        {
            var allcheckboxLen = $('#module' + moduleId + ' .checkbox input:checkbox').length;
            var checkedLen = $('#module' + moduleId + ' .checkbox [name="item_list[]"]:checked').length;

            if (allcheckboxLen == checkedLen)
            {
                $("#chk" + moduleId).prop('checked', true).iCheck('update');
            }
        }
        else {
            $("#chk" + moduleId).prop('checked', false).iCheck('update');
        }
    },
    addRoleToUser: function ()
    {
        var form = $("form#w0");
        $(".global-loader").show();
        $.ajax({
            url: form.attr('action'),
            type: 'post',
            data: form.serialize(),
            //async: false,
            success: function (response) {
                $(".global-loader").hide();
                //var response = $.parseJSON(data);
                if (response.success == 1) {
                    $('#response').html('<div class=\"alert alert-success\">' + response.msg + '</div>');
                }
                else {
                    $('#response').html('<div class=\"alert alert-danger\">' + response.msg + '</div>');
                }
                $('#resultModal').modal("show");
                setTimeout(function () {
                    $('#response').html("");
                    $('#resultModal').modal("hide");
                }, 3000)
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                $(".global-loader").hide();
                alert(jqXHR.responseText);
            }
        })

        return false;
    },
    showHideTreeNode: function (elm,mid)
    {
        $("#module"+mid).toggleClass('mcollapse mexpand');
        $(elm).nextAll('ul:first').toggle();
        $(elm).parent().nextAll('ul:first').toggle();
        $(elm).children('i').toggleClass('fa-plus-square-o fa-minus-square-o');
    },
}

