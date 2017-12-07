<?php
$this->Csv->addRow($th);

$this->Csv->addField($project['User']['nick_name']);
$this->Csv->addField($project['Project']['project_name']);
$this->Csv->addField($project['Project']['collected_amount']);
$this->Csv->addField($project['Project']['backers']);
$this->Csv->addField($project['Project']['site_fee']);
$this->Csv->addField($project['Project']['project_owner_price']);

$this->Csv->endRow();

$this->Csv->setFilename($filename);
echo $this->Csv->render(true, 'sjis', 'utf-8');
//echo $this->Csv->render();
