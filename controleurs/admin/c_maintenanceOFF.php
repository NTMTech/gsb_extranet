<?php 

if ($pdo->maintenanceOFF())
{
    echo "Mode maintenance active";
}else
{
    echo "L'activation du mode maintenance a echoue";
}
