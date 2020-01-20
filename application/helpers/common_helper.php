<?php

function show($result)
{
    echo '<pre>';
    print_r($result);
    echo '</pre>';
}

function setHash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

function matchHash($hashedPassword, $plainPassword)
{
    if (password_verify($plainPassword, $hashedPassword)) {
        return true;
    } else {
        return false;
    }
}

function countUserModuleRole($userId, $moduleId, $type)
{
    $CI =& get_instance();
    $CI->db->from('tbl_auth_assignment');
    $CI->db->join('tbl_auth_item', 'tbl_auth_assignment.auth_item_id = tbl_auth_item.auth_item_id', 'left');
    $CI->db->where('admin_id', $userId)->where('type', $type)->where('auth_module_id', $moduleId)->where('is_active', 1);
    $query = $CI->db->get()->num_rows();
    return $query;
}

function checkUserHasRole($userId, $itemId, $type)
{
    $CI =& get_instance();
    $CI->db->from('tbl_auth_assignment');
    $CI->db->join('tbl_auth_item', 'tbl_auth_assignment.auth_item_id = tbl_auth_item.auth_item_id', 'left');
    $CI->db->where('tbl_auth_assignment.auth_item_id', $itemId)->where('admin_id', $userId)->where('type', $type);
    $model = $CI->db->get()->row();
    if (empty($model)) {
        return 0;
    } else {
        return 1;
    }
}

function getUserPermission($userId, $type)
{
    $CI =& get_instance();
    $CI->db->from('tbl_auth_module');
    $modules = $CI->db->where('is_active', 1)->order_by('auth_module_id', 'asc')->get()->result_array();
    $result = array();
    foreach ($modules as $row) {
        $roles = getModuleAssignItem($row['auth_module_id'], $userId, $type);
        if (!empty($roles)) {
            $row['items'] = $roles;
            array_push($result, $row);
        }
    }

    return $result;
}

function getModuleAssignItem($mid, $userId, $type)
{
    $CI =& get_instance();
    $CI->db->select('tbl_auth_assignment.* , tbl_auth_item.auth_item_url, tbl_auth_item.auth_item_name, tbl_auth_item.auth_module_id, tbl_auth_item.rule_name, 
     tbl_auth_item.is_active,  tbl_auth_module.auth_module_name, tbl_auth_module.auth_module_url
     ');
    $CI->db->from('tbl_auth_assignment');
    $CI->db->join('tbl_auth_item', 'tbl_auth_assignment.auth_item_id = tbl_auth_item.auth_item_id', 'left');
    $CI->db->join('tbl_auth_module', 'tbl_auth_item.auth_module_id = tbl_auth_module.auth_module_id', 'left');
    $model = $CI->db->where('tbl_auth_item.is_active', 1)
        ->where('tbl_auth_item.auth_module_id', $mid)
        ->where('tbl_auth_assignment.admin_id', $userId)
        ->where('type', $type)
        ->order_by('tbl_auth_item.auth_module_id', 'asc')->get()->result_array();
    return $model;
}

function getPermissibleArray()
{
    $CI =& get_instance();
    $json = $CI->session->userdata('userPermissibleItem');
    //$perm = json_encode($json);
    $perm = $json;
    $result = array();
    if (!empty($perm)) {
        foreach ($perm as $row) {
            foreach ($row['items'] as $itm) {
                $url = $row['auth_module_url'] . $itm['auth_item_url'];
                array_push($result, $url);
            }
        }
    }
    return $result;
}

function checkAccess($itemUrl)
{
    $allPermissiableItemUrls = getPermissibleArray();
    array_push($allPermissiableItemUrls, '/dashboard/index');
    if (in_array($itemUrl, $allPermissiableItemUrls)) {
        return true;
    } else {
        return false;
    }
}

function isAccess($itemUrl)
{
   $isAccess =  checkAccess($itemUrl);
   if(!$isAccess){
       echo 'd-none';
   }else{
       echo '';
   }
}

function isAllowAccess($only=array())
{
    $CI =& get_instance();
    $className = $CI->router->fetch_class();
    $methodName = $CI->router->fetch_method();
    $makeUrl = '/'.$className.'/'.$methodName;

    if(!empty($only) && in_array($methodName, $only) &&  !checkAccess($makeUrl)){
        redirect('site/error');
    }

    if(empty($only) && !checkAccess($makeUrl)){
        redirect('site/error');
    }
}


?>