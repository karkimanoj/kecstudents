<?php
/*
namespace App;
use App\Event1;


$events = Event1::all();

foreach ($events as $event) {
    $data[]=[
        'id' => $event->id,
        'title' => $event->title,
        'start' => $event->start_at,
        'end' => $event->end_at

    ];
}*/

$data=[
    [
    'title' => 'sadasd',
    'start' => '2018-06-17',
    'end' => '2018-06-17',
    ],

    [
    'title' => 'sadasd',
    'start' => '2018-06-18',
    'end' => '2018-06-18' ,
    ]
];

echo json_encode($data);



?>