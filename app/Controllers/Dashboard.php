<?php

namespace Controller;

use Model\Datatable;

class Dashboard
{
    const TABLE_USER = "usuario";
    const TABLE_ROLE = "rol_usuario";

    /**
     * Informacion de usuario con "USER"
     * Informacion del role "ROLE"
     */
    static function ssp_users($columns, $config = [])
    {
        // select * from usuario A inner join rol_usuario B on A.id_role = B.id;
        $datatable = new Datatable;

        $table = [];
        $table[] = self::TABLE_USER . " USER";
        $table[] = "inner join " . self::TABLE_ROLE . " ROLE on USER.id_role = ROLE.id";

        return $datatable->serverSide($_REQUEST, $table, $columns, $config);
    }
}
