<?php

function data_format($data){
    foreach ($data as $key => $value) {
        $compound_name = '';
        if (strstr($key, '_')) {
            $name = explode('_', $key);
            foreach ($name as $value_of_indice) {
                $compound_name .= $value_of_indice.' ';
            }
            echo '<b>' . ucfirst($compound_name) . '$tag->b>: ' . $value . '<br>';
        }else{
            echo '<b>' . ucfirst($key) . '$tag->b>: ' . $value . '<br>';
        }
    }
    echo '<hr>';
}

function credit_card($data){
    global $tag;
    $card_number = $data['first_digits'] . $data['stars'] . $data['last_digits'];

    $tag->div('class="details-main col-xs-12 col-sm-8" partial-group="transactions.details.main"');
      $tag->div('class="panel details-panel flip-panel"');
        $tag->div('class="panel-heading"');
          $tag->p('class="panel-title ng-binding"');
            $tag->span('class="ss-icon ss-gizmo"');
              $tag->printer('info');
            $tag->span; 
            $tag->printer('CARTÃO DE CRÉDITO');
          $tag->p;
         $tag->div;

        $tag->div('ng-class="{\'active\': methodMode == \'payment\'}" class="panel-body hover-panel-body credit-card-container col-xs-8 paid active" ng-show="(transaction.payment_method == \'credit_card\' || transaction.payment_method == \'debit_card\') &amp;&amp; methodMode == \'payment\'"');
          

          $tag->div('class="detail-object card-header expiration-date col-xs-12"');
            $tag->div('class="card-icon paid"');
              $tag->span('class="ss-icon ss-gizmo"');
                $tag->printer('creditcard');
              $tag->span;
             $tag->div;
           $tag->div;

          $tag->div('class="detail-object col-xs-12 col-sm-7"');
            $tag->div('class="title ng-binding"');
              $tag->printer('NÚMERO');
             $tag->div;
           
           $tag->div('id="details-transaction-card-number" class="col-xs-12 value ng-binding ng-scope" ng-if="transaction.card_first_digits"');
              $tag->printer($card_number);
              $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $card_number . '" class="clipboard-copy ss-icon ss-gizmo paid"');
                $tag->printer('unlink');
              $tag->span;
             $tag->div;
           $tag->div;

          $tag->div('class="detail-object col-xs-12 col-sm-7"');
            $tag->div('class="title ng-binding"');
              $tag->printer('PORTADOR');
             $tag->div;
            $tag->div('id="details-transaction-card-holder-name" class="col-xs-12 value ng-binding ng-scope" ng-if="transaction.card_holder_name"');
              $tag->printer($data['holder_name']); 
              $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['holder_name'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
                $tag->printer('unlink');
                $tag->span();
                  $tag->printer('COPIAR');
                $tag->span;
            $tag->span;
             $tag->div;
           $tag->div;

          $tag->div('class="detail-object installment col-xs-12 col-sm-6"');
            $tag->div('class="title ng-binding"');
              $tag->printer('NÚMERO DE PARCELAS');
             $tag->div;
            $tag->div('id="details-transaction-splits" class="value ng-binding"');
              $tag->printer($data['installments'] . 'x');
             $tag->div;
           $tag->div;

          $tag->div('class="detail-object pull-right card-brand col-xs-12 col-sm-6"');
            $tag->div('class="title ng-binding"');
              $tag->printer('BANDEIRA');
             $tag->div;
            $tag->img('class="value visa" ng-src="https://dashboard.pagar.me/images/' . $data['brand'] . '.png" src="https://dashboard.pagar.me/images/' . $data['brand'] . '.png"');
           $tag->div;
         $tag->div;
        for($i = 1; $i < 14; $i++){
            $tag->br();
        }
       $tag->div;
    $tag->div;
}

