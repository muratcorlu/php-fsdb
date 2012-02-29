<?php

require('fsdb.php');

$db = new fsdb('db');

$person = array('name'=> 'Murat', 'children' => array('Hasan', 'Ali', 'Zehra'));

$id = $db->save('people', $person);

$person = $db->get('people', $id);
$person['name'] = 'Hasan';
$person['children'][0] = 'Murat';
$db->save('people', $person);

$people = $db->select('people');

foreach($people as $id) {
    $p = $db->get('people', $id);
    print($p['id'] . ': ' . $p['name'] . "\n");
}
