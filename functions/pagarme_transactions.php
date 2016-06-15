<?php
	require "functions.php";

	Pagarme::setApiKey("ak_test_VKyGQbMHvbAYjpi3Ud94tISm2MpYGY");

	function emulation_transaction($card_hash, $recipients, $transaction_info){

		$recipient1 = new_recipient($recipients[0]);

		$recipient2 = new_recipient($recipients[1]);

		$new_recipient1 = $recipient1->create();
		$new_recipient2 = $recipient2->create();

		$transaction = new PagarMe_Transaction(array(
		    'amount' => $transaction_info['amount'],
		    'installments' => $transaction_info['installments'],
		    'soft_descriptor' => $transaction_info['soft_descriptor'],
		    'card_hash' => "{$card_hash}",

		    'split_rules' => array(
		        array(
		            'recipient_id' => $new_recipient1['id'],
		            'charge_processing_fee' => true,
		            'liable' => true,
		            'percentage' => '60',

		        ),

		        array(
		            'recipient_id' => $new_recipient2['id'],
		            'charge_processing_fee' => true,
		            'liable' => false,
		            'percentage' => '40',
		        )
		    )
		));

		show_transaction($transaction);

	}

	function new_recipient($recipient){
		$new_recipient = new PagarMe_Recipient($recipient);
		return $new_recipient;
	}

	function show_transaction($transaction){
		global $tag;

		$tag->div('class="col-md-8"');
        	show_recipient_transaction($transaction);
      	$tag->div;
  	
		$transaction->charge();
		$status = $transaction->status; // status da transação
		$tag->div('class="container"');
        	$tag->div('class="col-md-12"');
				$tag->b();
					$tag->printer("Status da transação: {$status}");
				$tag->b;

				$tag->div('class="col-md-12"');
					show_card_info($transaction);
	            $tag->div;

	            $tag->div('class="col-md-12"');
					show_transaction_details($transaction);
				$tag->div;
			$tag->div;
		$tag->div;
	}

	function check_recipient($recipients){
		$valids_recipients;
		foreach ($recipients as $key => $value) {
			for ($i=0; $i <= 3; $i++) { 
				if ($key == 'recipient_' . $i) {
					$valids_recipients[] = $value;
				}
			}
		}
		return $valids_recipients;
	}

	function show_recipient_transaction($transaction){
		$recipient0 = PagarMe_Recipient::findById($transaction->split_rules[0]->recipient_id);
		$received_value0 = (($transaction->amount/100) * $transaction->split_rules[0]->percentage / 100);
		$divided_value0 = number_format(($received_value0/$transaction->installments), 2, ',', '.');

		$recipient1 = PagarMe_Recipient::findById($transaction->split_rules[1]->recipient_id);
		$received_value1 = (($transaction->amount/100) * $transaction->split_rules[1]->percentage / 100);
		$divided_value1 = number_format(($received_value1/$transaction->installments), 2, ',', '.');

		$amount_formated = number_format(($transaction->amount/100), 2, ',', '.');
		$recipient_details = [
			$amount_formated,
			$transaction->installments, 
			[
				'percentage'		=> $transaction->split_rules[0]->percentage,
				'divided_value'		=> $divided_value0,
				'legal_name'		=> $recipient0->bank_account['legal_name'],
				'document_type'		=> $recipient0->bank_account['document_type'],
				'document_number'	=> $recipient0->bank_account['document_number']
			],

			[
				'percentage'		=> $transaction->split_rules[1]->percentage,
				'divided_value'		=> $divided_value1,
				'legal_name'		=> $recipient1->bank_account['legal_name'],
				'document_type'		=> $recipient1->bank_account['document_type'],
				'document_number'	=> $recipient1->bank_account['document_number']
			]
		];

		recipients_details($recipient_details);
	}

	function show_card_info($transaction){
		$card_details = [
			'first_digits' 	=> $transaction->card['first_digits'],
			'stars' 		=> '******',
			'last_digits' 	=> $transaction->card['last_digits'],
			'holder_name' 	=> $transaction->card['holder_name'],
			'installments' 	=> $transaction->installments,
			'brand' 		=> $transaction->card['brand']
		];

		credit_card($card_details);
	}

	function show_transaction_details($transaction){
		$transaction_details = [
			'acquirer_name' 			=> $transaction->acquirer_name,
			'tid' 						=> $transaction->tid,
			'acquirer_response_code' 	=> $transaction->acquirer_response_code,
			'nsu' 						=> $transaction->nsu,
			'authorization_code' 		=> $transaction->authorization_code,
			'soft_descriptor' 			=> $transaction->soft_descriptor,
			'antifraud_score' 			=> $transaction->antifraud_score,
			'subscription_id' 			=> $transaction->subscription_id
		];

		transaction_details($transaction_details);
	}