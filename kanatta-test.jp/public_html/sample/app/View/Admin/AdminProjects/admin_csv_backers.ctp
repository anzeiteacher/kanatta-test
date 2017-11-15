<?php
$this->Csv->addRow($th);
foreach($backers as $b){
    $this->Csv->addField(date('Y/m/d', strtotime(h($b['BackedProject']['created']))));
    $pay = $b['BackedProject']['manual_flag'] ? '手動' : 'カード';
    $this->Csv->addField($pay);
    if($project['Project']['pay_pattern'] == MONTHLY){
        $pay_id =  h($b['BackedProject']['recurring_id']);
    }else{
        $pay_id =  h($b['BackedProject']['orderId']);
    }
    $this->Csv->addField($pay_id);
    $this->Csv->addField($statuses[$b['BackedProject']['status']]);
    $this->Csv->addField(number_format(h($b['BackedProject']['invest_amount'])).'円');
    if($project['Project']['pay_pattern'] == MONTHLY){
        $old_date = '';
        if(!empty($b['BackedProject']['old_charge_date'])){
            $old_date = date('Y/m/d', strtotime(h($b['BackedProject']['old_charge_date'])));
        }
        $this->Csv->addField($old_date);
        $cr = '';
        if(!empty($b['BackedProject']['charge_result'])){
            $cr = $charge_results[h($b['BackedProject']['charge_result'])];
        }
        $this->Csv->addField($cr);
        $next_date = '';
        if(!empty($b['BackedProject']['next_charge_date'])){
            $next_date = date('Y/m/d', strtotime(h($b['BackedProject']['next_charge_date'])));
        }
        $this->Csv->addField($next_date);
    }
    $this->Csv->addField(h($b['User']['nick_name']));
    $this->Csv->addField(h($b['User']['name']));
    $this->Csv->addField(h($b['User']['email']));
    $this->Csv->addField(h($b['User']['receive_address']));
    $this->Csv->addField(str_replace('level', '支援パターン', h($b['BackingLevel']['name'])));
    $this->Csv->addField($b['BackingLevel']['return_amount']);
    $this->Csv->addField(h($b['BackedProject']['comment']));
    $this->Csv->endRow();
}
$this->Csv->setFilename($filename);
echo $this->Csv->render(true, 'sjis', 'utf-8');
//echo $this->Csv->render();
