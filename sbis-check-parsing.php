<?
	// db connection
	$connection = Bitrix\Main\Application::getConnection();
	$sqlHelper = $connection->getSqlHelper();

	// select record by order id
	$sql = "SELECT `DATE_CREATE`, `LINK_PARAMS`, `CNT_FAIL_PRINT` FROM `b_sale_cashbox_check` WHERE `ORDER_ID` = '" . $order['ORDER']['ACCOUNT_NUMBER'] . "'";
	
	// execute query
	$recordset = $connection->query($sql);
	while ($record = $recordset->fetch())
	{
		// if there is no check printing error
		if ($record[CNT_FAIL_PRINT] != 1) {

			// parse check array
			$arrCheck = explode( ';', $record[LINK_PARAMS] );
		
			// getting "reg_number_kkt"
			$regNumberKkt = explode( '"', $arrCheck[1] );
	
			// parse date array
			$dateArr = explode( '.', $record[DATE_CREATE] );
		
			// getting year
			$yearArr = explode( ' ', $dateArr[2] );
			$yearShort = substr($yearArr[0], -2);
		
			// getting "fiscal_doc_number"
			$fiscalDocAttribute = explode( ':', $arrCheck[3] );

			// build a link
			$link = "https://ofd.sbis.ru/rec/" . $regNumberKkt[1] . "/" . $dateArr[0] . $dateArr[1] . $yearShort . "/" . $fiscalDocAttribute[1];
					
			// output a check link
			echo "<a href=\"" . $link . "\" target=\"_blank\">Чек</a><br>";
		}	
	}
?>