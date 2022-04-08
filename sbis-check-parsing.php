<?
    $connection = Bitrix\Main\Application::getConnection();
    $sqlHelper = $connection->getSqlHelper();

    $sql = "SELECT `DATE_CREATE`, `LINK_PARAMS`, `CNT_FAIL_PRINT` FROM `b_sale_cashbox_check` WHERE `ORDER_ID` = '" . $order['ORDER']['ACCOUNT_NUMBER'] . "'";
    
    $recordset = $connection->query($sql);
    while ($record = $recordset->fetch())
    {
        if ($record[CNT_FAIL_PRINT] != 1) {

            $arrCheck = explode( ';', $record[LINK_PARAMS] );
        
            $regNumberKkt = explode( '"', $arrCheck[1] );
    
            $dateArr = explode( '.', $record[DATE_CREATE] );
        
            $yearArr = explode( ' ', $dateArr[2] );
            $yearShort = substr($yearArr[0], -2);
        
            $fiscalDocAttribute = explode( ':', $arrCheck[3] );

            $link = "https://ofd.sbis.ru/rec/" . $regNumberKkt[1] . "/" . $dateArr[0] . $dateArr[1] . $yearShort . "/" . $fiscalDocAttribute[1];
                    
            echo "<a href=\"" . $link . "\" target=\"_blank\">Чек</a><br>";
        }	
    }
?>