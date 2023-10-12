<?php 

if ($pdo->maintenanceON())
{
    echo "Mode maintenance active";
}else
{
    echo "L'activation du mode maintenance a echoue";
}
