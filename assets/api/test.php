


<?php


$url="https://s-esms.maxis.net.my:8443/servlet/smsdirect.jsp?ID=Concept0205&Password=*#2020BananaML&Mobile=60199034016&Type=A&Message=Please+submit+your+field+report+now";



			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		 //    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		   //  curl_setopt($ch, CURLOPT_VERBOSE, true);
		   //  curl_setopt($ch, CURLOPT_HEADER, 0);
  			// curl_setopt($ch, CURLOPT_POST, 1);

  			// curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "Intermediate.crt");


    		// curl_setopt($ch, CURLOPT_SSLCERT,'ServerCertificate.crt');
    		// curl_setopt($ch, CURLOPT_CAINFO, './ServerCertificate.crt');
    		// curl_setopt($ch, CURLOPT_CAPATH, './ServerCertificate.crt');


			$output = curl_exec($ch);
			
			if($output==false){
				echo curl_error($ch);
			}else{
				echo json_encode($output);

			}

			curl_close($ch);
?>