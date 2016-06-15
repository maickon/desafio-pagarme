<?php 
require 'class/Tags.class.php';
require 'recipients.php';
require "pagarme-php/Pagarme.php";
require 'functions/pagarme_transactions.php';

$tag = new Tag;


$card_hash = isset($_POST['card_hash']) ? $_POST['card_hash'] : '';

$tag->html();
    $tag->head();
        $tag->meta('charset="utf-8"');
        // $tag->link('rel="stylesheet" href="css/bootstrap.min.css"');
        $tag->link('rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Titillium+Web:400,900,700italic,700,600,600italic,400italic,300italic,200italic,200,300"');
        $tag->link('rel="stylesheet" href="https://dashboard.pagar.me/pagarme-icon.css"');
        $tag->link('rel="stylesheet" href="https://dashboard.pagar.me/dashboard.css"');
        $tag->script('src="https://dashboard.pagar.me/vendors.js"'); $tag->script;
        $tag->script('src="https://dashboard.pagar.me/scripts.js"'); $tag->script;
        $tag->script('src="https://assets.pagar.me/js/pagarme.min.js"'); $tag->script;

        $tag->title();
            $tag->printer('Teste da Pagarme'); 
        $tag->title;
    $tag->head;

    $tag->body();

        $card_form = [
                    [   
                      'label' => 'Número do cartão',                 
                      'class' => 'form-control cc_numero',
                      'id'    => 'card_number'
                    ],
                    
                    [   
                      'label' => 'Nome (como escrito no cartão)',  
                      'class' => 'form-control cc_titular', 
                      'id'    => 'card_holder_name'
                    ],

                    [
                      'label' => 'Vencimento do cartão (Mês)',
                      'class' => 'form-control cc_vencimento mes',                 
                      'id'    => 'card_expiration_month'
                    ],

                    [
                      'label' => 'Vencimento do cartão (Ano)',
                      'class' => 'form-control cc_vencimento ano',                 
                      'id'    => 'card_expiration_year'
                    ],
                    
                    [
                      'label' => 'Código de segurança',
                      'class' => 'form-control cc_cod_seguranca',              
                      'id'    => 'card_cvv'
                    ]
                ];

        $tag->br();

        $tag->form('id="payment_form" action="" method="POST"');
        
          $tag->div('class="container"');
              
              $tag->div('class="col-md-4"');
                
                $tag->div('class="panel panel-primary"');
                  
                  $tag->div('class="panel-heading"');
                    $tag->printer('Dados do cartão');
                  $tag->div;

                  $tag->div('class="panel-body"');
                    
                           foreach ($card_form as $value) { 
                              $tag->div('class="form-group"');
                                  $tag->label('for="' . $value['id'] . '"'); 
                                      $tag->printer($value['label']);
                                  $tag->label;
                                  $tag->input('type="text" required class="' . $value['class'] . '" id="' . $value['id'] . '"');
                              $tag->div;
                           }
                          $tag->br;
                          $tag->input('type="submit" id="submit_btn" class="btn btn-primary"'); 
                          $tag->input;

                  $tag->div;
                    
                $tag->div;

              $tag->div;

              $tag->div('class="col-md-4"');
                
                $tag->div('class="panel panel-primary"');
                  
                  $tag->div('class="panel-heading"');
                    $tag->printer('Defina o valor, nome e forma de parcelamento');
                  $tag->div;

                  $tag->div('class="panel-body"');

                    $tag->input('type="text" class="moeda form-control" name="amount" placeholder="Valor a ser pago"'); 
                    
                    $tag->br();
                    
                    $tag->input('type="text" class="caixa_alta soft_descriptor form-control" name="soft_descriptor" value="" placeholder="Nome do produto (resumido)"'); 
                    
                    $tag->br();

                    $tag->input('type="text" class="installments form-control" name="installments" value="" placeholder="Número de parcelas"'); 
                      
                  $tag->div;
                    
                $tag->div;

              $tag->div;
              
              $tag->div('class="col-md-4"');
                
                $tag->div('class="panel panel-primary"');
                  
                  $tag->div('class="panel-heading"');
                    $tag->printer('Selecione dois recebedores');
                  $tag->div;

                  $tag->div('class="panel-body"');
                
                           foreach ($recipients as $key => $value) { 
                              $tag->div('class="input-group"'); 
                                $tag->span('class="input-group-addon"'); 
                                  $tag->input('type="checkbox" onchange="checkboxs_status()" name="recipient_' . $key . '" value="' . $key . '" id="checkbox_' . $key . '"'); 
                                $tag->span;

                                $title  = "Código bancário: {$recipients[$key]['bank_account']['bank_code']} \n"; 
                                $title .= "Agência: {$recipients[$key]['bank_account']['agencia']} \n"; 
                                $title .= "Conta: {$recipients[$key]['bank_account']['conta']} \n"; 
                                $title .= "Conta DV: {$recipients[$key]['bank_account']['conta_dv']} \n"; 
                                $title .= "CPF: {$recipients[$key]['bank_account']['document_number']}";

                                $tag->input('type="text" class="form-control" value="' . $value['bank_account']['legal_name'] . '" title="' . $title . '"'); 
                              $tag->div;
                              $tag->br();
                           }
                      
                  $tag->div;
                    
                $tag->div;

              $tag->div;

          $tag->div;

      $tag->form;

        $tag->script('src="js/jquery.js"'); $tag->script;
        $tag->script('src="js/card_hash_generation.js"'); $tag->script;
        $tag->script('src="js/formzin-1.0.4.js"'); $tag->script;
        $tag->script('src="js/index.js"'); $tag->script;

        if(!empty($card_hash)){ 
          $indice_recipients = check_recipient($_POST);
          $recipient1 = $recipients[$indice_recipients[0]];
          $recipient2 = $recipients[$indice_recipients[1]];
          
          $transaction_info = [
                                'amount'          => str_replace(['.',','], "", $_POST['amount']),
                                'soft_descriptor' => $_POST['soft_descriptor'],
                                'installments'    => $_POST['installments']
                              ];
          try {
            $tag->div('class="container"');
              emulation_transaction($card_hash, [$recipient1, $recipient2], $transaction_info);
            $tag->div;
          } catch(Exception $e) {
              $tag->div('class="container"');
                $tag->div('class="col-md-12"');
                  $tag->div('class="alert alert-danger" role="alert"');         
                      $tag->printer($e->getMessage());
                  $tag->div;
                $tag->div;
              $tag->div;
          }
        }

    $tag->body;
$tag->html;          