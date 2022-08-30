<?php

$numberTest = 6;


// version 1
function myArrowFunction(int $num): string
{
  $result = '';
  if ($num <= 0) {
    return $result;
  } else {
    for ($i = 0; $i < $num; $i++) {
      $result = $result . '<';
    }
    for ($i = 0; $i < $num; $i++) {
      $result = $result . '>';
    }
  }
  return $result;
}

echo (myArrowFunction($numberTest));


// version 2
echo '<br>';

function myArrowFunction2(int $num): string
{
  $result = '';
  if ($num <= 0) {
    return $result;
  } else {
    for ($i = 0; $i < $num; $i++) {
      $result = '<' . $result . '>';
    }
  }
  return $result;
}
echo (myArrowFunction2($numberTest));

// version 2
echo '<br>';

function myArrowFunction3(int $number): string
{
  if ($number <= 0) {
    return '';
  }
  return str_repeat('<', $number) . str_repeat('>', $number);
}
echo myArrowFunction3($numberTest);

?>



composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition task3


Открытый ключ : 4aa9320ca5a516f92b7066ad7fbc7516 4aa9320ca5a516f92b7066ad7fbc7516
Закрытый ключ : dfe862f346720b2ad2b7bdc2628f8828 dfe862f346720b2ad2b7bdc2628f8828


cd /var/www/html/task3
find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
chmod u+x bin/magento



bin/magento setup:install \
--base-url=http://localhost/magento2ee:80 \
--db-host=localhost \
--db-name=magento \
--db-user=root \
--admin-firstname=admin \
--admin-lastname=admin \
--admin-email=admin@admin.com \
--admin-user=admin \
--admin-password=admin123 \
--language=en_US \
--currency=USD \
--timezone=America/Chicago \
--use-rewrites=1 \
--search-engine=elasticsearch7 \
--elasticsearch-host=localhost \
--elasticsearch-port=9200 \
--elasticsearch-index-prefix=magento2 \
--elasticsearch-timeout=15

[SUCCESS]: Magento installation complete.
[SUCCESS]: Magento Admin URI: /admin_1ere74
Nothing to import.