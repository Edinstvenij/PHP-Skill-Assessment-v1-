<?php

$deliveryMethodsArray = [
  [
    'code' => 'dhl',
    'customer_costs' => [
      22 => '1.000',
      11 => '3.000',

    ]
  ],
  [
    'code' => 'fedex',
    'customer_costs' => [
      22 => '4.000',
      11 => '6.000',
    ]
  ]
];


function sortDeliveryMethods(array $array): array
{
  $result = [];

  foreach ($array as $value) {
    foreach ($value['customer_costs'] as $key => $item) {
      $result[$key][$value['code']] = $item;
    }
  }
  return $result;
}

echo '<pre>';
var_dump(sortDeliveryMethods($deliveryMethodsArray));
echo '</pre>';
