		 <?php
		/*
		// $data['senderAreaCode'] = '55';
		  // $data['senderPhone'] = 'xxxxxxxx'
		  // $data['shippingAddressStreet'] = "";
		  // $data['shippingAddressNumber'] = "";
		  // $data['shippingAddressPostalCode'] = "";
		  // $data['shippingAddressCity'] = "";
		  // $data['shippingAddressState'] = "";
		  // $data['shippingAddressCountry'] = 'BRA';

		*/

		 $price = "120.00";

		  if($type==3){
			  $endDate = date('Y-m-d', strtotime('+3 months'));
		  }elseif ($type==6) {
		  	  $endDate = date('Y-m-d', strtotime('+6 months'));
		  }
		  
		  $endDate = $endDate."T19:20:30.45+01:00";
		  $total = ($price*$type);
		  $url = 'https://ws.pagseguro.uol.com.br/v2/pre-approvals/request';

		  $data['email'] = "email da sua conta";
		  $data['token'] =  "token do pagseguro";
		  $data['currency'] = 'BRL';

		  $data['reference'] = "referência do cliente...código ex: 01, 02";
		  $data['senderName'] = "nome do cliente";
		  $data['senderEmail'] = "email do cliente";
		  $data['senderPhone'] = "telefone do cliente";
		  $data['shippingAddressCity'] = "";
		  $data['shippingAddressState'] = "";

	

		  $data['redirectURL'] = 'http://sualoja.com.br/success.php';

		  $data['preApprovalCharge'] = 'auto';
		  $data['preApprovalName'] = 'Assinatura mensal';
		  $data['preApprovalDetails'] = 'Cobrança de valor mensal para assinatura';
		  $data['preApprovalAmountPerPayment'] = $price;
		  $data['preApprovalPeriod'] = 'MONTHLY';
		 
		  $data['preApprovalFinalDate'] = $endDate;
		  $data['preApprovalMaxTotalAmount'] = $total;

		  $data['reviewURL'] = 'http://sualoja.com.br/planos.php';

		  $data = http_build_query($data);

		  $curl = curl_init($url);

		  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_POST, true);
		  curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		  $xml= curl_exec($curl);

		  if($xml == 'Unauthorized'){
		    echo "Unauthorized";
		    exit();
		  }

		  curl_close($curl);

		  $xml= simplexml_load_string($xml);

		  if(count($xml->error) > 0){
		    echo "XML ERRO";
		    exit();
		  }

  		header('Location: https://pagseguro.uol.com.br/v2/pre-approvals/request.html?code='.$xml->code);
		
		
		?>