function transaction_details($data){
    global $tag;
    $tag->div('class="details-main col-xs-12 col-sm-8" partial-group="transactions.details.main"');
      $tag->div('class="panel details-panel"');
        $tag->div('class="panel-heading"');
          $tag->p('class="panel-title ng-binding"');
            $tag->span('class="ss-icon ss-gizmo"');
              $tag->printer('expand');
            $tag->span;
            $tag->printer('DETALHES DA TRANSAÇÃO');
          $tag->p;
        $tag->div;

        $tag->div('class="panel-body hover-panel-body col-xs-11" partial-group="transactions.details.main.transaction"');
          
          $tag->div('class="detail-object col-xs-12 col-sm-6"');
            $tag->div('class="title ng-binding"');
              $tag->printer('OPERADORA DE CARTÃO');
            $tag->div;
          
            $tag->div('id="details-transaction-acquirer-name" class="col-xs-12 value ng-scope" ng-if="transaction.acquirer_name"');
              $tag->printer($data['acquirer_name']);
              $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['acquirer_name'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
                $tag->printer('unlink'); 
                $tag->span();
                  $tag->printer('COPIAR');
                $tag->span;
              $tag->span;

              $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['acquirer_name'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
                $tag->printer('unlink');
                $tag->span();
                  $tag->printer('COPIAR');
                $tag->span;
              $tag->span;
            $tag->div;
          $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('TID');
          $tag->div;
          
          $tag->div('id="details-transaction-tid" class="col-xs-12 value ng-binding ng-scope" ng-if="transaction.tid"');
            $tag->printer($data['tid']);
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['tid'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink'); 
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('RESPOSTA DA OPERADORA');
          $tag->div;
         
         $tag->div('id="details-transaction-acquirer-response" class="col-xs-12 value ng-binding ng-scope" ng-if="transaction.acquirer_response_code"');
            $tag->printer($data['acquirer_response_code']);
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['acquirer_response_code'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink');
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('NSU');
          $tag->div;
          
          $tag->div('id="details-transaction-nsu" class="col-xs-12 value ng-binding ng-scope" ng-if="transaction.nsu"');
            $tag->printer($data['nsu']);
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['nsu'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink'); 
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('CÓDIGO DE AUTORIZAÇÃO');
          $tag->div;
          
          $tag->div('id="details-transaction-authorization-code" class="col-xs-12 value ng-binding ng-scope" ng-if="transaction.authorization_code"');
            $tag->printer($data['authorization_code']);
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['authorization_code'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink');
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('SOFT DESCRIPTOR');
          $tag->div;
          $tag->div('id="details-transaction-soft-descriptor" class="col-xs-12 value ng-scope" ng-if="transaction.soft_descriptor"');
            $tag->p('class="ng-binding"');
              $tag->printer($data['soft_descriptor']);
            $tag->p;
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['soft_descriptor'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink');
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('SCORE DO ANTIFRAUDE');
          $tag->div;
          $tag->div('id="details-transaction-antifraud" class="col-xs-12 value ng-scope" ng-if="!transaction.antifraud_score"');
            $tag->p('class="text-holder"');
              $tag->printer($data['antifraud_score']);
            $tag->p;
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['antifraud_score'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink');
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;

        $tag->div('class="detail-object col-xs-12 col-sm-6"');
          $tag->div('class="title ng-binding"');
            $tag->printer('ID DA ASSINATURA');
          $tag->div;
          $tag->div('id="details-transaction-subscription-id" class="col-xs-12 value ng-scope" ng-if="!transaction.subscription_id"');
            $tag->p('class="text-holder"');
              $tag->printer($data['subscription_id']);
            $tag->p;
            $tag->span('pg-clipboard-copy="" data-clipboard-text="' . $data['subscription_id'] . '" class="clipboard-copy ss-icon ss-gizmo paid"');
              $tag->printer('unlink');
              $tag->span();
                $tag->printer('COPIAR');
              $tag->span;
            $tag->span;
          $tag->div;
        $tag->div;
      $tag->div;
    $tag->div;
}

function recipients_details($data){
  global $tag;
  
  $tag->div('id="split-details-container" class="panel details-panel ng-scope" ng-if="rulesCount > 0"');
    $tag->div('class="panel-heading"');
      $tag->p('class="panel-title ng-binding"');
        $tag->span('class="ss-icon ss-gizmo"');
        $tag->printer('fork');
        $tag->span; 
          $tag->printer('RECEBEDORES /');
        $tag->span('class="bold ng-binding"');
          $tag->printer('2');
        $tag->span;
      $tag->p;
    $tag->div;
  
    $tag->div('style="bottom: 215px" class="split-main-sidebar paid"');
    $tag->div;

    $tag->div('class="split-amount-wrapper paid"');
      $tag->p('class="split-total-amount ng-binding"');
        $tag->span();
          $tag->printer('R$');
        $tag->span;
        $tag->printer($data[0]);
      $tag->p;
      $tag->p('class="split-installment"');
        $tag->printer('parcelado em'); 
        $tag->span('class="ng-binding"');
          $tag->printer($data[1] . 'x');
        $tag->span;
      $tag->p;
    $tag->div;

    $tag->div('ng-class="{\'last-recipient\': $last }" class="col-xs-11 recipient-wrapper ng-scope" ng-repeat="rule in splitRules"');

      $tag->div('class="split-sidebar paid"');
      $tag->div;

      $tag->div('class="split-percentage paid"');
        $tag->printer($data[2]['percentage']);
        $tag->span('ng-if="rule.rule.percentage" class="ng-scope"');
          $tag->printer('%');
        $tag->span;
      $tag->div;

      $tag->div('class="split-data-container paid"');
        $tag->div('class="split-data-header paid"');
          $tag->p('class="split-name ng-binding"');
            $tag->span('class="ss-icon ng-binding"');
              $tag->printer('user');
            $tag->span; 
            $tag->printer($data[2]['legal_name']);
          $tag->p;

          $tag->p('class="split-document-number ng-binding"');
            $tag->span('class="ng-binding"');
              $tag->printer($data[2]['document_type']);
            $tag->span; 
            $tag->printer($data[2]['document_number']);
          $tag->p;
        $tag->div;

        $tag->div('class="split-data-body"');
          $tag->div('class="split-data-row ng-scope" ng-repeat="payable in rule.payables"');
            for ($i = 1; $i <= $data[1]; $i++) {
              $tag->div('ng-class="{\'last-left\': $last}" class="split-index ng-binding"');
                $tag->printer($i);
              $tag->div;
              $tag->div('ng-class="{\'last-right\': $last}" class="split-liquid credit"');
                $tag->span('ng-if="!payable.original_payment_date" class="ng-binding ng-scope"');
                  $tag->printer('R$' . $data[2]['divided_value']);
                $tag->span;
              $tag->div;
            }
          $tag->div;
        $tag->div;

      $tag->div;
    $tag->div;

    $tag->div('ng-class="{\'last-recipient\': $last }" class="col-xs-11 recipient-wrapper ng-scope last-recipient" ng-repeat="rule in splitRules"');
      
      $tag->div('class="split-sidebar paid"');
      $tag->div;

      $tag->div('class="split-percentage paid"');
        $tag->printer($data[3]['percentage']);
        $tag->span('ng-if="rule.rule.percentage" class="ng-scope"');
          $tag->printer('%');
        $tag->span;
      $tag->div;

      $tag->div('class="split-data-container paid"');
        $tag->div('class="split-data-header paid"');
          $tag->p('class="split-name ng-binding"');
            $tag->span('class="ss-icon ng-binding"');
              $tag->printer('user');
            $tag->span; 
            $tag->printer($data[3]['legal_name']);
          $tag->p;

          $tag->p('class="split-document-number ng-binding"');
            $tag->span('class="ng-binding"');
              $tag->printer($data[3]['document_type']);
            $tag->span; 
            $tag->printer($data[3]['document_number']);
          $tag->p;
        $tag->div;

        $tag->div('class="split-data-body"');
          $tag->div('class="split-data-row ng-scope" ng-repeat="payable in rule.payables"');
            for ($i = 1; $i <= $data[1]; $i++) {
              $tag->div('ng-class="{\'last-left\': $last}" class="split-index ng-binding"');
                $tag->printer($i);
              $tag->div;
              $tag->div('ng-class="{\'last-right\': $last}" class="split-liquid credit"');
                $tag->span('ng-if="!payable.original_payment_date" class="ng-binding ng-scope"');
                  $tag->printer('R$' . $data[3]['divided_value']);
                $tag->span;
              $tag->div;
            }
          $tag->div;
        $tag->div;
      $tag->div;
    $tag->div; 
  $tag->div; 
}